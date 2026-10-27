import * as THREE from 'three';
import { STLLoader } from 'three/addons/loaders/STLLoader.js';

export function mountPageArt(){
 const host=document.querySelector('[data-page-art]');
 if(!host||matchMedia('(prefers-reduced-motion: reduce)').matches||navigator.connection?.saveData)return;
 const renderer=new THREE.WebGLRenderer({alpha:true,antialias:devicePixelRatio<2});renderer.setPixelRatio(Math.min(devicePixelRatio,1.5));host.appendChild(renderer.domElement);
 const scene=new THREE.Scene(),camera=new THREE.PerspectiveCamera(42,1,.1,100);camera.position.z=6;const group=new THREE.Group();scene.add(group);
 const brass=new THREE.MeshBasicMaterial({color:0xd9b36c,wireframe:true,transparent:true,opacity:.58,blending:THREE.AdditiveBlending,depthWrite:false}),dark=new THREE.MeshBasicMaterial({color:0x8d6b3f,wireframe:true,transparent:true,opacity:.24,blending:THREE.AdditiveBlending,depthWrite:false});
 const seed=parseInt(host.dataset.pageId||'1',10)||1,variant=seed%7;
 const add=(geo,mat=brass,pos=[0,0,0],rot=[0,0,0])=>{const wrap=new THREE.Group(),glow=new THREE.Mesh(geo,new THREE.MeshBasicMaterial({color:0xe7c785,wireframe:true,transparent:true,opacity:.10,blending:THREE.AdditiveBlending,depthWrite:false})),m=new THREE.Mesh(geo,mat);glow.scale.setScalar(1.018);wrap.add(glow,m);wrap.position.set(...pos);wrap.rotation.set(...rot);group.add(wrap);return wrap};
 const fallback=()=>{
  if(variant===0){for(let i=0;i<6;i++)add(new THREE.TorusGeometry(.55+i*.19,.025+i*.004,10,80),i%2?dark:brass,[0,0,-i*.08],[.65+i*.13,i*.41,.15*i])}
  else if(variant===1){for(let i=0;i<5;i++)add(new THREE.BoxGeometry(1.65-i*.13,1.05-i*.08,.04),i%2?dark:brass,[0,0,-i*.2],[i*.1,i*.17,i*.08])}
  else if(variant===2){add(new THREE.TorusKnotGeometry(1,.075,120,14,2,3));add(new THREE.TorusGeometry(1.45,.025,10,90),dark,[0,0,-.2],[1,.2,.4])}
  else if(variant===3){for(let i=0;i<5;i++)add(new THREE.BoxGeometry(2.5,.04,.04),i%2?dark:brass,[0,.6-i*.3,0]);for(let i=0;i<4;i++)add(new THREE.SphereGeometry(.15,18,12),brass,[-.8+i*.55,.45-i*.25,.12])}
  else if(variant===4){add(new THREE.IcosahedronGeometry(.9,1),brass);for(let i=0;i<3;i++)add(new THREE.TorusGeometry(1.25+i*.22,.022,10,90),i%2?dark:brass,[0,0,-.1*i],[i*.7,.4*i,.2*i])}
  else if(variant===5){for(let i=0;i<7;i++)add(new THREE.CylinderGeometry(.035,.035,2.6-i*.18,10),i%2?dark:brass,[-.72+i*.24,0,(i%2)*.15],[0,0,.22-i*.07])}
  else {add(new THREE.SphereGeometry(.48,24,16),brass);for(let i=0;i<5;i++)add(new THREE.TorusGeometry(.75+i*.18,.025,10,80),i%2?dark:brass,[0,0,-i*.12],[i*.4,i*.31,i*.18])}
 };
 const stl=host.dataset.stl;
 if(stl){new STLLoader().load(stl,geo=>{geo.computeBoundingBox();geo.center();const size=new THREE.Vector3();geo.boundingBox?.getSize(size);const max=Math.max(size.x,size.y,size.z)||1;const mesh=add(geo,brass);mesh.scale.setScalar(3/max);mesh.rotation.set(-.25,.35,.08)},undefined,()=>fallback())}else fallback();
 scene.add(new THREE.AmbientLight(0xffffff,2));const light=new THREE.DirectionalLight(0xffe0ad,5);light.position.set(3,4,5);scene.add(light);
 const resize=()=>{const w=host.clientWidth,h=host.clientHeight;renderer.setSize(w,h,false);camera.aspect=w/h;camera.updateProjectionMatrix()};resize();new ResizeObserver(resize).observe(host);
 let mx=0,my=0;host.addEventListener('pointermove',e=>{const b=host.getBoundingClientRect();mx=(e.clientX-b.left)/b.width-.5;my=(e.clientY-b.top)/b.height-.5});
 let frame;const tick=()=>{group.rotation.y+=.0025;group.rotation.x+=(my*.2-group.rotation.x)*.025;group.rotation.z+=(mx*.15-group.rotation.z)*.025;renderer.render(scene,camera);frame=requestAnimationFrame(tick)};tick();
 document.addEventListener('visibilitychange',()=>{if(document.hidden)cancelAnimationFrame(frame);else tick()});
}