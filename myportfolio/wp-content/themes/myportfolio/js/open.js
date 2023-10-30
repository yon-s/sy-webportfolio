import { backfaceFixed } from './backfaceFixed.js';
import { toBoolean } from './toBoolean.js';
//Things that open and close
export const openAndClose = (click, changeTxt, openTxt, closeTxt, change, closes) => {
  const expandedChange = () => {
    const ariaExpanded = !toBoolean(click.getAttribute('aria-expanded'));
    const ariaHidden = !toBoolean(change.getAttribute('aria-hidden'));
    change.classList.toggle('open');
    change.setAttribute('aria-hidden',ariaHidden);
    click.setAttribute('aria-expanded',ariaExpanded);
    backfaceFixed(ariaExpanded);
    if(openTxt){
      changeTxt.textContent = changeTxt&&ariaExpanded ? closeTxt : openTxt;
    }
  }
  //Reverse Dom aria-expanded with close function
  const closesAction = (close) => {
    const closeExpanded = !toBoolean(close.getAttribute('aria-expanded'));
    close.setAttribute('aria-expanded',closeExpanded);
  }

  //Determines if there is more than one element. If there is more than one, forEach
  const closesDoms = () =>{
    let closesDOM = [];
    if(closes){  
      if(typeof closes.length !== "undefined"){
        closes.forEach(function(close){
          closesDOM.push(close);
        });
      }else{
        closesDOM.push(closes);
      }
    }
    return closesDOM;    
  } 

  //Open button click event
  click.addEventListener('click', () => {
    expandedChange();
    let closesItems = closesDoms();
    closesItems.forEach(function(closesItem){
      closesAction(closesItem);
    });
  });

  //Close button click event
  let closesItems = closesDoms();
  closesItems.forEach(function(closesItem){
    closesItem.addEventListener('click',function(){
      closesItems.forEach(function(closesItem){
        closesAction(closesItem);
      });
      expandedChange();
    });
  });
}


