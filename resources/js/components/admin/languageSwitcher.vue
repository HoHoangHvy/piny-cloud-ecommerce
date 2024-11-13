<script setup>
import {ref, computed, watchEffect, onMounted, onBeforeUnmount} from 'vue';
import {useI18n} from 'vue-i18n';

// Language options
const languages = [
    {code: 'en', name: 'English', flag: '🇺🇸'},
    {code: 'vn', name: 'Tiếng Việt', flag: '🇻🇳'},
];

// Set up i18n locale
const {locale} = useI18n();
const isOpen = ref(false);

// Computed current language based on locale
const currentLanguage = computed(() =>
    languages.find(lang => lang.code === locale.value) || languages[0]
);

// Set new language
const setLanguage = (newLang) =>  {
    debugger
    locale.value = newLang;
    localStorage.setItem('lang', newLang);
    isOpen.value = false;
};

// Load saved language from localStorage
watchEffect(() => {
    const storedLang = localStorage.getItem('lang');
    if (storedLang && languages.some(lang => lang.code === storedLang)) {
        locale.value = storedLang;
    }
});

// Directive to close dropdown on outside click
const clickOutsideHandler = (event) => {
    if (!event.target.closest('.language-switcher')) {
        isOpen.value = false;
    }
};

onMounted(() => document.addEventListener('click', clickOutsideHandler));
onBeforeUnmount(() => document.removeEventListener('click', clickOutsideHandler));

// Define a position prop to control dropdown position
defineProps({
    position: {
        type: String,
        default: 'below', // Default position is 'below', but can be set to 'above'
    }
});
</script>

<template>
    <div class="relative inline-block text-left language-switcher">
        <!-- Language list with dynamic position based on prop -->
        <div
            v-if="isOpen"
            :class="[
        position === 'above' ? 'absolute bottom-full left-0 mb-2' : 'absolute top-full left-0 mt-2',
        'w-full rounded-md shadow-lg bg-white ring-1 ring-black ring-opacity-5 z-10'
      ]"
            role="menu"
            aria-orientation="vertical"
            aria-labelledby="options-menu"
        >
            <div class="py-1">
                <a
                    v-for="lang in languages"
                    :key="lang.code"
                    href="#"
                    class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 hover:text-gray-900"
                    role="menuitem"
                    @click.prevent="setLanguage(lang.code)"
                >
                    {{ lang.flag }} {{ lang.name }}
                </a>
            </div>
        </div>

        <!-- Button to toggle the language list -->
        <button
            @click="isOpen = !isOpen"
            type="button"
            class="inline-flex justify-center w-full rounded-md shadow-sm px-4 py-2 bg-white text-sm font-medium text-gray-700 hover:bg-gray"
            id="options-menu"
            aria-haspopup="true"
            :aria-expanded="isOpen"
        >
            {{ currentLanguage.flag }} {{ currentLanguage.name }}

            <!-- Conditional SVG for Arrow Up or Down based on Position -->
            <svg
                v-if="position === 'above'"
                class="ml-2 h-5 w-5"
                xmlns="http://www.w3.org/2000/svg"
                viewBox="0 0 20 20"
                fill="currentColor"
                aria-hidden="true"
            >
                <path
                    fill-rule="evenodd"
                    d="M14.707 12.707a1 1 0 01-1.414 0L10 9.414l-3.293 3.293a1 1 0 01-1.414-1.414l4-4a1 1 0 011.414 0l4 4a1 1 0 010 1.414z"
                    clip-rule="evenodd"
                />
            </svg>
            <svg
                v-else
                class="ml-2 h-5 w-5"
                xmlns="http://www.w3.org/2000/svg"
                viewBox="0 0 20 20"
                fill="currentColor"
                aria-hidden="true"
            >
                <path
                    fill-rule="evenodd"
                    d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 011.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                    clip-rule="evenodd"
                />
            </svg>
        </button>
    </div>
</template>
