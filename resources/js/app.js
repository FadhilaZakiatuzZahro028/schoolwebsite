import 'bootstrap';

import {
    ArrowLeft,
    ArrowUpRight,
    Bot,
    Briefcase,
    CalendarDays,
    CircleAlert,
    CircleCheck,
    ClipboardList,
    Clock3,
    createIcons,
    GraduationCap,
    Image,
    Link,
    Mail,
    Map,
    MapPin,
    MessageCircle,
    MessagesSquare,
    Newspaper,
    Phone,
    School,
    Send,
    Share2,
    Star,
    Trophy,
    UserRound,
    X,
} from 'lucide';

const navbar = document.querySelector('[data-site-navbar]');

const updateNavbarState = () => {
    navbar?.classList.toggle('is-scrolled', window.scrollY > 16);
};

updateNavbarState();

window.addEventListener('scroll', updateNavbarState, {
    passive: true,
});

const chatbotWidget = document.querySelector('[data-chatbot-widget]');

if (chatbotWidget) {
    const chatbotPanel = chatbotWidget.querySelector(
        '[data-chatbot-panel]',
    );

    const chatbotTrigger = chatbotWidget.querySelector(
        '[data-chatbot-trigger]',
    );

    const chatbotClose = chatbotWidget.querySelector(
        '[data-chatbot-close]',
    );

    const chatbotForm = chatbotWidget.querySelector(
        '[data-chatbot-form]',
    );

    const chatbotInput = chatbotWidget.querySelector(
        '[data-chatbot-input]',
    );

    const chatbotSubmit = chatbotWidget.querySelector(
        '[data-chatbot-submit]',
    );

    const chatbotMessages = chatbotWidget.querySelector(
        '[data-chatbot-messages]',
    );

    const endpoint = chatbotWidget.dataset.chatbotEndpoint;

    const setPanelState = (isOpen) => {
        chatbotPanel.hidden = !isOpen;
        chatbotTrigger.setAttribute(
            'aria-expanded',
            String(isOpen),
        );

        chatbotTrigger.setAttribute(
            'aria-label',
            isOpen ? 'Tutup Chatbot' : 'Buka Chatbot',
        );

        if (isOpen) {
            window.setTimeout(() => {
                chatbotInput.focus();
            }, 50);
        }
    };

    const appendMessage = (message, sender) => {
        const wrapper = document.createElement('div');

        wrapper.className = [
            'chatbot-message',
            sender === 'user'
                ? 'chatbot-message-user'
                : 'chatbot-message-bot',
        ].join(' ');

        if (sender === 'bot') {
            const avatar = document.createElement('span');

            avatar.className = 'chatbot-message-avatar';
            avatar.setAttribute('aria-hidden', 'true');

            const icon = document.createElement('i');

            icon.setAttribute('data-lucide', 'bot');

            avatar.append(icon);
            wrapper.append(avatar);
        }

        const bubble = document.createElement('div');

        bubble.className = 'chatbot-message-bubble';
        bubble.textContent = message;

        wrapper.append(bubble);
        chatbotMessages.append(wrapper);

        createIcons({
            icons: {
                Bot,
            },
        });

        chatbotMessages.scrollTop = chatbotMessages.scrollHeight;
    };

    chatbotTrigger.addEventListener('click', () => {
        setPanelState(chatbotPanel.hidden);
    });

    chatbotClose.addEventListener('click', () => {
        setPanelState(false);
        chatbotTrigger.focus();
    });

    document.addEventListener('keydown', (event) => {
        if (
            event.key === 'Escape'
            && !chatbotPanel.hidden
        ) {
            setPanelState(false);
            chatbotTrigger.focus();
        }
    });

    chatbotForm.addEventListener('submit', async (event) => {
        event.preventDefault();

        const message = chatbotInput.value.trim();

        if (message.length < 2) {
            chatbotInput.focus();

            return;
        }

        appendMessage(message, 'user');

        chatbotInput.value = '';
        chatbotInput.disabled = true;
        chatbotSubmit.disabled = true;

        try {
            const response = await fetch(endpoint, {
                method: 'POST',
                headers: {
                    Accept: 'application/json',
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document
                        .querySelector('meta[name="csrf-token"]')
                        ?.getAttribute('content') ?? '',
                },
                body: JSON.stringify({
                    message,
                }),
            });

            if (response.status === 429) {
                appendMessage(
                    'Terlalu banyak pertanyaan dalam waktu singkat. '
                        + 'Silakan tunggu sebentar lalu coba kembali.',
                    'bot',
                );

                return;
            }

            if (!response.ok) {
                throw new Error(
                    `Chatbot request failed with status ${response.status}`,
                );
            }

            const data = await response.json();

            appendMessage(
                data.answer
                    ?? 'Maaf, jawaban belum tersedia.',
                'bot',
            );
        } catch (error) {
            console.error(error);

            appendMessage(
                'Maaf, layanan Chatbot sedang tidak dapat digunakan. '
                    + 'Silakan coba kembali atau hubungi sekolah '
                    + 'melalui halaman Kontak.',
                'bot',
            );
        } finally {
            chatbotInput.disabled = false;
            chatbotSubmit.disabled = false;
            chatbotInput.focus();
        }
    });
}

const staffCarousels = document.querySelectorAll(
    '[data-staff-carousel]',
);

staffCarousels.forEach((carousel) => {
    const viewport = carousel.querySelector(
        '[data-staff-carousel-viewport]',
    );

    const track = carousel.querySelector(
        '[data-staff-carousel-track]',
    );

    const originalSlides = Array.from(
        carousel.querySelectorAll(
            '[data-staff-carousel-slide]',
        ),
    );

    const previousButton = carousel.querySelector(
        '[data-staff-carousel-prev]',
    );

    const nextButton = carousel.querySelector(
        '[data-staff-carousel-next]',
    );

    const slideCount = originalSlides.length;

    if (!viewport || !track || slideCount === 0) {
        return;
    }

    const reducedMotion = window.matchMedia(
        '(prefers-reduced-motion: reduce)',
    );

    const shouldCloneForLoop = slideCount > 2;

    const requestedInitialIndex = Number.parseInt(
        carousel.dataset.initialIndex ?? '0',
        10,
    );

    const initialIndex = Number.isNaN(requestedInitialIndex)
        ? 0
        : Math.min(
            Math.max(requestedInitialIndex, 0),
            slideCount - 1,
        );

    const autoplayDelay = 2500;

    let allSlides = originalSlides;
    let currentIndex = initialIndex;
    let currentTranslateX = 0;
    let isMoving = false;
    let isDragging = false;
    let isHovered = false;
    let movementTimeout = null;
    let autoplayTimer = null;
    let dragPointerId = null;
    let dragStartX = 0;
    let dragDeltaX = 0;

    const createLoopClone = (slide) => {
        const clone = slide.cloneNode(true);

        clone.classList.remove('is-active');
        clone.removeAttribute('aria-current');
        clone.setAttribute('aria-hidden', 'true');
        clone.setAttribute('inert', '');
        clone.dataset.staffCarouselClone = 'true';

        return clone;
    };

    if (shouldCloneForLoop) {
        const beforeClones = originalSlides.map(
            createLoopClone,
        );

        const afterClones = originalSlides.map(
            createLoopClone,
        );

        track.prepend(...beforeClones);
        track.append(...afterClones);

        allSlides = Array.from(
            track.querySelectorAll(
                '[data-staff-carousel-slide]',
            ),
        );

        currentIndex = slideCount + initialIndex;
    }

    const getLogicalIndex = () => {
        const currentSlide = allSlides[currentIndex];

        if (!currentSlide) {
            return 0;
        }

        return Number.parseInt(
            currentSlide.dataset.index ?? '0',
            10,
        );
    };

    const updateActiveState = () => {
        const logicalIndex = getLogicalIndex();

        allSlides.forEach((slide, index) => {
            slide.classList.toggle(
                'is-active',
                index === currentIndex,
            );
        });

        originalSlides.forEach((slide) => {
            const slideIndex = Number.parseInt(
                slide.dataset.index ?? '0',
                10,
            );

            if (slideIndex === logicalIndex) {
                slide.setAttribute(
                    'aria-current',
                    'true',
                );
            } else {
                slide.removeAttribute(
                    'aria-current',
                );
            }
        });
    };

    const setTrackPosition = (
        translateX,
        animate = true,
    ) => {
        const shouldAnimate = animate
            && !reducedMotion.matches;

        if (!shouldAnimate) {
            track.style.transition = 'none';
        }

        currentTranslateX = translateX;

        track.style.transform = [
            'translate3d(',
            `${translateX}px`,
            ', 0, 0)',
        ].join('');

        if (!shouldAnimate) {
            track.getBoundingClientRect();
            track.style.removeProperty('transition');
        }
    };

    const positionCurrentSlide = (animate = true) => {
        const currentSlide = allSlides[currentIndex];

        if (!currentSlide) {
            return;
        }

        const slideCenter = currentSlide.offsetLeft
            + (currentSlide.offsetWidth / 2);

        const viewportCenter = viewport.clientWidth / 2;

        setTrackPosition(
            viewportCenter - slideCenter,
            animate,
        );
    };

    const normalizeLoopPosition = () => {
    if (!shouldCloneForLoop) {
        return;
    }

    if (currentIndex < slideCount) {
        currentIndex += slideCount;
    } else if (currentIndex >= slideCount * 2) {
        currentIndex -= slideCount;
    } else {
        return;
    }

    carousel.classList.add('is-resetting');

    updateActiveState();
    positionCurrentSlide(false);

    track.getBoundingClientRect();

    window.requestAnimationFrame(() => {
        carousel.classList.remove('is-resetting');
    });
};

    const finishMovement = () => {
        if (movementTimeout !== null) {
            window.clearTimeout(movementTimeout);
            movementTimeout = null;
        }

        normalizeLoopPosition();

        isMoving = false;
    };

    const move = (direction) => {
        if (
            slideCount < 2
            || isMoving
            || isDragging
        ) {
            return;
        }

        isMoving = true;

        if (shouldCloneForLoop) {
            currentIndex += direction;
        } else {
            currentIndex = (
                currentIndex
                + direction
                + slideCount
            ) % slideCount;
        }

        updateActiveState();
        positionCurrentSlide(true);

        if (reducedMotion.matches) {
            finishMovement();

            return;
        }

        movementTimeout = window.setTimeout(
            finishMovement,
            230,
        );
    };

    const stopAutoplay = () => {
        if (autoplayTimer === null) {
            return;
        }

        window.clearInterval(autoplayTimer);
        autoplayTimer = null;
    };

    const startAutoplay = () => {
        stopAutoplay();

        if (
            slideCount < 2
            || reducedMotion.matches
            || isHovered
            || isDragging
        ) {
            return;
        }

        autoplayTimer = window.setInterval(
            () => {
                move(1);
            },
            autoplayDelay,
        );
    };

    const restartAutoplay = () => {
        stopAutoplay();
        startAutoplay();
    };

    previousButton?.addEventListener('click', () => {
        move(-1);
        restartAutoplay();
    });

    nextButton?.addEventListener('click', () => {
        move(1);
        restartAutoplay();
    });

    carousel.addEventListener('mouseenter', () => {
        isHovered = true;
        stopAutoplay();
    });

    carousel.addEventListener('mouseleave', () => {
        isHovered = false;
        startAutoplay();
    });

    carousel.addEventListener('keydown', (event) => {
        if (event.key === 'ArrowLeft') {
            event.preventDefault();

            move(-1);
            restartAutoplay();
        }

        if (event.key === 'ArrowRight') {
            event.preventDefault();

            move(1);
            restartAutoplay();
        }
    });

    viewport.addEventListener(
        'pointerdown',
        (event) => {
            if (
                slideCount < 2
                || event.button !== 0
            ) {
                return;
            }

            isDragging = true;
            dragPointerId = event.pointerId;
            dragStartX = event.clientX;
            dragDeltaX = 0;

            stopAutoplay();

            carousel.classList.add('is-dragging');

            track.style.transition = 'none';

            viewport.setPointerCapture?.(
                event.pointerId,
            );
        },
    );

    viewport.addEventListener(
        'pointermove',
        (event) => {
            if (
                !isDragging
                || event.pointerId !== dragPointerId
            ) {
                return;
            }

            dragDeltaX = event.clientX - dragStartX;

            track.style.transform = [
                'translate3d(',
                `${currentTranslateX + dragDeltaX}px`,
                ', 0, 0)',
            ].join('');
        },
    );

    const endDrag = (
        event,
        allowNavigation = true,
    ) => {
        if (
            !isDragging
            || event.pointerId !== dragPointerId
        ) {
            return;
        }

        const distance = dragDeltaX;

        const threshold = Math.max(
            40,
            Math.min(
                80,
                viewport.clientWidth * 0.12,
            ),
        );

        isDragging = false;
        dragPointerId = null;
        dragDeltaX = 0;

        carousel.classList.remove('is-dragging');

        track.style.removeProperty('transition');

        viewport.releasePointerCapture?.(
            event.pointerId,
        );

        if (
            allowNavigation
            && Math.abs(distance) >= threshold
        ) {
            move(distance > 0 ? -1 : 1);
        } else {
            positionCurrentSlide(true);
        }

        startAutoplay();
    };

    viewport.addEventListener(
        'pointerup',
        (event) => {
            endDrag(event, true);
        },
    );

    viewport.addEventListener(
        'pointercancel',
        (event) => {
            endDrag(event, false);
        },
    );

    track.addEventListener(
        'transitionend',
        (event) => {
            if (
                event.target !== track
                || event.propertyName !== 'transform'
            ) {
                return;
            }

            finishMovement();
        },
    );

    const resetPosition = () => {
        updateActiveState();
        positionCurrentSlide(false);
    };

    reducedMotion.addEventListener(
        'change',
        () => {
            if (reducedMotion.matches) {
                stopAutoplay();
            } else {
                startAutoplay();
            }

            resetPosition();
        },
    );

    window.requestAnimationFrame(() => {
        resetPosition();
        startAutoplay();
    });

    window.addEventListener(
        'resize',
        resetPosition,
        {
            passive: true,
        },
    );
});

const historyTimeline = document.querySelector('.history-timeline');

if (historyTimeline) {
    const historyItems = Array.from(
        historyTimeline.querySelectorAll(
            '.history-timeline-item',
        ),
    );

    const historyYearLinks = Array.from(
        document.querySelectorAll(
            '.history-year-nav a[href^="#"]',
        ),
    );

    const reducedMotion = window.matchMedia(
        '(prefers-reduced-motion: reduce)',
    );

    historyTimeline.classList.add('is-motion-ready');

    const setActiveMilestone = (activeIndex) => {
        historyItems.forEach((item, index) => {
            item.classList.toggle(
                'is-passed',
                index < activeIndex,
            );

            item.classList.toggle(
                'is-current',
                index === activeIndex,
            );
        });

        historyYearLinks.forEach((link) => {
            const targetId = link
                .getAttribute('href')
                ?.replace('#', '');

            link.classList.toggle(
                'is-active',
                targetId === historyItems[activeIndex]?.id,
            );
        });
    };

    const updateTimelineState = () => {
        const timelineRect =
            historyTimeline.getBoundingClientRect();

        const viewportAnchor =
            window.innerHeight * 0.45;

        const travelled =
            viewportAnchor - timelineRect.top;

        const progress = Math.min(
            1,
            Math.max(
                0,
                travelled / timelineRect.height,
            ),
        );

        historyTimeline.style.setProperty(
            '--history-progress',
            progress,
        );

        let activeIndex = 0;

        historyItems.forEach((item, index) => {
    const marker =
        item.querySelector(
            '.history-timeline-marker',
        ) ?? item;

    const markerRect =
        marker.getBoundingClientRect();

    const markerCenter =
        markerRect.top
        + markerRect.height / 2;

    if (markerCenter <= viewportAnchor) {
        activeIndex = index;
    }

    if (!reducedMotion.matches) {
        const itemRect =
            item.getBoundingClientRect();

        const animationStart =
            window.innerHeight * 0.9;

        const animationEnd =
            window.innerHeight * 0.42;

        const rawProgress =
            (
                animationStart
                - itemRect.top
            )
            / (
                animationStart
                - animationEnd
            );

        const mediaProgress = Math.min(
            1,
            Math.max(0, rawProgress),
        );

        const easedProgress =
            1
            - Math.pow(
                1 - mediaProgress,
                3,
            );

        const mediaScale =
            1.08
            - easedProgress * 0.08;

        const mediaTranslate =
            16
            - easedProgress * 16;

        item.style.setProperty(
            '--history-media-scale',
            mediaScale.toFixed(4),
        );

        item.style.setProperty(
            '--history-media-translate',
            `${mediaTranslate.toFixed(2)}px`,
        );

        item.style.setProperty(
            '--history-media-progress',
            easedProgress.toFixed(4),
        );
    }
});

        setActiveMilestone(activeIndex);
    };

    if (
        'IntersectionObserver' in window
        && !reducedMotion.matches
    ) {
        const revealObserver =
            new IntersectionObserver(
                (entries, observer) => {
                    entries.forEach((entry) => {
                        if (!entry.isIntersecting) {
                            return;
                        }

                        entry.target.classList.add(
                            'is-visible',
                        );

                        observer.unobserve(
                            entry.target,
                        );
                    });
                },
                {
                    threshold: 0.18,
                    rootMargin:
                        '0px 0px -8% 0px',
                },
            );

        historyItems.forEach((item) => {
            revealObserver.observe(item);
        });
    } else {
        historyItems.forEach((item) => {
            item.classList.add('is-visible');
        });
    }

    historyYearLinks.forEach((link) => {
        link.addEventListener('click', (event) => {
            const selector =
                link.getAttribute('href');

            if (!selector) {
                return;
            }

            const target =
                document.querySelector(selector);

            if (!target) {
                return;
            }

            event.preventDefault();

            target.scrollIntoView({
                behavior: reducedMotion.matches
                    ? 'auto'
                    : 'smooth',
                block: 'start',
            });
        });
    });

    let timelineFrame = null;

    const requestTimelineUpdate = () => {
        if (timelineFrame !== null) {
            return;
        }

        timelineFrame =
            window.requestAnimationFrame(() => {
                updateTimelineState();
                timelineFrame = null;
            });
    };

    window.addEventListener(
        'scroll',
        requestTimelineUpdate,
        {
            passive: true,
        },
    );

    window.addEventListener(
        'resize',
        requestTimelineUpdate,
        {
            passive: true,
        },
    );

    reducedMotion.addEventListener(
        'change',
        () => {
            if (reducedMotion.matches) {
                historyItems.forEach((item) => {
                    item.classList.add(
                        'is-visible',
                    );
                });
            }

            requestTimelineUpdate();
        },
    );

    window.requestAnimationFrame(() => {
        updateTimelineState();
    });
}

const newsArticle = document.querySelector(
    '[data-news-article]',
);

const newsReadingProgress = document.querySelector(
    '[data-news-reading-progress]',
);

if (
    newsArticle
    && newsReadingProgress
) {
    let newsProgressFrame = null;

    const updateNewsReadingProgress = () => {
        const articleRect =
            newsArticle.getBoundingClientRect();

        const articleTop =
            window.scrollY + articleRect.top;

        const articleHeight =
            newsArticle.offsetHeight;

        const scrollableDistance = Math.max(
            articleHeight - window.innerHeight,
            1,
        );

        const rawProgress =
            (
                window.scrollY
                - articleTop
            )
            / scrollableDistance;

        const progress = Math.min(
            1,
            Math.max(
                0,
                rawProgress,
            ),
        );

        newsReadingProgress.style.transform =
            `scaleX(${progress})`;
    };

    const requestNewsProgressUpdate = () => {
        if (newsProgressFrame !== null) {
            return;
        }

        newsProgressFrame =
            window.requestAnimationFrame(() => {
                updateNewsReadingProgress();
                newsProgressFrame = null;
            });
    };

    window.addEventListener(
        'scroll',
        requestNewsProgressUpdate,
        {
            passive: true,
        },
    );

    window.addEventListener(
        'resize',
        requestNewsProgressUpdate,
        {
            passive: true,
        },
    );

    window.requestAnimationFrame(
        updateNewsReadingProgress,
    );
}

const newsCopyButtons = document.querySelectorAll(
    '[data-news-copy-link]',
);

newsCopyButtons.forEach((button) => {
    const label = button.querySelector(
        '[data-news-copy-label]',
    );

    const feedback = button
        .closest('.news-share-panel')
        ?.querySelector(
            '[data-news-copy-feedback]',
        );

    const url =
        button.dataset.newsUrl
        ?? window.location.href;

    let feedbackTimeout = null;

    const copyWithFallback = async (text) => {
        if (
            navigator.clipboard
            && window.isSecureContext
        ) {
            await navigator.clipboard.writeText(
                text,
            );

            return;
        }

        const textarea =
            document.createElement('textarea');

        textarea.value = text;
        textarea.setAttribute(
            'readonly',
            '',
        );

        textarea.style.position = 'fixed';
        textarea.style.opacity = '0';
        textarea.style.pointerEvents = 'none';

        document.body.append(textarea);

        textarea.select();
        textarea.setSelectionRange(
            0,
            textarea.value.length,
        );

        const copied =
            document.execCommand('copy');

        textarea.remove();

        if (!copied) {
            throw new Error(
                'Copy command failed.',
            );
        }
    };

    button.addEventListener(
        'click',
        async () => {
            if (feedbackTimeout !== null) {
                window.clearTimeout(
                    feedbackTimeout,
                );
            }

            try {
                await copyWithFallback(url);

                button.classList.add(
                    'is-copied',
                );

                if (label) {
                    label.textContent =
                        'Tautan Disalin';
                }

                if (feedback) {
                    feedback.textContent =
                        'Tautan berita berhasil disalin.';
                }

                feedbackTimeout =
                    window.setTimeout(
                        () => {
                            button.classList.remove(
                                'is-copied',
                            );

                            if (label) {
                                label.textContent =
                                    'Salin Tautan';
                            }

                            if (feedback) {
                                feedback.textContent =
                                    '';
                            }
                        },
                        2500,
                    );
            } catch (error) {
                console.error(error);

                if (feedback) {
                    feedback.textContent =
                        'Tautan belum dapat disalin. '
                        + 'Silakan salin dari bilah alamat.';
                }
            }
        },
    );
});

createIcons({
    icons: {
        ArrowLeft,
        ArrowUpRight,
        Bot,
        Briefcase,
        CalendarDays,
        CircleAlert,
        CircleCheck,
        ClipboardList,
        Clock3,
        GraduationCap,
        Image,
        Link,
        Mail,
        Map,
        MapPin,
        MessageCircle,
        MessagesSquare,
        Newspaper,
        Phone,
        School,
        Send,
        Share2,
        Star,
        Trophy,
        UserRound,
        X,
    },
});