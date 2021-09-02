const paralex=document.getElementById('paralex');
const pdf=document.getElementById('pdf');
const oldstate= parseInt('-1'+$('#paralex').css('background-position-y'));
const oldstateforbottom=parseInt('-1'+$('#pdf').css('background-position-y'))

window.addEventListener("scroll",function(){
    let y=window.pageYOffset;
   paralex.style.backgroundPositionY=(oldstate+(y*0.5))+"px";
  // paralex.style.backgroundPositionY=(20+(y*0.6))+"%";
  // pdf.style.backgroundPositionY=(y*0.6)+"px";
});



