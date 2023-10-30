import { toBoolean } from './toBoolean.js';
export const fadeInAdd = (FadeInItem, FadeInItemLeft, FadeInItemRight, FadeInItemDown, FadeInItemUp,FadeInFast) => {// (Item to add a class when scrolled, Items fading in from left to right, Items fading in from right to left, Items fading in from down to up, Items fading in from up to down)
  //FadeInItem with data attribute
  for (let i = 0; i < FadeInItem.length; i++){
    if(!FadeInItem[i].dataset.fadeIn !== 'scroll'){//Added data-fade-in="scroll" to FadeInItem
      FadeInItem[i].dataset.fadeIn = 'scroll';
    }
  }
  if(FadeInFast){
    for (let i = 0; i < FadeInFast.length; i++){
      if(!FadeInFast[i].dataset.scrollIn !== 'fast'){//Added data-fade-in="scroll" to FadeInFast
        FadeInFast[i].dataset.scrollIn = 'fast';
      }
    }
  }
  

  //Position before fade in
  const FadeInPositions = ['Left', 'Right', 'Down', 'Up']
  for(let Position = 0; Position < FadeInPositions.length; Position++){
    let FadeInDirections = FadeInPositions[Position];// 'Left', 'Right', 'Down', 'Up'
    let FadeInDirectionsClass = `fade-in--${FadeInDirections.slice( 0, 1 ).toLowerCase()}${FadeInDirections.slice( 1 )}`// fade-in--'left', 'right', 'down', 'up' (First letter lowercase.)
    let FadeInPosition = eval(`FadeInItem${FadeInDirections}`);// Convert to variable
    for (let i = 0; i < FadeInPosition.length; i++){
      let FadeInelements = document.querySelectorAll(FadeInPosition[i]);
      FadeInelements.forEach(function (FadeInelement) {
        if (!FadeInelement.className.match(/FadeInDirectionsClass/)){// If there is no class name, add a class.
          FadeInelement.classList.add(FadeInDirectionsClass);
        }
      });
    }
  }
}
//Fade in at a specific position
export const fadeIn = (fadeInTarget, scrolls, changingPositions, addClassItems, removeClass) =>{// (Items that fade in,　Scroll reference target(Set if other than fadeInTarget), Delay scroll position or(boolean), If there are items other than fadeInTarget to which you want to add a class, specify it., Specify if you want to remove the class)
  const windowHeight = window.innerHeight ;
  const scroll = scrolls ? scrolls.pageYOffset || scrolls.scrollTop : window.pageYOffset || document.documentElement.scrollTop;//スクロール値
  const manuAriaHidden = toBoolean(document.getElementById('menu').getAttribute('aria-hidden'));
  if(!removeClass && manuAriaHidden){
      const html = document.querySelector('html');
      const bodyHeight = document.body.clientHeight // Get body height
      const bottomPoint = bodyHeight - windowHeight //　Last place
    if (bottomPoint <= scroll){// Scroll to the end and add a class.
        html.classList.add('is-scrollEnd'); 
    };
    if(html.className.match(/is-scrollEnd/)) return;// If you scroll to the end, stop the process after that.
  }
  let changingPositionValue = windowHeight * 0.1150;
  const changingPosition = changingPositions ? changingPositionValue : 0;// Position to delay processing
  if (typeof fadeInTarget.length === "undefined") {// When fadeInTarget is one.(If the target is an id)
    fadeInTarget = [fadeInTarget];
  }
  let changingPositionPlus = 0;
  for (let i = 0; i < fadeInTarget.length; i++){
   const addClassItem = addClassItems ? addClassItems : fadeInTarget[i];// class item to be added
    const rect = fadeInTarget[i].getBoundingClientRect().top;
    const offset = rect + scroll;// Obtain y-axis value of target to be fadein
    const relativeHeight = scrolls ? 0 : windowHeight;// Obtains the height of the item on which the scrolling is based
    const fadeInTargetClass = fadeInTarget[i].className;
    const fadeInTargetHeight = fadeInTarget[i].offsetHeight // Get the height of that item
    if(fadeInTargetClass.match(/fade-in--down|fade-in--up/) ){// If the class name of the item to be fadein has fade-in--down or fade-in--up
      if(fadeInTargetClass.match(/down/)){// If the class name of the item to be fadein has down
        changingPositionPlus = -fadeInTargetHeight;// Speed up the process by the height of that item.(Since the transform: translate(0, 100%) is set to)
      }else if(fadeInTargetClass.match(/up/)){// If the class name of the item to be fadein has up
        changingPositionPlus = fadeInTargetHeight;// Slow down the process by the height of that item.(Since the transform: translate(0, -100%) is set to)
      }
    }
    const targetScrollIn = fadeInTarget[i].dataset.scrollIn;
    if(targetScrollIn === 'fast'){
      changingPositionPlus = -fadeInTargetHeight;
    }
    if (scroll > offset - relativeHeight + changingPosition + changingPositionPlus) {// If the scroll volume exceeds
      addClassItem.classList.add('scroll-in');// Add scroll-in class
    }else if(removeClass){
      addClassItem.classList.remove('scroll-in');//Remove scroll-in class
    }
  }
}
export const callFadeIn = () =>{// Call the FadeIn function(Scroll to the specified position and fadein)
let fadeInScroll = document.querySelectorAll('[data-fade-in="scroll"]');
    fadeIn(fadeInScroll, 0, 1, 0, 0);
    window.addEventListener('scroll', () => {// If you scroll down...
      fadeIn(fadeInScroll, 0, 1, 0, 0);
    });
    window.addEventListener('resize', ()=>{//　If the window size change 
      fadeIn(fadeInScroll, 0, 1, 0, 0);// Reload the fadeIn function because the display area changes
    });
}
