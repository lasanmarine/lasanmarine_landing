export const isEnglish = () => (document.documentElement.lang || '').toLowerCase().startsWith('en');
export const pageLocale = () => (isEnglish() ? 'en-US' : 'vi-VN');
