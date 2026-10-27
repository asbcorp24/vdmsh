import * as THREE from './three.module.min.js';
const palettes={news:[0xb9975b,0x272018],events:[0xc49a58,0x171310],admission:[0xc9ad78,0x34271c],gallery:[0x8e6d45,0x201b18],collectives:[0xb38a4d,0x2c2117],competitions:[0xc3a063,0x241a13],education:[0xc4a263,0x241b14],teachers:[0xb88d50,0x1f1914],documents:[0xb9975b,0x29221b],contacts:[0xc4a263,0x241c15],schedule:[0xb88d50,0x211a14],programs:[0xc6a568,0x241b14]};
export function mountSectionArt(){
 document.querySelectorAll('[data-section-art]').forEach(host=>{
  if(matchMedia('(prefers-reduced-motion: reduce)').matches||navigator.connection?.saveData)return;
  const key=host.closest('[data-art-variant]')?.dataset.artVariant||host.dataset.sectionArt||'news',p=palettes[key]||palettes.news;
  const renderer=new THREE.WebGLRenderer({alpha:true,antialias:devicePixelRatio<2});renderer.setPixelRatio(Math.min(devicePixelRatio,1.4));host.appendChild(renderer.domElement);
  const scene=new THREE.Scene(),camera=new THREE.PerspectiveCamera(38,1,.1,50);camera.position.z=6;const g=new THREE.Group();scene.add(g);
  const brass=new THREE.MeshBasicMaterial({color:p[0],wireframe:true,transparent:true,opacity:.52,blending:THREE.AdditiveBlending,depthWrite:false}),wood=new THREE.MeshBasicMaterial({color:p[0],wireframe:true,transparent:true,opacity:.18,blending:THREE.AdditiveBlending,depthWrite:false});
  const add=(geo,mat=brass,pos=[0,0,0],rot=[0,0,0])=>{const wrap=new THREE.Group(),glow=new THREE.Mesh(geo,new THREE.MeshBasicMaterial({color:p[0],wireframe:true,transparent:true,opacity:.09,blending:THREE.AdditiveBlending,depthWrite:false})),m=new THREE.Mesh(geo,mat);glow.scale.setScalar(1.02);wrap.add(glow,m);wrap.position.set(...pos);wrap.rotation.set(...rot);g.add(wrap);return wrap};
  if(key==='gallery'){for(let i=0;i<5;i++)add(new THREE.BoxGeometry(2-i*.22,1.25-i*.12,.045),i%2?wood:brass,[0,0,-i*.18],[.08*i,.18*i,.08*i])}
  else if(key==='events'||key==='competitions'){add(new THREE.TorusKnotGeometry(1.05,.08,120,14,2,3));add(new THREE.TorusGeometry(1.55,.025,10,100),wood,[0,0,-.2],[1.1,.2,.3])}
  else if(key==='teachers'){add(new THREE.CylinderGeometry(.05,.05,3.3,16),brass);add(new THREE.TorusGeometry(.75,.06,12,80),brass,[0,1.1,0],[0,0,0]);add(new THREE.TorusGeometry(.75,.06,12,80),brass,[0,-1.1,0],[0,0,0])}
  else if(key==='documents'||key==='news'){for(let i=0;i<5;i++)add(new THREE.BoxGeometry(1.8,2.35,.035),i%2?wood:brass,[i*.16-.32,i*.1-.2,-i*.18],[.08*i,.12*i,-.08+i*.035])}
  else if(key==='contacts'){add(new THREE.TorusGeometry(1,.18,18,80),brass,[0,.35,0],[0,0,0]);add(new THREE.ConeGeometry(.62,1.7,32),brass,[0,-.85,0],[0,0,Math.PI]);add(new THREE.SphereGeometry(.32,24,16),wood,[0,.35,.18])}
  else if(key==='schedule'){for(let i=0;i<5;i++)add(new THREE.BoxGeometry(2.5,.055,.055),i%2?wood:brass,[0,.6-i*.3,0]);for(let i=0;i<4;i++){add(new THREE.SphereGeometry(.16,18,12),brass,[-.8+i*.55,.45-i*.25,.1]);add(new THREE.CylinderGeometry(.025,.025,.65,10),brass,[-.65+i*.55,.7-i*.25,.1],[0,0,-.1])}}
  else if(key==='education'||key==='programs'||key==='admission'){for(let i=0;i<5;i++)add(new THREE.TorusGeometry(.65+i*.18,.025,10,80),i%2?wood:brass,[0,0,-i*.12],[.85+i*.12,.2*i,.15*i]);add(new THREE.SphereGeometry(.38,24,16),brass)}
  else {for(let i=0;i<5;i++)add(new THREE.TorusGeometry(.8+i*.2,.025+i*.006,10,90),i%2?wood:brass,[0,0,-i*.1],[i*.37,i*.49,i*.13])}
  scene.add(new THREE.AmbientLight(0xffffff,2.2));const dl=new THREE.DirectionalLight(0xffdba5,5);dl.position.set(4,3,5);scene.add(dl);
  const resize=()=>{const w=host.clientWidth,h=host.clientHeight;renderer.setSize(w,h,false);camera.aspect=w/h;camera.updateProjectionMatrix()};resize();new ResizeObserver(resize).observe(host);
  let x=0,y=0;host.parentElement?.addEventListener('pointermove',e=>{const b=host.getBoundingClientRect();x=(e.clientX-b.left)/b.width-.5;y=(e.clientY-b.top)/b.height-.5});
  const draw=()=>{g.rotation.y+=.002;g.rotation.x+=(y*.22-g.rotation.x)*.02;g.rotation.z+=(x*.16-g.rotation.z)*.02;renderer.render(scene,camera);requestAnimationFrame(draw)};draw();
 });
}