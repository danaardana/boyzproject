class ChatBubble {
    constructor(options = {}) {
        this.options = {
            position: 'bottom-right',
            theme: 'default',
            greeting: 'Hai! Bagaimana saya bisa membantu Anda hari ini?',
            botName: 'Dukungan',
            botAvatar: 'CS',
            userAvatar: 'Anda',
            apiEndpoint: null,
            showChatOptions: true, // New option to show chat type selection
            useMLModel: true, // Enable ML model for intelligent responses
            autoResponses: {
                'halo': 'Halo! Bagaimana saya bisa membantu Anda hari ini?',
                'hai': 'Hai! Ada yang bisa saya bantu?',
                'help': 'Saya di sini untuk membantu! Apa yang Anda butuhkan?',
                'bantuan': 'Saya di sini untuk membantu! Apa yang Anda butuhkan?',
                'kontak': 'Anda bisa menghubungi kami di contact@boysproject.com atau telepon 08211990442',
                'jam': 'Jam operasional kami adalah Senin-Jumat 09:00-18:00 WIB',
                'harga': 'Untuk informasi harga, silakan kunjungi halaman harga kami atau hubungi tim penjualan.',
                'pricing': 'Untuk informasi harga, silakan kunjungi halaman harga kami atau hubungi tim penjualan.',
                'demo': 'Apakah Anda ingin menjadwalkan demo? Saya bisa membantu Anda memulai!',
                'terima kasih': 'Sama-sama! Ada hal lain yang bisa saya bantu?',
                'thanks': 'Sama-sama! Ada hal lain yang bisa saya bantu?',
                'selamat tinggal': 'Selamat tinggal! Jangan ragu untuk menghubungi kami jika butuh bantuan.',
                'bye': 'Selamat tinggal! Jangan ragu untuk menghubungi kami jika butuh bantuan.',
                'default': 'Saya memahami Anda bertanya tentang: "{{message}}". Biarkan saya menghubungkan Anda dengan agen manusia yang dapat membantu lebih baik.'
            },
            ...options
        };

        this.isOpen = false;
        this.messages = [];
        this.typingTimeout = null;
        this.hasStartedChat = false;
        this.chatMode = null; // 'landing' or 'admin'
        this.adminConversationId = null; // Track admin conversation
        this.customerData = {}; // Store customer information
        this.dataCollectionStep = null; // Track data collection progress
        this.isCollectingData = false;
        this.displayedMessages = []; // Track displayed message IDs
        this.pollingInterval = null; // For polling admin messages
        this.lastMessageCount = 0; // Track message count for updates
        this.hasStartedDataCollection = false;
        this.needsToStartAdminConversation = false;
        this.pendingAdminSuggestion = false;
        
        this.init();
    }

    init() {
        this.createChatBubble();
        this.attachEventListeners();
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
                    ${this.createChatModeSelection()}
                    ${this.createChatInterface()}
                </div>
            </div>
        `;

        document.body.insertAdjacentHTML('beforeend', chatBubbleHTML);
    }

    createChatModeSelection() {
        if (!this.options.showChatOptions) return '';
        
        return `
            <div class="chat-mode-selection" id="chatModeSelection">
                <div class="chat-header">
                    <div class="chat-avatar">BP</div>
                    <div class="chat-info">
                        <h4>Boys Project</h4>
                        <p>Pilih jenis bantuan yang Anda butuhkan</p>
                    </div>
                </div>
                
                <div class="chat-mode-options">
                    <button class="chat-mode-option" data-mode="landing">
                        <div class="mode-icon">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="currentColor">
                                <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 15l-5-5 1.41-1.41L10 14.17l7.59-7.59L19 8l-9 9z"/>
                            </svg>
                        </div>
                        <div class="mode-content">
                            <h4>Chat Otomatis</h4>
                            <p>Dapatkan jawaban cepat untuk pertanyaan umum tentang layanan kami</p>
                        </div>
                    </button>
                    
                    <button class="chat-mode-option" data-mode="admin">
                        <div class="mode-icon">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="currentColor">
                                <path d="M16 4c0-1.11.89-2 2-2s2 .89 2 2-.89 2-2 2-2-.89-2-2zM4 18v-4h3v4h2v-7.5c0-1.1.9-2 2-2s2 .9 2 2V11h2v7h2v-4h3v4h-3v2H4v-2z"/>
                            </svg>
                        </div>
                        <div class="mode-content">
                            <h4>Chat dengan Admin</h4>
                            <p>Bicara langsung dengan tim dukungan kami untuk bantuan personal</p>
                        </div>
                    </button>
                </div>
            </div>
        `;
    }

    createChatInterface() {
        return `
            <div class="chat-interface" id="chatInterface" style="display: none;">
                <div class="chat-header">
                    <button class="back-btn" id="backBtn">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="currentColor">
                            <path d="M20 11H7.83l5.59-5.59L12 4l-8 8 8 8 1.41-1.41L7.83 13H20v-2z"/>
                        </svg>
                    </button>
                    <div class="chat-avatar" id="chatAvatar">${this.options.botAvatar}</div>
                    <div class="chat-info">
                        <h4 id="chatTitle">${this.options.botName}</h4>
                        <p id="chatStatus">Biasanya membalas langsung</p>
                    </div>
                </div>
                
                <!-- Customer Form -->
                <div class="customer-form" id="customerForm">
                    <div class="form-header">
                        <div class="form-avatar">BP</div>
                        <div class="form-title">
                            <h3>Hi, Selamat Datang di Livechat Boys Project. Mohon isi nama dan nomor ponsel kamu dibawah ini ya</h3>
                        </div>
                    </div>
                    
                    <div class="form-content">
                        <div class="form-group">
                            <input type="text" id="customerName" class="form-input" placeholder="Nama" required>
                        </div>
                        
                        <div class="form-group phone-group">
                            <div class="phone-input-wrapper">
                                <span class="country-code">🇮🇩 +62</span>
                                <input type="tel" id="customerPhone" class="form-input phone-input" placeholder="8277249066611" required>
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <input type="email" id="customerEmail" class="form-input" placeholder="Email (Opsional)">
                        </div>
                        
                        <div class="form-footer">
                            <div class="form-agreement">
                                <input type="checkbox" id="agreementCheck" checked>
                                <label for="agreementCheck">Saya telah membaca & setuju dengan <a href="/terms" target="_blank" class="agreement-link">syarat & ketentuan ini</a></label>
                            </div>
                            
                            <button type="button" class="connect-btn" id="connectBtn">
                                HUBUNGKAN
                            </button>
                        </div>
                    </div>
                </div>
                
                <div class="chat-messages" id="chatMessages" style="display: none;">
                    <div class="quick-actions" id="quickActions">
                        <button class="quick-action" data-message="Saya butuh bantuan">Saya butuh bantuan</button>
                        <button class="quick-action" data-message="Informasi kontak">Info kontak</button>
                        <button class="quick-action" data-message="Jam operasional">Jam operasional</button>
                        <button class="quick-action" data-message="Informasi harga">Harga</button>
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
                
                <div class="chat-input" id="chatInput" style="display: none;">
                    <div class="input-group">
                        <textarea 
                            class="chat-input-field" 
                            id="chatInputField" 
                            placeholder="Ketik pesan..." 
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
        `;
    }

    attachEventListeners() {
        console.log('🎧 [DEBUG] Attaching event listeners...');
        
        const chatBubbleBtn = document.getElementById('chatBubbleBtn');
        const chatWindow = document.getElementById('chatWindow');
        const chatInputField = document.getElementById('chatInputField');
        const sendBtn = document.getElementById('sendBtn');
        const backBtn = document.getElementById('backBtn');

        console.log('🎧 [DEBUG] Elements found:', {
            chatBubbleBtn: !!chatBubbleBtn,
            chatWindow: !!chatWindow,
            chatInputField: !!chatInputField,
            sendBtn: !!sendBtn,
            backBtn: !!backBtn
        });

        // Toggle chat window
        if (chatBubbleBtn) {
            chatBubbleBtn.addEventListener('click', () => {
                console.log('👆 [DEBUG] Chat bubble button clicked!');
                this.toggleChat();
            });
        }

        // Close chat when clicking outside
        document.addEventListener('click', (e) => {
            if (!e.target.closest('.chat-bubble') && this.isOpen) {
                console.log('👆 [DEBUG] Clicked outside chat, closing...');
                this.closeChat();
            }
        });

        // Back button to return to mode selection
        if (backBtn) {
            backBtn.addEventListener('click', () => {
                console.log('👆 [DEBUG] Back button clicked!');
                this.showModeSelection();
            });
        }

        // Chat mode selection
        const modeOptions = document.querySelectorAll('.chat-mode-option');
        console.log('🎧 [DEBUG] Mode options found:', modeOptions.length);
        
        modeOptions.forEach((option, index) => {
            option.addEventListener('click', () => {
                const mode = option.getAttribute('data-mode');
                console.log(`👆 [DEBUG] Mode option ${index} clicked! Mode:`, mode);
                this.selectChatMode(mode);
            });
        });

        // Send message on button click
        if (sendBtn) {
            sendBtn.addEventListener('click', () => {
                console.log('👆 [DEBUG] Send button clicked!');
                this.sendMessage();
            });
        }

        // Send message on Enter key (without Shift)
        if (chatInputField) {
            chatInputField.addEventListener('keydown', (e) => {
                if (e.key === 'Enter' && !e.shiftKey) {
                    e.preventDefault();
                    console.log('⌨️ [DEBUG] Enter key pressed!');
                    this.sendMessage();
                }
            });

            // Auto-resize textarea
            chatInputField.addEventListener('input', () => {
                this.autoResizeTextarea(chatInputField);
            });
        }

        // Quick action buttons (will be attached when chat mode is selected)
        this.attachQuickActionListeners();
        
        console.log('✅ [DEBUG] All event listeners attached!');
    }

    attachQuickActionListeners() {
        const quickActions = document.querySelectorAll('.quick-action');
        quickActions.forEach(button => {
            button.addEventListener('click', () => {
                const message = button.getAttribute('data-message');
                this.sendUserMessage(message);
                if (this.chatMode === 'landing') {
                    this.processMessage(message);
                } else {
                    this.sendToAdmin(message);
                }
                this.hideQuickActions();
            });
        });
    }

    selectChatMode(mode) {
        console.log('🎯 [DEBUG] selectChatMode called with mode:', mode);
        
        this.chatMode = mode;
        
        // Hide mode selection
        const modeSelection = document.getElementById('chatModeSelection');
        const chatInterface = document.getElementById('chatInterface');
        
        console.log('🎯 [DEBUG] Elements for mode switching:', {
            modeSelection: !!modeSelection,
            chatInterface: !!chatInterface
        });
        
        if (modeSelection && chatInterface) {
            modeSelection.style.display = 'none';
            chatInterface.style.display = 'block';
        }
        
        if (mode === 'admin') {
            console.log('🎯 [DEBUG] Admin mode selected, starting data collection...');
            
            // Update chat header for admin mode
            document.getElementById('chatTitle').textContent = 'Tim Dukungan';
            document.getElementById('chatStatus').textContent = 'Mengumpulkan informasi...';
            
            // Start data collection process
            this.updateQuickActionsForAdmin();
            this.startDataCollectionProcess();
        } else if (mode === 'landing') {
            console.log('🎯 [DEBUG] Landing mode selected, enabling normal chat...');
            
            // Update chat header for landing mode
            document.getElementById('chatTitle').textContent = this.options.botName;
            document.getElementById('chatStatus').textContent = 'Biasanya membalas langsung';
            
            // Enable normal chat
            this.enableNormalChatInput();
            this.addInitialMessage();
        }
        
        console.log('✅ [DEBUG] Chat mode set to:', this.chatMode);
    }

    updateQuickActionsForAdmin() {
        const quickActions = document.getElementById('quickActions');
        if (quickActions) {
            quickActions.innerHTML = `
                <button class="quick-action" data-message="Saya tertarik dengan layanan Anda">Tertarik dengan layanan</button>
                <button class="quick-action" data-message="Saya membutuhkan konsultasi">Butuh konsultasi</button>
                <button class="quick-action" data-message="Tanya harga proyek">Tanya harga</button>
                <button class="quick-action" data-message="Ingin melihat portfolio">Lihat portfolio</button>
            `;
        }
    }

    enableNormalChatInput() {
        // Reset input placeholder and re-enable for normal chat
        const inputField = document.getElementById('chatInputField');
        const sendBtn = document.getElementById('sendBtn');
        
        if (inputField) {
            inputField.disabled = false;  // Re-enable the input field
            inputField.placeholder = 'Ketik pesan Anda...';
            inputField.focus();
        }
        
        if (sendBtn) {
            sendBtn.disabled = false;  // Re-enable the send button
        }
        
        // Update status
        document.getElementById('chatStatus').textContent = 'Tim dukungan siap membantu';
        
        console.log('✅ [DEBUG] Normal chat input enabled');
    }

    showOngoingChatActions() {
        const quickActions = document.getElementById('quickActions');
        if (quickActions) {
            quickActions.innerHTML = `
                <button class="quick-action" data-message="Terima kasih atas bantuannya">Terima kasih</button>
                <button class="quick-action" data-message="Saya ada pertanyaan lain">Pertanyaan lain</button>
                <button class="quick-action" data-message="Mohon info lebih detail">Info detail</button>
                <button class="quick-action" data-message="Kapan bisa diproses?">Timeline</button>
            `;
        }
    }

    showModeSelection() {
        document.getElementById('chatModeSelection').style.display = 'block';
        document.getElementById('chatInterface').style.display = 'none';
        this.chatMode = null;
        this.clearChat();
    }

    sendToAdmin(message) {
        // Check if we need to collect customer data first
        if (!this.adminConversationId && !this.dataCollectionStep) {
            this.startDataCollection(message);
        } else if (this.dataCollectionStep) {
            this.handleDataCollectionResponse(message);
        } else {
            this.sendMessageToAdmin(message);
        }
    }

    startDataCollectionProcess() {
        console.log('📋 [DEBUG] Starting data collection process...');
        
        this.isCollectingData = true;
        this.customerData = {
            name: null,
            email: null,
            message: null
        };
        
        console.log('📋 [DEBUG] Customer data initialized:', this.customerData);
        
        // Start with name collection
        this.showNameInputPrompt();
    }

    startDataCollection(initialMessage) {
        // Store the initial message to send later (for manual message sending)
        this.customerData.initialMessage = initialMessage;
        this.dataCollectionStep = 'name';
        
        // Show typing indicator briefly
        this.showTypingIndicator();
        
        setTimeout(() => {
            this.hideTypingIndicator();
            this.sendBotMessage('Sebelum mengirim pesan Anda, saya perlu tahu siapa Anda. 😊');
            
            setTimeout(() => {
                this.sendBotMessage('Boleh saya tahu nama Anda?');
                this.showNameInputPrompt();
                this.enableDataCollectionInput();
            }, 1000);
        }, 500);
    }

    enableDataCollectionInput() {
        console.log('⌨️ [DEBUG] enableDataCollectionInput called');
        
        const inputField = document.getElementById('chatInputField');
        const sendBtn = document.getElementById('sendBtn');
        
        console.log('⌨️ [DEBUG] Input elements:', {
            inputField: !!inputField,
            sendBtn: !!sendBtn
        });
        
        if (inputField) {
            inputField.disabled = false;
            inputField.placeholder = 'Ketik nama Anda...';
        }
        
        if (sendBtn) {
            sendBtn.disabled = false;
        }
        
        console.log('✅ [DEBUG] Data collection input enabled');
    }

    handleDataCollectionResponse(message) {
        console.log('📝 [DEBUG] Data collection response:', message);
        console.log('📝 [DEBUG] Current collection step:', this.dataCollectionStep);
        console.log('📝 [DEBUG] Current customer data:', this.customerData);
        
        switch (this.dataCollectionStep) {
            case 'name':
                if (message.trim().length < 2) {
                    this.sendBotMessage('Mohon masukkan nama yang valid (minimal 2 karakter).');
                    return;
                }
                
                this.customerData.name = message.trim();
                console.log('✅ [DEBUG] Name collected:', this.customerData.name);
                this.showPhoneInputPrompt();
                break;
                
            case 'phone':
                const phoneNumber = this.cleanPhoneNumber(message.trim());
                if (!this.isValidIndonesianPhone(phoneNumber)) {
                    this.sendBotMessage('Nomor telepon tidak valid. Mohon masukkan nomor HP Indonesia yang benar (contoh: 081234567890 atau +6281234567890).');
                    return;
                }
                
                this.customerData.phone = phoneNumber;
                console.log('✅ [DEBUG] Phone collected:', this.customerData.phone);
                
                // Check if customer exists with this phone number
                this.checkExistingCustomer(phoneNumber);
                break;
                
            case 'email':
                if (message.toLowerCase() === 'skip' || message.toLowerCase() === 'lewati') {
                    this.customerData.email = null;
                    console.log('📝 [DEBUG] Email skipped');
                } else if (message.trim() && !this.isValidEmail(message.trim())) {
                    this.sendBotMessage('Format email tidak valid. Mohon masukkan email yang benar atau ketik "lewati" untuk melanjutkan tanpa email.');
                    return;
                } else {
                    this.customerData.email = message.trim() || null;
                    console.log('✅ [DEBUG] Email collected:', this.customerData.email);
                }
                
                // Customer data collection completed, now show mode selection
                this.completeDataCollection();
                break;
                
            default:
                console.error('❌ [DEBUG] Unknown data collection step:', this.dataCollectionStep);
                this.sendBotMessage('Terjadi kesalahan. Silakan mulai ulang percakapan.');
                this.showModeSelection();
        }
    }

    cleanPhoneNumber(phone) {
        // Remove all non-digit characters except +
        let cleaned = phone.replace(/[^\d+]/g, '');
        
        // If starts with +62, keep it
        if (cleaned.startsWith('+62')) {
            return cleaned;
        }
        
        // If starts with 62, add +
        if (cleaned.startsWith('62')) {
            return '+' + cleaned;
        }
        
        // If starts with 0, replace with +62
        if (cleaned.startsWith('0')) {
            return '+62' + cleaned.substring(1);
        }
        
        // If starts with 8, assume it's missing the 0
        if (cleaned.startsWith('8')) {
            return '+62' + cleaned;
        }
        
        return cleaned;
    }

    isValidIndonesianPhone(phone) {
        // Indonesian phone number validation
        // Should start with +62 followed by 8-15 digits
        const phoneRegex = /^\+62[8-9]\d{7,12}$/;
        return phoneRegex.test(phone);
    }

    checkExistingCustomer(phoneNumber) {
        console.log('🔍 [DEBUG] Checking existing customer for phone:', phoneNumber);
        
        // Make API call to check if customer exists
        fetch('/chat/check-customer', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || ''
            },
            body: JSON.stringify({
                phone: phoneNumber
            })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success && data.customer_exists) {
                this.sendBotMessage(`Halo ${data.customer.name}! Kami sudah mengenali nomor Anda. 😊`);
                
                // If customer exists, update our data with existing info
                this.customerData.name = data.customer.name;
                this.customerData.email = data.customer.email;
                this.customerData.existing_customer = true;
                this.customerData.customer_id = data.customer.id;
                
                if (data.has_chat_history) {
                    setTimeout(() => {
                        this.sendBotMessage('Anda memiliki riwayat percakapan sebelumnya. Apakah ada yang bisa kami bantu hari ini?');
                        this.showMessageInputPrompt();
                    }, 1000);
                } else {
                    setTimeout(() => {
                        this.sendBotMessage('Senang bertemu Anda lagi! Ada yang bisa kami bantu hari ini?');
                        this.showMessageInputPrompt();
                    }, 1000);
                }
            } else {
                // New customer, continue with email collection
                this.showEmailInputPrompt();
            }
        })
        .catch(error => {
            console.error('Error checking customer:', error);
            // Continue with normal flow if API fails
            this.showEmailInputPrompt();
        });
    }

    showNameInputPrompt() {
        console.log('👤 [DEBUG] showNameInputPrompt called');
        
        this.dataCollectionStep = 'name';
        
        // Show typing indicator
        this.showTypingIndicator();
        
        setTimeout(() => {
            this.hideTypingIndicator();
            this.sendBotMessage('Halo! Selamat datang di Boys Project Support! 👋');
            
            setTimeout(() => {
                this.sendBotMessage('Sebelum menghubungkan Anda dengan tim dukungan kami, saya perlu beberapa informasi dulu.');
                
                setTimeout(() => {
                    this.sendBotMessage('Boleh saya tahu nama Anda?');
                    this.enableDataCollectionInput();
                    
                    // Update input placeholder
                    const inputField = document.getElementById('chatInputField');
                    if (inputField) {
                        inputField.placeholder = 'Ketik nama Anda...';
                        inputField.focus();
                    }
                    
                    console.log('✅ [DEBUG] Name input prompt shown');
                }, 1500);
            }, 1000);
        }, 500);
    }

    showPhoneInputPrompt() {
        console.log('📱 [DEBUG] showPhoneInputPrompt called');
        
        this.dataCollectionStep = 'phone';
        
        this.sendBotMessage(`Terima kasih, ${this.customerData.name}! 👋`);
        
        setTimeout(() => {
            this.sendBotMessage('Boleh saya minta nomor HP Anda?');
            setTimeout(() => {
                this.sendBotMessage('📱 <em>Nomor HP diperlukan untuk menyimpan riwayat percakapan dan memudahkan komunikasi selanjutnya.</em>');
                
                // Update input placeholder
                const inputField = document.getElementById('chatInputField');
                if (inputField) {
                    inputField.placeholder = 'Contoh: 081234567890';
                    inputField.disabled = false;
                    inputField.focus();
                }
                
                const sendBtn = document.getElementById('sendBtn');
                if (sendBtn) {
                    sendBtn.disabled = false;
                }
                
                console.log('✅ [DEBUG] Phone input prompt shown');
            }, 1000);
        }, 1000);
    }

    showEmailInputPrompt() {
        console.log('📧 [DEBUG] showEmailInputPrompt called');
        
        this.dataCollectionStep = 'email';
        
        this.sendBotMessage(`Senang berkenalan dengan Anda, ${this.customerData.name}! 👋`);
        
        setTimeout(() => {
            this.sendBotMessage('Boleh saya minta alamat email Anda? (Opsional)');
            setTimeout(() => {
                this.sendBotMessage('📧 <em>Email bersifat opsional untuk komunikasi tambahan. Ketik "lewati" untuk melanjutkan tanpa email.</em>');
                
                // Update input placeholder and ensure it's enabled
                const inputField = document.getElementById('chatInputField');
                const sendBtn = document.getElementById('sendBtn');
                const chatInterface = document.getElementById('chatInterface');
                const chatWindow = document.getElementById('chatWindow');
                
                // Comprehensive debugging of all elements
                console.log('🔍 [DEBUG] Full DOM state check:');
                console.log('🔍 [DEBUG] Chat window:', {
                    exists: !!chatWindow,
                    display: chatWindow ? getComputedStyle(chatWindow).display : 'N/A',
                    visibility: chatWindow ? getComputedStyle(chatWindow).visibility : 'N/A',
                    className: chatWindow ? chatWindow.className : 'N/A'
                });
                
                console.log('🔍 [DEBUG] Chat interface:', {
                    exists: !!chatInterface,
                    display: chatInterface ? getComputedStyle(chatInterface).display : 'N/A',
                    visibility: chatInterface ? getComputedStyle(chatInterface).visibility : 'N/A',
                    className: chatInterface ? chatInterface.className : 'N/A'
                });
                
                if (inputField) {
                    const inputStyles = getComputedStyle(inputField);
                    inputField.placeholder = 'Ketik email Anda atau "lewati"...';
                    inputField.disabled = false;
                    inputField.focus();
                    
                    console.log('📧 [DEBUG] Input field full state:', {
                        placeholder: inputField.placeholder,
                        disabled: inputField.disabled,
                        value: inputField.value,
                        display: inputStyles.display,
                        visibility: inputStyles.visibility,
                        opacity: inputStyles.opacity,
                        pointerEvents: inputStyles.pointerEvents,
                        position: inputStyles.position,
                        zIndex: inputStyles.zIndex,
                        className: inputField.className,
                        offsetHeight: inputField.offsetHeight,
                        offsetWidth: inputField.offsetWidth
                    });
                } else {
                    console.error('❌ [DEBUG] Input field not found!');
                }
                
                if (sendBtn) {
                    const sendStyles = getComputedStyle(sendBtn);
                    sendBtn.disabled = false;
                    
                    console.log('📧 [DEBUG] Send button full state:', {
                        disabled: sendBtn.disabled,
                        display: sendStyles.display,
                        visibility: sendStyles.visibility,
                        opacity: sendStyles.opacity,
                        pointerEvents: sendStyles.pointerEvents,
                        className: sendBtn.className,
                        offsetHeight: sendBtn.offsetHeight,
                        offsetWidth: sendBtn.offsetWidth
                    });
                } else {
                    console.error('❌ [DEBUG] Send button not found!');
                }
                
                // Check if input container is visible
                const chatInput = document.querySelector('.chat-input');
                if (chatInput) {
                    const inputContainerStyles = getComputedStyle(chatInput);
                    console.log('📧 [DEBUG] Chat input container full state:', {
                        display: inputContainerStyles.display,
                        visibility: inputContainerStyles.visibility,
                        opacity: inputContainerStyles.opacity,
                        position: inputContainerStyles.position,
                        bottom: inputContainerStyles.bottom,
                        height: inputContainerStyles.height,
                        className: chatInput.className,
                        offsetHeight: chatInput.offsetHeight,
                        offsetWidth: chatInput.offsetWidth
                    });
                } else {
                    console.error('❌ [DEBUG] Chat input container not found!');
                }
                
                // Force a re-render attempt
                setTimeout(() => {
                    if (inputField) {
                        inputField.style.display = 'block';
                        inputField.style.visibility = 'visible';
                        inputField.style.opacity = '1';
                        inputField.style.pointerEvents = 'auto';
                        console.log('🔧 [DEBUG] Forced input field styles applied');
                    }
                    
                    // Force layout recalculation
                    this.forceLayoutFix();
                }, 100);
                
                console.log('✅ [DEBUG] Email input prompt shown');
            }, 1000);
        }, 1000);
    }

    showMessageInputPrompt() {
        console.log('💬 [DEBUG] showMessageInputPrompt called');
        
        this.dataCollectionStep = 'message';
        
        if (this.customerData.email) {
            this.sendBotMessage(`Terima kasih! Email ${this.customerData.email} telah disimpan. ✅`);
        } else {
            this.sendBotMessage('Baik, kita lanjutkan tanpa email. ✅');
        }
        
        setTimeout(() => {
            this.sendBotMessage('Sekarang, silakan ceritakan bagaimana kami bisa membantu Anda hari ini?');
            
            // Update input placeholder
            const inputField = document.getElementById('chatInputField');
            if (inputField) {
                inputField.placeholder = 'Ceritakan kebutuhan Anda...';
                inputField.focus();
            }
            
            console.log('✅ [DEBUG] Message input prompt shown');
        }, 1500);
    }

    isValidEmail(email) {
        const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        return emailRegex.test(email);
    }

    startAdminConversation() {
        // Show typing indicator
        this.showTypingIndicator();
        
        // Update status
        document.getElementById('chatStatus').textContent = 'Menghubungkan ke tim dukungan...';
        
        // Add comprehensive debugging
        console.log('🚀 [DEBUG] Starting admin conversation...');
        console.log('📝 [DEBUG] Customer data:', this.customerData);
        console.log('🔑 [DEBUG] CSRF token exists:', !!document.querySelector('meta[name="csrf-token"]'));
        console.log('🌐 [DEBUG] About to send request to /chat/start');
        
        // Send AJAX request to start admin conversation
        fetch('/chat/start', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                'Accept': 'application/json'
            },
            body: JSON.stringify({
                customer_name: this.customerData.name,
                customer_phone: this.customerData.phone,
                customer_email: this.customerData.email,
                initial_message: this.customerData.message,
                existing_customer: this.customerData.existing_customer || false,
                customer_id: this.customerData.customer_id || null
            })
        })
        .then(response => {
            console.log('📡 [DEBUG] Response status:', response.status);
            console.log('📡 [DEBUG] Response headers:', response.headers);
            console.log('📡 [DEBUG] Response OK:', response.ok);
            
            if (!response.ok) {
                throw new Error(`HTTP error! status: ${response.status}`);
            }
            return response.json();
        })
        .then(data => {
            console.log('✅ [DEBUG] Response data:', data);
            
            this.hideTypingIndicator();
            
            if (data.success) {
                // Store conversation ID for future messages
                this.adminConversationId = data.conversation_id;
                console.log('✅ [DEBUG] Conversation ID stored:', this.adminConversationId);
                
                // Send initial message
                this.sendUserMessage(this.customerData.message);
                
                // Show success message
                this.sendBotMessage('Terima kasih! Pesan Anda telah diterima. Tim dukungan kami akan segera merespons.');
                
                // Enable normal chat input
                this.enableNormalChatInput();
                
                // Show ongoing chat actions
                this.showOngoingChatActions();
                
                // Start polling for admin replies
                this.startPollingForReplies();
                
                console.log('🎉 [DEBUG] Admin conversation started successfully!');
            } else {
                console.error('❌ [DEBUG] Server returned success=false:', data);
                this.hideTypingIndicator();
                this.sendBotMessage('Maaf, terjadi kesalahan. Silakan coba lagi atau hubungi kami langsung.');
            }
        })
        .catch(error => {
            console.error('❌ [DEBUG] Network error:', error);
            this.hideTypingIndicator();
            this.sendBotMessage('Maaf, terjadi kesalahan koneksi. Silakan coba lagi atau hubungi kami langsung.');
        });
    }

    startPollingForReplies() {
        if (!this.adminConversationId) {
            console.log('⚠️ [DEBUG] No conversation ID, skipping polling');
            return;
        }
        
        console.log('🔄 [DEBUG] Starting polling for admin replies...');
        
        // Poll every 3 seconds for new admin replies
        this.pollingInterval = setInterval(() => {
            this.checkForAdminReplies();
        }, 3000);
        
        // Also check immediately
        setTimeout(() => {
            this.checkForAdminReplies();
        }, 1000);
    }

    checkForAdminReplies() {
        if (!this.adminConversationId) {
            console.log('⚠️ [DEBUG] No conversation ID for polling');
            return;
        }
        
        console.log('🔍 [DEBUG] Checking for admin replies...');
        
        fetch(`/chat/${this.adminConversationId}/messages`, {
            method: 'GET',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                'Accept': 'application/json'
            }
        })
        .then(response => {
            if (!response.ok) {
                throw new Error(`HTTP error! status: ${response.status}`);
            }
            return response.json();
        })
        .then(data => {
            console.log('📨 [DEBUG] Messages response:', data);
            
            if (data.success && data.messages) {
                this.processNewMessages(data.messages);
            }
        })
        .catch(error => {
            console.error('❌ [DEBUG] Error checking for replies:', error);
        });
    }

    processNewMessages(messages) {
        console.log('📋 [DEBUG] Processing messages:', messages);
        
        // Filter for admin messages that we haven't displayed yet
        const adminMessages = messages.filter(msg => 
            msg.sender_type === 'admin' && 
            !this.displayedMessages.includes(msg.id)
        );
        
        if (adminMessages.length > 0) {
            console.log('📬 [DEBUG] Found new admin messages:', adminMessages);
            
            adminMessages.forEach(message => {
                // Show admin reply
                this.sendBotMessage(message.message_content);
                
                // Mark as displayed
                this.displayedMessages.push(message.id);
                
                console.log('✅ [DEBUG] Displayed admin message:', message.id);
            });
            
            // Update status
            document.getElementById('chatStatus').textContent = 'Tim dukungan telah membalas';
        }
    }

    stopPolling() {
        if (this.pollingInterval) {
            console.log('🛑 [DEBUG] Stopping polling for admin replies');
            clearInterval(this.pollingInterval);
            this.pollingInterval = null;
        }
    }

    sendMessageToAdmin(message) {
        console.log('📤 [DEBUG] Sending message to admin:', message);
        console.log('📤 [DEBUG] Conversation ID:', this.adminConversationId);
        
        if (!this.adminConversationId) {
            console.error('❌ [DEBUG] No conversation ID available!');
            this.sendBotMessage('Maaf, tidak ada percakapan aktif. Silakan mulai ulang chat.');
            return;
        }

        fetch(`/chat/${this.adminConversationId}/reply`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                'Accept': 'application/json'
            },
            body: JSON.stringify({
                message: message
            })
        })
        .then(response => {
            console.log('📤 [DEBUG] Reply response status:', response.status);
            console.log('📤 [DEBUG] Reply response OK:', response.ok);
            
            if (!response.ok) {
                throw new Error(`HTTP error! status: ${response.status}`);
            }
            return response.json();
        })
        .then(data => {
            console.log('✅ [DEBUG] Reply response data:', data);
            
            if (data.success) {
                console.log('✅ [DEBUG] Message sent successfully to admin');
                // Message was sent successfully - the user message should already be displayed
            } else {
                console.error('❌ [DEBUG] Failed to send message:', data);
                this.sendBotMessage('Maaf, pesan tidak dapat dikirim. Silakan coba lagi.');
            }
        })
        .catch(error => {
            console.error('❌ [DEBUG] Error sending message to admin:', error);
            this.sendBotMessage('Maaf, terjadi kesalahan saat mengirim pesan. Silakan coba lagi.');
        });
    }

    toggleChat() {
        console.log('🔄 [DEBUG] toggleChat called, current state:', this.isOpen);
        
        if (this.isOpen) {
            this.closeChat();
        } else {
            this.openChat();
            
            // Start customer data collection immediately when chat opens
            if (!this.hasStartedDataCollection) {
                this.startCustomerDataCollection();
                this.hasStartedDataCollection = true;
            }
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
        
        // Stop polling when chat is closed
        this.stopPolling();
    }

    sendMessage() {
        console.log('📨 [DEBUG] sendMessage called');
        
        const chatInputField = document.getElementById('chatInputField');
        const sendBtn = document.getElementById('sendBtn');
        const message = chatInputField ? chatInputField.value.trim() : '';
        
        console.log('📨 [DEBUG] Input field state:', {
            exists: !!chatInputField,
            disabled: chatInputField ? chatInputField.disabled : 'N/A',
            value: message,
            placeholder: chatInputField ? chatInputField.placeholder : 'N/A'
        });
        
        console.log('📨 [DEBUG] Send button state:', {
            exists: !!sendBtn,
            disabled: sendBtn ? sendBtn.disabled : 'N/A'
        });
        
        console.log('📨 [DEBUG] Message content:', message);
        console.log('📨 [DEBUG] Is collecting data:', this.isCollectingData);
        console.log('📨 [DEBUG] Data collection step:', this.dataCollectionStep);
        
        if (message) {
            this.sendUserMessage(message);
            chatInputField.value = '';
            this.autoResizeTextarea(chatInputField);
            
            // Check if we're in data collection mode
            if (this.isCollectingData) {
                console.log('📨 [DEBUG] Processing data collection response...');
                this.handleDataCollectionResponse(message);
            } else if (this.chatMode === 'admin' && this.needsToStartAdminConversation) {
                console.log('📨 [DEBUG] Starting admin conversation with first message...');
                this.customerData.message = message;
                this.startAdminConversation();
                this.needsToStartAdminConversation = false;
            } else if (this.chatMode === 'admin' && this.adminConversationId) {
                console.log('📨 [DEBUG] Sending message to admin...');
                this.sendMessageToAdmin(message);
            } else {
                console.log('📨 [DEBUG] Processing as normal chat message...');
                this.processMessage(message);
            }
            
            // Hide quick actions after first user message
            if (!this.hasStartedChat) {
                this.hideQuickActions();
            }
        } else {
            console.log('⚠️ [DEBUG] Empty message, not sending');
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

    async processMessage(message) {
        // Check if this is a response to admin chat suggestion
        if (this.pendingAdminSuggestion) {
            const lowerMessage = message.toLowerCase();
            if (lowerMessage.includes('ya') || lowerMessage.includes('yes') || lowerMessage.includes('iya')) {
                this.pendingAdminSuggestion = false;
                this.showTypingIndicator();
                
                setTimeout(() => {
                    this.hideTypingIndicator();
                    this.sendBotMessage('Baik! Saya akan menghubungkan Anda dengan tim admin kami. Silakan tunggu sebentar...');
                    
                    setTimeout(() => {
                        // Switch to admin mode
                        this.chatMode = 'admin';
                        this.sendBotMessage('Anda sekarang terhubung dengan tim dukungan. Silakan jelaskan bagaimana kami bisa membantu Anda?');
                        this.enableNormalChatInput();
                        this.updateQuickActionsForAdmin();
                        this.needsToStartAdminConversation = true;
                        
                        // Update header
                        document.getElementById('chatTitle').textContent = 'Chat dengan Admin';
                        document.getElementById('chatStatus').textContent = 'Tim dukungan siap membantu';
                    }, 1500);
                }, 1000);
                
                return;
            } else if (lowerMessage.includes('tidak') || lowerMessage.includes('no') || lowerMessage.includes('gak')) {
                this.pendingAdminSuggestion = false;
                this.showTypingIndicator();
                
                setTimeout(() => {
                    this.hideTypingIndicator();
                    this.sendBotMessage('Baik, Anda tetap menggunakan chat otomatis. Silakan ajukan pertanyaan lain atau gunakan menu bantuan cepat di atas.');
                }, 1000);
                
                return;
            }
        }

        // Show typing indicator
        this.showTypingIndicator();
        
        try {
            console.log('🔄 [DEBUG] Starting generateResponse...');
            
            // Simulate processing time
            await new Promise(resolve => setTimeout(resolve, 1000 + Math.random() * 1500));
            
            this.hideTypingIndicator();
            
            const response = await this.generateResponse(message);
            console.log('✅ [DEBUG] Generated response:', response);
            
            this.sendBotMessage(response);
        } catch (error) {
            console.error('❌ [DEBUG] Error processing message:', error);
            this.hideTypingIndicator();
            this.sendBotMessage('Maaf, terjadi kesalahan. Silakan coba lagi.');
        }
    }

    async generateResponse(message) {
        console.log('🔍 [DEBUG] generateResponse called with:', message);
        
        try {
            console.log('📡 [DEBUG] Trying auto-response...');
            // First, try to get response from database
            const response = await fetch('/chat/get-auto-response', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || ''
                },
                body: JSON.stringify({ message: message })
            });

            if (response.ok) {
                const data = await response.json();
                console.log('📊 [DEBUG] Auto-response result:', data);
                
                if (data.success && data.matched) {
                    console.log('✅ [DEBUG] Found auto-response match!');
                    return data.response;
                }
            }
        } catch (error) {
            console.log('❌ [DEBUG] Failed to fetch database response, trying ML model:', error);
        }

        // If no database match, try ML model for intelligent response
        try {
            console.log('🤖 [DEBUG] Trying ML model...');
            const mlResponse = await fetch('/chat/get-intelligent-response', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || ''
                },
                body: JSON.stringify({ message: message })
            });

            console.log('🔍 [DEBUG] ML response status:', mlResponse.status);
            
            if (mlResponse.ok) {
                const mlData = await mlResponse.json();
                console.log('📊 [DEBUG] ML response data:', mlData);
                
                if (mlData.success && mlData.type === 'ml_prediction') {
                    // If ML model found a good response, use it
                    if (mlData.confidence > 0.3) {
                        console.log('✅ [DEBUG] ML model provided good response!');
                        return Array.isArray(mlData.response) ? mlData.response.join(' ') : mlData.response;
                    }
                }
            } else {
                console.log('❌ [DEBUG] ML response not OK:', await mlResponse.text());
            }
        } catch (error) {
            console.log('❌ [DEBUG] ML model failed:', error);
        }

        console.log('🔄 [DEBUG] Falling back to static responses...');
        
        // Fallback to static responses
        const lowerMessage = message.toLowerCase();
        
        // Check for specific keywords
        for (const [keyword, response] of Object.entries(this.options.autoResponses)) {
            if (keyword !== 'default' && lowerMessage.includes(keyword)) {
                console.log('✅ [DEBUG] Found keyword match:', keyword);
                return response;
            }
        }
        
        // If no match found, suggest admin chat with confirmation
        if (this.shouldSuggestAdminChat(message)) {
            console.log('🔄 [DEBUG] Suggesting admin chat...');
            this.pendingAdminSuggestion = true;
            return `Terima kasih atas pesan Anda: "${message}". Biarkan saya menghubungkan Anda dengan tim kami untuk bantuan yang lebih detail!\n\n**Apakah Anda ingin melanjutkan chat dengan admin?**\n\nBalas "Ya" untuk terhubung dengan admin atau "Tidak" untuk tetap menggunakan chat otomatis.`;
        }
        
        console.log('🔄 [DEBUG] Using default response...');
        // Default response
        return this.options.autoResponses.default.replace('{{message}}', message);
    }

    shouldSuggestAdminChat(message) {
        // Suggest admin chat for complex queries or when auto responses fail
        const complexKeywords = [
            'instalasi', 'pemasangan', 'custom', 'spesial', 'khusus', 
            'kompleks', 'detail', 'konsultasi', 'diskusi', 'negosiasi',
            'penawaran', 'proposal', 'project', 'proyek'
        ];
        
        const lowerMessage = message.toLowerCase();
        return complexKeywords.some(keyword => lowerMessage.includes(keyword)) || 
               message.length > 50; // Long messages might need human attention
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
                    <button class="quick-action" data-message="Saya butuh bantuan">Saya butuh bantuan</button>
                    <button class="quick-action" data-message="Informasi kontak">Info kontak</button>
                    <button class="quick-action" data-message="Jam operasional">Jam operasional</button>
                    <button class="quick-action" data-message="Informasi harga">Harga</button>
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

    forceLayoutFix() {
        console.log('🔧 [DEBUG] Applying layout fixes...');
        
        const chatWindow = document.getElementById('chatWindow');
        const chatInterface = document.getElementById('chatInterface');
        const chatMessages = document.getElementById('chatMessages');
        const chatInput = document.querySelector('.chat-input');
        const chatHeader = document.querySelector('.chat-header');
        
        if (chatWindow && chatInterface) {
            // Get current dimensions
            const windowRect = chatWindow.getBoundingClientRect();
            const interfaceRect = chatInterface.getBoundingClientRect();
            
            console.log('🔧 [DEBUG] Layout dimensions:', {
                chatWindow: {
                    width: windowRect.width,
                    height: windowRect.height,
                    top: windowRect.top,
                    bottom: windowRect.bottom
                },
                chatInterface: {
                    width: interfaceRect.width,
                    height: interfaceRect.height,
                    top: interfaceRect.top,
                    bottom: interfaceRect.bottom
                }
            });
            
            // Check if chat header exists and get its height
            if (chatHeader) {
                const headerRect = chatHeader.getBoundingClientRect();
                console.log('🔧 [DEBUG] Chat header:', {
                    height: headerRect.height,
                    display: getComputedStyle(chatHeader).display,
                    visibility: getComputedStyle(chatHeader).visibility
                });
            } else {
                console.error('❌ [DEBUG] Chat header not found!');
            }
            
            // Check if chat input exists and get its position
            if (chatInput) {
                const inputRect = chatInput.getBoundingClientRect();
                console.log('🔧 [DEBUG] Chat input position:', {
                    height: inputRect.height,
                    top: inputRect.top,
                    bottom: inputRect.bottom,
                    isVisible: inputRect.height > 0 && inputRect.width > 0
                });
                
                // Force the input to be at the bottom
                chatInput.style.position = 'absolute';
                chatInput.style.bottom = '0';
                chatInput.style.left = '0';
                chatInput.style.right = '0';
                chatInput.style.zIndex = '1000';
                
                console.log('🔧 [DEBUG] Forced chat input to bottom position');
            } else {
                console.error('❌ [DEBUG] Chat input container not found!');
            }
            
            // Adjust messages container height to account for header and input
            if (chatMessages && chatHeader && chatInput) {
                const headerHeight = chatHeader.offsetHeight;
                const inputHeight = chatInput.offsetHeight;
                const availableHeight = chatInterface.offsetHeight - headerHeight - inputHeight;
                
                chatMessages.style.height = `${availableHeight}px`;
                chatMessages.style.overflow = 'auto';
                
                console.log('🔧 [DEBUG] Adjusted messages container:', {
                    headerHeight,
                    inputHeight,
                    availableHeight,
                    messagesHeight: chatMessages.style.height
                });
            }
        }
    }

    startCustomerDataCollection() {
        console.log('📝 [DEBUG] Starting customer data collection with form');
        
        // Show the chat interface with form
        this.showChatInterface();
        
        // Show customer form
        this.showCustomerForm();
    }

    showChatInterface() {
        document.getElementById('chatModeSelection').style.display = 'none';
        document.getElementById('chatInterface').style.display = 'flex';
        
        // Update header for data collection
        document.getElementById('chatTitle').textContent = 'Boys Project';
        document.getElementById('chatStatus').textContent = 'Selamat datang!';
        
        // Hide back button during data collection
        const backBtn = document.getElementById('backBtn');
        if (backBtn) {
            backBtn.style.display = 'none';
        }
    }

    showCustomerForm() {
        console.log('📝 [DEBUG] Showing customer form');
        
        // Show form, hide chat messages
        document.getElementById('customerForm').style.display = 'flex';
        document.getElementById('chatMessages').style.display = 'none';
        document.getElementById('chatInput').style.display = 'none';
        
        // Debug: Check if elements exist
        setTimeout(() => {
            const connectBtn = document.getElementById('connectBtn');
            const customerForm = document.getElementById('customerForm');
            const nameInput = document.getElementById('customerName');
            const phoneInput = document.getElementById('customerPhone');
            
            console.log('🔍 [DEBUG] Form elements check:', {
                connectBtn: !!connectBtn,
                customerForm: !!customerForm,
                nameInput: !!nameInput,
                phoneInput: !!phoneInput,
                formVisible: customerForm ? getComputedStyle(customerForm).display : 'N/A',
                buttonVisible: connectBtn ? getComputedStyle(connectBtn).display : 'N/A'
            });
            
            if (connectBtn) {
                console.log('🔍 [DEBUG] Connect button details:', {
                    text: connectBtn.textContent,
                    disabled: connectBtn.disabled,
                    offsetHeight: connectBtn.offsetHeight,
                    offsetWidth: connectBtn.offsetWidth,
                    className: connectBtn.className
                });
            }
        }, 100);
        
        // Attach form event listeners
        this.attachFormEventListeners();
    }

    attachFormEventListeners() {
        const connectBtn = document.getElementById('connectBtn');
        const nameInput = document.getElementById('customerName');
        const phoneInput = document.getElementById('customerPhone');
        const emailInput = document.getElementById('customerEmail');
        const agreementCheck = document.getElementById('agreementCheck');

        // Phone input formatting
        if (phoneInput) {
            phoneInput.addEventListener('input', (e) => {
                // Remove non-digits
                let value = e.target.value.replace(/\D/g, '');
                
                // Remove leading 0 if present (since we show +62 prefix)
                if (value.startsWith('0')) {
                    value = value.substring(1);
                }
                
                e.target.value = value;
                this.validateForm();
            });

            phoneInput.addEventListener('keypress', (e) => {
                // Only allow digits
                if (!/\d/.test(e.key) && !['Backspace', 'Delete', 'Tab', 'Escape', 'Enter'].includes(e.key)) {
                    e.preventDefault();
                }
            });
        }

        // Name input validation
        if (nameInput) {
            nameInput.addEventListener('input', () => {
                this.validateForm();
            });
        }

        // Email input validation (optional)
        if (emailInput) {
            emailInput.addEventListener('input', () => {
                this.validateForm();
            });
        }

        // Agreement checkbox
        if (agreementCheck) {
            agreementCheck.addEventListener('change', () => {
                this.validateForm();
            });
        }

        // Connect button
        if (connectBtn) {
            connectBtn.addEventListener('click', () => {
                this.submitCustomerForm();
            });
        }

        // Initial validation
        this.validateForm();
    }

    validateForm() {
        const nameInput = document.getElementById('customerName');
        const phoneInput = document.getElementById('customerPhone');
        const emailInput = document.getElementById('customerEmail');
        const agreementCheck = document.getElementById('agreementCheck');
        const connectBtn = document.getElementById('connectBtn');

        const name = nameInput?.value.trim() || '';
        const phone = phoneInput?.value.trim() || '';
        const email = emailInput?.value.trim() || '';
        const agreed = agreementCheck?.checked || false;

        // Validate required fields
        const nameValid = name.length >= 2;
        const phoneValid = phone.length >= 9; // Indonesian mobile numbers are usually 10-12 digits
        const emailValid = !email || this.isValidEmail(email); // Email is optional
        
        // Enable/disable connect button
        const formValid = nameValid && phoneValid && emailValid && agreed;
        
        if (connectBtn) {
            connectBtn.disabled = !formValid;
            connectBtn.style.opacity = formValid ? '1' : '0.5';
            connectBtn.style.cursor = formValid ? 'pointer' : 'not-allowed';
        }

        return formValid;
    }

    submitCustomerForm() {
        console.log('📝 [DEBUG] Submitting customer form');

        const nameInput = document.getElementById('customerName');
        const phoneInput = document.getElementById('customerPhone');
        const emailInput = document.getElementById('customerEmail');

        const name = nameInput.value.trim();
        let phone = phoneInput.value.trim();
        const email = emailInput.value.trim();

        // Format phone number
        phone = '+62' + phone;

        // Validate
        if (!this.validateForm()) {
            console.error('❌ [DEBUG] Form validation failed');
            return;
        }

        // Store customer data
        this.customerData = {
            name: name,
            phone: phone,
            email: email || null
        };

        console.log('✅ [DEBUG] Customer data collected:', this.customerData);

        // Show loading state
        const connectBtn = document.getElementById('connectBtn');
        if (connectBtn) {
            connectBtn.textContent = 'MENGHUBUNGKAN...';
            connectBtn.disabled = true;
            connectBtn.classList.add('loading');
        }

        // Check existing customer
        this.checkExistingCustomer(phone);
    }

    // Update checkExistingCustomer to handle form completion
    checkExistingCustomer(phoneNumber) {
        console.log('🔍 [DEBUG] Checking existing customer for phone:', phoneNumber);
        
        // Make API call to check if customer exists
        fetch('/chat/check-customer', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || ''
            },
            body: JSON.stringify({
                phone: phoneNumber
            })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success && data.customer_exists) {
                // Update customer data with existing info
                this.customerData.name = data.customer.name;
                this.customerData.email = data.customer.email;
                this.customerData.existing_customer = true;
                this.customerData.customer_id = data.customer.id;
                
                console.log('✅ [DEBUG] Existing customer found');
            }
            
            // Complete the form submission
            this.completeFormSubmission();
        })
        .catch(error => {
            console.error('Error checking customer:', error);
            // Continue with form submission even if API fails
            this.completeFormSubmission();
        });
    }

    completeFormSubmission() {
        console.log('✅ [DEBUG] Completing form submission');
        
        // Hide form, show chat interface
        document.getElementById('customerForm').style.display = 'none';
        document.getElementById('chatMessages').style.display = 'flex';
        document.getElementById('chatInput').style.display = 'block';
        
        // Update header
        document.getElementById('chatTitle').textContent = 'Boys Project Support';
        document.getElementById('chatStatus').textContent = 'Data tersimpan, pilih jenis bantuan';
        
        // Show back button
        const backBtn = document.getElementById('backBtn');
        if (backBtn) {
            backBtn.style.display = 'flex';
        }
        
        // Show welcome message
        this.sendBotMessage(`Halo ${this.customerData.name}! Data Anda telah tersimpan. ✅`);
        
        setTimeout(() => {
            this.showModeSelectionAfterDataCollection();
        }, 1000);
    }

    showModeSelectionAfterDataCollection() {
        console.log('🎯 [DEBUG] Showing mode selection after data collection');
        
        // Clear messages area but keep customer data
        const messagesContainer = document.getElementById('messagesContainer');
        if (messagesContainer) {
            // Add mode selection buttons as messages
            const modeSelectionHTML = `
                <div class="message bot">
                    <div class="message-avatar">BP</div>
                    <div class="message-content">
                        <div class="mode-selection-buttons">
                            <button class="mode-selection-btn" data-mode="landing">
                                <div class="mode-icon">🤖</div>
                                <div class="mode-text">
                                    <h4>Chat Otomatis</h4>
                                    <p>Jawaban cepat untuk pertanyaan umum</p>
                                </div>
                            </button>
                            <button class="mode-selection-btn" data-mode="admin">
                                <div class="mode-icon">👨‍💼</div>
                                <div class="mode-text">
                                    <h4>Chat dengan Admin</h4>
                                    <p>Bicara langsung dengan tim dukungan</p>
                                </div>
                            </button>
                        </div>
                    </div>
                </div>
            `;
            
            messagesContainer.insertAdjacentHTML('beforeend', modeSelectionHTML);
            this.scrollToBottom();
            
            // Attach event listeners to mode selection buttons
            this.attachModeSelectionListeners();
        }
        
        // Show back button now
        const backBtn = document.getElementById('backBtn');
        if (backBtn) {
            backBtn.style.display = 'flex';
        }
        
        // Update status
        document.getElementById('chatStatus').textContent = 'Pilih jenis bantuan yang dibutuhkan';
        
        // Disable input field during mode selection
        const inputField = document.getElementById('chatInputField');
        const sendBtn = document.getElementById('sendBtn');
        if (inputField) {
            inputField.disabled = true;
            inputField.placeholder = 'Pilih mode chat terlebih dahulu...';
        }
        if (sendBtn) {
            sendBtn.disabled = true;
        }
    }

    attachModeSelectionListeners() {
        const modeButtons = document.querySelectorAll('.mode-selection-btn');
        modeButtons.forEach(button => {
            button.addEventListener('click', () => {
                const mode = button.getAttribute('data-mode');
                console.log('👆 [DEBUG] Mode selected after data collection:', mode);
                this.selectChatModeWithData(mode);
            });
        });
    }

    selectChatModeWithData(mode) {
        console.log('🎯 [DEBUG] Selecting chat mode with customer data:', mode);
        
        this.chatMode = mode;
        
        // Remove mode selection buttons
        const modeSelection = document.querySelector('.mode-selection-buttons');
        if (modeSelection) {
            modeSelection.parentElement.parentElement.remove();
        }
        
        if (mode === 'admin') {
            // Start admin chat with collected data
            this.sendBotMessage('Anda akan terhubung dengan tim dukungan kami. Silakan tunggu sebentar...');
            
            setTimeout(() => {
                this.sendBotMessage('Silakan ceritakan bagaimana kami bisa membantu Anda hari ini?');
                this.enableNormalChatInput();
                this.updateQuickActionsForAdmin();
                
                // Set flag to indicate we need to start conversation on first message
                this.needsToStartAdminConversation = true;
            }, 1500);
            
        } else if (mode === 'landing') {
            // Start auto chat mode
            this.sendBotMessage('Mode chat otomatis aktif. Anda bisa bertanya tentang layanan kami.');
            this.enableNormalChatInput();
            this.addInitialMessage();
        }
        
        // Update header
        const modeText = mode === 'admin' ? 'Chat dengan Admin' : 'Chat Otomatis';
        document.getElementById('chatTitle').textContent = modeText;
        document.getElementById('chatStatus').textContent = mode === 'admin' ? 'Tim dukungan siap membantu' : 'Siap menjawab pertanyaan Anda';
    }
}

// Initialize chat bubble when DOM is loaded
document.addEventListener('DOMContentLoaded', function() {
    console.log('🔍 [DEBUG] DOM loaded, initializing chat bubble...');
    

    
    // Check if chat bubble should be initialized
    if (!document.querySelector('.chat-bubble')) {
        console.log('🔍 [DEBUG] No existing chat bubble found, creating new one...');
        
        try {
            window.chatBubble = new ChatBubble({
                botName: 'Dukungan Boys Project',
                botAvatar: 'BP',
                greeting: 'Hai! Selamat datang di Boys Project! Bagaimana saya bisa membantu Anda hari ini? 👋',
                autoResponses: {
                    'halo': 'Halo! Selamat datang di Boys Project! Bagaimana saya bisa membantu Anda hari ini?',
                    'hai': 'Hai! Terima kasih telah mengunjungi Boys Project. Ada yang bisa saya bantu?',
                    'help': 'Saya di sini untuk membantu! Apa yang Anda butuhkan mengenai layanan kami?',
                    'bantuan': 'Saya di sini untuk membantu! Apa yang Anda butuhkan mengenai layanan kami?',
                    'kontak': 'Anda bisa menghubungi kami di info@boysproject.com atau melalui formulir kontak kami. Kami senang mendengar dari Anda!',
                    'jam': 'Kami tersedia Senin-Jumat 09:00-18:00 WIB. Untuk urusan mendesak, silakan gunakan formulir kontak kami!',
                    'harga': 'Untuk informasi harga detail, silakan cek halaman layanan kami atau hubungi kami untuk penawaran khusus!',
                    'pricing': 'Untuk informasi harga detail, silakan cek halaman layanan kami atau hubungi kami untuk penawaran khusus!',
                    'layanan': 'Kami menawarkan berbagai layanan digital. Layanan spesifik apa yang Anda minati?',
                    'services': 'Kami menawarkan berbagai layanan digital. Layanan spesifik apa yang Anda minati?',
                    'portfolio': 'Lihat bagian portfolio kami untuk melihat karya-karya menakjubkan dan kisah sukses klien kami!',
                    'tim': 'Tim kami terdiri dari profesional berpengalaman yang siap mewujudkan ide-ide Anda!',
                    'team': 'Tim kami terdiri dari profesional berpengalaman yang siap mewujudkan ide-ide Anda!',
                    'tentang': 'Boys Project berdedikasi memberikan solusi digital yang luar biasa. Pelajari lebih lanjut tentang kami di bagian Tentang Kami!',
                    'about': 'Boys Project berdedikasi memberikan solusi digital yang luar biasa. Pelajari lebih lanjut tentang kami di bagian Tentang Kami!',
                    'demo': 'Apakah Anda ingin melihat demo karya kami? Saya bisa membantu Anda menjadwalkan konsultasi!',
                    'terima kasih': 'Sama-sama! Ada hal lain tentang Boys Project yang bisa saya bantu?',
                    'thanks': 'Sama-sama! Ada hal lain tentang Boys Project yang bisa saya bantu?',
                    'selamat tinggal': 'Selamat tinggal! Terima kasih atas minat Anda terhadap Boys Project. Jangan ragu menghubungi kami kapan saja!',
                    'bye': 'Selamat tinggal! Terima kasih atas minat Anda terhadap Boys Project. Jangan ragu menghubungi kami kapan saja!',
                    'default': 'Terima kasih atas pesan Anda: "{{message}}". Biarkan saya menghubungkan Anda dengan tim kami untuk bantuan yang lebih detail!'
                }
            });
            
            console.log('✅ [DEBUG] Chat bubble created successfully!', window.chatBubble);
            
            // Check if the chat bubble HTML was added to DOM
            setTimeout(() => {
                const chatBubbleElement = document.querySelector('.chat-bubble');
                if (chatBubbleElement) {
                    console.log('✅ [DEBUG] Chat bubble HTML found in DOM:', chatBubbleElement);
                } else {
                    console.error('❌ [DEBUG] Chat bubble HTML not found in DOM!');
                }
            }, 100);
            
        } catch (error) {
            console.error('❌ [DEBUG] Error creating chat bubble:', error);
        }
    } else {
        console.log('🔍 [DEBUG] Chat bubble already exists in DOM');
    }
});

// Export for use in other scripts
if (typeof module !== 'undefined' && module.exports) {
    module.exports = ChatBubble;
}