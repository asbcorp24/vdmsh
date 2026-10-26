import * as THREE from 'three';

export function mountPageArt(){
 const host=document.querySelector('[data-page-art]');
 if(!host||window.matchMedia('(prefers-reduced-motion: reduce)').matches)return;
 const renderer=new THREE.WebGLRenderer({alpha:true,antialias:window.devicePixelRatio<2});
 renderer.setPixelRatio(Math.min(window.devicePixelRatio,1.5));host.appendChild(renderer.domElement);
 const scene=new THREE.Scene(),camera=new THREE.PerspectiveCamera(42,1,.1,100);camera.position.z=6;
 const group=new THREE.Group();scene.add(group);
 const mat=new THREE.MeshStandardMaterial({color:0xb9975b,metalness:.55,roughness:.35});
 const dark=new THREE.MeshStandardMaterial({color:0x211a14,metalness:.2,roughness:.6});
 for(let i=0;i<5;i++){const ring=new THREE.Mesh(new THREE.TorusGeometry(1.15+i*.22,.018+i*.005,10,80),i%2?dark:mat);ring.rotation.x=.8+i*.19;ring.rotation.y=i*.46;group.add(ring);}
 const core=new THREE.Mesh(new THREE.IcosahedronGeometry(.72,1),new THREE.MeshPhysicalMaterial({color:0xe9ddc5,roughness:.25,metalness:.15,transmission:.15}));group.add(core);
 scene.add(new THREE.AmbientLight(0xffffff,2));const light=new THREE.DirectionalLight(0xffe0ad,5);light.position.set(3,4,5);scene.add(light);
 const resize=()=>{const w=host.clientWidth,h=host.clientHeight;renderer.setSize(w,h,false);camera.aspect=w/h;camera.updateProjectionMatrix()};resize();new ResizeObserver(resize).observe(host);
 let mx=0,my=0;host.addEventListener('pointermove',e=>{const r=host.getBoundingClientRect();mx=(e.clientX-r.left)/r.width-.5;my=(e.clientY-r.top)/r.height-.5});
 let frame;const tick=()=>{group.rotation.y+=.0025;group.rotation.x+=(my*.2-group.rotation.x)*.025;group.rotation.z+=(mx*.15-group.rotation.z)*.025;renderer.render(scene,camera);frame=requestAnimationFrame(tick)};tick();
 document.addEventListener('visibilitychange',()=>{if(document.hidden)cancelAnimationFrame(frame);else tick()});
}
