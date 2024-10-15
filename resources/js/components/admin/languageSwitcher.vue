<template>
  <div class="relative inline-block text-left">
    <!-- Language list positioned above the button -->
    <div v-if="isOpen" class="absolute bottom-full left-0 mb-2 w-full rounded-md shadow-lg bg-white ring-1 ring-black ring-opacity-5">
      <div class="py-1" role="menu" aria-orientation="vertical" aria-labelledby="options-menu">
        <a v-for="lang in languages" :key="lang.code" href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 hover:text-gray-900" role="menuitem" @click.prevent="setLanguage(lang.code)">
          {{ lang.flag }} {{ lang.name }}
        </a>
      </div>
    </div>

    <!-- Button to toggle the language list -->
    <button @click="isOpen = !isOpen" type="button" class="inline-flex justify-center w-full rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-offset-gray-100 focus:ring-indigo-500" id="options-menu" aria-haspopup="true" :aria-expanded="isOpen">
      {{ currentLanguage.flag }} {{ currentLanguage.name }}
      <svg class="ml-2 h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
        <path fill-rule="evenodd" d="M14.707 12.707a1 1 0 01-1.414 0L10 9.414l-3.293 3.293a1 1 0 01-1.414-1.414l4-4a1 1 0 011.414 0l4 4a1 1 0 010 1.414z" clip-rule="evenodd" />
      </svg>
    </button>
  </div>
</template>

<script setup>
import { ref, computed, watchEffect } from 'vue';
import { useI18n } from 'vue-i18n';

const languages = [
  { code: 'en', name: 'English', flag: '🇺🇸' },
  { code: 'vn', name: 'Tiếng Việt', flag: '🇻🇳' },
];

const { locale } = useI18n();
const isOpen = ref(false);

const currentLanguage = computed(() =>
  languages.find(lang => lang.code === locale.value) || languages[0]
);

const setLanguage = (newLang) => {
  locale.value = newLang;
  localStorage.setItem('lang', newLang);
  isOpen.value = false;
};

watchEffect(() => {
  const storedLang = localStorage.getItem('lang');
  if (storedLang && languages.some(lang => lang.code === storedLang)) {
    locale.value = storedLang;
  }
});
</script>
