$(document).ready(function(){$(".no-display").slice(0,6).show();$("#loadMore").on('click',function(e){e.preventDefault();$(".no-display:hidden").slice(0,3).slideDown();if($(".no-display:hidden").length==0){$("#loadMore").fadeOut('slow');}});$(".no-show").slice(0,4).show();$("#showMore").on('click',function(e){e.preventDefault();$(".no-show:hidden").slice(0,4).slideDown();if($(".no-show:hidden").length==0){$("#showMore").fadeOut('slow');}});$('.banner-carousel').owlCarousel({loop:true,margin:10,nav:true,dots:false,responsive:{0:{items:1},600:{items:1,},1000:{items:1}}});var words=document.getElementsByClassName('word');var wordArray=[];var currentWord=0;words[currentWord].style.opacity=1;for(var i=0;i<words.length;i++){splitLetters(words[i]);}
function changeWord(){var cw=wordArray[currentWord];var nw=currentWord==words.length-1?wordArray[0]:wordArray[currentWord+1];for(var i=0;i<cw.length;i++){animateLetterOut(cw,i);}
for(var i=0;i<nw.length;i++){nw[i].className='letter behind';nw[0].parentElement.style.opacity=1;animateLetterIn(nw,i);}
currentWord=(currentWord==wordArray.length-1)?0:currentWord+1;}
function animateLetterOut(cw,i){setTimeout(function(){cw[i].className='letter out';},i*80);}
function animateLetterIn(nw,i){setTimeout(function(){nw[i].className='letter in';},340+(i*80));}
function splitLetters(word){var content=word.innerHTML;word.innerHTML='';var letters=[];for(var i=0;i<content.length;i++){var letter=document.createElement('span');letter.className='letter';letter.innerHTML=content.charAt(i);word.appendChild(letter);letters.push(letter);}
wordArray.push(letters);}
changeWord();setInterval(changeWord,4000);const PI2=Math.PI*2
const random=(min,max)=>Math.random()*(max-min+1)+min|0
const timestamp=_=>new Date().getTime()
class Birthday{constructor(){this.resize()
this.fireworks=[]
this.counter=0}
resize(){this.width=canvas.width=window.innerWidth
let center=this.width/2|0
this.spawnA=center-center/4|0
this.spawnB=center+center/4|0
this.height=canvas.height=window.innerHeight
this.spawnC=this.height*.1
this.spawnD=this.height*.5}
onClick(evt){let x=evt.clientX||evt.touches&&evt.touches[0].pageX
let y=evt.clientY||evt.touches&&evt.touches[0].pageY
let count=random(3,5)
for(let i=0;i<count;i++)this.fireworks.push(new Firework(random(this.spawnA,this.spawnB),this.height,x,y,random(0,260),random(30,110)))
this.counter=-1}
update(delta){ctx.globalCompositeOperation='hard-light'
ctx.fillStyle=`rgba(20,20,20,${ 7 * delta })`
ctx.fillRect(0,0,this.width,this.height)
ctx.globalCompositeOperation='lighter'
for(let firework of this.fireworks)firework.update(delta)
this.counter+=delta*3
if(this.counter>=1){this.fireworks.push(new Firework(random(this.spawnA,this.spawnB),this.height,random(0,this.width),random(this.spawnC,this.spawnD),random(0,360),random(30,110)))
this.counter=0}
if(this.fireworks.length>1000)this.fireworks=this.fireworks.filter(firework=>!firework.dead)}}
class Firework{constructor(x,y,targetX,targetY,shade,offsprings){this.dead=false
this.offsprings=offsprings
this.x=x
this.y=y
this.targetX=targetX
this.targetY=targetY
this.shade=shade
this.history=[]}
update(delta){if(this.dead)return
let xDiff=this.targetX-this.x
let yDiff=this.targetY-this.y
if(Math.abs(xDiff)>3||Math.abs(yDiff)>3){this.x+=xDiff*2*delta
this.y+=yDiff*2*delta
this.history.push({x:this.x,y:this.y})
if(this.history.length>20)this.history.shift()}else{if(this.offsprings&&!this.madeChilds){let babies=this.offsprings/2
for(let i=0;i<babies;i++){let targetX=this.x+this.offsprings*Math.cos(PI2*i/babies)|0
let targetY=this.y+this.offsprings*Math.sin(PI2*i/babies)|0
birthday.fireworks.push(new Firework(this.x,this.y,targetX,targetY,this.shade,0))}}
this.madeChilds=true
this.history.shift()}
if(this.history.length===0)this.dead=true
else if(this.offsprings){for(let i=0;this.history.length>i;i++){let point=this.history[i]
ctx.beginPath()
ctx.fillStyle='hsl('+this.shade+',100%,'+i+'%)'
ctx.arc(point.x,point.y,1,0,PI2,false)
ctx.fill()}}else{ctx.beginPath()
ctx.fillStyle='hsl('+this.shade+',100%,50%)'
ctx.arc(this.x,this.y,1,0,PI2,false)
ctx.fill()}}}
let canvas=document.getElementById('birthday')
let ctx=canvas.getContext('2d')
let then=timestamp()
let birthday=new Birthday
window.onresize=()=>birthday.resize()
document.onclick=evt=>birthday.onClick(evt)
document.ontouchstart=evt=>birthday.onClick(evt);(function loop(){requestAnimationFrame(loop)
let now=timestamp()
let delta=now-then
then=now
birthday.update(delta/1000)})()});function openTab(evt,cityName){var i,tabcontent,tablinks;tabcontent=document.getElementsByClassName("tabcontent");for(i=0;i<tabcontent.length;i++){tabcontent[i].style.display="none";}
tablinks=document.getElementsByClassName("tablinks");for(i=0;i<tablinks.length;i++){tablinks[i].className=tablinks[i].className.replace(" active","");}
document.getElementById(cityName).style.display="block";document.getElementById(cityName).classList.add("active")}