/**
 * MagicalUI.js
 * JavaScript implementation of MagicalTheme's popup and alert functionality
 * Uses the same visual design as the PHP MagicalTheme class
 * 
 * @version 1.0.0
 */

// Self-executing function to avoid global scope pollution
(function(window) {
    'use strict';

    // Theme colors - will be initialized from PHP MagicalTheme
    let themeColors = {
        primary: '#ff6ec7',    // Default fallback values if PHP data isn't available
        secondary: '#a78bfa',
        accent: '#ffc8dd',
        success: '#4ade80',
        warning: '#fbbf24',
        danger: '#f87171',
        light: '#fff1f9',
        dark: '#4e2a5a'
    };
    
    // Initialize theme colors from PHP when possible
    (function initThemeColors() {
        // First check if colors are provided in a data attribute
        const colorDataEl = document.getElementById('magical-theme-colors');
        if (colorDataEl && colorDataEl.dataset.colors) {
            try {
                const phpColors = JSON.parse(colorDataEl.dataset.colors);
                themeColors = {...themeColors, ...phpColors};
                return;
            } catch (e) {
                console.warn('Failed to parse theme colors from data attribute:', e);
            }
        }
        
        // If not found in data attribute, try to fetch from a PHP endpoint
        // const fetchColors = (url = '../../get-theme-colors.php') => {
        //     fetch(url)
        //         .then(response => response.json())
        //         .then(data => {
        //             if (data && Object.keys(data).length) {
        //                 themeColors = {...themeColors, ...data};
        //             }
        //         })
        //         .catch(err => {
        //             console.warn('Could not fetch theme colors:', err);
        //         });
        // };
        
        // // Only fetch if we're in a browser environment
        // if (typeof window !== 'undefined' && window.fetch) {
        //     fetchColors('../../get-theme-colors.php'); // Fix: Explicitly pass the default URL
        // }
    })();

    /**
     * Fetch theme colors from a PHP endpoint
     * 
     * @param {string} url The URL to fetch colors from
     * @returns {Promise} A promise that resolves with the fetched colors
     */
    function fetchColors(url = '../../get-theme-colors.php') {
        return new Promise((resolve, reject) => {
            if (typeof window === 'undefined' || !window.fetch) {
                reject(new Error('Fetch API not available'));
                return;
            }
            
            fetch(url)
                .then(response => response.json())
                .then(data => {
                    if (data && Object.keys(data).length) {
                        themeColors = {...themeColors, ...data};
                        updateUIColors(); // Update UI colors after fetching
                        resolve(themeColors);
                    } else {
                        resolve(themeColors);
                    }
                })
                .catch(err => {
                    console.warn('Could not fetch theme colors:', err);
                    reject(err);
                });
        });
    }

    /**
     * Set theme colors from MagicalTheme.php
     * 
     * @param {boolean|string} useColorscript Whether to try getting colors from the magical-theme-colors script first, 
     *                                       or a string URL to the get-theme-colors.php file
     * @param {string} [customUrl] Optional URL to the get-theme-colors.php file (if first param is boolean)
     * @returns {Promise} A promise that resolves when colors are set
     */
    function setThemeColorsFromPHP(useColorscript = true, customUrl = null) {
        // Handle case when URL is passed as first parameter
        let shouldUseColorscript = useColorscript;
        let themeUrl = '../get-theme-colors.php'; // Default URL
        
        if (typeof useColorscript === 'string') {
            themeUrl = useColorscript;
            shouldUseColorscript = true;
        } else if (customUrl) {
            themeUrl = customUrl;
        }
        
        return new Promise((resolve, reject) => {
            // First try to get colors from the magical-theme-colors script if requested
            if (shouldUseColorscript) {
                const colorDataEl = document.getElementById('magical-theme-colors');
                if (colorDataEl && colorDataEl.dataset.colors) {
                    try {
                        const phpColors = JSON.parse(colorDataEl.dataset.colors);
                        themeColors = {...themeColors, ...phpColors};
                        updateUIColors(); // Update UI colors after setting from script
                        resolve(themeColors);
                        return;
                    } catch (e) {
                        console.warn('Failed to parse theme colors from data attribute:', e);
                    }
                }
            }
            
            // If we didn't find colors from the script or it was disabled,
            // make an AJAX request to the server to get the colors
            const xhr = new XMLHttpRequest();
            xhr.open('GET', themeUrl, true);
            
            xhr.onload = function() {
                if (xhr.status === 200) {
                    try {
                        const data = JSON.parse(xhr.responseText);
                        if (data && Object.keys(data).length) {
                            themeColors = {...themeColors, ...data};
                            updateUIColors(); // Update UI colors after setting from XHR
                            resolve(themeColors);
                        } else {
                            resolve(themeColors); // Return current colors if response is empty
                        }
                    } catch (e) {
                        console.warn('Failed to parse theme colors from server response:', e);
                        reject(e);
                    }
                } else {
                    console.warn('Error fetching theme colors, status:', xhr.status);
                    reject(new Error(`Failed to fetch theme colors: ${xhr.statusText}`));
                }
            };
            
            xhr.onerror = function() {
                console.warn('Network error fetching theme colors');
                reject(new Error('Network error fetching theme colors'));
            };
            
            xhr.send();
        });
    }

    // Helper function to convert hex to rgba
    function hexToRgb(hex) {
        // Remove # if present
        hex = hex.replace(/^#/, '');
        
        // Convert to RGB
        let r, g, b;
        if (hex.length === 3) {
            r = parseInt(hex.charAt(0) + hex.charAt(0), 16);
            g = parseInt(hex.charAt(1) + hex.charAt(1), 16);
            b = parseInt(hex.charAt(2) + hex.charAt(2), 16);
        } else {
            r = parseInt(hex.substring(0, 2), 16);
            g = parseInt(hex.substring(2, 4), 16);
            b = parseInt(hex.substring(4, 6), 16);
        }
        
        return `${r}, ${g}, ${b}`;
    }

    // Ensure the alert styles are added to the document
    function ensureStyles() {
        if (!document.getElementById('magical-ui-styles')) {
            const styleSheet = document.createElement('style');
            styleSheet.id = 'magical-ui-styles';
            styleSheet.textContent = `
                @keyframes popup-sparkle {
                    0%, 100% { opacity: 0; transform: scale(0); }
                    50% { opacity: 1; transform: scale(1); }
                }
                
                @keyframes float {
                    0%, 100% { transform: translateY(0); }
                    50% { transform: translateY(-10px); }
                }
                
                @keyframes moveSparkle {
                    0% { transform: translateY(0) scale(0); opacity: 0; }
                    20% { opacity: 1; }
                    50% { transform: translateY(-20px) scale(1); opacity: 1; }
                    80% { opacity: 0.5; }
                    100% { transform: translateY(-40px) scale(0); opacity: 0; }
                }
                
                @keyframes dotAnimation {
                    0% { content: "."; }
                    33% { content: ".."; }
                    66% { content: "..."; }
                }
                
                @keyframes sparkle {
                    0% { transform: translate(-50px, 0) rotate(0deg); opacity: 0; }
                    50% { opacity: 1; }
                    100% { transform: translate(50px, -50px) rotate(360deg); opacity: 0; }
                }
                
                /* Alert styles */
                .magical-alert {
                    margin-bottom: 1.25rem;
                    overflow: hidden;
                    position: relative;
                    backdrop-filter: blur(4px);
                    transition: all 0.5s ease-in-out;
                    border-radius: 0.75rem;
                    box-shadow: 0 10px 25px -5px rgba(255, 110, 199, 0.5);
                    max-height: 500px;
                    opacity: 1;
                }
                
                .magical-alert.hiding {
                    opacity: 0;
                    max-height: 0;
                    margin-bottom: 0;
                    padding-top: 0;
                    padding-bottom: 0;
                }
                
                /* Popup styles */
                .magical-popup {
                    position: fixed;
                    inset: 0;
                    display: flex;
                    align-items: center;
                    justify-content: center;
                    z-index: 9999;
                    opacity: 0;
                    pointer-events: none;
                    transition: opacity 0.3s;
                }
                
                .magical-popup.show {
                    opacity: 1;
                    pointer-events: auto;
                }
                
                .magical-popup-backdrop {
                    position: absolute;
                    inset: 0;
                    background-color: rgba(78, 42, 90, 0.2);
                    backdrop-filter: blur(4px);
                }
                
                .magical-popup-content {
                    width: 90%;
                    max-width: 28rem;
                    transform: scale(0.9);
                    transition: transform 0.3s;
                    position: relative;
                    z-index: 10;
                }
                
                .magical-popup.show .magical-popup-content {
                    transform: scale(1);
                }
                
                /* Magic button */
                .magic-button {
                    display: inline-block;
                    background-image: linear-gradient(to right, #ff6ec7, #a78bfa);
                    color: white;
                    font-family: 'Itim', cursive, sans-serif;
                    padding: 0.75rem 2rem;
                    border-radius: 9999px;
                    transition: all 300ms;
                    box-shadow: 0 10px 25px -5px rgba(255, 110, 199, 0.5);
                    transform: translateY(0);
                    position: relative;
                    overflow: hidden;
                    border: none;
                    cursor: pointer;
                }
                
                .magic-button:hover {
                    transform: translateY(-0.25rem);
                    box-shadow: 0 20px 35px -10px rgba(255, 110, 199, 0.6);
                }
            `;
            document.head.appendChild(styleSheet);
        }
    }

    // Ensure the alert container exists
    function ensureAlertContainer() {
        let alertContainer = document.getElementById('alert-container');
        
        if (!alertContainer) {
            alertContainer = document.createElement('div');
            alertContainer.id = 'alert-container';
            alertContainer.style.position = 'fixed';
            alertContainer.style.top = '5rem';
            alertContainer.style.left = '50%';
            alertContainer.style.transform = 'translateX(-50%)';
            alertContainer.style.width = '100%';
            alertContainer.style.maxWidth = '28rem';
            alertContainer.style.zIndex = '50';
            alertContainer.style.padding = '0 1rem';
            document.body.appendChild(alertContainer);
        }
        
        return alertContainer;
    }

    /**
     * Create and display a magical alert notification
     * 
     * @param {string} type Alert type (success, error, warning, info)
     * @param {string} message Message to display
     * @param {Object|string} options Additional options or custom title if string
     * @param {string} [options.title] Custom title for the alert
     * @param {boolean} [options.autoClose=true] Whether to automatically close the alert
     * @param {number} [options.duration=5000] Duration in ms to show alert before auto-closing
     * @param {string} [options.containerId] Custom container ID
     * @returns {string} The ID of the created alert element
     */
    function renderAlert(type, message, options = {}, customTitle = '') {
        ensureStyles();
        const alertContainer = ensureAlertContainer();
        
        // Handle case where options is passed as a string (representing title)
        if (typeof options === 'string') {
            customTitle = options;
            options = {};
        }
        
        // Default options
        const settings = {
            autoClose: true,
            duration: 5000,
            containerId: null,
            title: customTitle, // Add title to settings object
            ...options
        };
        
        // Define alert icon and color based on type
        let icon, bg, border, text, title;
        
        switch (type) {
            case 'success':
                icon = 'fa-wand-magic-sparkles';
                bg = 'rgba(74, 222, 128, 0.1)';
                border = `4px solid ${themeColors.success}`;
                text = themeColors.success;
                title = settings.title || 'Magical Success!';
                break;
            case 'error':
                icon = 'fa-ghost';
                bg = 'rgba(248, 113, 113, 0.1)';
                border = `4px solid ${themeColors.danger}`;
                text = themeColors.danger;
                title = settings.title || 'Magical Mishap!';
                break;
            case 'warning':
                icon = 'fa-hat-wizard';
                bg = 'rgba(251, 191, 36, 0.1)';
                border = `4px solid ${themeColors.warning}`;
                text = themeColors.warning;
                title = settings.title || 'Magical Warning!';
                break;
            case 'info':
                icon = 'fa-crystal-ball';
                bg = 'rgba(255, 110, 199, 0.1)';
                border = `4px solid ${themeColors.primary}`;
                text = themeColors.primary;
                title = settings.title || 'Magic Insight!';
                break;
            default:
                icon = 'fa-stars';
                bg = 'rgba(167, 139, 250, 0.1)';
                border = `4px solid ${themeColors.secondary}`;
                text = themeColors.secondary;
                title = settings.title || 'Magic Notice!';
        }
        
        // Generate a unique ID for this alert
        const alertId = 'magical-alert-' + Date.now() + Math.floor(Math.random() * 1000);
        
        // Create alert element
        const alertEl = document.createElement('div');
        alertEl.id = alertId;
        alertEl.className = 'magical-alert';
        alertEl.style.backgroundColor = bg;
        alertEl.style.borderLeft = border;
        
        // Create alert content
        alertEl.innerHTML = `
            <div style="position: absolute; left: 0; top: 0; bottom: 0; display: flex; 
                        align-items: center; justify-content: center; width: 3.5rem; color: ${text}; font-size: 1.125rem;">
                <i class="fas ${icon}"></i>
            </div>
            <div style="padding-left: 4rem; padding-right: 3rem; padding-top: 1rem; padding-bottom: 1rem;">
                <h5 style="font-family: 'Itim', cursive, sans-serif; font-size: 1rem; font-weight: 600; 
                           margin-bottom: 0.25rem; color: ${text};">${title}</h5>
                <p style="font-family: 'Itim', cursive, sans-serif; font-size: 0.875rem; color: #4b5563;">${message}</p>
            </div>
            <button type="button" style="position: absolute; top: 0.5rem; right: 0.5rem; color: #9ca3af; 
                                        transition: color 0.2s; background: none; border: none; cursor: pointer;"
                    onclick="MagicalUI.closeAlert('${alertId}')">
                <i class="fas fa-times"></i>
            </button>
            <div style="position: absolute; top: 0.25rem; right: 1rem; animation: ping 3s cubic-bezier(0, 0, 0.2, 1) infinite; opacity: 0.5;">✨</div>
            <div style="position: absolute; bottom: 0.25rem; left: 4rem; animation: ping 3s cubic-bezier(0, 0, 0.2, 1) infinite 1s; opacity: 0.3;">✨</div>
        `;
        
        // Add to container
        alertContainer.appendChild(alertEl);
        
        // Auto-close if enabled
        if (settings.autoClose) {
            setTimeout(() => {
                closeAlert(alertId);
            }, settings.duration);
        }
        
        return alertId;
    }

    /**
     * Close an alert by ID
     * 
     * @param {string} alertId The ID of the alert to close
     */
    function closeAlert(alertId) {
        const alertElement = document.getElementById(alertId);
        if (alertElement) {
            // Start hiding animation
            alertElement.classList.add('hiding');
            
            // Remove from DOM after animation completes
            setTimeout(() => {
                if (alertElement.parentNode) {
                    alertElement.parentNode.removeChild(alertElement);
                }
            }, 500);
        }
    }

    /**
     * Create and show a SweetAlert-like popup
     * 
     * @param {string} message Message to display
     * @param {string} type Popup type (success, error, warning, info)
     * @param {Object} options Additional options
     * @param {number} [options.afterTime=0] Delay in ms before showing the popup
     * @param {number} [options.showTime=3000] Duration in ms to show popup (0 for manual close only)
     * @param {number} [options.animationDuration=300] Duration in ms for popup animation
     * @param {boolean} [options.showProgressBar=false] Whether to show a progress bar for auto-close
     * @returns {Object} Object containing popup ID and control methods
     */
    function renderPopup(message = '', type = 'success', options = {}) {
        ensureStyles();
        
        // Default options
        const settings = {
            afterTime: 0,           // Delay before showing
            showTime: 3000,         // Auto-close time (0 for manual close only)
            title: '',              // Custom title (if not provided, uses default for type)
            confirmText: 'OK',      // Button text
            onConfirm: null,        // Callback when confirmed
            animationDuration: 300, // Animation duration in ms
            showProgressBar: false, // Show progress bar for auto-close timing
            ...options
        };
        
        // Generate a unique ID for this popup
        const popupId = 'magical-popup-' + Date.now() + Math.floor(Math.random() * 1000);
        
        // Define icons, colors, and titles based on type
        let icon, bgColor, titleColor, borderColor, bgGlow;
        let title = settings.title;
        
        switch (type) {
            case 'success':
                icon = '<svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>';
                bgColor = `linear-gradient(to bottom right, rgba(${hexToRgb(themeColors.success)}, 0.1), rgba(${hexToRgb(themeColors.success)}, 0.05))`;
                titleColor = themeColors.success;
                borderColor = themeColors.success;
                bgGlow = 'rgba(74, 222, 128, 0.2)';
                if (!title) title = 'Success!';
                break;
            case 'error':
                icon = '<svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>';
                bgColor = `linear-gradient(to bottom right, rgba(${hexToRgb(themeColors.danger)}, 0.1), rgba(${hexToRgb(themeColors.danger)}, 0.05))`;
                titleColor = themeColors.danger;
                borderColor = themeColors.danger;
                bgGlow = 'rgba(248, 113, 113, 0.2)';
                if (!title) title = 'Error!';
                break;
            case 'warning':
                icon = '<svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>';
                bgColor = `linear-gradient(to bottom right, rgba(${hexToRgb(themeColors.warning)}, 0.1), rgba(${hexToRgb(themeColors.warning)}, 0.05))`;
                titleColor = themeColors.warning;
                borderColor = themeColors.warning;
                bgGlow = 'rgba(251, 191, 36, 0.2)';
                if (!title) title = 'Warning!';
                break;
            case 'info':
            default:
                icon = '<svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>';
                bgColor = `linear-gradient(to bottom right, rgba(${hexToRgb(themeColors.primary)}, 0.1), rgba(${hexToRgb(themeColors.primary)}, 0.05))`;
                titleColor = themeColors.primary;
                borderColor = themeColors.primary;
                bgGlow = 'rgba(255, 110, 199, 0.2)';
                if (!title) title = 'Information';
                break;
        }
        
        // Create popup container
        const popup = document.createElement('div');
        popup.id = popupId;
        popup.className = 'magical-popup';
        
        // Store callbacks and settings on the popup element
        popup._onConfirm = settings.onConfirm;
        popup._settings = settings;
        
        // Create progress bar HTML if enabled
        const progressBarHTML = settings.showProgressBar && settings.showTime > 0 ? 
            `<div class="magical-popup-progress" style="position: absolute; bottom: 0; left: 0; height: 3px; 
                  width: 100%; background-color: ${titleColor}; transform-origin: left; 
                  transition: transform ${settings.showTime}ms linear;"></div>` : '';
        
        // Create popup HTML structure
        popup.innerHTML = `
            <div class="magical-popup-backdrop"></div>
            <div class="magical-popup-content">
                <div style="background: ${bgColor}; backdrop-filter: blur(10px); 
                            border-top: 2px solid ${borderColor}; border-radius: 0.75rem; 
                            padding: 1.5rem; box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25); 
                            display: flex; flex-direction: column; align-items: center; text-align: center; position: relative; overflow: hidden;">
                    <div style="color: ${titleColor}; margin-bottom: 0.5rem; animation: bounce 1s infinite;">
                        ${icon}
                    </div>
                    <div class="magical-popup-sparkles" style="position: absolute; inset: 0; pointer-events: none; overflow: hidden; border-radius: 0.75rem;"></div>
                    <h3 style="font-family: 'Itim', cursive, sans-serif; font-size: 1.25rem; 
                               color: ${titleColor}; margin-bottom: 0.5rem; font-weight: 600;">${title}</h3>
                    <p style="color: #4b5563; font-family: 'Itim', cursive, sans-serif;">${message}</p>
                    <button type="button" class="magic-button" style="margin-top: 1.25rem; padding: 0.5rem 2rem;" 
                            onclick="MagicalUI.closePopup('${popupId}')">${settings.confirmText}</button>
                    ${progressBarHTML}
                </div>
            </div>
        `;
        
        // Append popup to body
        document.body.appendChild(popup);
        
        // Create sparkle elements
        const sparklesContainer = popup.querySelector('.magical-popup-sparkles');
        for (let i = 0; i < 7; i++) {
            const sparkle = document.createElement('div');
            sparkle.style.position = 'absolute';
            
            // Random position
            const top = Math.random() * 100;
            const left = Math.random() * 100;
            sparkle.style.top = `${top}%`;
            sparkle.style.left = `${left}%`;
            
            // Random size
            const size = Math.random() * 10 + 5;
            sparkle.style.width = `${size}px`;
            sparkle.style.height = `${size}px`;
            
            // Visual effect
            sparkle.style.background = 'white';
            sparkle.style.boxShadow = `0 0 10px ${bgGlow}`;
            sparkle.style.borderRadius = '50%';
            
            // Animation
            const delay = Math.random() * 3;
            const duration = 2 + Math.random() * 2;
            sparkle.style.animation = `popup-sparkle ${duration}s infinite ${delay}s`;
            
            sparklesContainer.appendChild(sparkle);
        }
        
        // Create popup controller with timing methods
        const popupController = {
            id: popupId,
            
            // Show the popup
            show: function(delay = null) {
                const delayTime = delay !== null ? delay : settings.afterTime;
                return new Promise(resolve => {
                    setTimeout(() => {
                        const popupEl = document.getElementById(this.id);
                        if (popupEl) {
                            popupEl.classList.add('show');
                            
                            // Animate progress bar if enabled
                            if (settings.showProgressBar && settings.showTime > 0) {
                                setTimeout(() => {
                                    const progressBar = popupEl.querySelector('.magical-popup-progress');
                                    if (progressBar) {
                                        progressBar.style.transform = 'scaleX(0)';
                                    }
                                }, 50); // Small delay to ensure transition works
                            }
                            
                            resolve(true);
                        } else {
                            resolve(false);
                        }
                    }, delayTime);
                });
            },
            
            // Hide the popup
            hide: function(runCallback = true) {
                return new Promise(resolve => {
                    closePopup(this.id, runCallback);
                    setTimeout(resolve, settings.animationDuration);
                });
            },
            
            // Reset auto-close timer
            resetTimer: function(newDuration = null) {
                const popupEl = document.getElementById(this.id);
                if (!popupEl) return false;
                
                // Clear any existing auto-close timer
                if (popupEl._autoCloseTimer) {
                    clearTimeout(popupEl._autoCloseTimer);
                }
                
                // Set new timer if duration is provided and greater than 0
                const duration = newDuration !== null ? newDuration : settings.showTime;
                if (duration > 0) {
                    popupEl._autoCloseTimer = setTimeout(() => {
                        closePopup(this.id);
                    }, duration);
                    
                    // Reset progress bar if it exists
                    if (settings.showProgressBar) {
                        const progressBar = popupEl.querySelector('.magical-popup-progress');
                        if (progressBar) {
                            progressBar.style.transition = 'none';
                            progressBar.style.transform = 'scaleX(1)';
                            setTimeout(() => {
                                progressBar.style.transition = `transform ${duration}ms linear`;
                                progressBar.style.transform = 'scaleX(0)';
                            }, 50);
                        }
                    }
                    
                    return true;
                }
                
                return false;
            }
        };
        
        // Show the popup after the specified delay
        popupController.show().then(() => {
            // Auto-close if showTime is provided and greater than 0
            if (settings.showTime > 0) {
                const popup = document.getElementById(popupId);
                if (popup) {
                    popup._autoCloseTimer = setTimeout(() => {
                        closePopup(popupId);
                    }, settings.showTime);
                }
            }
        });
        
        return popupController;
    }

    /**
     * Close a popup by ID
     * 
     * @param {string} popupId The ID of the popup to close
     * @param {boolean} runOnConfirm Whether to run the onConfirm callback
     */
    function closePopup(popupId, runOnConfirm = true) {
        const popup = document.getElementById(popupId);
        if (!popup) return;
        
        // Clear any auto-close timer
        if (popup._autoCloseTimer) {
            clearTimeout(popup._autoCloseTimer);
        }
        
        // Get animation duration from settings or use default
        const animDuration = popup._settings?.animationDuration || 300;
        
        // Hide with animation
        popup.classList.remove('show');
        
        // Remove from DOM after animation
        setTimeout(() => {
            if (popup.parentNode) {
                popup.parentNode.removeChild(popup);
            }
            
            // Call onConfirm callback if it exists
            if (runOnConfirm && popup._onConfirm && typeof popup._onConfirm === 'function') {
                popup._onConfirm();
            }
        }, animDuration);
    }
    
    /**
     * Set custom theme colors
     * 
     * @param {Object} colors Object containing color overrides
     */
    function setThemeColors(colors) {
        Object.assign(themeColors, colors);
        updateUIColors(); // Update UI colors after setting manually
    }
    
    /**
     * Update UI colors based on current theme colors
     * This applies the colors to CSS variables and updates any existing elements
     */
    function updateUIColors() {
        // Set CSS variables for use in CSS
        const root = document.documentElement;
        
        // Set the main colors
        Object.keys(themeColors).forEach(colorName => {
            root.style.setProperty(`--${colorName}`, themeColors[colorName]);
            
            // Also add RGB values for rgba() usage
            const rgbValue = hexToRgb(themeColors[colorName]);
            root.style.setProperty(`--${colorName}-rgb`, rgbValue);
        });
        
        // Update button styles and other dynamic elements
        updateButtonStyles();
        
        // Dispatch an event that other components can listen for
        window.dispatchEvent(new CustomEvent('themecolorschanged', { 
            detail: { colors: {...themeColors} }
        }));
    }
    
    /**
     * Update button styles to match the current theme colors
     */
    function updateButtonStyles() {
        // Get and update the styles
        ensureStyles();
        
        // If the magical-ui-styles tag was already created, update its content
        const styleTag = document.getElementById('magical-ui-styles');
        if (styleTag) {
            // Add/update button gradients and other themed styles
            const buttonStyles = `
                .magic-button {
                    background-image: linear-gradient(to right, ${themeColors.primary}, ${themeColors.secondary});
                    box-shadow: 0 10px 25px -5px rgba(${hexToRgb(themeColors.primary)}, 0.5);
                }
                
                .magic-button:hover {
                    box-shadow: 0 20px 35px -10px rgba(${hexToRgb(themeColors.primary)}, 0.6);
                }
                
                .magic-button-primary {
                    background-image: linear-gradient(to right, ${themeColors.primary}, rgba(${hexToRgb(themeColors.primary)}, 0.8));
                }
                
                .magic-button-secondary {
                    background-image: linear-gradient(to right, ${themeColors.secondary}, rgba(${hexToRgb(themeColors.secondary)}, 0.8));
                }
                
                .magic-button-success {
                    background-image: linear-gradient(to right, ${themeColors.success}, rgba(${hexToRgb(themeColors.success)}, 0.8));
                }
                
                .magic-button-warning {
                    background-image: linear-gradient(to right, ${themeColors.warning}, rgba(${hexToRgb(themeColors.warning)}, 0.8));
                }
                
                .magic-button-danger {
                    background-image: linear-gradient(to right, ${themeColors.danger}, rgba(${hexToRgb(themeColors.danger)}, 0.8));
                }
                
                /* Update other dynamic styles based on theme colors */
                .magical-alert {
                    box-shadow: 0 10px 25px -5px rgba(${hexToRgb(themeColors.primary)}, 0.5);
                }
            `;
            
            // Add button styles to the existing style tag
            const currentStyles = styleTag.textContent;
            if (!currentStyles.includes('.magic-button-primary')) {
                styleTag.textContent += buttonStyles;
            } else {
                // Replace existing button styles
                const updatedStyles = currentStyles.replace(
                    /.magic-button {[\s\S]*?}.magic-button-danger {[\s\S]*?}/gm,
                    buttonStyles
                );
                styleTag.textContent = updatedStyles;
            }
        }
        
        // Update any existing buttons in the DOM
        updateExistingButtons();
    }
    
    /**
     * Update any existing buttons in the DOM with new theme colors
     */
    function updateExistingButtons() {
        // Get all buttons with the magic-button class
        const magicButtons = document.querySelectorAll('.magic-button');
        
        magicButtons.forEach(button => {
            // Default button (primary + secondary gradient)
            if (button.classList.contains('magic-button') && 
                !button.classList.contains('magic-button-primary') && 
                !button.classList.contains('magic-button-secondary') &&
                !button.classList.contains('magic-button-success') &&
                !button.classList.contains('magic-button-warning') &&
                !button.classList.contains('magic-button-danger')) {
                button.style.backgroundImage = `linear-gradient(to right, ${themeColors.primary}, ${themeColors.secondary})`;
                button.style.boxShadow = `0 10px 25px -5px rgba(${hexToRgb(themeColors.primary)}, 0.5)`;
            }
            
            // Primary button
            if (button.classList.contains('magic-button-primary')) {
                button.style.backgroundImage = `linear-gradient(to right, ${themeColors.primary}, rgba(${hexToRgb(themeColors.primary)}, 0.8))`;
                button.style.boxShadow = `0 10px 25px -5px rgba(${hexToRgb(themeColors.primary)}, 0.5)`;
            }
            
            // Secondary button
            if (button.classList.contains('magic-button-secondary')) {
                button.style.backgroundImage = `linear-gradient(to right, ${themeColors.secondary}, rgba(${hexToRgb(themeColors.secondary)}, 0.8))`;
                button.style.boxShadow = `0 10px 25px -5px rgba(${hexToRgb(themeColors.secondary)}, 0.5)`;
            }
            
            // Success button
            if (button.classList.contains('magic-button-success')) {
                button.style.backgroundImage = `linear-gradient(to right, ${themeColors.success}, rgba(${hexToRgb(themeColors.success)}, 0.8))`;
                button.style.boxShadow = `0 10px 25px -5px rgba(${hexToRgb(themeColors.success)}, 0.5)`;
            }
            
            // Warning button
            if (button.classList.contains('magic-button-warning')) {
                button.style.backgroundImage = `linear-gradient(to right, ${themeColors.warning}, rgba(${hexToRgb(themeColors.warning)}, 0.8))`;
                button.style.boxShadow = `0 10px 25px -5px rgba(${hexToRgb(themeColors.warning)}, 0.5)`;
            }
            
            // Danger button
            if (button.classList.contains('magic-button-danger')) {
                button.style.backgroundImage = `linear-gradient(to right, ${themeColors.danger}, rgba(${hexToRgb(themeColors.danger)}, 0.8))`;
                button.style.boxShadow = `0 10px 25px -5px rgba(${hexToRgb(themeColors.danger)}, 0.5)`;
            }
        });
    }

    /**
     * Get current theme colors
     * 
     * @returns {Object} Current theme colors
     */
    function getThemeColors() {
        return {...themeColors};
    }

    // Export the public API
    const MagicalUI = {
        renderAlert,
        closeAlert,
        renderPopup,
        closePopup,
        setThemeColors,
        getThemeColors,
        fetchColors,
        setThemeColorsFromPHP,
        updateUIColors // Add updateUIColors to the public API
    };
    
    // Expose to window
    window.MagicalUI = MagicalUI;
    
})(window);
