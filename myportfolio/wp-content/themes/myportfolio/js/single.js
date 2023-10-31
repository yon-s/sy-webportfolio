import { fadeInAdd, callFadeIn } from './fadeIn.js';
//scroll fadein
  //Elements to fade in
  const FadeInItem = document.querySelectorAll(['#info', '.detail__ttl-group', '.detail__work-outer', '.work__list-item']);
  //Elements fading in from the left
  const FadeInItemLeft = ['.detail__box:nth-child(even) .detail__work-outer', '.work__list-item'];
  //Elements fading in from the right
  const FadeInItemRight = ['.about__info','.detail__box:nth-child(odd) .detail__work-outer'];
  //Elements fading in from the bottom
  const FadeInItemDown = ['#info'];
  //Elements fading in from the top
  const FadeInItemUp = ['.detail__ttl-group'];
  //Items that fade quickly
  const FadeInHalfFast = document.querySelectorAll([ '.detail__ttl-group','.detail__box:first-child .detail__work-outer']);
  const FadeInFast = document.querySelectorAll([ '.detail__box:nth-child(2) .detail__work-outer']);

  fadeInAdd(FadeInItem, FadeInItemLeft, FadeInItemRight, FadeInItemDown, FadeInItemUp,FadeInFast,FadeInHalfFast);
  
  callFadeIn();
//end scroll fadein 
//スマホで画像ズーム
const zoomImgs = document.querySelectorAll('[data-img-type="zoom"]');
zoomImgs.forEach(function(zoomImg){
  zoomImg.addEventListener('click',function(){
    zoomImg.classList.toggle('zoom');
  });
});
