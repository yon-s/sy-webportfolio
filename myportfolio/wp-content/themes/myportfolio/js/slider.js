//アンエスケープ
function unescapeHTML(escapedHtml) {
  const doc = new DOMParser().parseFromString(escapedHtml, 'text/html');
  return doc.documentElement.textContent;
}
//slider
document.addEventListener("DOMContentLoaded", function(){
  const sliderBoxs = document.querySelectorAll('[data-slider-type]');//Data attributes with data-slider-type
  const sliderOuters = [].slice.call( sliderBoxs );//array the slider item 
  const sliderTypeChanges = document.querySelectorAll('[data-slider-type="change"]');
  const a = null;
  let sliderItems = null; let counters = [0]; sliderDomdate = null;
  function sliderSet(sliderOuter){//Get the DOM and information for each slider
    counterBox = sliderOuters.indexOf(sliderOuter);//slider count
    sliderOuterWidth = sliderOuter.clientWidth;//slider view widht
    sliderInner = sliderOuter.firstElementChild;//slider patent DOM
    sliderCount = sliderInner.childElementCount;//slider the number
    sliderList = sliderInner.firstElementChild; //slider item
    sliderListClass = document.querySelectorAll('.' + sliderList.classList.item(0));////slider item class name
    sliderListwidth = sliderList.clientWidth; //slider item width
    sliderListSumwidth = sliderListwidth*sliderCount  //slider item sum width
      prev = sliderOuter.children[1].firstElementChild;// slider prev btn
      next = prev.nextElementSibling;// slider next btn
      sliderOuterPrev =  sliderOuter.previousElementSibling;//slider prev DOM
      sliderItemBtnOuter = sliderOuterPrev.children[1];// slider icon or nav outer 保留
      sliderItems  = {thisCounter: counterBox, count: sliderCount, slider: sliderInner, sliderListClass: sliderListClass ,width: sliderListwidth, prev: prev, next: next, sliderIconNav: sliderItemBtnOuter,sliderListwidth:sliderListwidth};
      sliderViewCount = sliderOuterWidth / sliderListwidth;//Number of units visible without sliding
      if(!Number.isInteger(sliderViewCount)){
        sliderViewCount = Math.floor(sliderViewCount);
      }
    if(sliderOuterWidth < sliderListSumwidth){
      sliderOverhanging = sliderOuterWidth - sliderListSumwidth; //Number of sheets that are overflowing
      sliderOverhanging = Math.abs(sliderOverhanging);
      sliderOverhangingCount = sliderOverhanging / sliderListwidth;//はみ出ている枚数
      if(sliderOverhangingCount > 0 && sliderOverhangingCount < 1){
        sliderOverhangingCount = 1;
      }else if(!Number.isInteger(sliderOverhangingCount)){
        sliderOverhangingCount = Math.round(sliderOverhangingCount);
      }
      if(sliderItemBtnOuter.childElementCount > 0){
        sliderItemBtnClass = sliderOuterPrev.children[1].firstElementChild.classList.item(0);// slider icon or nav class name
        sliderItemBtns = document.querySelectorAll('.' + sliderItemBtnClass);
        sliderItems['navClassName'] = sliderItemBtnClass;// slider icons or navs
        sliderItems['sliderBtnlists'] = sliderItemBtns;// slider icons or navs
      }
    }else{
      sliderOverhangingCount = 0;
    }
      slidertextName = sliderOuterPrev.firstElementChild;//.sliderlist__name
      sliderItems ['text'] = slidertextName;//Where the image name of the slide is placed 
      sliderItems ['viewCount'] = sliderViewCount;//Number of visible images.
      sliderItems ['sliderListCount'] = sliderOverhangingCount;//Number of overflowed images
      return sliderItems;
  }
  function changeSlider(sliderType){//Navigation operation of the slider that changes the image
    changesliderSets = sliderSet(sliderType);//sliderSet関数で必要なデータ取得
    sliderOverCount = changesliderSets['sliderListCount'];//はみ出ている枚数
    sliderNextBtn = changesliderSets['next'];//次へボタン
    if(sliderOverCount > 0){//はみ出ていたら次へボタン表示
      sliderNextBtn.style.display = "block";
    }
  }
  function detailImgChange(imgDates, device) {//Change detail__img to an image for each device.
    const detailImgList = document.getElementById('detail-img-list');
      detailImg = detailImgList.firstElementChild;//.detail__img--
      if(imgDates){//画像があれば
        detailImg.setAttribute('class', 'detail__img--' + device);//classの後ろをデバイス名に変更
        detailImg.innerHTML = imgDates;//画像HTML書き換え
      }
  }
  function slide(slider, width, counter, viewCount){//スライドさせる関数(スライド, 一枚の横幅, クリック数, 一回に見せる枚数)
    slider.style.transform = "translateX("+ (- width * counter * viewCount + "px");
  }
  function slider(clickSliderBtn=false,detailDate,swipe=0,$deviceNames){//Slider movement when clicked
    sliderBtnClass = clickSliderBtn.className;
    if(sliderBtnClass.includes('item') && !swipe){//attach the item to the class for the icon.
      sliderOuter = clickSliderBtn.closest('#mockup-list-outer').nextElementSibling;
      sliderSets = sliderSet(sliderOuter);
      clickClass = clickSliderBtn.classList.item(0);
      clickClassItem = document.querySelectorAll('.' + clickClass);
      clickClassItems = [].slice.call( clickClassItem ) ;
      itemCounter = clickClassItems.indexOf(clickSliderBtn);//slider count
      counters[sliderSets['thisCounter']] = itemCounter;
    }else{
      sliderOuter = clickSliderBtn.closest('[data-slider-type]');
      sliderSets = sliderSet(sliderOuter);
    }
    if(sliderBtnClass.includes('next') || 0 > swipe){//attach the slider next btn to the class for the next.
      if(counters[sliderSets['thisCounter']] == sliderSets['sliderListCount'] ) return;
      counters[sliderSets['thisCounter']] ++;
    }
    if(sliderBtnClass.includes('before') || 0 < swipe){//attach the slider prev btn to the class for the before.
      if(counters[sliderSets['thisCounter']] == sliderSets['sliderListCount'] - sliderSets['sliderListCount']) return;
      counters[sliderSets['thisCounter']] --;
    }
    deviceName = $deviceNames[counters[0]]; 
    if(sliderSets['thisCounter'] === 0){
      detailImgChange(detailDate[counters[0]],deviceName);
      sliderTypeChanges.forEach(function(sliderTypeChange){
        changeSlider(sliderTypeChange);
      });
    }
    if(sliderItems == null) return;
    let width = sliderSets['width'];
      if(counters[sliderSets['thisCounter']] < sliderSets['sliderListCount']){
        sliderSets['next'].style.display = "block";
    }
    if(counters[sliderSets['thisCounter']] > sliderSets['sliderListCount'] - sliderSets['sliderListCount'] ){
      sliderSets['prev'].style.display = "block";
    }
    sliderSets['slider'].style.transition = ".3s";
    slide(sliderSets['slider'], width, counters[sliderSets['thisCounter']], sliderSets['viewCount']);
    for (let i = 0; i <= sliderSets['sliderListCount']; i++) {// change icon
      const activeIcon = sliderSets['sliderBtnlists'][i].firstElementChild;
      if(i === counters[sliderSets['thisCounter']]){
        activeIcon.classList.add('active');
      }else if(activeIcon.classList.contains('active')){
        activeIcon.classList.remove('active');
      }
    }
    sliderSets['slider'].addEventListener("transitionend", function(){
      if(counters[sliderSets['thisCounter']] == sliderSets['sliderListCount'] ||counters[sliderSets['thisCounter']] == sliderSets['sliderListCount'] - sliderSets['sliderListCount']){//最初と最後の場合
        sliderSets['slider'].style.transition = "none";
      }
      if(counters[sliderSets['thisCounter']] == sliderSets['sliderListCount'] ){//最後の場合
        sliderSets['next'].style.display = "none";
      }else if(counters[sliderSets['thisCounter']] == sliderSets['sliderListCount'] - sliderSets['sliderListCount']){//s
        sliderSets['prev'].style.display = "none";
      } 
    })
  }
  const  sliderbtn = document.querySelectorAll('.sliderbtn');
  const  swipeItems = document.querySelectorAll('[data-slider="swipe"]');
    if(typeof mockupChange !== "undefined")return;
      mockupChange = true;
    const data ={//phpから画像のHTMLタグが入った配列取得
      ajaxurl: my_ajax_date.ajax_url,
      action: my_ajax_date.action,
      _nonce: my_ajax_date.nonce, 
      post_id: my_ajax_date.post_id, 
    };
     if(window.fetch){
      let params = new URLSearchParams();
      params.append("action", data.action);
      params.append("_nonce", data._nonce);
      params.append("post_id", data.post_id);
      fetch(data.ajaxurl,{ 
        method:'POST',
        credentials:"same-origin",
        body:params
      }).then(function(response){
        if (response.ok) {
          response.json().then(function(detailmgDates){
            detailmgDates = Object.entries(detailmgDates);//オブジェクト→配列型
            $deviceNames = detailmgDates.map(row => row[0]);//デバイス名の配列
            detailmgDates = detailmgDates.map(row => row[1]);
            detailmgDates.forEach((detailmgDate,index)=>{
              detailmgDates[index] = unescapeHTML(detailmgDate);
            })
            sliderBoxs.forEach(function(sliderBox){
              changeSlider(sliderBox);
              window.addEventListener('resize', function(){//ウィンドウサイズ変更されたらスライドする数値変更
                sliderSets = sliderSet(sliderBox);
                slide(sliderSets['slider'], sliderSets['width'], counters[sliderSets['thisCounter']], sliderSets['viewCount']);
              });
            });
            sliderbtn.forEach(function(sliderbtn){
              sliderbtn.addEventListener('click',function(){//クリックしたらスライド
                slider(sliderbtn,detailmgDates,0,$deviceNames);
              });
            });
            //スマホ対応
            let startX = null;
            let endX = null;
            swipeItems.forEach(function(swipeItem){
              // スワイプ／フリック
              swipeItem.addEventListener('touchmove', logSwipe,supportsPassive?{passive:true}:false);
              // タッチ開始
              swipeItem.addEventListener('touchstart', logSwipeStart,supportsPassive?{passive:true}:false);
              // タッチ終了
              swipeItem.addEventListener('touchend', logSwipeEnd,supportsPassive?{passive:true}:false);
            });
            function logSwipeStart(event) {//スタートの横軸取得
              startX = event.touches[0].pageX;
            }
            function logSwipe(event) {//スワイプ終わったら終わりの横軸取得
              endX = event.touches[0].pageX;
            }
            function logSwipeEnd(event) {
              let sliderbtn = null;
              if(endX !== null){ //スワイプだったら
                let swipe = endX - startX;//移動範囲
                if(Math.sign(swipe) === -1) sliderbtn = document.getElementById('mockup-next');
                else if(Math.sign(swipe) === 1) sliderbtn = document.getElementById('mockup-prev');
                slider(sliderbtn,detailmgDates,swipe,$deviceNames);
              }
            }
          });
        }
      }, function(error){
      });
    }else {
        alert('ご使用のブラウザはサポートしていません。Chrome, firefox, Edge等の最新版のブラウザをご使用下さい');
    }
}, false);
  //end slider
 