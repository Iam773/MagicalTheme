<?php
/**
 * Game Manager Class for Azure Cards
 * Manages game creation, joining, and state management
 */
class GameManager {
    // Game settings constants
    const MIN_PLAYERS = 2;
    const MAX_PLAYERS = 4;
    const GAME_STORAGE_PATH = __DIR__ . '/data/';
    
    /**
     * Creates a new game room with a unique ID
     * 
     * @param string $creatorName The name of the player creating the game
     * @param string $creatorAvatar The creator's avatar URL
     * @param array $gameOptions Game configuration options
     * @return array The newly created game data including ID and join URL
     */
    public static function createGame($creatorName, $creatorAvatar = '', $gameOptions = []) {
        // Generate unique 32-bit (8 character) game ID
        $gameId = self::generateGameId();
        
        // Check if data directory exists, create if not
        if (!is_dir(self::GAME_STORAGE_PATH)) {
            mkdir(self::GAME_STORAGE_PATH, 0755, true);
        }
        
        // Default game options
        $defaultOptions = [
            'maxPlayers' => 2, // 2-4 players
            'turnTimeLimit' => 60, // seconds
            'initialCards' => 4,
            'maxMana' => 10,
            'gameMode' => 'standard' // standard, draft, arena
        ];
        
        // Merge with user options, with defaults taking precedence
        $gameOptions = array_merge($defaultOptions, $gameOptions);
        
        // Validate maxPlayers
        if ($gameOptions['maxPlayers'] < self::MIN_PLAYERS) {
            $gameOptions['maxPlayers'] = self::MIN_PLAYERS;
        } else if ($gameOptions['maxPlayers'] > self::MAX_PLAYERS) {
            $gameOptions['maxPlayers'] = self::MAX_PLAYERS;
        }
        
        // Initial game state
        $game = [
            'id' => $gameId,
            'status' => 'waiting', // waiting, starting, in_progress, finished
            'created' => time(),
            'lastActivity' => time(),
            'options' => $gameOptions,
            'players' => [
                // First player (creator)
                [
                    'id' => 1,
                    'name' => $creatorName,
                    'avatar' => $creatorAvatar,
                    'status' => 'ready',
                    'joinTime' => time(),
                    'deck' => [], // Will be populated when game starts
                    'hand' => [],
                    'field' => [],
                    'health' => 30,
                    'mana' => 1,
                    'maxMana' => 1
                ]
            ],
            'currentPlayer' => 0, // Will be set when game starts
            'currentTurn' => 0,
            'turnStartTime' => 0,
            'winner' => null,
            'actionLog' => [
                [
                    'type' => 'system',
                    'message' => "Game room created by $creatorName",
                    'time' => time()
                ]
            ]
        ];
        
        // Save game to storage
        self::saveGame($gameId, $game);
        
        // Return game data with join URL
        $joinUrl = self::getJoinUrl($gameId);
        return [
            'gameId' => $gameId,
            'joinUrl' => $joinUrl,
            'status' => 'created',
            'createdBy' => $creatorName,
            'maxPlayers' => $gameOptions['maxPlayers'],
            'currentPlayers' => 1
        ];
    }
    
    /**
     * Generates a unique 32-bit (8 character) game ID
     * 
     * @return string Unique game ID
     */
    private static function generateGameId() {
        // Generate random bytes and convert to hex
        $randomBytes = random_bytes(4); // 4 bytes = 32 bits
        $hexString = bin2hex($randomBytes);
        
        // Check if this ID already exists
        if (file_exists(self::GAME_STORAGE_PATH . $hexString . '.json')) {
            // Recursively try again if ID collision (extremely unlikely)
            return self::generateGameId();
        }
        
        return $hexString;
    }
    
    /**
     * Saves game state to storage
     * 
     * @param string $gameId The game ID
     * @param array $gameData The game data to save
     * @return bool True if successful
     */
    private static function saveGame($gameId, $gameData) {
        $gamePath = self::GAME_STORAGE_PATH . $gameId . '.json';
        $jsonData = json_encode($gameData, JSON_PRETTY_PRINT);
        return file_put_contents($gamePath, $jsonData) !== false;
    }
    
    /**
     * Loads game state from storage
     * 
     * @param string $gameId The game ID
     * @return array|null The game data or null if not found
     */
    public static function loadGame($gameId) {
        $gamePath = self::GAME_STORAGE_PATH . $gameId . '.json';
        
        if (!file_exists($gamePath)) {
            return null;
        }
        
        $jsonData = file_get_contents($gamePath);
        return json_decode($jsonData, true);
    }
    
    /**
     * Gets the game join URL
     * 
     * @param string $gameId The game ID
     * @return string URL for joining the game
     */
    public static function getJoinUrl($gameId) {
        // Construct the URL based on the current host
        $protocol = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? 'https' : 'http';
        $host = $_SERVER['HTTP_HOST'] ?? 'localhost';
        $basePath = dirname($_SERVER['PHP_SELF']);
        $basePath = str_replace('\\', '/', $basePath);
        
        // Navigate to the join.php page with the game ID
        return "$protocol://$host$basePath/join.php?game=$gameId";
    }
    
    /**
     * Joins a player to an existing game
     * 
     * @param string $gameId The game ID
     * @param string $playerName The joining player's name
     * @param string $playerAvatar The joining player's avatar URL
     * @return array Status and message
     */
    public static function joinGame($gameId, $playerName, $playerAvatar = '') {
        // Load game data
        $game = self::loadGame($gameId);
        
        // Check if game exists
        if (!$game) {
            return [
                'status' => 'error',
                'message' => 'Game not found'
            ];
        }
        
        // Check if game is joinable
        if ($game['status'] !== 'waiting') {
            return [
                'status' => 'error',
                'message' => 'Game is not accepting new players'
            ];
        }
        
        // Check if game is full
        if (count($game['players']) >= $game['options']['maxPlayers']) {
            return [
                'status' => 'error',
                'message' => 'Game is full'
            ];
        }
        
        // Add player to game
        $playerId = count($game['players']) + 1;
        $game['players'][] = [
            'id' => $playerId,
            'name' => $playerName,
            'avatar' => $playerAvatar,
            'status' => 'ready',
            'joinTime' => time(),
            'deck' => [],
            'hand' => [],
            'field' => [],
            'health' => 30,
            'mana' => 1,
            'maxMana' => 1
        ];
        
        // Update last activity time
        $game['lastActivity'] = time();
        
        // Add to action log
        $game['actionLog'][] = [
            'type' => 'system',
            'message' => "$playerName joined the game",
            'time' => time()
        ];
        
        // Check if game should auto-start (all players joined)
        if (count($game['players']) >= $game['options']['maxPlayers']) {
            $game['status'] = 'starting';
        }
        
        // Save updated game
        self::saveGame($gameId, $game);
        
        // Return success status
        return [
            'status' => 'success',
            'message' => 'Successfully joined game',
            'playerId' => $playerId,
            'gameStatus' => $game['status'],
            'currentPlayers' => count($game['players']),
            'maxPlayers' => $game['options']['maxPlayers']
        ];
    }
    
    /**
     * Starts a game if it's ready
     * 
     * @param string $gameId The game ID
     * @return array Status and message
     */
    public static function startGame($gameId) {
        // Load game data
        $game = self::loadGame($gameId);
        
        // Check if game exists
        if (!$game) {
            return [
                'status' => 'error',
                'message' => 'Game not found'
            ];
        }
        
        // Check if game can be started
        if ($game['status'] !== 'waiting' && $game['status'] !== 'starting') {
            return [
                'status' => 'error',
                'message' => 'Game cannot be started in its current state'
            ];
        }
        
        // Ensure minimum number of players
        if (count($game['players']) < self::MIN_PLAYERS) {
            return [
                'status' => 'error',
                'message' => 'Not enough players to start'
            ];
        }
        
        // Initialize game state
        $game['status'] = 'in_progress';
        $game['currentTurn'] = 1;
        
        // Randomly determine first player
        $game['currentPlayer'] = rand(1, count($game['players']));
        
        // Set turn start time
        $game['turnStartTime'] = time();
        
        // Initialize player decks, hands, etc. (simplified)
        foreach ($game['players'] as &$player) {
            // Generate a deck (in a real game, players would have their own decks)
            $player['deck'] = self::generateDeck($player['id']);
            
            // Draw initial hand
            $player['hand'] = [];
            for ($i = 0; $i < $game['options']['initialCards']; $i++) {
                if (count($player['deck']) > 0) {
                    $player['hand'][] = array_pop($player['deck']);
                }
            }
        }
        
        // Add to action log
        $game['actionLog'][] = [
            'type' => 'system',
            'message' => "Game started! " . $game['players'][$game['currentPlayer'] - 1]['name'] . "'s turn",
            'time' => time()
        ];
        
        // Save updated game
        self::saveGame($gameId, $game);
        
        // Return success status
        return [
            'status' => 'success',
            'message' => 'Game started successfully',
            'firstPlayer' => $game['players'][$game['currentPlayer'] - 1]['name'],
            'currentTurn' => $game['currentTurn']
        ];
    }
    
    /**
     * Generate a deck for a player (simplified)
     * 
     * @param int $playerId The player ID
     * @return array Deck of cards
     */
    private static function generateDeck($playerId) {
        $deck = [];
        
        // In a real game, this would load from a database or user's saved decks
        // For now, just create some random cards for each element type
        $elements = ['water', 'fire', 'earth', 'air', 'arcane'];
        
        // Select an element based on player ID
        $playerElement = $elements[($playerId - 1) % count($elements)];
        
        // Generate 30 cards for the deck
        for ($i = 1; $i <= 30; $i++) {
            $cardType = rand(1, 10) <= 7 ? 'creature' : (rand(1, 10) <= 5 ? 'spell' : 'equipment');
            $rarity = getRarity();
            
            $card = [
                'id' => "p{$playerId}_c{$i}",
                'name' => getRandomCardName($playerElement, $cardType),
                'element' => $playerElement,
                'type' => $cardType,
                'rarity' => $rarity,
                'mana' => min(rand(1, 10), $rarity * 2),
            ];
            
            if ($cardType === 'creature') {
                $card['power'] = rand(1, 8);
                $card['health'] = rand(1, 10);
            } else if ($cardType === 'spell') {
                $card['power'] = rand(1, 6);
                $card['health'] = null;
            } else {
                $card['power'] = rand(0, 2);
                $card['health'] = rand(1, 5);
            }
            
            $deck[] = $card;
        }
        
        // Shuffle the deck
        shuffle($deck);
        
        return $deck;
    }
}

/**
 * Helper function to get a random rarity
 */
function getRarity() {
    $rand = rand(1, 100);
    if ($rand <= 40) return 1; // Common (40%)
    if ($rand <= 70) return 2; // Uncommon (30%)
    if ($rand <= 90) return 3; // Rare (20%)
    if ($rand <= 98) return 4; // Epic (8%)
    return 5; // Legendary (2%)
}

/**
 * Helper function to generate a random card name
 */
function getRandomCardName($element, $type) {
    $elementPrefixes = [
        'water' => ['Aqua', 'Frost', 'Tidal', 'Ocean', 'Wave'],
        'fire' => ['Flame', 'Blaze', 'Inferno', 'Ember', 'Burning'],
        'earth' => ['Stone', 'Mountain', 'Crystal', 'Terra', 'Boulder'],
        'air' => ['Wind', 'Gale', 'Cyclone', 'Tempest', 'Storm'],
        'arcane' => ['Mystic', 'Arcane', 'Astral', 'Ethereal', 'Celestial']
    ];
    
    $typeSuffixes = [
        'creature' => ['Beast', 'Guardian', 'Spirit', 'Elemental', 'Colossus', 'Titan', 'Knight'],
        'spell' => ['Blast', 'Surge', 'Strike', 'Bolt', 'Nova', 'Wave', 'Storm'],
        'equipment' => ['Shield', 'Armor', 'Blade', 'Staff', 'Orb', 'Wand', 'Rune']
    ];
    
    $prefix = $elementPrefixes[$element][array_rand($elementPrefixes[$element])];
    $suffix = $typeSuffixes[$type][array_rand($typeSuffixes[$type])];
    
    return $prefix . ' ' . $suffix;
}
