import * as THREE from 'three';
const palettes={news:[0xb9975b,0x272018],events:[0x9b7440,0x171310],admission:[0xc9ad78,0x34271c],gallery:[0x8e6d45,0x201b18],collectives:[0xb38a4d,0x2c2117],competitions:[0xc3a063,0x241a13]};
export function mountSectionArt(){
 document.querySelectorAll('[data-section-art]').forEach(host=>{
  if(matchMedia('(prefers-reduced-motion: reduce)').matches)return;
  const key=host.closest('[data-art-variant]')?.dataset.artVariant||'news',p=palettes[key]||palettes.news;
  const renderer=new THREE.WebGLRenderer({alpha:true,antialias:devicePixelRatio<2});renderer.setPixelRatio(Math.min(devicePixelRatio,1.4));host.appendChild(renderer.domElement);
  const scene=new THREE.Scene(),camera=new THREE.PerspectiveCamera(38,1,.1,50);camera.position.z=6;const g=new THREE.Group();scene.add(g);
  const brass=new THREE.MeshStandardMaterial({color:p[0],metalness:.7,roughness:.28}),wood=new THREE.MeshStandardMaterial({color:p[1],metalness:.08,roughness:.72});
  const count=key==='gallery'?7:5;
  for(let i=0;i<count;i++){let mesh;if(key==='events'||key==='competitions')mesh=new THREE.Mesh(new THREE.TorusKnotGeometry(.7+i*.07,.035,90,10,2+i%2,3),i%2?wood:brass);else if(key==='gallery')mesh=new THREE.Mesh(new THREE.BoxGeometry(1.8-i*.12,1.15-i*.07,.035),i%2?wood:brass);else mesh=new THREE.Mesh(new THREE.TorusGeometry(.8+i*.2,.025+i*.006,10,90),i%2?wood:brass);mesh.rotation.set(i*.37,i*.49,i*.13);g.add(mesh)}
  scene.add(new THREE.AmbientLight(0xffffff,2.2));const dl=new THREE.DirectionalLight(0xffdba5,5);dl.position.set(4,3,5);scene.add(dl);
  const resize=()=>{const w=host.clientWidth,h=host.clientHeight;renderer.setSize(w,h,false);camera.aspect=w/h;camera.updateProjectionMatrix()};resize();new ResizeObserver(resize).observe(host);
  let x=0,y=0;host.parentElement.addEventListener('pointermove',e=>{const r=host.getBoundingClientRect();x=(e.clientX-r.left)/r.width-.5;y=(e.clientY-r.top)/r.height-.5});
  const draw=()=>{g.rotation.y+=.002;g.rotation.x+=(y*.25-g.rotation.x)*.02;g.rotation.z+=(x*.18-g.rotation.z)*.02;renderer.render(scene,camera);requestAnimationFrame(draw)};draw();
 });
}