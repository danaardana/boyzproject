class ChatBubble {
    constructor(options = {}) {
        this.options = {
            position: 'bottom-right',
            theme: 'default',
            greeting: 'Hi! How can I help you today?',
            botName: 'Support',
            botAvatar: 'CS',
            userAvatar: 'You',
            apiEndpoint: null,
            autoResponses: {
                'hello': 'Hello! How can I assist you today?',
                'hi': 'Hi there! What can I do for you?',
                'help': 'I\'m here to help! What do you need assistance with?',
                'contact': 'You can reach us at contact@example.com or call (555) 123-4567',
                'hours': 'Our support hours are Monday-Friday 9AM-6PM EST',
                'pricing': 'For pricing information, please visit our pricing page or contact our sales team.',
                'demo': 'Would you like to schedule a demo? I can help you get started!',
                'thanks': 'You\'re welcome! Is there anything else I can help you with?',
                'bye': 'Goodbye! Feel free to reach out if you need any help.',
                'default': 'I understand you\'re asking about: "{{message}}". Let me connect you with a human agent who can better assist you.'
            },
            ...options
        };

        this.isOpen = false;
        this.messages = [];
        this.typingTimeout = null;
        this.hasStartedChat = false; // Track if user has sent first message

        this.init();
    }

    init() {
        this.createChatBubble();
        this.attachEventListeners();
        this.addInitialMessage();
    }

    createChatBubble() {
        const chatBubbleHTML = `
            <div class="chat-bubble">
                <button class="chat-bubble-btn" id="chatBubbleBtn">
                    <svg class="chat-bubble-icon" viewBox="0 0 24 24">
                        <path d="M20 2H4c-1.1 0-2 .9-2 2v12c0 1.1.9 2 2 2h4l4 4 4-4h4c1.1 0 2-.9 2-2V4c0-1.1-.9-2-2-2zm-2 12H6v-2h12v2zm0-3H6V9h12v2zm0-3H6V6h12v2z"/>
                    </svg>
                    <div class="online-status"></div>
                </button>
                
                <div class="chat-window" id="chatWindow">
                    <div class="chat-header">
                        <div class="chat-avatar">${this.options.botAvatar}</div>
                        <div class="chat-info">
                            <h4>${this.options.botName}</h4>
                            <p>Typically replies instantly</p>
                        </div>
                    </div>
                    
                    <div class="chat-messages" id="chatMessages">
                        <div class="quick-actions" id="quickActions">
                            <button class="quick-action" data-message="I need help">I need help</button>
                            <button class="quick-action" data-message="Contact information">Contact info</button>
                            <button class="quick-action" data-message="Business hours">Business hours</button>
                            <button class="quick-action" data-message="Pricing information">Pricing</button>
                        </div>
                        <div class="messages-container" id="messagesContainer">
                            <!-- Messages will be added here -->
                        </div>
                        <div class="typing-indicator" id="typingIndicator">
                            <div class="typing-dot"></div>
                            <div class="typing-dot"></div>
                            <div class="typing-dot"></div>
                        </div>
                    </div>
                    
                    <div class="chat-input">
                        <div class="input-group">
                            <textarea 
                                class="chat-input-field" 
                                id="chatInputField" 
                                placeholder="Type a message..." 
                                rows="1"
                            ></textarea>
                            <button class="send-btn" id="sendBtn">
                                <svg width="20" height="20" viewBox="0 0 24 24" fill="currentColor">
                                    <path d="M2.01 21L23 12 2.01 3 2 10l15 2-15 2z"/>
                                </svg>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        `;

        document.body.insertAdjacentHTML('beforeend', chatBubbleHTML);
    }

    attachEventListeners() {
        const chatBubbleBtn = document.getElementById('chatBubbleBtn');
        const chatWindow = document.getElementById('chatWindow');
        const chatInputField = document.getElementById('chatInputField');
        const sendBtn = document.getElementById('sendBtn');
        const quickActions = document.querySelectorAll('.quick-action');

        // Toggle chat window
        chatBubbleBtn.addEventListener('click', () => {
            this.toggleChat();
        });

        // Close chat when clicking outside
        document.addEventListener('click', (e) => {
            if (!e.target.closest('.chat-bubble') && this.isOpen) {
                this.closeChat();
            }
        });

        // Send message on button click
        sendBtn.addEventListener('click', () => {
            this.sendMessage();
        });

        // Send message on Enter key (without Shift)
        chatInputField.addEventListener('keydown', (e) => {
            if (e.key === 'Enter' && !e.shiftKey) {
                e.preventDefault();
                this.sendMessage();
            }
        });

        // Auto-resize textarea
        chatInputField.addEventListener('input', () => {
            this.autoResizeTextarea(chatInputField);
        });

        // Quick action buttons
        quickActions.forEach(button => {
            button.addEventListener('click', () => {
                const message = button.getAttribute('data-message');
                this.sendUserMessage(message);
                this.processMessage(message);
                this.hideQuickActions(); // Hide quick actions after first use
            });
        });
    }

    hideQuickActions() {
        const quickActions = document.getElementById('quickActions');
        if (quickActions && !this.hasStartedChat) {
            this.hasStartedChat = true;
            quickActions.style.transition = 'opacity 0.3s ease, height 0.3s ease';
            quickActions.style.opacity = '0';
            quickActions.style.height = '0';
            quickActions.style.marginBottom = '0';
            quickActions.style.overflow = 'hidden';
            
            // Remove from DOM after animation
            setTimeout(() => {
                if (quickActions.parentNode) {
                    quickActions.parentNode.removeChild(quickActions);
                }
            }, 300);
        }
    }

    toggleChat() {
        if (this.isOpen) {
            this.closeChat();
        } else {
            this.openChat();
        }
    }

    openChat() {
        const chatBubbleBtn = document.getElementById('chatBubbleBtn');
        const chatWindow = document.getElementById('chatWindow');
        
        this.isOpen = true;
        chatBubbleBtn.classList.add('active');
        chatWindow.classList.add('active');
        
        // Focus on input field
        setTimeout(() => {
            document.getElementById('chatInputField').focus();
        }, 300);
    }

    closeChat() {
        const chatBubbleBtn = document.getElementById('chatBubbleBtn');
        const chatWindow = document.getElementById('chatWindow');
        
        this.isOpen = false;
        chatBubbleBtn.classList.remove('active');
        chatWindow.classList.remove('active');
    }

    sendMessage() {
        const chatInputField = document.getElementById('chatInputField');
        const message = chatInputField.value.trim();
        
        if (message) {
            this.sendUserMessage(message);
            chatInputField.value = '';
            this.autoResizeTextarea(chatInputField);
            this.processMessage(message);
            
            // Hide quick actions after first user message
            if (!this.hasStartedChat) {
                this.hideQuickActions();
            }
        }
    }

    sendUserMessage(message) {
        const timestamp = this.getCurrentTime();
        const messageHTML = `
            <div class="message user">
                <div class="message-content">
                    <div class="message-bubble">${this.escapeHtml(message)}</div>
                    <div class="message-time">${timestamp}</div>
                </div>
            </div>
        `;
        
        this.addMessageToChat(messageHTML);
        this.messages.push({ type: 'user', message, timestamp });
        this.scrollToBottom();
    }

    sendBotMessage(message) {
        const timestamp = this.getCurrentTime();
        const messageHTML = `
            <div class="message bot">
                <div class="message-avatar">${this.options.botAvatar}</div>
                <div class="message-content">
                    <div class="message-bubble">${message}</div>
                    <div class="message-time">${timestamp}</div>
                </div>
            </div>
        `;
        
        this.addMessageToChat(messageHTML);
        this.messages.push({ type: 'bot', message, timestamp });
        this.scrollToBottom();
    }

    addMessageToChat(messageHTML) {
        const messagesContainer = document.getElementById('messagesContainer');
        
        if (messagesContainer) {
            messagesContainer.insertAdjacentHTML('beforeend', messageHTML);
        } else {
            // Fallback if messagesContainer doesn't exist
            const chatMessages = document.getElementById('chatMessages');
            const typingIndicator = document.getElementById('typingIndicator');
            typingIndicator.insertAdjacentHTML('beforebegin', messageHTML);
        }
    }

    scrollToBottom() {
        const chatMessages = document.getElementById('chatMessages');
        // Use requestAnimationFrame for smooth scrolling
        requestAnimationFrame(() => {
            chatMessages.scrollTop = chatMessages.scrollHeight;
        });
    }

    processMessage(message) {
        // Show typing indicator
        this.showTypingIndicator();
        
        // Simulate processing time
        setTimeout(() => {
            this.hideTypingIndicator();
            
            const response = this.generateResponse(message);
            this.sendBotMessage(response);
        }, 1000 + Math.random() * 1500); // Random delay between 1-2.5 seconds
    }

    generateResponse(message) {
        const lowerMessage = message.toLowerCase();
        
        // Check for specific keywords
        for (const [keyword, response] of Object.entries(this.options.autoResponses)) {
            if (keyword !== 'default' && lowerMessage.includes(keyword)) {
                return response;
            }
        }
        
        // Default response
        return this.options.autoResponses.default.replace('{{message}}', message);
    }

    showTypingIndicator() {
        const typingIndicator = document.getElementById('typingIndicator');
        typingIndicator.style.display = 'flex';
        this.scrollToBottom();
    }

    hideTypingIndicator() {
        const typingIndicator = document.getElementById('typingIndicator');
        typingIndicator.style.display = 'none';
    }

    addInitialMessage() {
        setTimeout(() => {
            this.sendBotMessage(this.options.greeting);
        }, 500);
    }

    autoResizeTextarea(textarea) {
        textarea.style.height = 'auto';
        textarea.style.height = Math.min(textarea.scrollHeight, 80) + 'px';
    }

    getCurrentTime() {
        const now = new Date();
        return now.toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' });
    }

    escapeHtml(text) {
        const map = {
            '&': '&amp;',
            '<': '&lt;',
            '>': '&gt;',
            '"': '&quot;',
            "'": '&#039;'
        };
        return text.replace(/[&<>"']/g, m => map[m]);
    }

    // Public methods for customization
    updateOptions(newOptions) {
        this.options = { ...this.options, ...newOptions };
    }

    addCustomResponse(keyword, response) {
        this.options.autoResponses[keyword] = response;
    }

    clearChat() {
        const messagesContainer = document.getElementById('messagesContainer');
        if (messagesContainer) {
            messagesContainer.innerHTML = '';
        }
        
        this.messages = [];
        this.hasStartedChat = false;
        
        // Re-add quick actions if they were removed
        const chatMessages = document.getElementById('chatMessages');
        const quickActionsExist = document.getElementById('quickActions');
        
        if (!quickActionsExist) {
            const quickActionsHTML = `
                <div class="quick-actions" id="quickActions">
                    <button class="quick-action" data-message="I need help">I need help</button>
                    <button class="quick-action" data-message="Contact information">Contact info</button>
                    <button class="quick-action" data-message="Business hours">Business hours</button>
                    <button class="quick-action" data-message="Pricing information">Pricing</button>
                </div>
            `;
            chatMessages.insertAdjacentHTML('afterbegin', quickActionsHTML);
            
            // Re-attach event listeners for quick actions
            const quickActions = document.querySelectorAll('.quick-action');
            quickActions.forEach(button => {
                button.addEventListener('click', () => {
                    const message = button.getAttribute('data-message');
                    this.sendUserMessage(message);
                    this.processMessage(message);
                    this.hideQuickActions();
                });
            });
        }
        
        this.addInitialMessage();
    }

    getMessages() {
        return this.messages;
    }
}

// Initialize chat bubble when DOM is loaded
document.addEventListener('DOMContentLoaded', function() {
    // Check if chat bubble should be initialized
    if (!document.querySelector('.chat-bubble')) {
        window.chatBubble = new ChatBubble({
            botName: 'Boys Project Support',
            botAvatar: 'BP',
            greeting: 'Hi! Welcome to Boys Project! How can I help you today? 👋',
            autoResponses: {
                'hello': 'Hello! Welcome to Boys Project! How can I assist you today?',
                'hi': 'Hi there! Thanks for visiting Boys Project. What can I do for you?',
                'help': 'I\'m here to help! What do you need assistance with regarding our services?',
                'contact': 'You can reach us at info@boysproject.com or through our contact form. We\'d love to hear from you!',
                'hours': 'We\'re available Monday-Friday 9AM-6PM. For urgent matters, please use our contact form!',
                'pricing': 'For detailed pricing information, please check our services page or contact us for a custom quote!',
                'services': 'We offer a wide range of digital services. What specific service are you interested in?',
                'portfolio': 'Check out our portfolio section to see our amazing work and client success stories!',
                'team': 'Our team consists of experienced professionals ready to bring your ideas to life!',
                'about': 'Boys Project is dedicated to delivering exceptional digital solutions. Learn more about us in our About section!',
                'demo': 'Would you like to see a demo of our work? I can help you schedule a consultation!',
                'thanks': 'You\'re very welcome! Is there anything else about Boys Project I can help you with?',
                'bye': 'Goodbye! Thank you for your interest in Boys Project. Feel free to reach out anytime!',
                'default': 'Thanks for your message: "{{message}}". Let me connect you with our team for detailed assistance!'
            }
        });
    }
});

// Export for use in other scripts
if (typeof module !== 'undefined' && module.exports) {
    module.exports = ChatBubble;
} 