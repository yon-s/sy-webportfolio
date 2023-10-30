//Don't let the body scroll
export const backfaceFixed = (fixed) => {
  //Measure the difference from the displayed scroll bar and generate a margin for the difference body element when the back is fixed.
  const scrollbarWidth = window.innerWidth - document.body.clientWidth;
  document.body.style.paddingRight = fixed ? `${scrollbarWidth}px` : '';

  //Output element to get scroll position(`html`or`body`)
  const scrollingElement = () => {
    const browser = window.navigator.userAgent.toLowerCase();
    if ('scrollingElement' in document) return document.scrollingElement;
    if (browser.indexOf('webkit') > 0) return document.body;
    return document.documentElement;
  };

  //Stores the scroll amount in a variable
  const scrollY = fixed
    ? scrollingElement().scrollTop
    : parseInt(document.body.style.top || '0');

  ///Fix the back with CSS
  const styles = {
    height: '100vh',
    left: '0',
    overflow: 'hidden',
    position: 'fixed',
    top: `${scrollY * -1}px`,
    width: '100vw',
  };

  Object.keys(styles).forEach((key) => {
    document.body.style[key] = fixed ? styles[key] : '';
  });

  //Scrolls to the original position when the back is unfastened
  if (!fixed) window.scrollTo(0, scrollY * -1);
};