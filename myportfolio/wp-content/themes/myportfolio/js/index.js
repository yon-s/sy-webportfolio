import {openAndClose} from './open.js'
import { toBoolean } from './toBoolean.js';
import { fadeInAdd, fadeIn, callFadeIn } from './fadeIn.js';


//scroll fadein
  //Elements to fade in
  const FadeInItem = document.querySelectorAll(['.work__list-item','.seo__item','.about__img','.about__info','.skill__ttl','.skill__list-outer','#skill__ttl-study','.skill__study-list-item','#contact__progress-outer', '#contact__form-bg']);
  //Elements fading in from the left
  const FadeInItemLeft = ['.work__list-item','.about__img','.skill__section:nth-child(odd) .skill__list-outer'];
  //Elements fading in from the right
  const FadeInItemRight = ['.about__info','.skill__section:nth-child(even) .skill__list-outer','.skill__study-list-item','#contact__progress-outer'];
  //Elements fading in from the bottom
  const FadeInItemDown = ['.seo__item','#skill__ttl-study'];
  //Elements fading in from the top
  const FadeInItemUp = ['.skill__ttl','#contact__form-bg'];

  fadeInAdd(FadeInItem, FadeInItemLeft, FadeInItemRight, FadeInItemDown, FadeInItemUp);
  
  callFadeIn();
//end scroll fadein 

//Show Hide Privacy Policy
  const privacyOpen = document.getElementById('privacy-open');
  const privacy = document.getElementById('privacy');
  const privacyClose = document.getElementById('privacy__close');
  openAndClose(privacyOpen, 0, 0, 0, privacy, privacyClose);
  const privacyInner = document.getElementsByClassName('privacy__inner')[0];
  const privacyCloseOuter = document.getElementsByClassName('privacy__close-outer')[0];
  privacy.addEventListener('scroll', function(){
    fadeIn(privacyInner, privacy, 0, privacyCloseOuter, 1)  
  });
  
//end Show Hide Privacy Policy

// Clicking on a production category switches the contents displayed.
  const workCatItems = document.getElementsByClassName('work__cat-item');
  const workLists = document.getElementsByClassName('work__list');
  function workCatItemwitch(){
    // Change the aria-expanded value of the tab
    for( let i = 0 ; i < workCatItems.length ; i ++ ){
      const workCatItemExpanded = toBoolean(workCatItems[i].getAttribute('aria-expanded'));
      if(workCatItemExpanded){
        workCatItems[i].setAttribute('aria-expanded',!workCatItemExpanded);
      }
    }
    this.setAttribute('aria-expanded','true');
    // Change the value of aria-hidden for hidden content
    for( let i = 0 ; i <workLists.length ; i ++ ){
      const workItemExpanded = toBoolean(workLists[i].getAttribute('aria-hidden'));
      if(!workItemExpanded){
        workLists[i].setAttribute('aria-hidden',!workItemExpanded);
      }
    }
    const arrayworkCatItem = Array.prototype.slice.call(workCatItems);
    const index = arrayworkCatItem.indexOf(this);
    workLists[index].setAttribute('aria-hidden','flase');
    //Set slower than css transitions.
    setTimeout(() => {
      callFadeIn();
    }, 600);
    
  }  
  for(let i = 0; i < workCatItems.length; i++) {
  workCatItems[i].addEventListener('click', workCatItemwitch, false);
  }
//end Clicking on a production category switches the contents displayed.
