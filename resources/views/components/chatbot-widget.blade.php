<aside
    class="chatbot-widget"
    data-chatbot-widget
    data-chatbot-endpoint="{{ route('chatbot.reply') }}"
    aria-label="Asisten informasi sekolah"
>
    <section
        class="chatbot-panel"
        data-chatbot-panel
        aria-label="Percakapan dengan asisten sekolah"
        hidden
    >
        <header class="chatbot-header">
            <div class="chatbot-header-identity">
                <span
                    class="chatbot-header-icon"
                    aria-hidden="true"
                >
                    <i data-lucide="bot"></i>
                </span>

                <div>
                    <h2>Asisten Sekolah</h2>
                    <p>Informasi seputar sekolah</p>
                </div>
            </div>

            <button
                class="chatbot-close-button"
                type="button"
                data-chatbot-close
                aria-label="Tutup Chatbot"
            >
                <i
                    data-lucide="x"
                    aria-hidden="true"
                ></i>
            </button>
        </header>

        <div
            class="chatbot-messages"
            data-chatbot-messages
            aria-live="polite"
            aria-relevant="additions"
        >
            <div class="chatbot-message chatbot-message-bot">
                <span
                    class="chatbot-message-avatar"
                    aria-hidden="true"
                >
                    <i data-lucide="bot"></i>
                </span>

                <div class="chatbot-message-bubble">
                    Halo! Silakan tanyakan informasi mengenai profil,
                    SPMB, guru, fasilitas, prestasi, atau layanan sekolah.
                </div>
            </div>
        </div>

        <form
            class="chatbot-form"
            data-chatbot-form
        >
            <label
                class="visually-hidden"
                for="chatbot-message"
            >
                Tulis pertanyaan
            </label>

            <input
                id="chatbot-message"
                class="chatbot-input"
                type="text"
                name="message"
                minlength="2"
                maxlength="500"
                autocomplete="off"
                placeholder="Tulis pertanyaan..."
                data-chatbot-input
                required
            >

            <button
                class="chatbot-send-button"
                type="submit"
                data-chatbot-submit
                aria-label="Kirim pertanyaan"
            >
                <i
                    data-lucide="send"
                    aria-hidden="true"
                ></i>
            </button>
        </form>
    </section>

    <button
        class="chatbot-trigger"
        type="button"
        data-chatbot-trigger
        aria-label="Buka Chatbot"
        aria-expanded="false"
    >
        <i
            data-lucide="message-circle"
            aria-hidden="true"
        ></i>

        <span class="chatbot-trigger-label">
            Tanya Kami
        </span>
    </button>
</aside>