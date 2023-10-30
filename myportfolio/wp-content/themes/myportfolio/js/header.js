import {openAndClose} from './open.js'
//ハンバーガーメニュー
  const headerMenu = document.getElementById('header__menu');
  const headerMenuTxt = document.getElementById('header__menu-txt');
  const menu = document.getElementById('menu');
  const headerMenuLists = document.querySelectorAll('.menu__item-link');
  openAndClose(headerMenu, headerMenuTxt, 'menu', 'close', menu, headerMenuLists);

  //スムーススクロール
  const smoothScrollTrigger = document.querySelectorAll('a[href^="#"]');
  for (let i = 0; i < smoothScrollTrigger.length; i++){
    smoothScrollTrigger[i].addEventListener('click', (e) => {
      e.preventDefault();
      let href = smoothScrollTrigger[i].getAttribute('href');
      let targetElement = document.getElementById(href.replace('#', ''));
      const rect = targetElement.getBoundingClientRect().top;
      const offset = window.pageYOffset;
      const gap = 60;
      const target = rect + offset - gap;
      window.scrollTo({
        top: target,
        behavior: 'smooth',
      });
    });
  }
  //100vh対応
  const setFillHeight = () => {
    const vh = window.innerHeight * 0.01;
    document.documentElement.style.setProperty('--vh', `${vh}px`);
  }
  // ここからリサイズの対応
  let vw = window.innerWidth;
  window.addEventListener('resize', () => {
    if (vw === window.innerWidth) {
    // 画面の横幅にサイズ変動がないので処理を終える
      return;
    }
    // 画面の横幅のサイズ変動があった時のみ高さを再計算する
    vw = window.innerWidth;
    setFillHeight();
  });
  
  // 実行
  setFillHeight();