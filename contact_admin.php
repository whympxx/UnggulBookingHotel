<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact Admin - Hotel Booking</title>
    <link rel="stylesheet" href="chatbot.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="contact_admin.css">
</head>\
<body>
    <div class="account-security-container">
        <header class="main-header">
            <div class="header-left">
                <a href="index.php" class="back-button" title="Kembali ke Beranda">
                    <i class="fas fa-arrow-left"></i>
                </a>
                <span class="company-name">Unggul Booking Hotel Assistant</span>
            </div>
        </header>

        <div class="menu-group">
            <div class="chatbot-container">
                <div class="chatbot-header">
                    <div class="chatbot-title">
                        <i class="fas fa-robot"></i>
                        <h2>Hotel Booking Assistant</h2>
                    </div>
                    <p class="chatbot-subtitle">Ask me anything about hotel bookings and our services</p>
                </div>

                <div class="chatbot-messages" id="chatbotMessages">
                    <div class="message bot">
                        <div class="message-content">
                            Hello! I'm your hotel booking assistant. How can I help you today?
                        </div>
                    </div>
                </div>

                <div class="chatbot-input">
                    <input type="text" id="userInput" placeholder="Type your message here..." autocomplete="off" aria-label="Input Pesan">
                    <button id="sendMessage" class="send-button" aria-label="Kirim Pesan">
                        <i class="fas fa-paper-plane"></i>
                    </button>
                    <button id="typeQuestion" class="type-button" aria-label="Tulis Pesan">
                        <i class="fas fa-keyboard"></i>
                        <span class="button-label">Tulis</span>
                    </button>
                </div>
                <div class="quick-reply-group" id="quickReplyGroup"></div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const chatbotMessages = document.getElementById('chatbotMessages');
            const userInput = document.getElementById('userInput');
            const sendButton = document.getElementById('sendMessage');
            const typeButton = document.getElementById('typeQuestion');
            let isTypingMode = false;

            // Predefined responses in both languages
            const responses = {
                'greeting': {
                    'id': 'Halo! Saya adalah asisten pemesanan hotel Anda. Apa yang bisa saya bantu hari ini?',
                    'en': 'Hello! I am your hotel booking assistant. How can I help you today?'
                },
                'farewell': {
                    'id': 'Terima kasih telah menghubungi kami. Jika Anda memiliki pertanyaan lain, jangan ragu untuk bertanya!',
                    'en': 'Thank you for contacting us. If you have any other questions, feel free to ask!'
                },
                'booking': {
                    'id': 'Untuk melakukan pemesanan, silakan ikuti langkah-langkah berikut:\n1. Pilih hotel yang diinginkan\n2. Pilih tanggal check-in dan check-out\n3. Pilih tipe kamar\n4. Isi data pemesanan\n5. Lakukan pembayaran\nApakah Anda ingin saya menjelaskan langkah-langkah ini lebih detail?',
                    'en': 'To make a booking, please follow these steps:\n1. Choose your preferred hotel\n2. Select check-in and check-out dates\n3. Choose room type\n4. Fill in booking details\n5. Complete payment\nWould you like me to explain these steps in more detail?'
                },
                'payment': {
                    'id': 'Kami menerima berbagai metode pembayaran:\n- Kartu Kredit/Debit\n- Transfer Bank\n- E-wallet (GoPay, OVO, DANA)\n- Virtual Account\nApakah Anda ingin informasi lebih lanjut tentang metode pembayaran tertentu?',
                    'en': 'We accept various payment methods:\n- Credit/Debit Card\n- Bank Transfer\n- E-wallet (GoPay, OVO, DANA)\n- Virtual Account\nWould you like more information about a specific payment method?'
                },
                'cancellation': {
                    'id': 'Kebijakan pembatalan kami:\n- Pembatalan 24 jam sebelum check-in: pengembalian dana penuh\n- Pembatalan 12-24 jam sebelum check-in: pengembalian dana 50%\n- Pembatalan kurang dari 12 jam: tidak ada pengembalian dana\nApakah Anda ingin informasi lebih lanjut?',
                    'en': 'Our cancellation policy:\n- Cancellation 24 hours before check-in: full refund\n- Cancellation 12-24 hours before check-in: 50% refund\n- Cancellation less than 12 hours: no refund\nWould you like more information?'
                },
                'check-in': {
                    'id': 'Waktu check-in dimulai dari pukul 14:00 WIB. Jika Anda tiba lebih awal, Anda dapat meninggalkan barang bawaan Anda di resepsionis. Apakah ada hal lain yang ingin Anda tanyakan?',
                    'en': 'Check-in time starts from 2:00 PM. If you arrive earlier, you can leave your luggage at the reception. Is there anything else you would like to know?'
                },
                'check-out': {
                    'id': 'Waktu check-out adalah pukul 12:00 WIB. Anda dapat meminta late check-out dengan biaya tambahan. Apakah Anda ingin informasi tentang late check-out?',
                    'en': 'Check-out time is 12:00 PM. You can request a late check-out for an additional fee. Would you like information about late check-out?'
                },
                'amenities': {
                    'id': 'Fasilitas hotel kami meliputi:\n- WiFi gratis\n- Kolam renang\n- Pusat kebugaran\n- Restoran 24 jam\n- Layanan kamar 24 jam\n- Parkir gratis\nApakah Anda ingin informasi lebih detail tentang fasilitas tertentu?',
                    'en': 'Our hotel amenities include:\n- Free WiFi\n- Swimming pool\n- Fitness center\n- 24-hour restaurant\n- 24-hour room service\n- Free parking\nWould you like more detailed information about specific amenities?'
                },
                'location': {
                    'id': 'Hotel kami terletak di pusat kota dengan akses mudah ke berbagai tempat wisata dan pusat perbelanjaan. Apakah Anda ingin informasi tentang transportasi ke hotel?',
                    'en': 'Our hotel is located in the city center with easy access to various tourist attractions and shopping centers. Would you like information about transportation to the hotel?'
                },
                'features': {
                    'id': 'Berikut adalah fitur-fitur utama aplikasi Pemesanan Hotel:\n\n- Pencarian & Pemesanan Hotel: Cari hotel berdasarkan lokasi, rating, dan fasilitas. Lihat detail hotel, harga, dan lakukan pemesanan kamar.\n- Keranjang & Checkout: Tambahkan hotel ke keranjang, lanjutkan ke proses checkout, dan konfirmasi pemesanan.\n- Pembayaran: Berbagai metode pembayaran (transfer, kartu kredit, e-wallet, virtual account).\n- Manajemen Akun: Daftar, login, ubah password, dan kelola profil.\n- Dashboard Admin & Agen: Admin/agen dapat mengelola data hotel, kamar, pesanan, dan melihat statistik.\n- Fitur Pembatalan & Refund: Ajukan pembatalan dan dapatkan refund sesuai kebijakan.\n- Layanan Pelanggan: Chatbot & kontak admin untuk bantuan.\n- Pengaturan Bahasa & Preferensi: Ubah bahasa dan pengaturan akun.\n- Fitur Lain: Lihat fasilitas hotel, lokasi, galeri foto, dan layanan tambahan.',
                    'en': 'Here are the main features of the Hotel Booking application:\n\n- Hotel Search & Booking: Search hotels by location, rating, and facilities. View hotel details, prices, and book rooms.\n- Cart & Checkout: Add hotels to cart, proceed to checkout, and confirm bookings.\n- Payment: Various payment methods (bank transfer, credit card, e-wallet, virtual account).\n- Account Management: Register, login, change password, and manage profile.\n- Admin & Agent Dashboard: Admin/agents can manage hotel data, rooms, orders, and view statistics.\n- Cancellation & Refund: Request cancellations and get refunds according to policy.\n- Customer Service: Chatbot & contact admin for assistance.\n- Language & Preferences: Change language and account settings.\n- Other Features: View hotel amenities, location, photo gallery, and additional services.'
                },
                'default': {
                    'id': 'Mohon maaf, saya tidak sepenuhnya memahami pertanyaan Anda. Bisakah Anda memberikan detail lebih lanjut atau mengajukan pertanyaan yang berbeda?',
                    'en': 'I apologize, but I don\'t fully understand your question. Could you provide more details or ask a different question?'
                }
            };

            // Function to detect language
            function detectLanguage(text) {
                const indonesianWords = [
                    'apa', 'bagaimana', 'kapan', 'dimana', 'siapa', 'mengapa',
                    'bisa', 'mau', 'ingin', 'tolong', 'bantu', 'saya', 'anda',
                    'kami', 'mereka', 'ini', 'itu', 'tersebut', 'dengan', 'untuk',
                    'dari', 'ke', 'pada', 'di', 'yang', 'dan', 'atau', 'tetapi',
                    'karena', 'jika', 'ketika', 'sebelum', 'sesudah', 'selama',
                    'hingga', 'sejak', 'oleh', 'dalam', 'atas', 'bawah', 'depan',
                    'belakang', 'samping', 'antara', 'seperti', 'sama', 'berbeda',
                    'lebih', 'kurang', 'sangat', 'sekali', 'juga', 'lagi', 'sudah',
                    'belum', 'akan', 'sedang', 'pernah', 'tidak', 'bukan', 'ya',
                    'tidak', 'baik', 'buruk', 'besar', 'kecil', 'tinggi', 'rendah',
                    'panjang', 'pendek', 'lebar', 'sempit', 'tebal', 'tipis',
                    'berat', 'ringan', 'mahal', 'murah', 'baru', 'lama', 'cepat',
                    'lambat', 'jauh', 'dekat', 'banyak', 'sedikit', 'semua',
                    'sebagian', 'beberapa', 'satu', 'dua', 'tiga', 'empat', 'lima',
                    'kamar', 'hotel', 'pesan', 'booking', 'reservasi', 'check-in',
                    'check-out', 'fasilitas', 'harga', 'bayar', 'pembayaran',
                    'batal', 'pembatalan', 'refund', 'lokasi', 'alamat', 'wifi',
                    'kolam', 'renang', 'restoran', 'makan', 'minum', 'sarapan',
                    'makan', 'siang', 'makan', 'malam', 'parkir', 'gratis',
                    'berbayar', 'kamar', 'mandi', 'ac', 'tv', 'lemari', 'kasur',
                    'bantal', 'selimut', 'handuk', 'sabun', 'sampo', 'pasta', 'gigi',
                    'sikat', 'gigi', 'tisu', 'toilet', 'shower', 'bathub', 'air',
                    'panas', 'dingin', 'listrik', 'stop', 'kontak', 'lampu',
                    'kamar', 'mandi', 'toilet', 'shower', 'bathub', 'air', 'panas',
                    'dingin', 'listrik', 'stop', 'kontak', 'lampu', 'kamar', 'mandi'
                ];

                const englishWords = [
                    'what', 'how', 'when', 'where', 'who', 'why', 'can', 'could',
                    'would', 'should', 'will', 'shall', 'may', 'might', 'must',
                    'have', 'has', 'had', 'do', 'does', 'did', 'is', 'are', 'was',
                    'were', 'be', 'been', 'being', 'i', 'you', 'he', 'she', 'it',
                    'we', 'they', 'me', 'him', 'her', 'us', 'them', 'my', 'your',
                    'his', 'its', 'our', 'their', 'mine', 'yours', 'hers', 'ours',
                    'theirs', 'this', 'that', 'these', 'those', 'a', 'an', 'the',
                    'and', 'or', 'but', 'because', 'if', 'when', 'while', 'before',
                    'after', 'during', 'until', 'since', 'by', 'in', 'on', 'at',
                    'to', 'for', 'with', 'without', 'about', 'against', 'between',
                    'among', 'through', 'under', 'over', 'above', 'below', 'inside',
                    'outside', 'room', 'hotel', 'book', 'booking', 'reservation',
                    'check-in', 'check-out', 'amenities', 'price', 'pay', 'payment',
                    'cancel', 'cancellation', 'refund', 'location', 'address', 'wifi',
                    'pool', 'swimming', 'restaurant', 'eat', 'drink', 'breakfast',
                    'lunch', 'dinner', 'parking', 'free', 'paid', 'bathroom', 'shower',
                    'bathtub', 'hot', 'cold', 'water', 'electricity', 'outlet', 'light',
                    'bed', 'pillow', 'blanket', 'towel', 'soap', 'shampoo', 'toothpaste',
                    'toothbrush', 'tissue', 'toilet', 'shower', 'bathtub', 'water',
                    'hot', 'cold', 'electricity', 'outlet', 'light', 'bathroom'
                ];
                
                const words = text.toLowerCase().split(' ');
                let indonesianCount = 0;
                let englishCount = 0;

                for (let word of words) {
                    if (indonesianWords.includes(word)) {
                        indonesianCount++;
                    }
                    if (englishWords.includes(word)) {
                        englishCount++;
                    }
                }

                // If both languages are detected, use the one with more matches
                if (indonesianCount > 0 || englishCount > 0) {
                    return indonesianCount >= englishCount ? 'id' : 'en';
                }

                // Default to English if no language is detected
                return 'en';
            }

            // Function to find the best matching response
            function findBestMatch(userMessage, responses) {
                const message = userMessage.toLowerCase();
                let bestMatch = null;
                let highestScore = 0;

                // Keywords for each response type in both languages
                const keywords = {
                    'greeting': {
                        'id': ['halo', 'hai', 'hi', 'hello', 'hey', 'selamat pagi', 'selamat siang', 'selamat malam', 'selamat sore'],
                        'en': ['hello', 'hi', 'hey', 'good morning', 'good afternoon', 'good evening', 'good night']
                    },
                    'farewell': {
                        'id': ['terima kasih', 'makasih', 'thanks', 'thank you', 'bye', 'selamat tinggal', 'goodbye', 'sampai jumpa'],
                        'en': ['thank you', 'thanks', 'bye', 'goodbye', 'see you', 'farewell']
                    },
                    'booking': {
                        'id': ['pesan', 'booking', 'reservasi', 'reserve', 'book', 'pemesanan', 'order', 'kamar', 'hotel'],
                        'en': ['book', 'booking', 'reserve', 'reservation', 'order', 'room', 'hotel']
                    },
                    'payment': {
                        'id': ['bayar', 'pembayaran', 'payment', 'pay', 'metode pembayaran', 'payment method', 'transfer', 'kartu kredit', 'credit card', 'debit', 'e-wallet'],
                        'en': ['pay', 'payment', 'payment method', 'transfer', 'credit card', 'debit', 'e-wallet', 'cash']
                    },
                    'cancellation': {
                        'id': ['batal', 'pembatalan', 'cancel', 'cancellation', 'refund', 'pengembalian dana', 'batalkan'],
                        'en': ['cancel', 'cancellation', 'refund', 'cancel booking', 'cancel reservation']
                    },
                    'check-in': {
                        'id': ['check in', 'check-in', 'masuk', 'kedatangan', 'arrival', 'checkin', 'check in'],
                        'en': ['check in', 'check-in', 'arrival', 'arrive', 'coming']
                    },
                    'check-out': {
                        'id': ['check out', 'check-out', 'keluar', 'keberangkatan', 'departure', 'checkout', 'check out'],
                        'en': ['check out', 'check-out', 'departure', 'leave', 'leaving']
                    },
                    'amenities': {
                        'id': ['fasilitas', 'amenities', 'kolam renang', 'swimming pool', 'wifi', 'restoran', 'restaurant', 'gym', 'fitness', 'sarapan', 'parkir'],
                        'en': ['amenities', 'facilities', 'swimming pool', 'wifi', 'restaurant', 'gym', 'fitness', 'breakfast', 'parking']
                    },
                    'location': {
                        'id': ['lokasi', 'location', 'alamat', 'address', 'dimana', 'where', 'letak', 'position', 'tempat'],
                        'en': ['location', 'address', 'where', 'place', 'position', 'area']
                    },
                    'features': {
                        'id': ['fitur', 'fitur aplikasi', 'apa saja fitur', 'semua fitur', 'keunggulan', 'kelebihan', 'apa yang bisa dilakukan', 'apa yang tersedia', 'layanan aplikasi'],
                        'en': ['feature', 'features', 'application features', 'what can i do', 'what are the features', 'all features', 'capabilities', 'services', 'what is available']
                    }
                };

                for (let type in keywords) {
                    let score = 0;
                    // Check both Indonesian and English keywords
                    for (let lang in keywords[type]) {
                        for (let keyword of keywords[type][lang]) {
                            if (message.includes(keyword)) {
                                score += 1;
                            }
                        }
                    }
                    if (score > highestScore) {
                        highestScore = score;
                        bestMatch = type;
                    }
                }

                return highestScore > 0 ? bestMatch : 'default';
            }

            function getBotResponse(userMessage) {
                const language = detectLanguage(userMessage);
                const bestMatch = findBestMatch(userMessage, responses);
                return responses[bestMatch][language];
            }

            function addMessage(message, isUser = false) {
                const messageDiv = document.createElement('div');
                messageDiv.className = `message ${isUser ? 'user' : 'bot'}`;
                
                const contentDiv = document.createElement('div');
                contentDiv.className = 'message-content';
                
                // Handle multiline messages
                const formattedMessage = message.replace(/\n/g, '<br>');
                contentDiv.innerHTML = formattedMessage;
                
                messageDiv.appendChild(contentDiv);
                chatbotMessages.appendChild(messageDiv);
                
                // Scroll to bottom
                chatbotMessages.scrollTop = chatbotMessages.scrollHeight;
            }

            typeButton.addEventListener('click', function() {
                isTypingMode = !isTypingMode;
                if (isTypingMode) {
                    typeButton.classList.add('active');
                    typeButton.innerHTML = '<i class="fas fa-times"></i><span class="button-label">Batal</span>';
                    userInput.focus();
                    userInput.placeholder = detectLanguage(userInput.value) === 'id' ? 
                        'Ketik pertanyaan Anda di sini...' : 
                        'Type your question here...';
                } else {
                    typeButton.classList.remove('active');
                    typeButton.innerHTML = '<i class="fas fa-keyboard"></i><span class="button-label">Tulis</span>';
                    userInput.placeholder = detectLanguage(userInput.value) === 'id' ? 
                        'Ketik pesan Anda di sini...' : 
                        'Type your message here...';
                }
            });

            const quickReplyGroup = document.getElementById('quickReplyGroup');
            // Quick reply options
            const quickReplies = [
                { text: 'Cara booking hotel', value: 'Bagaimana cara booking hotel?' },
                { text: 'Metode pembayaran', value: 'Apa saja metode pembayaran?' },
                { text: 'Kebijakan pembatalan', value: 'Bagaimana kebijakan pembatalan?' },
                { text: 'Fasilitas hotel', value: 'Fasilitas apa saja yang tersedia?' },
                { text: 'Lokasi hotel', value: 'Dimana lokasi hotel?' }
            ];
            function renderQuickReplies() {
                quickReplyGroup.innerHTML = '';
                quickReplies.forEach(q => {
                    const btn = document.createElement('button');
                    btn.className = 'quick-reply-btn';
                    btn.type = 'button';
                    btn.innerText = q.text;
                    btn.setAttribute('aria-label', q.text);
                    btn.onclick = function() {
                        userInput.value = q.value;
                        userInput.focus();
                    };
                    quickReplyGroup.appendChild(btn);
                });
            }
            renderQuickReplies();

            function handleUserMessage() {
                const message = userInput.value.trim();
                if (message) {
                    addMessage(message, true);
                    userInput.value = '';
                    // Add loading state
                    const loadingDiv = document.createElement('div');
                    loadingDiv.className = 'message bot loading';
                    loadingDiv.innerHTML = '<div class="message-content">...</div>';
                    chatbotMessages.appendChild(loadingDiv);
                    // Simulate bot thinking
                    setTimeout(() => {
                        chatbotMessages.removeChild(loadingDiv);
                        const response = getBotResponse(message);
                        addMessage(response);
                        // Notifikasi jika pesan tidak dikenali
                        if (response === responses['default']['id'] || response === responses['default']['en']) {
                            quickReplyGroup.classList.add('show-suggestion');
                        } else {
                            quickReplyGroup.classList.remove('show-suggestion');
                        }
                        // Reset typing mode after sending
                        if (isTypingMode) {
                            isTypingMode = false;
                            typeButton.classList.remove('active');
                            typeButton.innerHTML = '<i class="fas fa-keyboard"></i><span class="button-label">Tulis</span>';
                        }
                    }, 500);
                } else {
                    userInput.focus();
                }
            }

            // Event listeners
            sendButton.addEventListener('click', handleUserMessage);
            userInput.addEventListener('keypress', (e) => {
                if (e.key === 'Enter') {
                    handleUserMessage();
                }
            });

            // Add input placeholder based on detected language
            userInput.addEventListener('input', function() {
                const language = detectLanguage(this.value);
                this.placeholder = language === 'id' ? 'Ketik pesan Anda di sini...' : 'Type your message here...';
            });
        });
    </script>
</body>
</html> 