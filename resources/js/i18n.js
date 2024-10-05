import { createI18n } from 'vue-i18n';
import en from '@/language/en/en.json';
import vn from '@/language/vn/vn.json';

const i18n = createI18n({
  legacy: false,
  locale: localStorage.getItem('lang') || 'en',
  fallbackLocale: 'en',
  messages: {
    en,
    vn,
  },
});

export default i18n;
