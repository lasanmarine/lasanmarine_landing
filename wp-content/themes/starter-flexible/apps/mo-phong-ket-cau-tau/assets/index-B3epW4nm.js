(function(){const t=document.createElement("link").relList;if(t&&t.supports&&t.supports("modulepreload"))return;for(const s of document.querySelectorAll('link[rel="modulepreload"]'))n(s);new MutationObserver(s=>{for(const r of s)if(r.type==="childList")for(const o of r.addedNodes)o.tagName==="LINK"&&o.rel==="modulepreload"&&n(o)}).observe(document,{childList:!0,subtree:!0});function e(s){const r={};return s.integrity&&(r.integrity=s.integrity),s.referrerPolicy&&(r.referrerPolicy=s.referrerPolicy),s.crossOrigin==="use-credentials"?r.credentials="include":s.crossOrigin==="anonymous"?r.credentials="omit":r.credentials="same-origin",r}function n(s){if(s.ep)return;s.ep=!0;const r=e(s);fetch(s.href,r)}})();/**
 * @license
 * Copyright 2010-2024 Three.js Authors
 * SPDX-License-Identifier: MIT
 */const xa="169",Ni={ROTATE:0,DOLLY:1,PAN:2},Li={ROTATE:0,PAN:1,DOLLY_PAN:2,DOLLY_ROTATE:3},Nh=0,Za=1,kh=2,El=1,Fh=2,vn=3,Bn=0,Re=1,qe=2,Fn=0,ki=1,ja=2,Ja=3,Qa=4,Oh=5,ti=100,Bh=101,zh=102,Hh=103,Vh=104,Gh=200,Wh=201,Xh=202,$h=203,So=204,bo=205,qh=206,Yh=207,Kh=208,Zh=209,jh=210,Jh=211,Qh=212,tu=213,eu=214,Eo=0,To=1,wo=2,Hi=3,Ao=4,Co=5,Ro=6,Po=7,Tl=0,nu=1,iu=2,On=0,su=1,ru=2,ou=3,wl=4,au=5,cu=6,lu=7,Al=300,Vi=301,Gi=302,Lo=303,Do=304,yr=306,Io=1e3,ni=1001,Uo=1002,Ke=1003,hu=1004,ws=1005,nn=1006,Ir=1007,ii=1008,bn=1009,Cl=1010,Rl=1011,gs=1012,ya=1013,ri=1014,xn=1015,Ss=1016,Ma=1017,Sa=1018,Wi=1020,Pl=35902,Ll=1021,Dl=1022,sn=1023,Il=1024,Ul=1025,Fi=1026,Xi=1027,Nl=1028,ba=1029,kl=1030,Ea=1031,Ta=1033,sr=33776,rr=33777,or=33778,ar=33779,No=35840,ko=35841,Fo=35842,Oo=35843,Bo=36196,zo=37492,Ho=37496,Vo=37808,Go=37809,Wo=37810,Xo=37811,$o=37812,qo=37813,Yo=37814,Ko=37815,Zo=37816,jo=37817,Jo=37818,Qo=37819,ta=37820,ea=37821,cr=36492,na=36494,ia=36495,Fl=36283,sa=36284,ra=36285,oa=36286,uu=3200,du=3201,Ol=0,fu=1,In="",cn="srgb",Xn="srgb-linear",wa="display-p3",Mr="display-p3-linear",ur="linear",le="srgb",dr="rec709",fr="p3",fi=7680,tc=519,pu=512,mu=513,gu=514,Bl=515,_u=516,vu=517,xu=518,yu=519,ec=35044,nc="300 es",yn=2e3,pr=2001;class hi{addEventListener(t,e){this._listeners===void 0&&(this._listeners={});const n=this._listeners;n[t]===void 0&&(n[t]=[]),n[t].indexOf(e)===-1&&n[t].push(e)}hasEventListener(t,e){if(this._listeners===void 0)return!1;const n=this._listeners;return n[t]!==void 0&&n[t].indexOf(e)!==-1}removeEventListener(t,e){if(this._listeners===void 0)return;const s=this._listeners[t];if(s!==void 0){const r=s.indexOf(e);r!==-1&&s.splice(r,1)}}dispatchEvent(t){if(this._listeners===void 0)return;const n=this._listeners[t.type];if(n!==void 0){t.target=this;const s=n.slice(0);for(let r=0,o=s.length;r<o;r++)s[r].call(this,t);t.target=null}}}const Ee=["00","01","02","03","04","05","06","07","08","09","0a","0b","0c","0d","0e","0f","10","11","12","13","14","15","16","17","18","19","1a","1b","1c","1d","1e","1f","20","21","22","23","24","25","26","27","28","29","2a","2b","2c","2d","2e","2f","30","31","32","33","34","35","36","37","38","39","3a","3b","3c","3d","3e","3f","40","41","42","43","44","45","46","47","48","49","4a","4b","4c","4d","4e","4f","50","51","52","53","54","55","56","57","58","59","5a","5b","5c","5d","5e","5f","60","61","62","63","64","65","66","67","68","69","6a","6b","6c","6d","6e","6f","70","71","72","73","74","75","76","77","78","79","7a","7b","7c","7d","7e","7f","80","81","82","83","84","85","86","87","88","89","8a","8b","8c","8d","8e","8f","90","91","92","93","94","95","96","97","98","99","9a","9b","9c","9d","9e","9f","a0","a1","a2","a3","a4","a5","a6","a7","a8","a9","aa","ab","ac","ad","ae","af","b0","b1","b2","b3","b4","b5","b6","b7","b8","b9","ba","bb","bc","bd","be","bf","c0","c1","c2","c3","c4","c5","c6","c7","c8","c9","ca","cb","cc","cd","ce","cf","d0","d1","d2","d3","d4","d5","d6","d7","d8","d9","da","db","dc","dd","de","df","e0","e1","e2","e3","e4","e5","e6","e7","e8","e9","ea","eb","ec","ed","ee","ef","f0","f1","f2","f3","f4","f5","f6","f7","f8","f9","fa","fb","fc","fd","fe","ff"];let ic=1234567;const Oi=Math.PI/180,_s=180/Math.PI;function ui(){const i=Math.random()*4294967295|0,t=Math.random()*4294967295|0,e=Math.random()*4294967295|0,n=Math.random()*4294967295|0;return(Ee[i&255]+Ee[i>>8&255]+Ee[i>>16&255]+Ee[i>>24&255]+"-"+Ee[t&255]+Ee[t>>8&255]+"-"+Ee[t>>16&15|64]+Ee[t>>24&255]+"-"+Ee[e&63|128]+Ee[e>>8&255]+"-"+Ee[e>>16&255]+Ee[e>>24&255]+Ee[n&255]+Ee[n>>8&255]+Ee[n>>16&255]+Ee[n>>24&255]).toLowerCase()}function ye(i,t,e){return Math.max(t,Math.min(e,i))}function Aa(i,t){return(i%t+t)%t}function Mu(i,t,e,n,s){return n+(i-t)*(s-n)/(e-t)}function Su(i,t,e){return i!==t?(e-i)/(t-i):0}function ls(i,t,e){return(1-e)*i+e*t}function bu(i,t,e,n){return ls(i,t,1-Math.exp(-e*n))}function Eu(i,t=1){return t-Math.abs(Aa(i,t*2)-t)}function Tu(i,t,e){return i<=t?0:i>=e?1:(i=(i-t)/(e-t),i*i*(3-2*i))}function wu(i,t,e){return i<=t?0:i>=e?1:(i=(i-t)/(e-t),i*i*i*(i*(i*6-15)+10))}function Au(i,t){return i+Math.floor(Math.random()*(t-i+1))}function Cu(i,t){return i+Math.random()*(t-i)}function Ru(i){return i*(.5-Math.random())}function Pu(i){i!==void 0&&(ic=i);let t=ic+=1831565813;return t=Math.imul(t^t>>>15,t|1),t^=t+Math.imul(t^t>>>7,t|61),((t^t>>>14)>>>0)/4294967296}function Lu(i){return i*Oi}function Du(i){return i*_s}function Iu(i){return(i&i-1)===0&&i!==0}function Uu(i){return Math.pow(2,Math.ceil(Math.log(i)/Math.LN2))}function Nu(i){return Math.pow(2,Math.floor(Math.log(i)/Math.LN2))}function ku(i,t,e,n,s){const r=Math.cos,o=Math.sin,a=r(e/2),c=o(e/2),l=r((t+n)/2),h=o((t+n)/2),d=r((t-n)/2),u=o((t-n)/2),f=r((n-t)/2),g=o((n-t)/2);switch(s){case"XYX":i.set(a*h,c*d,c*u,a*l);break;case"YZY":i.set(c*u,a*h,c*d,a*l);break;case"ZXZ":i.set(c*d,c*u,a*h,a*l);break;case"XZX":i.set(a*h,c*g,c*f,a*l);break;case"YXY":i.set(c*f,a*h,c*g,a*l);break;case"ZYZ":i.set(c*g,c*f,a*h,a*l);break;default:console.warn("THREE.MathUtils: .setQuaternionFromProperEuler() encountered an unknown order: "+s)}}function Pi(i,t){switch(t.constructor){case Float32Array:return i;case Uint32Array:return i/4294967295;case Uint16Array:return i/65535;case Uint8Array:return i/255;case Int32Array:return Math.max(i/2147483647,-1);case Int16Array:return Math.max(i/32767,-1);case Int8Array:return Math.max(i/127,-1);default:throw new Error("Invalid component type.")}}function Ae(i,t){switch(t.constructor){case Float32Array:return i;case Uint32Array:return Math.round(i*4294967295);case Uint16Array:return Math.round(i*65535);case Uint8Array:return Math.round(i*255);case Int32Array:return Math.round(i*2147483647);case Int16Array:return Math.round(i*32767);case Int8Array:return Math.round(i*127);default:throw new Error("Invalid component type.")}}const zl={DEG2RAD:Oi,RAD2DEG:_s,generateUUID:ui,clamp:ye,euclideanModulo:Aa,mapLinear:Mu,inverseLerp:Su,lerp:ls,damp:bu,pingpong:Eu,smoothstep:Tu,smootherstep:wu,randInt:Au,randFloat:Cu,randFloatSpread:Ru,seededRandom:Pu,degToRad:Lu,radToDeg:Du,isPowerOfTwo:Iu,ceilPowerOfTwo:Uu,floorPowerOfTwo:Nu,setQuaternionFromProperEuler:ku,normalize:Ae,denormalize:Pi};class nt{constructor(t=0,e=0){nt.prototype.isVector2=!0,this.x=t,this.y=e}get width(){return this.x}set width(t){this.x=t}get height(){return this.y}set height(t){this.y=t}set(t,e){return this.x=t,this.y=e,this}setScalar(t){return this.x=t,this.y=t,this}setX(t){return this.x=t,this}setY(t){return this.y=t,this}setComponent(t,e){switch(t){case 0:this.x=e;break;case 1:this.y=e;break;default:throw new Error("index is out of range: "+t)}return this}getComponent(t){switch(t){case 0:return this.x;case 1:return this.y;default:throw new Error("index is out of range: "+t)}}clone(){return new this.constructor(this.x,this.y)}copy(t){return this.x=t.x,this.y=t.y,this}add(t){return this.x+=t.x,this.y+=t.y,this}addScalar(t){return this.x+=t,this.y+=t,this}addVectors(t,e){return this.x=t.x+e.x,this.y=t.y+e.y,this}addScaledVector(t,e){return this.x+=t.x*e,this.y+=t.y*e,this}sub(t){return this.x-=t.x,this.y-=t.y,this}subScalar(t){return this.x-=t,this.y-=t,this}subVectors(t,e){return this.x=t.x-e.x,this.y=t.y-e.y,this}multiply(t){return this.x*=t.x,this.y*=t.y,this}multiplyScalar(t){return this.x*=t,this.y*=t,this}divide(t){return this.x/=t.x,this.y/=t.y,this}divideScalar(t){return this.multiplyScalar(1/t)}applyMatrix3(t){const e=this.x,n=this.y,s=t.elements;return this.x=s[0]*e+s[3]*n+s[6],this.y=s[1]*e+s[4]*n+s[7],this}min(t){return this.x=Math.min(this.x,t.x),this.y=Math.min(this.y,t.y),this}max(t){return this.x=Math.max(this.x,t.x),this.y=Math.max(this.y,t.y),this}clamp(t,e){return this.x=Math.max(t.x,Math.min(e.x,this.x)),this.y=Math.max(t.y,Math.min(e.y,this.y)),this}clampScalar(t,e){return this.x=Math.max(t,Math.min(e,this.x)),this.y=Math.max(t,Math.min(e,this.y)),this}clampLength(t,e){const n=this.length();return this.divideScalar(n||1).multiplyScalar(Math.max(t,Math.min(e,n)))}floor(){return this.x=Math.floor(this.x),this.y=Math.floor(this.y),this}ceil(){return this.x=Math.ceil(this.x),this.y=Math.ceil(this.y),this}round(){return this.x=Math.round(this.x),this.y=Math.round(this.y),this}roundToZero(){return this.x=Math.trunc(this.x),this.y=Math.trunc(this.y),this}negate(){return this.x=-this.x,this.y=-this.y,this}dot(t){return this.x*t.x+this.y*t.y}cross(t){return this.x*t.y-this.y*t.x}lengthSq(){return this.x*this.x+this.y*this.y}length(){return Math.sqrt(this.x*this.x+this.y*this.y)}manhattanLength(){return Math.abs(this.x)+Math.abs(this.y)}normalize(){return this.divideScalar(this.length()||1)}angle(){return Math.atan2(-this.y,-this.x)+Math.PI}angleTo(t){const e=Math.sqrt(this.lengthSq()*t.lengthSq());if(e===0)return Math.PI/2;const n=this.dot(t)/e;return Math.acos(ye(n,-1,1))}distanceTo(t){return Math.sqrt(this.distanceToSquared(t))}distanceToSquared(t){const e=this.x-t.x,n=this.y-t.y;return e*e+n*n}manhattanDistanceTo(t){return Math.abs(this.x-t.x)+Math.abs(this.y-t.y)}setLength(t){return this.normalize().multiplyScalar(t)}lerp(t,e){return this.x+=(t.x-this.x)*e,this.y+=(t.y-this.y)*e,this}lerpVectors(t,e,n){return this.x=t.x+(e.x-t.x)*n,this.y=t.y+(e.y-t.y)*n,this}equals(t){return t.x===this.x&&t.y===this.y}fromArray(t,e=0){return this.x=t[e],this.y=t[e+1],this}toArray(t=[],e=0){return t[e]=this.x,t[e+1]=this.y,t}fromBufferAttribute(t,e){return this.x=t.getX(e),this.y=t.getY(e),this}rotateAround(t,e){const n=Math.cos(e),s=Math.sin(e),r=this.x-t.x,o=this.y-t.y;return this.x=r*n-o*s+t.x,this.y=r*s+o*n+t.y,this}random(){return this.x=Math.random(),this.y=Math.random(),this}*[Symbol.iterator](){yield this.x,yield this.y}}class Vt{constructor(t,e,n,s,r,o,a,c,l){Vt.prototype.isMatrix3=!0,this.elements=[1,0,0,0,1,0,0,0,1],t!==void 0&&this.set(t,e,n,s,r,o,a,c,l)}set(t,e,n,s,r,o,a,c,l){const h=this.elements;return h[0]=t,h[1]=s,h[2]=a,h[3]=e,h[4]=r,h[5]=c,h[6]=n,h[7]=o,h[8]=l,this}identity(){return this.set(1,0,0,0,1,0,0,0,1),this}copy(t){const e=this.elements,n=t.elements;return e[0]=n[0],e[1]=n[1],e[2]=n[2],e[3]=n[3],e[4]=n[4],e[5]=n[5],e[6]=n[6],e[7]=n[7],e[8]=n[8],this}extractBasis(t,e,n){return t.setFromMatrix3Column(this,0),e.setFromMatrix3Column(this,1),n.setFromMatrix3Column(this,2),this}setFromMatrix4(t){const e=t.elements;return this.set(e[0],e[4],e[8],e[1],e[5],e[9],e[2],e[6],e[10]),this}multiply(t){return this.multiplyMatrices(this,t)}premultiply(t){return this.multiplyMatrices(t,this)}multiplyMatrices(t,e){const n=t.elements,s=e.elements,r=this.elements,o=n[0],a=n[3],c=n[6],l=n[1],h=n[4],d=n[7],u=n[2],f=n[5],g=n[8],_=s[0],p=s[3],m=s[6],w=s[1],x=s[4],b=s[7],I=s[2],R=s[5],A=s[8];return r[0]=o*_+a*w+c*I,r[3]=o*p+a*x+c*R,r[6]=o*m+a*b+c*A,r[1]=l*_+h*w+d*I,r[4]=l*p+h*x+d*R,r[7]=l*m+h*b+d*A,r[2]=u*_+f*w+g*I,r[5]=u*p+f*x+g*R,r[8]=u*m+f*b+g*A,this}multiplyScalar(t){const e=this.elements;return e[0]*=t,e[3]*=t,e[6]*=t,e[1]*=t,e[4]*=t,e[7]*=t,e[2]*=t,e[5]*=t,e[8]*=t,this}determinant(){const t=this.elements,e=t[0],n=t[1],s=t[2],r=t[3],o=t[4],a=t[5],c=t[6],l=t[7],h=t[8];return e*o*h-e*a*l-n*r*h+n*a*c+s*r*l-s*o*c}invert(){const t=this.elements,e=t[0],n=t[1],s=t[2],r=t[3],o=t[4],a=t[5],c=t[6],l=t[7],h=t[8],d=h*o-a*l,u=a*c-h*r,f=l*r-o*c,g=e*d+n*u+s*f;if(g===0)return this.set(0,0,0,0,0,0,0,0,0);const _=1/g;return t[0]=d*_,t[1]=(s*l-h*n)*_,t[2]=(a*n-s*o)*_,t[3]=u*_,t[4]=(h*e-s*c)*_,t[5]=(s*r-a*e)*_,t[6]=f*_,t[7]=(n*c-l*e)*_,t[8]=(o*e-n*r)*_,this}transpose(){let t;const e=this.elements;return t=e[1],e[1]=e[3],e[3]=t,t=e[2],e[2]=e[6],e[6]=t,t=e[5],e[5]=e[7],e[7]=t,this}getNormalMatrix(t){return this.setFromMatrix4(t).invert().transpose()}transposeIntoArray(t){const e=this.elements;return t[0]=e[0],t[1]=e[3],t[2]=e[6],t[3]=e[1],t[4]=e[4],t[5]=e[7],t[6]=e[2],t[7]=e[5],t[8]=e[8],this}setUvTransform(t,e,n,s,r,o,a){const c=Math.cos(r),l=Math.sin(r);return this.set(n*c,n*l,-n*(c*o+l*a)+o+t,-s*l,s*c,-s*(-l*o+c*a)+a+e,0,0,1),this}scale(t,e){return this.premultiply(Ur.makeScale(t,e)),this}rotate(t){return this.premultiply(Ur.makeRotation(-t)),this}translate(t,e){return this.premultiply(Ur.makeTranslation(t,e)),this}makeTranslation(t,e){return t.isVector2?this.set(1,0,t.x,0,1,t.y,0,0,1):this.set(1,0,t,0,1,e,0,0,1),this}makeRotation(t){const e=Math.cos(t),n=Math.sin(t);return this.set(e,-n,0,n,e,0,0,0,1),this}makeScale(t,e){return this.set(t,0,0,0,e,0,0,0,1),this}equals(t){const e=this.elements,n=t.elements;for(let s=0;s<9;s++)if(e[s]!==n[s])return!1;return!0}fromArray(t,e=0){for(let n=0;n<9;n++)this.elements[n]=t[n+e];return this}toArray(t=[],e=0){const n=this.elements;return t[e]=n[0],t[e+1]=n[1],t[e+2]=n[2],t[e+3]=n[3],t[e+4]=n[4],t[e+5]=n[5],t[e+6]=n[6],t[e+7]=n[7],t[e+8]=n[8],t}clone(){return new this.constructor().fromArray(this.elements)}}const Ur=new Vt;function Hl(i){for(let t=i.length-1;t>=0;--t)if(i[t]>=65535)return!0;return!1}function mr(i){return document.createElementNS("http://www.w3.org/1999/xhtml",i)}function Fu(){const i=mr("canvas");return i.style.display="block",i}const sc={};function lr(i){i in sc||(sc[i]=!0,console.warn(i))}function Ou(i,t,e){return new Promise(function(n,s){function r(){switch(i.clientWaitSync(t,i.SYNC_FLUSH_COMMANDS_BIT,0)){case i.WAIT_FAILED:s();break;case i.TIMEOUT_EXPIRED:setTimeout(r,e);break;default:n()}}setTimeout(r,e)})}function Bu(i){const t=i.elements;t[2]=.5*t[2]+.5*t[3],t[6]=.5*t[6]+.5*t[7],t[10]=.5*t[10]+.5*t[11],t[14]=.5*t[14]+.5*t[15]}function zu(i){const t=i.elements;t[11]===-1?(t[10]=-t[10]-1,t[14]=-t[14]):(t[10]=-t[10],t[14]=-t[14]+1)}const rc=new Vt().set(.8224621,.177538,0,.0331941,.9668058,0,.0170827,.0723974,.9105199),oc=new Vt().set(1.2249401,-.2249404,0,-.0420569,1.0420571,0,-.0196376,-.0786361,1.0982735),Qi={[Xn]:{transfer:ur,primaries:dr,luminanceCoefficients:[.2126,.7152,.0722],toReference:i=>i,fromReference:i=>i},[cn]:{transfer:le,primaries:dr,luminanceCoefficients:[.2126,.7152,.0722],toReference:i=>i.convertSRGBToLinear(),fromReference:i=>i.convertLinearToSRGB()},[Mr]:{transfer:ur,primaries:fr,luminanceCoefficients:[.2289,.6917,.0793],toReference:i=>i.applyMatrix3(oc),fromReference:i=>i.applyMatrix3(rc)},[wa]:{transfer:le,primaries:fr,luminanceCoefficients:[.2289,.6917,.0793],toReference:i=>i.convertSRGBToLinear().applyMatrix3(oc),fromReference:i=>i.applyMatrix3(rc).convertLinearToSRGB()}},Hu=new Set([Xn,Mr]),ee={enabled:!0,_workingColorSpace:Xn,get workingColorSpace(){return this._workingColorSpace},set workingColorSpace(i){if(!Hu.has(i))throw new Error(`Unsupported working color space, "${i}".`);this._workingColorSpace=i},convert:function(i,t,e){if(this.enabled===!1||t===e||!t||!e)return i;const n=Qi[t].toReference,s=Qi[e].fromReference;return s(n(i))},fromWorkingColorSpace:function(i,t){return this.convert(i,this._workingColorSpace,t)},toWorkingColorSpace:function(i,t){return this.convert(i,t,this._workingColorSpace)},getPrimaries:function(i){return Qi[i].primaries},getTransfer:function(i){return i===In?ur:Qi[i].transfer},getLuminanceCoefficients:function(i,t=this._workingColorSpace){return i.fromArray(Qi[t].luminanceCoefficients)}};function Bi(i){return i<.04045?i*.0773993808:Math.pow(i*.9478672986+.0521327014,2.4)}function Nr(i){return i<.0031308?i*12.92:1.055*Math.pow(i,.41666)-.055}let pi;class Vu{static getDataURL(t){if(/^data:/i.test(t.src)||typeof HTMLCanvasElement>"u")return t.src;let e;if(t instanceof HTMLCanvasElement)e=t;else{pi===void 0&&(pi=mr("canvas")),pi.width=t.width,pi.height=t.height;const n=pi.getContext("2d");t instanceof ImageData?n.putImageData(t,0,0):n.drawImage(t,0,0,t.width,t.height),e=pi}return e.width>2048||e.height>2048?(console.warn("THREE.ImageUtils.getDataURL: Image converted to jpg for performance reasons",t),e.toDataURL("image/jpeg",.6)):e.toDataURL("image/png")}static sRGBToLinear(t){if(typeof HTMLImageElement<"u"&&t instanceof HTMLImageElement||typeof HTMLCanvasElement<"u"&&t instanceof HTMLCanvasElement||typeof ImageBitmap<"u"&&t instanceof ImageBitmap){const e=mr("canvas");e.width=t.width,e.height=t.height;const n=e.getContext("2d");n.drawImage(t,0,0,t.width,t.height);const s=n.getImageData(0,0,t.width,t.height),r=s.data;for(let o=0;o<r.length;o++)r[o]=Bi(r[o]/255)*255;return n.putImageData(s,0,0),e}else if(t.data){const e=t.data.slice(0);for(let n=0;n<e.length;n++)e instanceof Uint8Array||e instanceof Uint8ClampedArray?e[n]=Math.floor(Bi(e[n]/255)*255):e[n]=Bi(e[n]);return{data:e,width:t.width,height:t.height}}else return console.warn("THREE.ImageUtils.sRGBToLinear(): Unsupported image type. No color space conversion applied."),t}}let Gu=0;class Vl{constructor(t=null){this.isSource=!0,Object.defineProperty(this,"id",{value:Gu++}),this.uuid=ui(),this.data=t,this.dataReady=!0,this.version=0}set needsUpdate(t){t===!0&&this.version++}toJSON(t){const e=t===void 0||typeof t=="string";if(!e&&t.images[this.uuid]!==void 0)return t.images[this.uuid];const n={uuid:this.uuid,url:""},s=this.data;if(s!==null){let r;if(Array.isArray(s)){r=[];for(let o=0,a=s.length;o<a;o++)s[o].isDataTexture?r.push(kr(s[o].image)):r.push(kr(s[o]))}else r=kr(s);n.url=r}return e||(t.images[this.uuid]=n),n}}function kr(i){return typeof HTMLImageElement<"u"&&i instanceof HTMLImageElement||typeof HTMLCanvasElement<"u"&&i instanceof HTMLCanvasElement||typeof ImageBitmap<"u"&&i instanceof ImageBitmap?Vu.getDataURL(i):i.data?{data:Array.from(i.data),width:i.width,height:i.height,type:i.data.constructor.name}:(console.warn("THREE.Texture: Unable to serialize Texture."),{})}let Wu=0;class Ue extends hi{constructor(t=Ue.DEFAULT_IMAGE,e=Ue.DEFAULT_MAPPING,n=ni,s=ni,r=nn,o=ii,a=sn,c=bn,l=Ue.DEFAULT_ANISOTROPY,h=In){super(),this.isTexture=!0,Object.defineProperty(this,"id",{value:Wu++}),this.uuid=ui(),this.name="",this.source=new Vl(t),this.mipmaps=[],this.mapping=e,this.channel=0,this.wrapS=n,this.wrapT=s,this.magFilter=r,this.minFilter=o,this.anisotropy=l,this.format=a,this.internalFormat=null,this.type=c,this.offset=new nt(0,0),this.repeat=new nt(1,1),this.center=new nt(0,0),this.rotation=0,this.matrixAutoUpdate=!0,this.matrix=new Vt,this.generateMipmaps=!0,this.premultiplyAlpha=!1,this.flipY=!0,this.unpackAlignment=4,this.colorSpace=h,this.userData={},this.version=0,this.onUpdate=null,this.isRenderTargetTexture=!1,this.pmremVersion=0}get image(){return this.source.data}set image(t=null){this.source.data=t}updateMatrix(){this.matrix.setUvTransform(this.offset.x,this.offset.y,this.repeat.x,this.repeat.y,this.rotation,this.center.x,this.center.y)}clone(){return new this.constructor().copy(this)}copy(t){return this.name=t.name,this.source=t.source,this.mipmaps=t.mipmaps.slice(0),this.mapping=t.mapping,this.channel=t.channel,this.wrapS=t.wrapS,this.wrapT=t.wrapT,this.magFilter=t.magFilter,this.minFilter=t.minFilter,this.anisotropy=t.anisotropy,this.format=t.format,this.internalFormat=t.internalFormat,this.type=t.type,this.offset.copy(t.offset),this.repeat.copy(t.repeat),this.center.copy(t.center),this.rotation=t.rotation,this.matrixAutoUpdate=t.matrixAutoUpdate,this.matrix.copy(t.matrix),this.generateMipmaps=t.generateMipmaps,this.premultiplyAlpha=t.premultiplyAlpha,this.flipY=t.flipY,this.unpackAlignment=t.unpackAlignment,this.colorSpace=t.colorSpace,this.userData=JSON.parse(JSON.stringify(t.userData)),this.needsUpdate=!0,this}toJSON(t){const e=t===void 0||typeof t=="string";if(!e&&t.textures[this.uuid]!==void 0)return t.textures[this.uuid];const n={metadata:{version:4.6,type:"Texture",generator:"Texture.toJSON"},uuid:this.uuid,name:this.name,image:this.source.toJSON(t).uuid,mapping:this.mapping,channel:this.channel,repeat:[this.repeat.x,this.repeat.y],offset:[this.offset.x,this.offset.y],center:[this.center.x,this.center.y],rotation:this.rotation,wrap:[this.wrapS,this.wrapT],format:this.format,internalFormat:this.internalFormat,type:this.type,colorSpace:this.colorSpace,minFilter:this.minFilter,magFilter:this.magFilter,anisotropy:this.anisotropy,flipY:this.flipY,generateMipmaps:this.generateMipmaps,premultiplyAlpha:this.premultiplyAlpha,unpackAlignment:this.unpackAlignment};return Object.keys(this.userData).length>0&&(n.userData=this.userData),e||(t.textures[this.uuid]=n),n}dispose(){this.dispatchEvent({type:"dispose"})}transformUv(t){if(this.mapping!==Al)return t;if(t.applyMatrix3(this.matrix),t.x<0||t.x>1)switch(this.wrapS){case Io:t.x=t.x-Math.floor(t.x);break;case ni:t.x=t.x<0?0:1;break;case Uo:Math.abs(Math.floor(t.x)%2)===1?t.x=Math.ceil(t.x)-t.x:t.x=t.x-Math.floor(t.x);break}if(t.y<0||t.y>1)switch(this.wrapT){case Io:t.y=t.y-Math.floor(t.y);break;case ni:t.y=t.y<0?0:1;break;case Uo:Math.abs(Math.floor(t.y)%2)===1?t.y=Math.ceil(t.y)-t.y:t.y=t.y-Math.floor(t.y);break}return this.flipY&&(t.y=1-t.y),t}set needsUpdate(t){t===!0&&(this.version++,this.source.needsUpdate=!0)}set needsPMREMUpdate(t){t===!0&&this.pmremVersion++}}Ue.DEFAULT_IMAGE=null;Ue.DEFAULT_MAPPING=Al;Ue.DEFAULT_ANISOTROPY=1;class se{constructor(t=0,e=0,n=0,s=1){se.prototype.isVector4=!0,this.x=t,this.y=e,this.z=n,this.w=s}get width(){return this.z}set width(t){this.z=t}get height(){return this.w}set height(t){this.w=t}set(t,e,n,s){return this.x=t,this.y=e,this.z=n,this.w=s,this}setScalar(t){return this.x=t,this.y=t,this.z=t,this.w=t,this}setX(t){return this.x=t,this}setY(t){return this.y=t,this}setZ(t){return this.z=t,this}setW(t){return this.w=t,this}setComponent(t,e){switch(t){case 0:this.x=e;break;case 1:this.y=e;break;case 2:this.z=e;break;case 3:this.w=e;break;default:throw new Error("index is out of range: "+t)}return this}getComponent(t){switch(t){case 0:return this.x;case 1:return this.y;case 2:return this.z;case 3:return this.w;default:throw new Error("index is out of range: "+t)}}clone(){return new this.constructor(this.x,this.y,this.z,this.w)}copy(t){return this.x=t.x,this.y=t.y,this.z=t.z,this.w=t.w!==void 0?t.w:1,this}add(t){return this.x+=t.x,this.y+=t.y,this.z+=t.z,this.w+=t.w,this}addScalar(t){return this.x+=t,this.y+=t,this.z+=t,this.w+=t,this}addVectors(t,e){return this.x=t.x+e.x,this.y=t.y+e.y,this.z=t.z+e.z,this.w=t.w+e.w,this}addScaledVector(t,e){return this.x+=t.x*e,this.y+=t.y*e,this.z+=t.z*e,this.w+=t.w*e,this}sub(t){return this.x-=t.x,this.y-=t.y,this.z-=t.z,this.w-=t.w,this}subScalar(t){return this.x-=t,this.y-=t,this.z-=t,this.w-=t,this}subVectors(t,e){return this.x=t.x-e.x,this.y=t.y-e.y,this.z=t.z-e.z,this.w=t.w-e.w,this}multiply(t){return this.x*=t.x,this.y*=t.y,this.z*=t.z,this.w*=t.w,this}multiplyScalar(t){return this.x*=t,this.y*=t,this.z*=t,this.w*=t,this}applyMatrix4(t){const e=this.x,n=this.y,s=this.z,r=this.w,o=t.elements;return this.x=o[0]*e+o[4]*n+o[8]*s+o[12]*r,this.y=o[1]*e+o[5]*n+o[9]*s+o[13]*r,this.z=o[2]*e+o[6]*n+o[10]*s+o[14]*r,this.w=o[3]*e+o[7]*n+o[11]*s+o[15]*r,this}divideScalar(t){return this.multiplyScalar(1/t)}setAxisAngleFromQuaternion(t){this.w=2*Math.acos(t.w);const e=Math.sqrt(1-t.w*t.w);return e<1e-4?(this.x=1,this.y=0,this.z=0):(this.x=t.x/e,this.y=t.y/e,this.z=t.z/e),this}setAxisAngleFromRotationMatrix(t){let e,n,s,r;const c=t.elements,l=c[0],h=c[4],d=c[8],u=c[1],f=c[5],g=c[9],_=c[2],p=c[6],m=c[10];if(Math.abs(h-u)<.01&&Math.abs(d-_)<.01&&Math.abs(g-p)<.01){if(Math.abs(h+u)<.1&&Math.abs(d+_)<.1&&Math.abs(g+p)<.1&&Math.abs(l+f+m-3)<.1)return this.set(1,0,0,0),this;e=Math.PI;const x=(l+1)/2,b=(f+1)/2,I=(m+1)/2,R=(h+u)/4,A=(d+_)/4,P=(g+p)/4;return x>b&&x>I?x<.01?(n=0,s=.707106781,r=.707106781):(n=Math.sqrt(x),s=R/n,r=A/n):b>I?b<.01?(n=.707106781,s=0,r=.707106781):(s=Math.sqrt(b),n=R/s,r=P/s):I<.01?(n=.707106781,s=.707106781,r=0):(r=Math.sqrt(I),n=A/r,s=P/r),this.set(n,s,r,e),this}let w=Math.sqrt((p-g)*(p-g)+(d-_)*(d-_)+(u-h)*(u-h));return Math.abs(w)<.001&&(w=1),this.x=(p-g)/w,this.y=(d-_)/w,this.z=(u-h)/w,this.w=Math.acos((l+f+m-1)/2),this}setFromMatrixPosition(t){const e=t.elements;return this.x=e[12],this.y=e[13],this.z=e[14],this.w=e[15],this}min(t){return this.x=Math.min(this.x,t.x),this.y=Math.min(this.y,t.y),this.z=Math.min(this.z,t.z),this.w=Math.min(this.w,t.w),this}max(t){return this.x=Math.max(this.x,t.x),this.y=Math.max(this.y,t.y),this.z=Math.max(this.z,t.z),this.w=Math.max(this.w,t.w),this}clamp(t,e){return this.x=Math.max(t.x,Math.min(e.x,this.x)),this.y=Math.max(t.y,Math.min(e.y,this.y)),this.z=Math.max(t.z,Math.min(e.z,this.z)),this.w=Math.max(t.w,Math.min(e.w,this.w)),this}clampScalar(t,e){return this.x=Math.max(t,Math.min(e,this.x)),this.y=Math.max(t,Math.min(e,this.y)),this.z=Math.max(t,Math.min(e,this.z)),this.w=Math.max(t,Math.min(e,this.w)),this}clampLength(t,e){const n=this.length();return this.divideScalar(n||1).multiplyScalar(Math.max(t,Math.min(e,n)))}floor(){return this.x=Math.floor(this.x),this.y=Math.floor(this.y),this.z=Math.floor(this.z),this.w=Math.floor(this.w),this}ceil(){return this.x=Math.ceil(this.x),this.y=Math.ceil(this.y),this.z=Math.ceil(this.z),this.w=Math.ceil(this.w),this}round(){return this.x=Math.round(this.x),this.y=Math.round(this.y),this.z=Math.round(this.z),this.w=Math.round(this.w),this}roundToZero(){return this.x=Math.trunc(this.x),this.y=Math.trunc(this.y),this.z=Math.trunc(this.z),this.w=Math.trunc(this.w),this}negate(){return this.x=-this.x,this.y=-this.y,this.z=-this.z,this.w=-this.w,this}dot(t){return this.x*t.x+this.y*t.y+this.z*t.z+this.w*t.w}lengthSq(){return this.x*this.x+this.y*this.y+this.z*this.z+this.w*this.w}length(){return Math.sqrt(this.x*this.x+this.y*this.y+this.z*this.z+this.w*this.w)}manhattanLength(){return Math.abs(this.x)+Math.abs(this.y)+Math.abs(this.z)+Math.abs(this.w)}normalize(){return this.divideScalar(this.length()||1)}setLength(t){return this.normalize().multiplyScalar(t)}lerp(t,e){return this.x+=(t.x-this.x)*e,this.y+=(t.y-this.y)*e,this.z+=(t.z-this.z)*e,this.w+=(t.w-this.w)*e,this}lerpVectors(t,e,n){return this.x=t.x+(e.x-t.x)*n,this.y=t.y+(e.y-t.y)*n,this.z=t.z+(e.z-t.z)*n,this.w=t.w+(e.w-t.w)*n,this}equals(t){return t.x===this.x&&t.y===this.y&&t.z===this.z&&t.w===this.w}fromArray(t,e=0){return this.x=t[e],this.y=t[e+1],this.z=t[e+2],this.w=t[e+3],this}toArray(t=[],e=0){return t[e]=this.x,t[e+1]=this.y,t[e+2]=this.z,t[e+3]=this.w,t}fromBufferAttribute(t,e){return this.x=t.getX(e),this.y=t.getY(e),this.z=t.getZ(e),this.w=t.getW(e),this}random(){return this.x=Math.random(),this.y=Math.random(),this.z=Math.random(),this.w=Math.random(),this}*[Symbol.iterator](){yield this.x,yield this.y,yield this.z,yield this.w}}class Xu extends hi{constructor(t=1,e=1,n={}){super(),this.isRenderTarget=!0,this.width=t,this.height=e,this.depth=1,this.scissor=new se(0,0,t,e),this.scissorTest=!1,this.viewport=new se(0,0,t,e);const s={width:t,height:e,depth:1};n=Object.assign({generateMipmaps:!1,internalFormat:null,minFilter:nn,depthBuffer:!0,stencilBuffer:!1,resolveDepthBuffer:!0,resolveStencilBuffer:!0,depthTexture:null,samples:0,count:1},n);const r=new Ue(s,n.mapping,n.wrapS,n.wrapT,n.magFilter,n.minFilter,n.format,n.type,n.anisotropy,n.colorSpace);r.flipY=!1,r.generateMipmaps=n.generateMipmaps,r.internalFormat=n.internalFormat,this.textures=[];const o=n.count;for(let a=0;a<o;a++)this.textures[a]=r.clone(),this.textures[a].isRenderTargetTexture=!0;this.depthBuffer=n.depthBuffer,this.stencilBuffer=n.stencilBuffer,this.resolveDepthBuffer=n.resolveDepthBuffer,this.resolveStencilBuffer=n.resolveStencilBuffer,this.depthTexture=n.depthTexture,this.samples=n.samples}get texture(){return this.textures[0]}set texture(t){this.textures[0]=t}setSize(t,e,n=1){if(this.width!==t||this.height!==e||this.depth!==n){this.width=t,this.height=e,this.depth=n;for(let s=0,r=this.textures.length;s<r;s++)this.textures[s].image.width=t,this.textures[s].image.height=e,this.textures[s].image.depth=n;this.dispose()}this.viewport.set(0,0,t,e),this.scissor.set(0,0,t,e)}clone(){return new this.constructor().copy(this)}copy(t){this.width=t.width,this.height=t.height,this.depth=t.depth,this.scissor.copy(t.scissor),this.scissorTest=t.scissorTest,this.viewport.copy(t.viewport),this.textures.length=0;for(let n=0,s=t.textures.length;n<s;n++)this.textures[n]=t.textures[n].clone(),this.textures[n].isRenderTargetTexture=!0;const e=Object.assign({},t.texture.image);return this.texture.source=new Vl(e),this.depthBuffer=t.depthBuffer,this.stencilBuffer=t.stencilBuffer,this.resolveDepthBuffer=t.resolveDepthBuffer,this.resolveStencilBuffer=t.resolveStencilBuffer,t.depthTexture!==null&&(this.depthTexture=t.depthTexture.clone()),this.samples=t.samples,this}dispose(){this.dispatchEvent({type:"dispose"})}}class oi extends Xu{constructor(t=1,e=1,n={}){super(t,e,n),this.isWebGLRenderTarget=!0}}class Gl extends Ue{constructor(t=null,e=1,n=1,s=1){super(null),this.isDataArrayTexture=!0,this.image={data:t,width:e,height:n,depth:s},this.magFilter=Ke,this.minFilter=Ke,this.wrapR=ni,this.generateMipmaps=!1,this.flipY=!1,this.unpackAlignment=1,this.layerUpdates=new Set}addLayerUpdate(t){this.layerUpdates.add(t)}clearLayerUpdates(){this.layerUpdates.clear()}}class $u extends Ue{constructor(t=null,e=1,n=1,s=1){super(null),this.isData3DTexture=!0,this.image={data:t,width:e,height:n,depth:s},this.magFilter=Ke,this.minFilter=Ke,this.wrapR=ni,this.generateMipmaps=!1,this.flipY=!1,this.unpackAlignment=1}}class En{constructor(t=0,e=0,n=0,s=1){this.isQuaternion=!0,this._x=t,this._y=e,this._z=n,this._w=s}static slerpFlat(t,e,n,s,r,o,a){let c=n[s+0],l=n[s+1],h=n[s+2],d=n[s+3];const u=r[o+0],f=r[o+1],g=r[o+2],_=r[o+3];if(a===0){t[e+0]=c,t[e+1]=l,t[e+2]=h,t[e+3]=d;return}if(a===1){t[e+0]=u,t[e+1]=f,t[e+2]=g,t[e+3]=_;return}if(d!==_||c!==u||l!==f||h!==g){let p=1-a;const m=c*u+l*f+h*g+d*_,w=m>=0?1:-1,x=1-m*m;if(x>Number.EPSILON){const I=Math.sqrt(x),R=Math.atan2(I,m*w);p=Math.sin(p*R)/I,a=Math.sin(a*R)/I}const b=a*w;if(c=c*p+u*b,l=l*p+f*b,h=h*p+g*b,d=d*p+_*b,p===1-a){const I=1/Math.sqrt(c*c+l*l+h*h+d*d);c*=I,l*=I,h*=I,d*=I}}t[e]=c,t[e+1]=l,t[e+2]=h,t[e+3]=d}static multiplyQuaternionsFlat(t,e,n,s,r,o){const a=n[s],c=n[s+1],l=n[s+2],h=n[s+3],d=r[o],u=r[o+1],f=r[o+2],g=r[o+3];return t[e]=a*g+h*d+c*f-l*u,t[e+1]=c*g+h*u+l*d-a*f,t[e+2]=l*g+h*f+a*u-c*d,t[e+3]=h*g-a*d-c*u-l*f,t}get x(){return this._x}set x(t){this._x=t,this._onChangeCallback()}get y(){return this._y}set y(t){this._y=t,this._onChangeCallback()}get z(){return this._z}set z(t){this._z=t,this._onChangeCallback()}get w(){return this._w}set w(t){this._w=t,this._onChangeCallback()}set(t,e,n,s){return this._x=t,this._y=e,this._z=n,this._w=s,this._onChangeCallback(),this}clone(){return new this.constructor(this._x,this._y,this._z,this._w)}copy(t){return this._x=t.x,this._y=t.y,this._z=t.z,this._w=t.w,this._onChangeCallback(),this}setFromEuler(t,e=!0){const n=t._x,s=t._y,r=t._z,o=t._order,a=Math.cos,c=Math.sin,l=a(n/2),h=a(s/2),d=a(r/2),u=c(n/2),f=c(s/2),g=c(r/2);switch(o){case"XYZ":this._x=u*h*d+l*f*g,this._y=l*f*d-u*h*g,this._z=l*h*g+u*f*d,this._w=l*h*d-u*f*g;break;case"YXZ":this._x=u*h*d+l*f*g,this._y=l*f*d-u*h*g,this._z=l*h*g-u*f*d,this._w=l*h*d+u*f*g;break;case"ZXY":this._x=u*h*d-l*f*g,this._y=l*f*d+u*h*g,this._z=l*h*g+u*f*d,this._w=l*h*d-u*f*g;break;case"ZYX":this._x=u*h*d-l*f*g,this._y=l*f*d+u*h*g,this._z=l*h*g-u*f*d,this._w=l*h*d+u*f*g;break;case"YZX":this._x=u*h*d+l*f*g,this._y=l*f*d+u*h*g,this._z=l*h*g-u*f*d,this._w=l*h*d-u*f*g;break;case"XZY":this._x=u*h*d-l*f*g,this._y=l*f*d-u*h*g,this._z=l*h*g+u*f*d,this._w=l*h*d+u*f*g;break;default:console.warn("THREE.Quaternion: .setFromEuler() encountered an unknown order: "+o)}return e===!0&&this._onChangeCallback(),this}setFromAxisAngle(t,e){const n=e/2,s=Math.sin(n);return this._x=t.x*s,this._y=t.y*s,this._z=t.z*s,this._w=Math.cos(n),this._onChangeCallback(),this}setFromRotationMatrix(t){const e=t.elements,n=e[0],s=e[4],r=e[8],o=e[1],a=e[5],c=e[9],l=e[2],h=e[6],d=e[10],u=n+a+d;if(u>0){const f=.5/Math.sqrt(u+1);this._w=.25/f,this._x=(h-c)*f,this._y=(r-l)*f,this._z=(o-s)*f}else if(n>a&&n>d){const f=2*Math.sqrt(1+n-a-d);this._w=(h-c)/f,this._x=.25*f,this._y=(s+o)/f,this._z=(r+l)/f}else if(a>d){const f=2*Math.sqrt(1+a-n-d);this._w=(r-l)/f,this._x=(s+o)/f,this._y=.25*f,this._z=(c+h)/f}else{const f=2*Math.sqrt(1+d-n-a);this._w=(o-s)/f,this._x=(r+l)/f,this._y=(c+h)/f,this._z=.25*f}return this._onChangeCallback(),this}setFromUnitVectors(t,e){let n=t.dot(e)+1;return n<Number.EPSILON?(n=0,Math.abs(t.x)>Math.abs(t.z)?(this._x=-t.y,this._y=t.x,this._z=0,this._w=n):(this._x=0,this._y=-t.z,this._z=t.y,this._w=n)):(this._x=t.y*e.z-t.z*e.y,this._y=t.z*e.x-t.x*e.z,this._z=t.x*e.y-t.y*e.x,this._w=n),this.normalize()}angleTo(t){return 2*Math.acos(Math.abs(ye(this.dot(t),-1,1)))}rotateTowards(t,e){const n=this.angleTo(t);if(n===0)return this;const s=Math.min(1,e/n);return this.slerp(t,s),this}identity(){return this.set(0,0,0,1)}invert(){return this.conjugate()}conjugate(){return this._x*=-1,this._y*=-1,this._z*=-1,this._onChangeCallback(),this}dot(t){return this._x*t._x+this._y*t._y+this._z*t._z+this._w*t._w}lengthSq(){return this._x*this._x+this._y*this._y+this._z*this._z+this._w*this._w}length(){return Math.sqrt(this._x*this._x+this._y*this._y+this._z*this._z+this._w*this._w)}normalize(){let t=this.length();return t===0?(this._x=0,this._y=0,this._z=0,this._w=1):(t=1/t,this._x=this._x*t,this._y=this._y*t,this._z=this._z*t,this._w=this._w*t),this._onChangeCallback(),this}multiply(t){return this.multiplyQuaternions(this,t)}premultiply(t){return this.multiplyQuaternions(t,this)}multiplyQuaternions(t,e){const n=t._x,s=t._y,r=t._z,o=t._w,a=e._x,c=e._y,l=e._z,h=e._w;return this._x=n*h+o*a+s*l-r*c,this._y=s*h+o*c+r*a-n*l,this._z=r*h+o*l+n*c-s*a,this._w=o*h-n*a-s*c-r*l,this._onChangeCallback(),this}slerp(t,e){if(e===0)return this;if(e===1)return this.copy(t);const n=this._x,s=this._y,r=this._z,o=this._w;let a=o*t._w+n*t._x+s*t._y+r*t._z;if(a<0?(this._w=-t._w,this._x=-t._x,this._y=-t._y,this._z=-t._z,a=-a):this.copy(t),a>=1)return this._w=o,this._x=n,this._y=s,this._z=r,this;const c=1-a*a;if(c<=Number.EPSILON){const f=1-e;return this._w=f*o+e*this._w,this._x=f*n+e*this._x,this._y=f*s+e*this._y,this._z=f*r+e*this._z,this.normalize(),this}const l=Math.sqrt(c),h=Math.atan2(l,a),d=Math.sin((1-e)*h)/l,u=Math.sin(e*h)/l;return this._w=o*d+this._w*u,this._x=n*d+this._x*u,this._y=s*d+this._y*u,this._z=r*d+this._z*u,this._onChangeCallback(),this}slerpQuaternions(t,e,n){return this.copy(t).slerp(e,n)}random(){const t=2*Math.PI*Math.random(),e=2*Math.PI*Math.random(),n=Math.random(),s=Math.sqrt(1-n),r=Math.sqrt(n);return this.set(s*Math.sin(t),s*Math.cos(t),r*Math.sin(e),r*Math.cos(e))}equals(t){return t._x===this._x&&t._y===this._y&&t._z===this._z&&t._w===this._w}fromArray(t,e=0){return this._x=t[e],this._y=t[e+1],this._z=t[e+2],this._w=t[e+3],this._onChangeCallback(),this}toArray(t=[],e=0){return t[e]=this._x,t[e+1]=this._y,t[e+2]=this._z,t[e+3]=this._w,t}fromBufferAttribute(t,e){return this._x=t.getX(e),this._y=t.getY(e),this._z=t.getZ(e),this._w=t.getW(e),this._onChangeCallback(),this}toJSON(){return this.toArray()}_onChange(t){return this._onChangeCallback=t,this}_onChangeCallback(){}*[Symbol.iterator](){yield this._x,yield this._y,yield this._z,yield this._w}}class C{constructor(t=0,e=0,n=0){C.prototype.isVector3=!0,this.x=t,this.y=e,this.z=n}set(t,e,n){return n===void 0&&(n=this.z),this.x=t,this.y=e,this.z=n,this}setScalar(t){return this.x=t,this.y=t,this.z=t,this}setX(t){return this.x=t,this}setY(t){return this.y=t,this}setZ(t){return this.z=t,this}setComponent(t,e){switch(t){case 0:this.x=e;break;case 1:this.y=e;break;case 2:this.z=e;break;default:throw new Error("index is out of range: "+t)}return this}getComponent(t){switch(t){case 0:return this.x;case 1:return this.y;case 2:return this.z;default:throw new Error("index is out of range: "+t)}}clone(){return new this.constructor(this.x,this.y,this.z)}copy(t){return this.x=t.x,this.y=t.y,this.z=t.z,this}add(t){return this.x+=t.x,this.y+=t.y,this.z+=t.z,this}addScalar(t){return this.x+=t,this.y+=t,this.z+=t,this}addVectors(t,e){return this.x=t.x+e.x,this.y=t.y+e.y,this.z=t.z+e.z,this}addScaledVector(t,e){return this.x+=t.x*e,this.y+=t.y*e,this.z+=t.z*e,this}sub(t){return this.x-=t.x,this.y-=t.y,this.z-=t.z,this}subScalar(t){return this.x-=t,this.y-=t,this.z-=t,this}subVectors(t,e){return this.x=t.x-e.x,this.y=t.y-e.y,this.z=t.z-e.z,this}multiply(t){return this.x*=t.x,this.y*=t.y,this.z*=t.z,this}multiplyScalar(t){return this.x*=t,this.y*=t,this.z*=t,this}multiplyVectors(t,e){return this.x=t.x*e.x,this.y=t.y*e.y,this.z=t.z*e.z,this}applyEuler(t){return this.applyQuaternion(ac.setFromEuler(t))}applyAxisAngle(t,e){return this.applyQuaternion(ac.setFromAxisAngle(t,e))}applyMatrix3(t){const e=this.x,n=this.y,s=this.z,r=t.elements;return this.x=r[0]*e+r[3]*n+r[6]*s,this.y=r[1]*e+r[4]*n+r[7]*s,this.z=r[2]*e+r[5]*n+r[8]*s,this}applyNormalMatrix(t){return this.applyMatrix3(t).normalize()}applyMatrix4(t){const e=this.x,n=this.y,s=this.z,r=t.elements,o=1/(r[3]*e+r[7]*n+r[11]*s+r[15]);return this.x=(r[0]*e+r[4]*n+r[8]*s+r[12])*o,this.y=(r[1]*e+r[5]*n+r[9]*s+r[13])*o,this.z=(r[2]*e+r[6]*n+r[10]*s+r[14])*o,this}applyQuaternion(t){const e=this.x,n=this.y,s=this.z,r=t.x,o=t.y,a=t.z,c=t.w,l=2*(o*s-a*n),h=2*(a*e-r*s),d=2*(r*n-o*e);return this.x=e+c*l+o*d-a*h,this.y=n+c*h+a*l-r*d,this.z=s+c*d+r*h-o*l,this}project(t){return this.applyMatrix4(t.matrixWorldInverse).applyMatrix4(t.projectionMatrix)}unproject(t){return this.applyMatrix4(t.projectionMatrixInverse).applyMatrix4(t.matrixWorld)}transformDirection(t){const e=this.x,n=this.y,s=this.z,r=t.elements;return this.x=r[0]*e+r[4]*n+r[8]*s,this.y=r[1]*e+r[5]*n+r[9]*s,this.z=r[2]*e+r[6]*n+r[10]*s,this.normalize()}divide(t){return this.x/=t.x,this.y/=t.y,this.z/=t.z,this}divideScalar(t){return this.multiplyScalar(1/t)}min(t){return this.x=Math.min(this.x,t.x),this.y=Math.min(this.y,t.y),this.z=Math.min(this.z,t.z),this}max(t){return this.x=Math.max(this.x,t.x),this.y=Math.max(this.y,t.y),this.z=Math.max(this.z,t.z),this}clamp(t,e){return this.x=Math.max(t.x,Math.min(e.x,this.x)),this.y=Math.max(t.y,Math.min(e.y,this.y)),this.z=Math.max(t.z,Math.min(e.z,this.z)),this}clampScalar(t,e){return this.x=Math.max(t,Math.min(e,this.x)),this.y=Math.max(t,Math.min(e,this.y)),this.z=Math.max(t,Math.min(e,this.z)),this}clampLength(t,e){const n=this.length();return this.divideScalar(n||1).multiplyScalar(Math.max(t,Math.min(e,n)))}floor(){return this.x=Math.floor(this.x),this.y=Math.floor(this.y),this.z=Math.floor(this.z),this}ceil(){return this.x=Math.ceil(this.x),this.y=Math.ceil(this.y),this.z=Math.ceil(this.z),this}round(){return this.x=Math.round(this.x),this.y=Math.round(this.y),this.z=Math.round(this.z),this}roundToZero(){return this.x=Math.trunc(this.x),this.y=Math.trunc(this.y),this.z=Math.trunc(this.z),this}negate(){return this.x=-this.x,this.y=-this.y,this.z=-this.z,this}dot(t){return this.x*t.x+this.y*t.y+this.z*t.z}lengthSq(){return this.x*this.x+this.y*this.y+this.z*this.z}length(){return Math.sqrt(this.x*this.x+this.y*this.y+this.z*this.z)}manhattanLength(){return Math.abs(this.x)+Math.abs(this.y)+Math.abs(this.z)}normalize(){return this.divideScalar(this.length()||1)}setLength(t){return this.normalize().multiplyScalar(t)}lerp(t,e){return this.x+=(t.x-this.x)*e,this.y+=(t.y-this.y)*e,this.z+=(t.z-this.z)*e,this}lerpVectors(t,e,n){return this.x=t.x+(e.x-t.x)*n,this.y=t.y+(e.y-t.y)*n,this.z=t.z+(e.z-t.z)*n,this}cross(t){return this.crossVectors(this,t)}crossVectors(t,e){const n=t.x,s=t.y,r=t.z,o=e.x,a=e.y,c=e.z;return this.x=s*c-r*a,this.y=r*o-n*c,this.z=n*a-s*o,this}projectOnVector(t){const e=t.lengthSq();if(e===0)return this.set(0,0,0);const n=t.dot(this)/e;return this.copy(t).multiplyScalar(n)}projectOnPlane(t){return Fr.copy(this).projectOnVector(t),this.sub(Fr)}reflect(t){return this.sub(Fr.copy(t).multiplyScalar(2*this.dot(t)))}angleTo(t){const e=Math.sqrt(this.lengthSq()*t.lengthSq());if(e===0)return Math.PI/2;const n=this.dot(t)/e;return Math.acos(ye(n,-1,1))}distanceTo(t){return Math.sqrt(this.distanceToSquared(t))}distanceToSquared(t){const e=this.x-t.x,n=this.y-t.y,s=this.z-t.z;return e*e+n*n+s*s}manhattanDistanceTo(t){return Math.abs(this.x-t.x)+Math.abs(this.y-t.y)+Math.abs(this.z-t.z)}setFromSpherical(t){return this.setFromSphericalCoords(t.radius,t.phi,t.theta)}setFromSphericalCoords(t,e,n){const s=Math.sin(e)*t;return this.x=s*Math.sin(n),this.y=Math.cos(e)*t,this.z=s*Math.cos(n),this}setFromCylindrical(t){return this.setFromCylindricalCoords(t.radius,t.theta,t.y)}setFromCylindricalCoords(t,e,n){return this.x=t*Math.sin(e),this.y=n,this.z=t*Math.cos(e),this}setFromMatrixPosition(t){const e=t.elements;return this.x=e[12],this.y=e[13],this.z=e[14],this}setFromMatrixScale(t){const e=this.setFromMatrixColumn(t,0).length(),n=this.setFromMatrixColumn(t,1).length(),s=this.setFromMatrixColumn(t,2).length();return this.x=e,this.y=n,this.z=s,this}setFromMatrixColumn(t,e){return this.fromArray(t.elements,e*4)}setFromMatrix3Column(t,e){return this.fromArray(t.elements,e*3)}setFromEuler(t){return this.x=t._x,this.y=t._y,this.z=t._z,this}setFromColor(t){return this.x=t.r,this.y=t.g,this.z=t.b,this}equals(t){return t.x===this.x&&t.y===this.y&&t.z===this.z}fromArray(t,e=0){return this.x=t[e],this.y=t[e+1],this.z=t[e+2],this}toArray(t=[],e=0){return t[e]=this.x,t[e+1]=this.y,t[e+2]=this.z,t}fromBufferAttribute(t,e){return this.x=t.getX(e),this.y=t.getY(e),this.z=t.getZ(e),this}random(){return this.x=Math.random(),this.y=Math.random(),this.z=Math.random(),this}randomDirection(){const t=Math.random()*Math.PI*2,e=Math.random()*2-1,n=Math.sqrt(1-e*e);return this.x=n*Math.cos(t),this.y=e,this.z=n*Math.sin(t),this}*[Symbol.iterator](){yield this.x,yield this.y,yield this.z}}const Fr=new C,ac=new En;class Yi{constructor(t=new C(1/0,1/0,1/0),e=new C(-1/0,-1/0,-1/0)){this.isBox3=!0,this.min=t,this.max=e}set(t,e){return this.min.copy(t),this.max.copy(e),this}setFromArray(t){this.makeEmpty();for(let e=0,n=t.length;e<n;e+=3)this.expandByPoint(je.fromArray(t,e));return this}setFromBufferAttribute(t){this.makeEmpty();for(let e=0,n=t.count;e<n;e++)this.expandByPoint(je.fromBufferAttribute(t,e));return this}setFromPoints(t){this.makeEmpty();for(let e=0,n=t.length;e<n;e++)this.expandByPoint(t[e]);return this}setFromCenterAndSize(t,e){const n=je.copy(e).multiplyScalar(.5);return this.min.copy(t).sub(n),this.max.copy(t).add(n),this}setFromObject(t,e=!1){return this.makeEmpty(),this.expandByObject(t,e)}clone(){return new this.constructor().copy(this)}copy(t){return this.min.copy(t.min),this.max.copy(t.max),this}makeEmpty(){return this.min.x=this.min.y=this.min.z=1/0,this.max.x=this.max.y=this.max.z=-1/0,this}isEmpty(){return this.max.x<this.min.x||this.max.y<this.min.y||this.max.z<this.min.z}getCenter(t){return this.isEmpty()?t.set(0,0,0):t.addVectors(this.min,this.max).multiplyScalar(.5)}getSize(t){return this.isEmpty()?t.set(0,0,0):t.subVectors(this.max,this.min)}expandByPoint(t){return this.min.min(t),this.max.max(t),this}expandByVector(t){return this.min.sub(t),this.max.add(t),this}expandByScalar(t){return this.min.addScalar(-t),this.max.addScalar(t),this}expandByObject(t,e=!1){t.updateWorldMatrix(!1,!1);const n=t.geometry;if(n!==void 0){const r=n.getAttribute("position");if(e===!0&&r!==void 0&&t.isInstancedMesh!==!0)for(let o=0,a=r.count;o<a;o++)t.isMesh===!0?t.getVertexPosition(o,je):je.fromBufferAttribute(r,o),je.applyMatrix4(t.matrixWorld),this.expandByPoint(je);else t.boundingBox!==void 0?(t.boundingBox===null&&t.computeBoundingBox(),As.copy(t.boundingBox)):(n.boundingBox===null&&n.computeBoundingBox(),As.copy(n.boundingBox)),As.applyMatrix4(t.matrixWorld),this.union(As)}const s=t.children;for(let r=0,o=s.length;r<o;r++)this.expandByObject(s[r],e);return this}containsPoint(t){return t.x>=this.min.x&&t.x<=this.max.x&&t.y>=this.min.y&&t.y<=this.max.y&&t.z>=this.min.z&&t.z<=this.max.z}containsBox(t){return this.min.x<=t.min.x&&t.max.x<=this.max.x&&this.min.y<=t.min.y&&t.max.y<=this.max.y&&this.min.z<=t.min.z&&t.max.z<=this.max.z}getParameter(t,e){return e.set((t.x-this.min.x)/(this.max.x-this.min.x),(t.y-this.min.y)/(this.max.y-this.min.y),(t.z-this.min.z)/(this.max.z-this.min.z))}intersectsBox(t){return t.max.x>=this.min.x&&t.min.x<=this.max.x&&t.max.y>=this.min.y&&t.min.y<=this.max.y&&t.max.z>=this.min.z&&t.min.z<=this.max.z}intersectsSphere(t){return this.clampPoint(t.center,je),je.distanceToSquared(t.center)<=t.radius*t.radius}intersectsPlane(t){let e,n;return t.normal.x>0?(e=t.normal.x*this.min.x,n=t.normal.x*this.max.x):(e=t.normal.x*this.max.x,n=t.normal.x*this.min.x),t.normal.y>0?(e+=t.normal.y*this.min.y,n+=t.normal.y*this.max.y):(e+=t.normal.y*this.max.y,n+=t.normal.y*this.min.y),t.normal.z>0?(e+=t.normal.z*this.min.z,n+=t.normal.z*this.max.z):(e+=t.normal.z*this.max.z,n+=t.normal.z*this.min.z),e<=-t.constant&&n>=-t.constant}intersectsTriangle(t){if(this.isEmpty())return!1;this.getCenter(ts),Cs.subVectors(this.max,ts),mi.subVectors(t.a,ts),gi.subVectors(t.b,ts),_i.subVectors(t.c,ts),An.subVectors(gi,mi),Cn.subVectors(_i,gi),qn.subVectors(mi,_i);let e=[0,-An.z,An.y,0,-Cn.z,Cn.y,0,-qn.z,qn.y,An.z,0,-An.x,Cn.z,0,-Cn.x,qn.z,0,-qn.x,-An.y,An.x,0,-Cn.y,Cn.x,0,-qn.y,qn.x,0];return!Or(e,mi,gi,_i,Cs)||(e=[1,0,0,0,1,0,0,0,1],!Or(e,mi,gi,_i,Cs))?!1:(Rs.crossVectors(An,Cn),e=[Rs.x,Rs.y,Rs.z],Or(e,mi,gi,_i,Cs))}clampPoint(t,e){return e.copy(t).clamp(this.min,this.max)}distanceToPoint(t){return this.clampPoint(t,je).distanceTo(t)}getBoundingSphere(t){return this.isEmpty()?t.makeEmpty():(this.getCenter(t.center),t.radius=this.getSize(je).length()*.5),t}intersect(t){return this.min.max(t.min),this.max.min(t.max),this.isEmpty()&&this.makeEmpty(),this}union(t){return this.min.min(t.min),this.max.max(t.max),this}applyMatrix4(t){return this.isEmpty()?this:(dn[0].set(this.min.x,this.min.y,this.min.z).applyMatrix4(t),dn[1].set(this.min.x,this.min.y,this.max.z).applyMatrix4(t),dn[2].set(this.min.x,this.max.y,this.min.z).applyMatrix4(t),dn[3].set(this.min.x,this.max.y,this.max.z).applyMatrix4(t),dn[4].set(this.max.x,this.min.y,this.min.z).applyMatrix4(t),dn[5].set(this.max.x,this.min.y,this.max.z).applyMatrix4(t),dn[6].set(this.max.x,this.max.y,this.min.z).applyMatrix4(t),dn[7].set(this.max.x,this.max.y,this.max.z).applyMatrix4(t),this.setFromPoints(dn),this)}translate(t){return this.min.add(t),this.max.add(t),this}equals(t){return t.min.equals(this.min)&&t.max.equals(this.max)}}const dn=[new C,new C,new C,new C,new C,new C,new C,new C],je=new C,As=new Yi,mi=new C,gi=new C,_i=new C,An=new C,Cn=new C,qn=new C,ts=new C,Cs=new C,Rs=new C,Yn=new C;function Or(i,t,e,n,s){for(let r=0,o=i.length-3;r<=o;r+=3){Yn.fromArray(i,r);const a=s.x*Math.abs(Yn.x)+s.y*Math.abs(Yn.y)+s.z*Math.abs(Yn.z),c=t.dot(Yn),l=e.dot(Yn),h=n.dot(Yn);if(Math.max(-Math.max(c,l,h),Math.min(c,l,h))>a)return!1}return!0}const qu=new Yi,es=new C,Br=new C;class Sr{constructor(t=new C,e=-1){this.isSphere=!0,this.center=t,this.radius=e}set(t,e){return this.center.copy(t),this.radius=e,this}setFromPoints(t,e){const n=this.center;e!==void 0?n.copy(e):qu.setFromPoints(t).getCenter(n);let s=0;for(let r=0,o=t.length;r<o;r++)s=Math.max(s,n.distanceToSquared(t[r]));return this.radius=Math.sqrt(s),this}copy(t){return this.center.copy(t.center),this.radius=t.radius,this}isEmpty(){return this.radius<0}makeEmpty(){return this.center.set(0,0,0),this.radius=-1,this}containsPoint(t){return t.distanceToSquared(this.center)<=this.radius*this.radius}distanceToPoint(t){return t.distanceTo(this.center)-this.radius}intersectsSphere(t){const e=this.radius+t.radius;return t.center.distanceToSquared(this.center)<=e*e}intersectsBox(t){return t.intersectsSphere(this)}intersectsPlane(t){return Math.abs(t.distanceToPoint(this.center))<=this.radius}clampPoint(t,e){const n=this.center.distanceToSquared(t);return e.copy(t),n>this.radius*this.radius&&(e.sub(this.center).normalize(),e.multiplyScalar(this.radius).add(this.center)),e}getBoundingBox(t){return this.isEmpty()?(t.makeEmpty(),t):(t.set(this.center,this.center),t.expandByScalar(this.radius),t)}applyMatrix4(t){return this.center.applyMatrix4(t),this.radius=this.radius*t.getMaxScaleOnAxis(),this}translate(t){return this.center.add(t),this}expandByPoint(t){if(this.isEmpty())return this.center.copy(t),this.radius=0,this;es.subVectors(t,this.center);const e=es.lengthSq();if(e>this.radius*this.radius){const n=Math.sqrt(e),s=(n-this.radius)*.5;this.center.addScaledVector(es,s/n),this.radius+=s}return this}union(t){return t.isEmpty()?this:this.isEmpty()?(this.copy(t),this):(this.center.equals(t.center)===!0?this.radius=Math.max(this.radius,t.radius):(Br.subVectors(t.center,this.center).setLength(t.radius),this.expandByPoint(es.copy(t.center).add(Br)),this.expandByPoint(es.copy(t.center).sub(Br))),this)}equals(t){return t.center.equals(this.center)&&t.radius===this.radius}clone(){return new this.constructor().copy(this)}}const fn=new C,zr=new C,Ps=new C,Rn=new C,Hr=new C,Ls=new C,Vr=new C;class br{constructor(t=new C,e=new C(0,0,-1)){this.origin=t,this.direction=e}set(t,e){return this.origin.copy(t),this.direction.copy(e),this}copy(t){return this.origin.copy(t.origin),this.direction.copy(t.direction),this}at(t,e){return e.copy(this.origin).addScaledVector(this.direction,t)}lookAt(t){return this.direction.copy(t).sub(this.origin).normalize(),this}recast(t){return this.origin.copy(this.at(t,fn)),this}closestPointToPoint(t,e){e.subVectors(t,this.origin);const n=e.dot(this.direction);return n<0?e.copy(this.origin):e.copy(this.origin).addScaledVector(this.direction,n)}distanceToPoint(t){return Math.sqrt(this.distanceSqToPoint(t))}distanceSqToPoint(t){const e=fn.subVectors(t,this.origin).dot(this.direction);return e<0?this.origin.distanceToSquared(t):(fn.copy(this.origin).addScaledVector(this.direction,e),fn.distanceToSquared(t))}distanceSqToSegment(t,e,n,s){zr.copy(t).add(e).multiplyScalar(.5),Ps.copy(e).sub(t).normalize(),Rn.copy(this.origin).sub(zr);const r=t.distanceTo(e)*.5,o=-this.direction.dot(Ps),a=Rn.dot(this.direction),c=-Rn.dot(Ps),l=Rn.lengthSq(),h=Math.abs(1-o*o);let d,u,f,g;if(h>0)if(d=o*c-a,u=o*a-c,g=r*h,d>=0)if(u>=-g)if(u<=g){const _=1/h;d*=_,u*=_,f=d*(d+o*u+2*a)+u*(o*d+u+2*c)+l}else u=r,d=Math.max(0,-(o*u+a)),f=-d*d+u*(u+2*c)+l;else u=-r,d=Math.max(0,-(o*u+a)),f=-d*d+u*(u+2*c)+l;else u<=-g?(d=Math.max(0,-(-o*r+a)),u=d>0?-r:Math.min(Math.max(-r,-c),r),f=-d*d+u*(u+2*c)+l):u<=g?(d=0,u=Math.min(Math.max(-r,-c),r),f=u*(u+2*c)+l):(d=Math.max(0,-(o*r+a)),u=d>0?r:Math.min(Math.max(-r,-c),r),f=-d*d+u*(u+2*c)+l);else u=o>0?-r:r,d=Math.max(0,-(o*u+a)),f=-d*d+u*(u+2*c)+l;return n&&n.copy(this.origin).addScaledVector(this.direction,d),s&&s.copy(zr).addScaledVector(Ps,u),f}intersectSphere(t,e){fn.subVectors(t.center,this.origin);const n=fn.dot(this.direction),s=fn.dot(fn)-n*n,r=t.radius*t.radius;if(s>r)return null;const o=Math.sqrt(r-s),a=n-o,c=n+o;return c<0?null:a<0?this.at(c,e):this.at(a,e)}intersectsSphere(t){return this.distanceSqToPoint(t.center)<=t.radius*t.radius}distanceToPlane(t){const e=t.normal.dot(this.direction);if(e===0)return t.distanceToPoint(this.origin)===0?0:null;const n=-(this.origin.dot(t.normal)+t.constant)/e;return n>=0?n:null}intersectPlane(t,e){const n=this.distanceToPlane(t);return n===null?null:this.at(n,e)}intersectsPlane(t){const e=t.distanceToPoint(this.origin);return e===0||t.normal.dot(this.direction)*e<0}intersectBox(t,e){let n,s,r,o,a,c;const l=1/this.direction.x,h=1/this.direction.y,d=1/this.direction.z,u=this.origin;return l>=0?(n=(t.min.x-u.x)*l,s=(t.max.x-u.x)*l):(n=(t.max.x-u.x)*l,s=(t.min.x-u.x)*l),h>=0?(r=(t.min.y-u.y)*h,o=(t.max.y-u.y)*h):(r=(t.max.y-u.y)*h,o=(t.min.y-u.y)*h),n>o||r>s||((r>n||isNaN(n))&&(n=r),(o<s||isNaN(s))&&(s=o),d>=0?(a=(t.min.z-u.z)*d,c=(t.max.z-u.z)*d):(a=(t.max.z-u.z)*d,c=(t.min.z-u.z)*d),n>c||a>s)||((a>n||n!==n)&&(n=a),(c<s||s!==s)&&(s=c),s<0)?null:this.at(n>=0?n:s,e)}intersectsBox(t){return this.intersectBox(t,fn)!==null}intersectTriangle(t,e,n,s,r){Hr.subVectors(e,t),Ls.subVectors(n,t),Vr.crossVectors(Hr,Ls);let o=this.direction.dot(Vr),a;if(o>0){if(s)return null;a=1}else if(o<0)a=-1,o=-o;else return null;Rn.subVectors(this.origin,t);const c=a*this.direction.dot(Ls.crossVectors(Rn,Ls));if(c<0)return null;const l=a*this.direction.dot(Hr.cross(Rn));if(l<0||c+l>o)return null;const h=-a*Rn.dot(Vr);return h<0?null:this.at(h/o,r)}applyMatrix4(t){return this.origin.applyMatrix4(t),this.direction.transformDirection(t),this}equals(t){return t.origin.equals(this.origin)&&t.direction.equals(this.direction)}clone(){return new this.constructor().copy(this)}}class re{constructor(t,e,n,s,r,o,a,c,l,h,d,u,f,g,_,p){re.prototype.isMatrix4=!0,this.elements=[1,0,0,0,0,1,0,0,0,0,1,0,0,0,0,1],t!==void 0&&this.set(t,e,n,s,r,o,a,c,l,h,d,u,f,g,_,p)}set(t,e,n,s,r,o,a,c,l,h,d,u,f,g,_,p){const m=this.elements;return m[0]=t,m[4]=e,m[8]=n,m[12]=s,m[1]=r,m[5]=o,m[9]=a,m[13]=c,m[2]=l,m[6]=h,m[10]=d,m[14]=u,m[3]=f,m[7]=g,m[11]=_,m[15]=p,this}identity(){return this.set(1,0,0,0,0,1,0,0,0,0,1,0,0,0,0,1),this}clone(){return new re().fromArray(this.elements)}copy(t){const e=this.elements,n=t.elements;return e[0]=n[0],e[1]=n[1],e[2]=n[2],e[3]=n[3],e[4]=n[4],e[5]=n[5],e[6]=n[6],e[7]=n[7],e[8]=n[8],e[9]=n[9],e[10]=n[10],e[11]=n[11],e[12]=n[12],e[13]=n[13],e[14]=n[14],e[15]=n[15],this}copyPosition(t){const e=this.elements,n=t.elements;return e[12]=n[12],e[13]=n[13],e[14]=n[14],this}setFromMatrix3(t){const e=t.elements;return this.set(e[0],e[3],e[6],0,e[1],e[4],e[7],0,e[2],e[5],e[8],0,0,0,0,1),this}extractBasis(t,e,n){return t.setFromMatrixColumn(this,0),e.setFromMatrixColumn(this,1),n.setFromMatrixColumn(this,2),this}makeBasis(t,e,n){return this.set(t.x,e.x,n.x,0,t.y,e.y,n.y,0,t.z,e.z,n.z,0,0,0,0,1),this}extractRotation(t){const e=this.elements,n=t.elements,s=1/vi.setFromMatrixColumn(t,0).length(),r=1/vi.setFromMatrixColumn(t,1).length(),o=1/vi.setFromMatrixColumn(t,2).length();return e[0]=n[0]*s,e[1]=n[1]*s,e[2]=n[2]*s,e[3]=0,e[4]=n[4]*r,e[5]=n[5]*r,e[6]=n[6]*r,e[7]=0,e[8]=n[8]*o,e[9]=n[9]*o,e[10]=n[10]*o,e[11]=0,e[12]=0,e[13]=0,e[14]=0,e[15]=1,this}makeRotationFromEuler(t){const e=this.elements,n=t.x,s=t.y,r=t.z,o=Math.cos(n),a=Math.sin(n),c=Math.cos(s),l=Math.sin(s),h=Math.cos(r),d=Math.sin(r);if(t.order==="XYZ"){const u=o*h,f=o*d,g=a*h,_=a*d;e[0]=c*h,e[4]=-c*d,e[8]=l,e[1]=f+g*l,e[5]=u-_*l,e[9]=-a*c,e[2]=_-u*l,e[6]=g+f*l,e[10]=o*c}else if(t.order==="YXZ"){const u=c*h,f=c*d,g=l*h,_=l*d;e[0]=u+_*a,e[4]=g*a-f,e[8]=o*l,e[1]=o*d,e[5]=o*h,e[9]=-a,e[2]=f*a-g,e[6]=_+u*a,e[10]=o*c}else if(t.order==="ZXY"){const u=c*h,f=c*d,g=l*h,_=l*d;e[0]=u-_*a,e[4]=-o*d,e[8]=g+f*a,e[1]=f+g*a,e[5]=o*h,e[9]=_-u*a,e[2]=-o*l,e[6]=a,e[10]=o*c}else if(t.order==="ZYX"){const u=o*h,f=o*d,g=a*h,_=a*d;e[0]=c*h,e[4]=g*l-f,e[8]=u*l+_,e[1]=c*d,e[5]=_*l+u,e[9]=f*l-g,e[2]=-l,e[6]=a*c,e[10]=o*c}else if(t.order==="YZX"){const u=o*c,f=o*l,g=a*c,_=a*l;e[0]=c*h,e[4]=_-u*d,e[8]=g*d+f,e[1]=d,e[5]=o*h,e[9]=-a*h,e[2]=-l*h,e[6]=f*d+g,e[10]=u-_*d}else if(t.order==="XZY"){const u=o*c,f=o*l,g=a*c,_=a*l;e[0]=c*h,e[4]=-d,e[8]=l*h,e[1]=u*d+_,e[5]=o*h,e[9]=f*d-g,e[2]=g*d-f,e[6]=a*h,e[10]=_*d+u}return e[3]=0,e[7]=0,e[11]=0,e[12]=0,e[13]=0,e[14]=0,e[15]=1,this}makeRotationFromQuaternion(t){return this.compose(Yu,t,Ku)}lookAt(t,e,n){const s=this.elements;return Oe.subVectors(t,e),Oe.lengthSq()===0&&(Oe.z=1),Oe.normalize(),Pn.crossVectors(n,Oe),Pn.lengthSq()===0&&(Math.abs(n.z)===1?Oe.x+=1e-4:Oe.z+=1e-4,Oe.normalize(),Pn.crossVectors(n,Oe)),Pn.normalize(),Ds.crossVectors(Oe,Pn),s[0]=Pn.x,s[4]=Ds.x,s[8]=Oe.x,s[1]=Pn.y,s[5]=Ds.y,s[9]=Oe.y,s[2]=Pn.z,s[6]=Ds.z,s[10]=Oe.z,this}multiply(t){return this.multiplyMatrices(this,t)}premultiply(t){return this.multiplyMatrices(t,this)}multiplyMatrices(t,e){const n=t.elements,s=e.elements,r=this.elements,o=n[0],a=n[4],c=n[8],l=n[12],h=n[1],d=n[5],u=n[9],f=n[13],g=n[2],_=n[6],p=n[10],m=n[14],w=n[3],x=n[7],b=n[11],I=n[15],R=s[0],A=s[4],P=s[8],W=s[12],v=s[1],S=s[5],F=s[9],N=s[13],H=s[2],X=s[6],z=s[10],J=s[14],G=s[3],ht=s[7],ft=s[11],pt=s[15];return r[0]=o*R+a*v+c*H+l*G,r[4]=o*A+a*S+c*X+l*ht,r[8]=o*P+a*F+c*z+l*ft,r[12]=o*W+a*N+c*J+l*pt,r[1]=h*R+d*v+u*H+f*G,r[5]=h*A+d*S+u*X+f*ht,r[9]=h*P+d*F+u*z+f*ft,r[13]=h*W+d*N+u*J+f*pt,r[2]=g*R+_*v+p*H+m*G,r[6]=g*A+_*S+p*X+m*ht,r[10]=g*P+_*F+p*z+m*ft,r[14]=g*W+_*N+p*J+m*pt,r[3]=w*R+x*v+b*H+I*G,r[7]=w*A+x*S+b*X+I*ht,r[11]=w*P+x*F+b*z+I*ft,r[15]=w*W+x*N+b*J+I*pt,this}multiplyScalar(t){const e=this.elements;return e[0]*=t,e[4]*=t,e[8]*=t,e[12]*=t,e[1]*=t,e[5]*=t,e[9]*=t,e[13]*=t,e[2]*=t,e[6]*=t,e[10]*=t,e[14]*=t,e[3]*=t,e[7]*=t,e[11]*=t,e[15]*=t,this}determinant(){const t=this.elements,e=t[0],n=t[4],s=t[8],r=t[12],o=t[1],a=t[5],c=t[9],l=t[13],h=t[2],d=t[6],u=t[10],f=t[14],g=t[3],_=t[7],p=t[11],m=t[15];return g*(+r*c*d-s*l*d-r*a*u+n*l*u+s*a*f-n*c*f)+_*(+e*c*f-e*l*u+r*o*u-s*o*f+s*l*h-r*c*h)+p*(+e*l*d-e*a*f-r*o*d+n*o*f+r*a*h-n*l*h)+m*(-s*a*h-e*c*d+e*a*u+s*o*d-n*o*u+n*c*h)}transpose(){const t=this.elements;let e;return e=t[1],t[1]=t[4],t[4]=e,e=t[2],t[2]=t[8],t[8]=e,e=t[6],t[6]=t[9],t[9]=e,e=t[3],t[3]=t[12],t[12]=e,e=t[7],t[7]=t[13],t[13]=e,e=t[11],t[11]=t[14],t[14]=e,this}setPosition(t,e,n){const s=this.elements;return t.isVector3?(s[12]=t.x,s[13]=t.y,s[14]=t.z):(s[12]=t,s[13]=e,s[14]=n),this}invert(){const t=this.elements,e=t[0],n=t[1],s=t[2],r=t[3],o=t[4],a=t[5],c=t[6],l=t[7],h=t[8],d=t[9],u=t[10],f=t[11],g=t[12],_=t[13],p=t[14],m=t[15],w=d*p*l-_*u*l+_*c*f-a*p*f-d*c*m+a*u*m,x=g*u*l-h*p*l-g*c*f+o*p*f+h*c*m-o*u*m,b=h*_*l-g*d*l+g*a*f-o*_*f-h*a*m+o*d*m,I=g*d*c-h*_*c-g*a*u+o*_*u+h*a*p-o*d*p,R=e*w+n*x+s*b+r*I;if(R===0)return this.set(0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0);const A=1/R;return t[0]=w*A,t[1]=(_*u*r-d*p*r-_*s*f+n*p*f+d*s*m-n*u*m)*A,t[2]=(a*p*r-_*c*r+_*s*l-n*p*l-a*s*m+n*c*m)*A,t[3]=(d*c*r-a*u*r-d*s*l+n*u*l+a*s*f-n*c*f)*A,t[4]=x*A,t[5]=(h*p*r-g*u*r+g*s*f-e*p*f-h*s*m+e*u*m)*A,t[6]=(g*c*r-o*p*r-g*s*l+e*p*l+o*s*m-e*c*m)*A,t[7]=(o*u*r-h*c*r+h*s*l-e*u*l-o*s*f+e*c*f)*A,t[8]=b*A,t[9]=(g*d*r-h*_*r-g*n*f+e*_*f+h*n*m-e*d*m)*A,t[10]=(o*_*r-g*a*r+g*n*l-e*_*l-o*n*m+e*a*m)*A,t[11]=(h*a*r-o*d*r-h*n*l+e*d*l+o*n*f-e*a*f)*A,t[12]=I*A,t[13]=(h*_*s-g*d*s+g*n*u-e*_*u-h*n*p+e*d*p)*A,t[14]=(g*a*s-o*_*s-g*n*c+e*_*c+o*n*p-e*a*p)*A,t[15]=(o*d*s-h*a*s+h*n*c-e*d*c-o*n*u+e*a*u)*A,this}scale(t){const e=this.elements,n=t.x,s=t.y,r=t.z;return e[0]*=n,e[4]*=s,e[8]*=r,e[1]*=n,e[5]*=s,e[9]*=r,e[2]*=n,e[6]*=s,e[10]*=r,e[3]*=n,e[7]*=s,e[11]*=r,this}getMaxScaleOnAxis(){const t=this.elements,e=t[0]*t[0]+t[1]*t[1]+t[2]*t[2],n=t[4]*t[4]+t[5]*t[5]+t[6]*t[6],s=t[8]*t[8]+t[9]*t[9]+t[10]*t[10];return Math.sqrt(Math.max(e,n,s))}makeTranslation(t,e,n){return t.isVector3?this.set(1,0,0,t.x,0,1,0,t.y,0,0,1,t.z,0,0,0,1):this.set(1,0,0,t,0,1,0,e,0,0,1,n,0,0,0,1),this}makeRotationX(t){const e=Math.cos(t),n=Math.sin(t);return this.set(1,0,0,0,0,e,-n,0,0,n,e,0,0,0,0,1),this}makeRotationY(t){const e=Math.cos(t),n=Math.sin(t);return this.set(e,0,n,0,0,1,0,0,-n,0,e,0,0,0,0,1),this}makeRotationZ(t){const e=Math.cos(t),n=Math.sin(t);return this.set(e,-n,0,0,n,e,0,0,0,0,1,0,0,0,0,1),this}makeRotationAxis(t,e){const n=Math.cos(e),s=Math.sin(e),r=1-n,o=t.x,a=t.y,c=t.z,l=r*o,h=r*a;return this.set(l*o+n,l*a-s*c,l*c+s*a,0,l*a+s*c,h*a+n,h*c-s*o,0,l*c-s*a,h*c+s*o,r*c*c+n,0,0,0,0,1),this}makeScale(t,e,n){return this.set(t,0,0,0,0,e,0,0,0,0,n,0,0,0,0,1),this}makeShear(t,e,n,s,r,o){return this.set(1,n,r,0,t,1,o,0,e,s,1,0,0,0,0,1),this}compose(t,e,n){const s=this.elements,r=e._x,o=e._y,a=e._z,c=e._w,l=r+r,h=o+o,d=a+a,u=r*l,f=r*h,g=r*d,_=o*h,p=o*d,m=a*d,w=c*l,x=c*h,b=c*d,I=n.x,R=n.y,A=n.z;return s[0]=(1-(_+m))*I,s[1]=(f+b)*I,s[2]=(g-x)*I,s[3]=0,s[4]=(f-b)*R,s[5]=(1-(u+m))*R,s[6]=(p+w)*R,s[7]=0,s[8]=(g+x)*A,s[9]=(p-w)*A,s[10]=(1-(u+_))*A,s[11]=0,s[12]=t.x,s[13]=t.y,s[14]=t.z,s[15]=1,this}decompose(t,e,n){const s=this.elements;let r=vi.set(s[0],s[1],s[2]).length();const o=vi.set(s[4],s[5],s[6]).length(),a=vi.set(s[8],s[9],s[10]).length();this.determinant()<0&&(r=-r),t.x=s[12],t.y=s[13],t.z=s[14],Je.copy(this);const l=1/r,h=1/o,d=1/a;return Je.elements[0]*=l,Je.elements[1]*=l,Je.elements[2]*=l,Je.elements[4]*=h,Je.elements[5]*=h,Je.elements[6]*=h,Je.elements[8]*=d,Je.elements[9]*=d,Je.elements[10]*=d,e.setFromRotationMatrix(Je),n.x=r,n.y=o,n.z=a,this}makePerspective(t,e,n,s,r,o,a=yn){const c=this.elements,l=2*r/(e-t),h=2*r/(n-s),d=(e+t)/(e-t),u=(n+s)/(n-s);let f,g;if(a===yn)f=-(o+r)/(o-r),g=-2*o*r/(o-r);else if(a===pr)f=-o/(o-r),g=-o*r/(o-r);else throw new Error("THREE.Matrix4.makePerspective(): Invalid coordinate system: "+a);return c[0]=l,c[4]=0,c[8]=d,c[12]=0,c[1]=0,c[5]=h,c[9]=u,c[13]=0,c[2]=0,c[6]=0,c[10]=f,c[14]=g,c[3]=0,c[7]=0,c[11]=-1,c[15]=0,this}makeOrthographic(t,e,n,s,r,o,a=yn){const c=this.elements,l=1/(e-t),h=1/(n-s),d=1/(o-r),u=(e+t)*l,f=(n+s)*h;let g,_;if(a===yn)g=(o+r)*d,_=-2*d;else if(a===pr)g=r*d,_=-1*d;else throw new Error("THREE.Matrix4.makeOrthographic(): Invalid coordinate system: "+a);return c[0]=2*l,c[4]=0,c[8]=0,c[12]=-u,c[1]=0,c[5]=2*h,c[9]=0,c[13]=-f,c[2]=0,c[6]=0,c[10]=_,c[14]=-g,c[3]=0,c[7]=0,c[11]=0,c[15]=1,this}equals(t){const e=this.elements,n=t.elements;for(let s=0;s<16;s++)if(e[s]!==n[s])return!1;return!0}fromArray(t,e=0){for(let n=0;n<16;n++)this.elements[n]=t[n+e];return this}toArray(t=[],e=0){const n=this.elements;return t[e]=n[0],t[e+1]=n[1],t[e+2]=n[2],t[e+3]=n[3],t[e+4]=n[4],t[e+5]=n[5],t[e+6]=n[6],t[e+7]=n[7],t[e+8]=n[8],t[e+9]=n[9],t[e+10]=n[10],t[e+11]=n[11],t[e+12]=n[12],t[e+13]=n[13],t[e+14]=n[14],t[e+15]=n[15],t}}const vi=new C,Je=new re,Yu=new C(0,0,0),Ku=new C(1,1,1),Pn=new C,Ds=new C,Oe=new C,cc=new re,lc=new En;class on{constructor(t=0,e=0,n=0,s=on.DEFAULT_ORDER){this.isEuler=!0,this._x=t,this._y=e,this._z=n,this._order=s}get x(){return this._x}set x(t){this._x=t,this._onChangeCallback()}get y(){return this._y}set y(t){this._y=t,this._onChangeCallback()}get z(){return this._z}set z(t){this._z=t,this._onChangeCallback()}get order(){return this._order}set order(t){this._order=t,this._onChangeCallback()}set(t,e,n,s=this._order){return this._x=t,this._y=e,this._z=n,this._order=s,this._onChangeCallback(),this}clone(){return new this.constructor(this._x,this._y,this._z,this._order)}copy(t){return this._x=t._x,this._y=t._y,this._z=t._z,this._order=t._order,this._onChangeCallback(),this}setFromRotationMatrix(t,e=this._order,n=!0){const s=t.elements,r=s[0],o=s[4],a=s[8],c=s[1],l=s[5],h=s[9],d=s[2],u=s[6],f=s[10];switch(e){case"XYZ":this._y=Math.asin(ye(a,-1,1)),Math.abs(a)<.9999999?(this._x=Math.atan2(-h,f),this._z=Math.atan2(-o,r)):(this._x=Math.atan2(u,l),this._z=0);break;case"YXZ":this._x=Math.asin(-ye(h,-1,1)),Math.abs(h)<.9999999?(this._y=Math.atan2(a,f),this._z=Math.atan2(c,l)):(this._y=Math.atan2(-d,r),this._z=0);break;case"ZXY":this._x=Math.asin(ye(u,-1,1)),Math.abs(u)<.9999999?(this._y=Math.atan2(-d,f),this._z=Math.atan2(-o,l)):(this._y=0,this._z=Math.atan2(c,r));break;case"ZYX":this._y=Math.asin(-ye(d,-1,1)),Math.abs(d)<.9999999?(this._x=Math.atan2(u,f),this._z=Math.atan2(c,r)):(this._x=0,this._z=Math.atan2(-o,l));break;case"YZX":this._z=Math.asin(ye(c,-1,1)),Math.abs(c)<.9999999?(this._x=Math.atan2(-h,l),this._y=Math.atan2(-d,r)):(this._x=0,this._y=Math.atan2(a,f));break;case"XZY":this._z=Math.asin(-ye(o,-1,1)),Math.abs(o)<.9999999?(this._x=Math.atan2(u,l),this._y=Math.atan2(a,r)):(this._x=Math.atan2(-h,f),this._y=0);break;default:console.warn("THREE.Euler: .setFromRotationMatrix() encountered an unknown order: "+e)}return this._order=e,n===!0&&this._onChangeCallback(),this}setFromQuaternion(t,e,n){return cc.makeRotationFromQuaternion(t),this.setFromRotationMatrix(cc,e,n)}setFromVector3(t,e=this._order){return this.set(t.x,t.y,t.z,e)}reorder(t){return lc.setFromEuler(this),this.setFromQuaternion(lc,t)}equals(t){return t._x===this._x&&t._y===this._y&&t._z===this._z&&t._order===this._order}fromArray(t){return this._x=t[0],this._y=t[1],this._z=t[2],t[3]!==void 0&&(this._order=t[3]),this._onChangeCallback(),this}toArray(t=[],e=0){return t[e]=this._x,t[e+1]=this._y,t[e+2]=this._z,t[e+3]=this._order,t}_onChange(t){return this._onChangeCallback=t,this}_onChangeCallback(){}*[Symbol.iterator](){yield this._x,yield this._y,yield this._z,yield this._order}}on.DEFAULT_ORDER="XYZ";class Ca{constructor(){this.mask=1}set(t){this.mask=(1<<t|0)>>>0}enable(t){this.mask|=1<<t|0}enableAll(){this.mask=-1}toggle(t){this.mask^=1<<t|0}disable(t){this.mask&=~(1<<t|0)}disableAll(){this.mask=0}test(t){return(this.mask&t.mask)!==0}isEnabled(t){return(this.mask&(1<<t|0))!==0}}let Zu=0;const hc=new C,xi=new En,pn=new re,Is=new C,ns=new C,ju=new C,Ju=new En,uc=new C(1,0,0),dc=new C(0,1,0),fc=new C(0,0,1),pc={type:"added"},Qu={type:"removed"},yi={type:"childadded",child:null},Gr={type:"childremoved",child:null};class Me extends hi{constructor(){super(),this.isObject3D=!0,Object.defineProperty(this,"id",{value:Zu++}),this.uuid=ui(),this.name="",this.type="Object3D",this.parent=null,this.children=[],this.up=Me.DEFAULT_UP.clone();const t=new C,e=new on,n=new En,s=new C(1,1,1);function r(){n.setFromEuler(e,!1)}function o(){e.setFromQuaternion(n,void 0,!1)}e._onChange(r),n._onChange(o),Object.defineProperties(this,{position:{configurable:!0,enumerable:!0,value:t},rotation:{configurable:!0,enumerable:!0,value:e},quaternion:{configurable:!0,enumerable:!0,value:n},scale:{configurable:!0,enumerable:!0,value:s},modelViewMatrix:{value:new re},normalMatrix:{value:new Vt}}),this.matrix=new re,this.matrixWorld=new re,this.matrixAutoUpdate=Me.DEFAULT_MATRIX_AUTO_UPDATE,this.matrixWorldAutoUpdate=Me.DEFAULT_MATRIX_WORLD_AUTO_UPDATE,this.matrixWorldNeedsUpdate=!1,this.layers=new Ca,this.visible=!0,this.castShadow=!1,this.receiveShadow=!1,this.frustumCulled=!0,this.renderOrder=0,this.animations=[],this.userData={}}onBeforeShadow(){}onAfterShadow(){}onBeforeRender(){}onAfterRender(){}applyMatrix4(t){this.matrixAutoUpdate&&this.updateMatrix(),this.matrix.premultiply(t),this.matrix.decompose(this.position,this.quaternion,this.scale)}applyQuaternion(t){return this.quaternion.premultiply(t),this}setRotationFromAxisAngle(t,e){this.quaternion.setFromAxisAngle(t,e)}setRotationFromEuler(t){this.quaternion.setFromEuler(t,!0)}setRotationFromMatrix(t){this.quaternion.setFromRotationMatrix(t)}setRotationFromQuaternion(t){this.quaternion.copy(t)}rotateOnAxis(t,e){return xi.setFromAxisAngle(t,e),this.quaternion.multiply(xi),this}rotateOnWorldAxis(t,e){return xi.setFromAxisAngle(t,e),this.quaternion.premultiply(xi),this}rotateX(t){return this.rotateOnAxis(uc,t)}rotateY(t){return this.rotateOnAxis(dc,t)}rotateZ(t){return this.rotateOnAxis(fc,t)}translateOnAxis(t,e){return hc.copy(t).applyQuaternion(this.quaternion),this.position.add(hc.multiplyScalar(e)),this}translateX(t){return this.translateOnAxis(uc,t)}translateY(t){return this.translateOnAxis(dc,t)}translateZ(t){return this.translateOnAxis(fc,t)}localToWorld(t){return this.updateWorldMatrix(!0,!1),t.applyMatrix4(this.matrixWorld)}worldToLocal(t){return this.updateWorldMatrix(!0,!1),t.applyMatrix4(pn.copy(this.matrixWorld).invert())}lookAt(t,e,n){t.isVector3?Is.copy(t):Is.set(t,e,n);const s=this.parent;this.updateWorldMatrix(!0,!1),ns.setFromMatrixPosition(this.matrixWorld),this.isCamera||this.isLight?pn.lookAt(ns,Is,this.up):pn.lookAt(Is,ns,this.up),this.quaternion.setFromRotationMatrix(pn),s&&(pn.extractRotation(s.matrixWorld),xi.setFromRotationMatrix(pn),this.quaternion.premultiply(xi.invert()))}add(t){if(arguments.length>1){for(let e=0;e<arguments.length;e++)this.add(arguments[e]);return this}return t===this?(console.error("THREE.Object3D.add: object can't be added as a child of itself.",t),this):(t&&t.isObject3D?(t.removeFromParent(),t.parent=this,this.children.push(t),t.dispatchEvent(pc),yi.child=t,this.dispatchEvent(yi),yi.child=null):console.error("THREE.Object3D.add: object not an instance of THREE.Object3D.",t),this)}remove(t){if(arguments.length>1){for(let n=0;n<arguments.length;n++)this.remove(arguments[n]);return this}const e=this.children.indexOf(t);return e!==-1&&(t.parent=null,this.children.splice(e,1),t.dispatchEvent(Qu),Gr.child=t,this.dispatchEvent(Gr),Gr.child=null),this}removeFromParent(){const t=this.parent;return t!==null&&t.remove(this),this}clear(){return this.remove(...this.children)}attach(t){return this.updateWorldMatrix(!0,!1),pn.copy(this.matrixWorld).invert(),t.parent!==null&&(t.parent.updateWorldMatrix(!0,!1),pn.multiply(t.parent.matrixWorld)),t.applyMatrix4(pn),t.removeFromParent(),t.parent=this,this.children.push(t),t.updateWorldMatrix(!1,!0),t.dispatchEvent(pc),yi.child=t,this.dispatchEvent(yi),yi.child=null,this}getObjectById(t){return this.getObjectByProperty("id",t)}getObjectByName(t){return this.getObjectByProperty("name",t)}getObjectByProperty(t,e){if(this[t]===e)return this;for(let n=0,s=this.children.length;n<s;n++){const o=this.children[n].getObjectByProperty(t,e);if(o!==void 0)return o}}getObjectsByProperty(t,e,n=[]){this[t]===e&&n.push(this);const s=this.children;for(let r=0,o=s.length;r<o;r++)s[r].getObjectsByProperty(t,e,n);return n}getWorldPosition(t){return this.updateWorldMatrix(!0,!1),t.setFromMatrixPosition(this.matrixWorld)}getWorldQuaternion(t){return this.updateWorldMatrix(!0,!1),this.matrixWorld.decompose(ns,t,ju),t}getWorldScale(t){return this.updateWorldMatrix(!0,!1),this.matrixWorld.decompose(ns,Ju,t),t}getWorldDirection(t){this.updateWorldMatrix(!0,!1);const e=this.matrixWorld.elements;return t.set(e[8],e[9],e[10]).normalize()}raycast(){}traverse(t){t(this);const e=this.children;for(let n=0,s=e.length;n<s;n++)e[n].traverse(t)}traverseVisible(t){if(this.visible===!1)return;t(this);const e=this.children;for(let n=0,s=e.length;n<s;n++)e[n].traverseVisible(t)}traverseAncestors(t){const e=this.parent;e!==null&&(t(e),e.traverseAncestors(t))}updateMatrix(){this.matrix.compose(this.position,this.quaternion,this.scale),this.matrixWorldNeedsUpdate=!0}updateMatrixWorld(t){this.matrixAutoUpdate&&this.updateMatrix(),(this.matrixWorldNeedsUpdate||t)&&(this.matrixWorldAutoUpdate===!0&&(this.parent===null?this.matrixWorld.copy(this.matrix):this.matrixWorld.multiplyMatrices(this.parent.matrixWorld,this.matrix)),this.matrixWorldNeedsUpdate=!1,t=!0);const e=this.children;for(let n=0,s=e.length;n<s;n++)e[n].updateMatrixWorld(t)}updateWorldMatrix(t,e){const n=this.parent;if(t===!0&&n!==null&&n.updateWorldMatrix(!0,!1),this.matrixAutoUpdate&&this.updateMatrix(),this.matrixWorldAutoUpdate===!0&&(this.parent===null?this.matrixWorld.copy(this.matrix):this.matrixWorld.multiplyMatrices(this.parent.matrixWorld,this.matrix)),e===!0){const s=this.children;for(let r=0,o=s.length;r<o;r++)s[r].updateWorldMatrix(!1,!0)}}toJSON(t){const e=t===void 0||typeof t=="string",n={};e&&(t={geometries:{},materials:{},textures:{},images:{},shapes:{},skeletons:{},animations:{},nodes:{}},n.metadata={version:4.6,type:"Object",generator:"Object3D.toJSON"});const s={};s.uuid=this.uuid,s.type=this.type,this.name!==""&&(s.name=this.name),this.castShadow===!0&&(s.castShadow=!0),this.receiveShadow===!0&&(s.receiveShadow=!0),this.visible===!1&&(s.visible=!1),this.frustumCulled===!1&&(s.frustumCulled=!1),this.renderOrder!==0&&(s.renderOrder=this.renderOrder),Object.keys(this.userData).length>0&&(s.userData=this.userData),s.layers=this.layers.mask,s.matrix=this.matrix.toArray(),s.up=this.up.toArray(),this.matrixAutoUpdate===!1&&(s.matrixAutoUpdate=!1),this.isInstancedMesh&&(s.type="InstancedMesh",s.count=this.count,s.instanceMatrix=this.instanceMatrix.toJSON(),this.instanceColor!==null&&(s.instanceColor=this.instanceColor.toJSON())),this.isBatchedMesh&&(s.type="BatchedMesh",s.perObjectFrustumCulled=this.perObjectFrustumCulled,s.sortObjects=this.sortObjects,s.drawRanges=this._drawRanges,s.reservedRanges=this._reservedRanges,s.visibility=this._visibility,s.active=this._active,s.bounds=this._bounds.map(a=>({boxInitialized:a.boxInitialized,boxMin:a.box.min.toArray(),boxMax:a.box.max.toArray(),sphereInitialized:a.sphereInitialized,sphereRadius:a.sphere.radius,sphereCenter:a.sphere.center.toArray()})),s.maxInstanceCount=this._maxInstanceCount,s.maxVertexCount=this._maxVertexCount,s.maxIndexCount=this._maxIndexCount,s.geometryInitialized=this._geometryInitialized,s.geometryCount=this._geometryCount,s.matricesTexture=this._matricesTexture.toJSON(t),this._colorsTexture!==null&&(s.colorsTexture=this._colorsTexture.toJSON(t)),this.boundingSphere!==null&&(s.boundingSphere={center:s.boundingSphere.center.toArray(),radius:s.boundingSphere.radius}),this.boundingBox!==null&&(s.boundingBox={min:s.boundingBox.min.toArray(),max:s.boundingBox.max.toArray()}));function r(a,c){return a[c.uuid]===void 0&&(a[c.uuid]=c.toJSON(t)),c.uuid}if(this.isScene)this.background&&(this.background.isColor?s.background=this.background.toJSON():this.background.isTexture&&(s.background=this.background.toJSON(t).uuid)),this.environment&&this.environment.isTexture&&this.environment.isRenderTargetTexture!==!0&&(s.environment=this.environment.toJSON(t).uuid);else if(this.isMesh||this.isLine||this.isPoints){s.geometry=r(t.geometries,this.geometry);const a=this.geometry.parameters;if(a!==void 0&&a.shapes!==void 0){const c=a.shapes;if(Array.isArray(c))for(let l=0,h=c.length;l<h;l++){const d=c[l];r(t.shapes,d)}else r(t.shapes,c)}}if(this.isSkinnedMesh&&(s.bindMode=this.bindMode,s.bindMatrix=this.bindMatrix.toArray(),this.skeleton!==void 0&&(r(t.skeletons,this.skeleton),s.skeleton=this.skeleton.uuid)),this.material!==void 0)if(Array.isArray(this.material)){const a=[];for(let c=0,l=this.material.length;c<l;c++)a.push(r(t.materials,this.material[c]));s.material=a}else s.material=r(t.materials,this.material);if(this.children.length>0){s.children=[];for(let a=0;a<this.children.length;a++)s.children.push(this.children[a].toJSON(t).object)}if(this.animations.length>0){s.animations=[];for(let a=0;a<this.animations.length;a++){const c=this.animations[a];s.animations.push(r(t.animations,c))}}if(e){const a=o(t.geometries),c=o(t.materials),l=o(t.textures),h=o(t.images),d=o(t.shapes),u=o(t.skeletons),f=o(t.animations),g=o(t.nodes);a.length>0&&(n.geometries=a),c.length>0&&(n.materials=c),l.length>0&&(n.textures=l),h.length>0&&(n.images=h),d.length>0&&(n.shapes=d),u.length>0&&(n.skeletons=u),f.length>0&&(n.animations=f),g.length>0&&(n.nodes=g)}return n.object=s,n;function o(a){const c=[];for(const l in a){const h=a[l];delete h.metadata,c.push(h)}return c}}clone(t){return new this.constructor().copy(this,t)}copy(t,e=!0){if(this.name=t.name,this.up.copy(t.up),this.position.copy(t.position),this.rotation.order=t.rotation.order,this.quaternion.copy(t.quaternion),this.scale.copy(t.scale),this.matrix.copy(t.matrix),this.matrixWorld.copy(t.matrixWorld),this.matrixAutoUpdate=t.matrixAutoUpdate,this.matrixWorldAutoUpdate=t.matrixWorldAutoUpdate,this.matrixWorldNeedsUpdate=t.matrixWorldNeedsUpdate,this.layers.mask=t.layers.mask,this.visible=t.visible,this.castShadow=t.castShadow,this.receiveShadow=t.receiveShadow,this.frustumCulled=t.frustumCulled,this.renderOrder=t.renderOrder,this.animations=t.animations.slice(),this.userData=JSON.parse(JSON.stringify(t.userData)),e===!0)for(let n=0;n<t.children.length;n++){const s=t.children[n];this.add(s.clone())}return this}}Me.DEFAULT_UP=new C(0,1,0);Me.DEFAULT_MATRIX_AUTO_UPDATE=!0;Me.DEFAULT_MATRIX_WORLD_AUTO_UPDATE=!0;const Qe=new C,mn=new C,Wr=new C,gn=new C,Mi=new C,Si=new C,mc=new C,Xr=new C,$r=new C,qr=new C,Yr=new se,Kr=new se,Zr=new se;class Ye{constructor(t=new C,e=new C,n=new C){this.a=t,this.b=e,this.c=n}static getNormal(t,e,n,s){s.subVectors(n,e),Qe.subVectors(t,e),s.cross(Qe);const r=s.lengthSq();return r>0?s.multiplyScalar(1/Math.sqrt(r)):s.set(0,0,0)}static getBarycoord(t,e,n,s,r){Qe.subVectors(s,e),mn.subVectors(n,e),Wr.subVectors(t,e);const o=Qe.dot(Qe),a=Qe.dot(mn),c=Qe.dot(Wr),l=mn.dot(mn),h=mn.dot(Wr),d=o*l-a*a;if(d===0)return r.set(0,0,0),null;const u=1/d,f=(l*c-a*h)*u,g=(o*h-a*c)*u;return r.set(1-f-g,g,f)}static containsPoint(t,e,n,s){return this.getBarycoord(t,e,n,s,gn)===null?!1:gn.x>=0&&gn.y>=0&&gn.x+gn.y<=1}static getInterpolation(t,e,n,s,r,o,a,c){return this.getBarycoord(t,e,n,s,gn)===null?(c.x=0,c.y=0,"z"in c&&(c.z=0),"w"in c&&(c.w=0),null):(c.setScalar(0),c.addScaledVector(r,gn.x),c.addScaledVector(o,gn.y),c.addScaledVector(a,gn.z),c)}static getInterpolatedAttribute(t,e,n,s,r,o){return Yr.setScalar(0),Kr.setScalar(0),Zr.setScalar(0),Yr.fromBufferAttribute(t,e),Kr.fromBufferAttribute(t,n),Zr.fromBufferAttribute(t,s),o.setScalar(0),o.addScaledVector(Yr,r.x),o.addScaledVector(Kr,r.y),o.addScaledVector(Zr,r.z),o}static isFrontFacing(t,e,n,s){return Qe.subVectors(n,e),mn.subVectors(t,e),Qe.cross(mn).dot(s)<0}set(t,e,n){return this.a.copy(t),this.b.copy(e),this.c.copy(n),this}setFromPointsAndIndices(t,e,n,s){return this.a.copy(t[e]),this.b.copy(t[n]),this.c.copy(t[s]),this}setFromAttributeAndIndices(t,e,n,s){return this.a.fromBufferAttribute(t,e),this.b.fromBufferAttribute(t,n),this.c.fromBufferAttribute(t,s),this}clone(){return new this.constructor().copy(this)}copy(t){return this.a.copy(t.a),this.b.copy(t.b),this.c.copy(t.c),this}getArea(){return Qe.subVectors(this.c,this.b),mn.subVectors(this.a,this.b),Qe.cross(mn).length()*.5}getMidpoint(t){return t.addVectors(this.a,this.b).add(this.c).multiplyScalar(1/3)}getNormal(t){return Ye.getNormal(this.a,this.b,this.c,t)}getPlane(t){return t.setFromCoplanarPoints(this.a,this.b,this.c)}getBarycoord(t,e){return Ye.getBarycoord(t,this.a,this.b,this.c,e)}getInterpolation(t,e,n,s,r){return Ye.getInterpolation(t,this.a,this.b,this.c,e,n,s,r)}containsPoint(t){return Ye.containsPoint(t,this.a,this.b,this.c)}isFrontFacing(t){return Ye.isFrontFacing(this.a,this.b,this.c,t)}intersectsBox(t){return t.intersectsTriangle(this)}closestPointToPoint(t,e){const n=this.a,s=this.b,r=this.c;let o,a;Mi.subVectors(s,n),Si.subVectors(r,n),Xr.subVectors(t,n);const c=Mi.dot(Xr),l=Si.dot(Xr);if(c<=0&&l<=0)return e.copy(n);$r.subVectors(t,s);const h=Mi.dot($r),d=Si.dot($r);if(h>=0&&d<=h)return e.copy(s);const u=c*d-h*l;if(u<=0&&c>=0&&h<=0)return o=c/(c-h),e.copy(n).addScaledVector(Mi,o);qr.subVectors(t,r);const f=Mi.dot(qr),g=Si.dot(qr);if(g>=0&&f<=g)return e.copy(r);const _=f*l-c*g;if(_<=0&&l>=0&&g<=0)return a=l/(l-g),e.copy(n).addScaledVector(Si,a);const p=h*g-f*d;if(p<=0&&d-h>=0&&f-g>=0)return mc.subVectors(r,s),a=(d-h)/(d-h+(f-g)),e.copy(s).addScaledVector(mc,a);const m=1/(p+_+u);return o=_*m,a=u*m,e.copy(n).addScaledVector(Mi,o).addScaledVector(Si,a)}equals(t){return t.a.equals(this.a)&&t.b.equals(this.b)&&t.c.equals(this.c)}}const Wl={aliceblue:15792383,antiquewhite:16444375,aqua:65535,aquamarine:8388564,azure:15794175,beige:16119260,bisque:16770244,black:0,blanchedalmond:16772045,blue:255,blueviolet:9055202,brown:10824234,burlywood:14596231,cadetblue:6266528,chartreuse:8388352,chocolate:13789470,coral:16744272,cornflowerblue:6591981,cornsilk:16775388,crimson:14423100,cyan:65535,darkblue:139,darkcyan:35723,darkgoldenrod:12092939,darkgray:11119017,darkgreen:25600,darkgrey:11119017,darkkhaki:12433259,darkmagenta:9109643,darkolivegreen:5597999,darkorange:16747520,darkorchid:10040012,darkred:9109504,darksalmon:15308410,darkseagreen:9419919,darkslateblue:4734347,darkslategray:3100495,darkslategrey:3100495,darkturquoise:52945,darkviolet:9699539,deeppink:16716947,deepskyblue:49151,dimgray:6908265,dimgrey:6908265,dodgerblue:2003199,firebrick:11674146,floralwhite:16775920,forestgreen:2263842,fuchsia:16711935,gainsboro:14474460,ghostwhite:16316671,gold:16766720,goldenrod:14329120,gray:8421504,green:32768,greenyellow:11403055,grey:8421504,honeydew:15794160,hotpink:16738740,indianred:13458524,indigo:4915330,ivory:16777200,khaki:15787660,lavender:15132410,lavenderblush:16773365,lawngreen:8190976,lemonchiffon:16775885,lightblue:11393254,lightcoral:15761536,lightcyan:14745599,lightgoldenrodyellow:16448210,lightgray:13882323,lightgreen:9498256,lightgrey:13882323,lightpink:16758465,lightsalmon:16752762,lightseagreen:2142890,lightskyblue:8900346,lightslategray:7833753,lightslategrey:7833753,lightsteelblue:11584734,lightyellow:16777184,lime:65280,limegreen:3329330,linen:16445670,magenta:16711935,maroon:8388608,mediumaquamarine:6737322,mediumblue:205,mediumorchid:12211667,mediumpurple:9662683,mediumseagreen:3978097,mediumslateblue:8087790,mediumspringgreen:64154,mediumturquoise:4772300,mediumvioletred:13047173,midnightblue:1644912,mintcream:16121850,mistyrose:16770273,moccasin:16770229,navajowhite:16768685,navy:128,oldlace:16643558,olive:8421376,olivedrab:7048739,orange:16753920,orangered:16729344,orchid:14315734,palegoldenrod:15657130,palegreen:10025880,paleturquoise:11529966,palevioletred:14381203,papayawhip:16773077,peachpuff:16767673,peru:13468991,pink:16761035,plum:14524637,powderblue:11591910,purple:8388736,rebeccapurple:6697881,red:16711680,rosybrown:12357519,royalblue:4286945,saddlebrown:9127187,salmon:16416882,sandybrown:16032864,seagreen:3050327,seashell:16774638,sienna:10506797,silver:12632256,skyblue:8900331,slateblue:6970061,slategray:7372944,slategrey:7372944,snow:16775930,springgreen:65407,steelblue:4620980,tan:13808780,teal:32896,thistle:14204888,tomato:16737095,turquoise:4251856,violet:15631086,wheat:16113331,white:16777215,whitesmoke:16119285,yellow:16776960,yellowgreen:10145074},Ln={h:0,s:0,l:0},Us={h:0,s:0,l:0};function jr(i,t,e){return e<0&&(e+=1),e>1&&(e-=1),e<1/6?i+(t-i)*6*e:e<1/2?t:e<2/3?i+(t-i)*6*(2/3-e):i}class Xt{constructor(t,e,n){return this.isColor=!0,this.r=1,this.g=1,this.b=1,this.set(t,e,n)}set(t,e,n){if(e===void 0&&n===void 0){const s=t;s&&s.isColor?this.copy(s):typeof s=="number"?this.setHex(s):typeof s=="string"&&this.setStyle(s)}else this.setRGB(t,e,n);return this}setScalar(t){return this.r=t,this.g=t,this.b=t,this}setHex(t,e=cn){return t=Math.floor(t),this.r=(t>>16&255)/255,this.g=(t>>8&255)/255,this.b=(t&255)/255,ee.toWorkingColorSpace(this,e),this}setRGB(t,e,n,s=ee.workingColorSpace){return this.r=t,this.g=e,this.b=n,ee.toWorkingColorSpace(this,s),this}setHSL(t,e,n,s=ee.workingColorSpace){if(t=Aa(t,1),e=ye(e,0,1),n=ye(n,0,1),e===0)this.r=this.g=this.b=n;else{const r=n<=.5?n*(1+e):n+e-n*e,o=2*n-r;this.r=jr(o,r,t+1/3),this.g=jr(o,r,t),this.b=jr(o,r,t-1/3)}return ee.toWorkingColorSpace(this,s),this}setStyle(t,e=cn){function n(r){r!==void 0&&parseFloat(r)<1&&console.warn("THREE.Color: Alpha component of "+t+" will be ignored.")}let s;if(s=/^(\w+)\(([^\)]*)\)/.exec(t)){let r;const o=s[1],a=s[2];switch(o){case"rgb":case"rgba":if(r=/^\s*(\d+)\s*,\s*(\d+)\s*,\s*(\d+)\s*(?:,\s*(\d*\.?\d+)\s*)?$/.exec(a))return n(r[4]),this.setRGB(Math.min(255,parseInt(r[1],10))/255,Math.min(255,parseInt(r[2],10))/255,Math.min(255,parseInt(r[3],10))/255,e);if(r=/^\s*(\d+)\%\s*,\s*(\d+)\%\s*,\s*(\d+)\%\s*(?:,\s*(\d*\.?\d+)\s*)?$/.exec(a))return n(r[4]),this.setRGB(Math.min(100,parseInt(r[1],10))/100,Math.min(100,parseInt(r[2],10))/100,Math.min(100,parseInt(r[3],10))/100,e);break;case"hsl":case"hsla":if(r=/^\s*(\d*\.?\d+)\s*,\s*(\d*\.?\d+)\%\s*,\s*(\d*\.?\d+)\%\s*(?:,\s*(\d*\.?\d+)\s*)?$/.exec(a))return n(r[4]),this.setHSL(parseFloat(r[1])/360,parseFloat(r[2])/100,parseFloat(r[3])/100,e);break;default:console.warn("THREE.Color: Unknown color model "+t)}}else if(s=/^\#([A-Fa-f\d]+)$/.exec(t)){const r=s[1],o=r.length;if(o===3)return this.setRGB(parseInt(r.charAt(0),16)/15,parseInt(r.charAt(1),16)/15,parseInt(r.charAt(2),16)/15,e);if(o===6)return this.setHex(parseInt(r,16),e);console.warn("THREE.Color: Invalid hex color "+t)}else if(t&&t.length>0)return this.setColorName(t,e);return this}setColorName(t,e=cn){const n=Wl[t.toLowerCase()];return n!==void 0?this.setHex(n,e):console.warn("THREE.Color: Unknown color "+t),this}clone(){return new this.constructor(this.r,this.g,this.b)}copy(t){return this.r=t.r,this.g=t.g,this.b=t.b,this}copySRGBToLinear(t){return this.r=Bi(t.r),this.g=Bi(t.g),this.b=Bi(t.b),this}copyLinearToSRGB(t){return this.r=Nr(t.r),this.g=Nr(t.g),this.b=Nr(t.b),this}convertSRGBToLinear(){return this.copySRGBToLinear(this),this}convertLinearToSRGB(){return this.copyLinearToSRGB(this),this}getHex(t=cn){return ee.fromWorkingColorSpace(Te.copy(this),t),Math.round(ye(Te.r*255,0,255))*65536+Math.round(ye(Te.g*255,0,255))*256+Math.round(ye(Te.b*255,0,255))}getHexString(t=cn){return("000000"+this.getHex(t).toString(16)).slice(-6)}getHSL(t,e=ee.workingColorSpace){ee.fromWorkingColorSpace(Te.copy(this),e);const n=Te.r,s=Te.g,r=Te.b,o=Math.max(n,s,r),a=Math.min(n,s,r);let c,l;const h=(a+o)/2;if(a===o)c=0,l=0;else{const d=o-a;switch(l=h<=.5?d/(o+a):d/(2-o-a),o){case n:c=(s-r)/d+(s<r?6:0);break;case s:c=(r-n)/d+2;break;case r:c=(n-s)/d+4;break}c/=6}return t.h=c,t.s=l,t.l=h,t}getRGB(t,e=ee.workingColorSpace){return ee.fromWorkingColorSpace(Te.copy(this),e),t.r=Te.r,t.g=Te.g,t.b=Te.b,t}getStyle(t=cn){ee.fromWorkingColorSpace(Te.copy(this),t);const e=Te.r,n=Te.g,s=Te.b;return t!==cn?`color(${t} ${e.toFixed(3)} ${n.toFixed(3)} ${s.toFixed(3)})`:`rgb(${Math.round(e*255)},${Math.round(n*255)},${Math.round(s*255)})`}offsetHSL(t,e,n){return this.getHSL(Ln),this.setHSL(Ln.h+t,Ln.s+e,Ln.l+n)}add(t){return this.r+=t.r,this.g+=t.g,this.b+=t.b,this}addColors(t,e){return this.r=t.r+e.r,this.g=t.g+e.g,this.b=t.b+e.b,this}addScalar(t){return this.r+=t,this.g+=t,this.b+=t,this}sub(t){return this.r=Math.max(0,this.r-t.r),this.g=Math.max(0,this.g-t.g),this.b=Math.max(0,this.b-t.b),this}multiply(t){return this.r*=t.r,this.g*=t.g,this.b*=t.b,this}multiplyScalar(t){return this.r*=t,this.g*=t,this.b*=t,this}lerp(t,e){return this.r+=(t.r-this.r)*e,this.g+=(t.g-this.g)*e,this.b+=(t.b-this.b)*e,this}lerpColors(t,e,n){return this.r=t.r+(e.r-t.r)*n,this.g=t.g+(e.g-t.g)*n,this.b=t.b+(e.b-t.b)*n,this}lerpHSL(t,e){this.getHSL(Ln),t.getHSL(Us);const n=ls(Ln.h,Us.h,e),s=ls(Ln.s,Us.s,e),r=ls(Ln.l,Us.l,e);return this.setHSL(n,s,r),this}setFromVector3(t){return this.r=t.x,this.g=t.y,this.b=t.z,this}applyMatrix3(t){const e=this.r,n=this.g,s=this.b,r=t.elements;return this.r=r[0]*e+r[3]*n+r[6]*s,this.g=r[1]*e+r[4]*n+r[7]*s,this.b=r[2]*e+r[5]*n+r[8]*s,this}equals(t){return t.r===this.r&&t.g===this.g&&t.b===this.b}fromArray(t,e=0){return this.r=t[e],this.g=t[e+1],this.b=t[e+2],this}toArray(t=[],e=0){return t[e]=this.r,t[e+1]=this.g,t[e+2]=this.b,t}fromBufferAttribute(t,e){return this.r=t.getX(e),this.g=t.getY(e),this.b=t.getZ(e),this}toJSON(){return this.getHex()}*[Symbol.iterator](){yield this.r,yield this.g,yield this.b}}const Te=new Xt;Xt.NAMES=Wl;let td=0;class Ki extends hi{constructor(){super(),this.isMaterial=!0,Object.defineProperty(this,"id",{value:td++}),this.uuid=ui(),this.name="",this.type="Material",this.blending=ki,this.side=Bn,this.vertexColors=!1,this.opacity=1,this.transparent=!1,this.alphaHash=!1,this.blendSrc=So,this.blendDst=bo,this.blendEquation=ti,this.blendSrcAlpha=null,this.blendDstAlpha=null,this.blendEquationAlpha=null,this.blendColor=new Xt(0,0,0),this.blendAlpha=0,this.depthFunc=Hi,this.depthTest=!0,this.depthWrite=!0,this.stencilWriteMask=255,this.stencilFunc=tc,this.stencilRef=0,this.stencilFuncMask=255,this.stencilFail=fi,this.stencilZFail=fi,this.stencilZPass=fi,this.stencilWrite=!1,this.clippingPlanes=null,this.clipIntersection=!1,this.clipShadows=!1,this.shadowSide=null,this.colorWrite=!0,this.precision=null,this.polygonOffset=!1,this.polygonOffsetFactor=0,this.polygonOffsetUnits=0,this.dithering=!1,this.alphaToCoverage=!1,this.premultipliedAlpha=!1,this.forceSinglePass=!1,this.visible=!0,this.toneMapped=!0,this.userData={},this.version=0,this._alphaTest=0}get alphaTest(){return this._alphaTest}set alphaTest(t){this._alphaTest>0!=t>0&&this.version++,this._alphaTest=t}onBeforeRender(){}onBeforeCompile(){}customProgramCacheKey(){return this.onBeforeCompile.toString()}setValues(t){if(t!==void 0)for(const e in t){const n=t[e];if(n===void 0){console.warn(`THREE.Material: parameter '${e}' has value of undefined.`);continue}const s=this[e];if(s===void 0){console.warn(`THREE.Material: '${e}' is not a property of THREE.${this.type}.`);continue}s&&s.isColor?s.set(n):s&&s.isVector3&&n&&n.isVector3?s.copy(n):this[e]=n}}toJSON(t){const e=t===void 0||typeof t=="string";e&&(t={textures:{},images:{}});const n={metadata:{version:4.6,type:"Material",generator:"Material.toJSON"}};n.uuid=this.uuid,n.type=this.type,this.name!==""&&(n.name=this.name),this.color&&this.color.isColor&&(n.color=this.color.getHex()),this.roughness!==void 0&&(n.roughness=this.roughness),this.metalness!==void 0&&(n.metalness=this.metalness),this.sheen!==void 0&&(n.sheen=this.sheen),this.sheenColor&&this.sheenColor.isColor&&(n.sheenColor=this.sheenColor.getHex()),this.sheenRoughness!==void 0&&(n.sheenRoughness=this.sheenRoughness),this.emissive&&this.emissive.isColor&&(n.emissive=this.emissive.getHex()),this.emissiveIntensity!==void 0&&this.emissiveIntensity!==1&&(n.emissiveIntensity=this.emissiveIntensity),this.specular&&this.specular.isColor&&(n.specular=this.specular.getHex()),this.specularIntensity!==void 0&&(n.specularIntensity=this.specularIntensity),this.specularColor&&this.specularColor.isColor&&(n.specularColor=this.specularColor.getHex()),this.shininess!==void 0&&(n.shininess=this.shininess),this.clearcoat!==void 0&&(n.clearcoat=this.clearcoat),this.clearcoatRoughness!==void 0&&(n.clearcoatRoughness=this.clearcoatRoughness),this.clearcoatMap&&this.clearcoatMap.isTexture&&(n.clearcoatMap=this.clearcoatMap.toJSON(t).uuid),this.clearcoatRoughnessMap&&this.clearcoatRoughnessMap.isTexture&&(n.clearcoatRoughnessMap=this.clearcoatRoughnessMap.toJSON(t).uuid),this.clearcoatNormalMap&&this.clearcoatNormalMap.isTexture&&(n.clearcoatNormalMap=this.clearcoatNormalMap.toJSON(t).uuid,n.clearcoatNormalScale=this.clearcoatNormalScale.toArray()),this.dispersion!==void 0&&(n.dispersion=this.dispersion),this.iridescence!==void 0&&(n.iridescence=this.iridescence),this.iridescenceIOR!==void 0&&(n.iridescenceIOR=this.iridescenceIOR),this.iridescenceThicknessRange!==void 0&&(n.iridescenceThicknessRange=this.iridescenceThicknessRange),this.iridescenceMap&&this.iridescenceMap.isTexture&&(n.iridescenceMap=this.iridescenceMap.toJSON(t).uuid),this.iridescenceThicknessMap&&this.iridescenceThicknessMap.isTexture&&(n.iridescenceThicknessMap=this.iridescenceThicknessMap.toJSON(t).uuid),this.anisotropy!==void 0&&(n.anisotropy=this.anisotropy),this.anisotropyRotation!==void 0&&(n.anisotropyRotation=this.anisotropyRotation),this.anisotropyMap&&this.anisotropyMap.isTexture&&(n.anisotropyMap=this.anisotropyMap.toJSON(t).uuid),this.map&&this.map.isTexture&&(n.map=this.map.toJSON(t).uuid),this.matcap&&this.matcap.isTexture&&(n.matcap=this.matcap.toJSON(t).uuid),this.alphaMap&&this.alphaMap.isTexture&&(n.alphaMap=this.alphaMap.toJSON(t).uuid),this.lightMap&&this.lightMap.isTexture&&(n.lightMap=this.lightMap.toJSON(t).uuid,n.lightMapIntensity=this.lightMapIntensity),this.aoMap&&this.aoMap.isTexture&&(n.aoMap=this.aoMap.toJSON(t).uuid,n.aoMapIntensity=this.aoMapIntensity),this.bumpMap&&this.bumpMap.isTexture&&(n.bumpMap=this.bumpMap.toJSON(t).uuid,n.bumpScale=this.bumpScale),this.normalMap&&this.normalMap.isTexture&&(n.normalMap=this.normalMap.toJSON(t).uuid,n.normalMapType=this.normalMapType,n.normalScale=this.normalScale.toArray()),this.displacementMap&&this.displacementMap.isTexture&&(n.displacementMap=this.displacementMap.toJSON(t).uuid,n.displacementScale=this.displacementScale,n.displacementBias=this.displacementBias),this.roughnessMap&&this.roughnessMap.isTexture&&(n.roughnessMap=this.roughnessMap.toJSON(t).uuid),this.metalnessMap&&this.metalnessMap.isTexture&&(n.metalnessMap=this.metalnessMap.toJSON(t).uuid),this.emissiveMap&&this.emissiveMap.isTexture&&(n.emissiveMap=this.emissiveMap.toJSON(t).uuid),this.specularMap&&this.specularMap.isTexture&&(n.specularMap=this.specularMap.toJSON(t).uuid),this.specularIntensityMap&&this.specularIntensityMap.isTexture&&(n.specularIntensityMap=this.specularIntensityMap.toJSON(t).uuid),this.specularColorMap&&this.specularColorMap.isTexture&&(n.specularColorMap=this.specularColorMap.toJSON(t).uuid),this.envMap&&this.envMap.isTexture&&(n.envMap=this.envMap.toJSON(t).uuid,this.combine!==void 0&&(n.combine=this.combine)),this.envMapRotation!==void 0&&(n.envMapRotation=this.envMapRotation.toArray()),this.envMapIntensity!==void 0&&(n.envMapIntensity=this.envMapIntensity),this.reflectivity!==void 0&&(n.reflectivity=this.reflectivity),this.refractionRatio!==void 0&&(n.refractionRatio=this.refractionRatio),this.gradientMap&&this.gradientMap.isTexture&&(n.gradientMap=this.gradientMap.toJSON(t).uuid),this.transmission!==void 0&&(n.transmission=this.transmission),this.transmissionMap&&this.transmissionMap.isTexture&&(n.transmissionMap=this.transmissionMap.toJSON(t).uuid),this.thickness!==void 0&&(n.thickness=this.thickness),this.thicknessMap&&this.thicknessMap.isTexture&&(n.thicknessMap=this.thicknessMap.toJSON(t).uuid),this.attenuationDistance!==void 0&&this.attenuationDistance!==1/0&&(n.attenuationDistance=this.attenuationDistance),this.attenuationColor!==void 0&&(n.attenuationColor=this.attenuationColor.getHex()),this.size!==void 0&&(n.size=this.size),this.shadowSide!==null&&(n.shadowSide=this.shadowSide),this.sizeAttenuation!==void 0&&(n.sizeAttenuation=this.sizeAttenuation),this.blending!==ki&&(n.blending=this.blending),this.side!==Bn&&(n.side=this.side),this.vertexColors===!0&&(n.vertexColors=!0),this.opacity<1&&(n.opacity=this.opacity),this.transparent===!0&&(n.transparent=!0),this.blendSrc!==So&&(n.blendSrc=this.blendSrc),this.blendDst!==bo&&(n.blendDst=this.blendDst),this.blendEquation!==ti&&(n.blendEquation=this.blendEquation),this.blendSrcAlpha!==null&&(n.blendSrcAlpha=this.blendSrcAlpha),this.blendDstAlpha!==null&&(n.blendDstAlpha=this.blendDstAlpha),this.blendEquationAlpha!==null&&(n.blendEquationAlpha=this.blendEquationAlpha),this.blendColor&&this.blendColor.isColor&&(n.blendColor=this.blendColor.getHex()),this.blendAlpha!==0&&(n.blendAlpha=this.blendAlpha),this.depthFunc!==Hi&&(n.depthFunc=this.depthFunc),this.depthTest===!1&&(n.depthTest=this.depthTest),this.depthWrite===!1&&(n.depthWrite=this.depthWrite),this.colorWrite===!1&&(n.colorWrite=this.colorWrite),this.stencilWriteMask!==255&&(n.stencilWriteMask=this.stencilWriteMask),this.stencilFunc!==tc&&(n.stencilFunc=this.stencilFunc),this.stencilRef!==0&&(n.stencilRef=this.stencilRef),this.stencilFuncMask!==255&&(n.stencilFuncMask=this.stencilFuncMask),this.stencilFail!==fi&&(n.stencilFail=this.stencilFail),this.stencilZFail!==fi&&(n.stencilZFail=this.stencilZFail),this.stencilZPass!==fi&&(n.stencilZPass=this.stencilZPass),this.stencilWrite===!0&&(n.stencilWrite=this.stencilWrite),this.rotation!==void 0&&this.rotation!==0&&(n.rotation=this.rotation),this.polygonOffset===!0&&(n.polygonOffset=!0),this.polygonOffsetFactor!==0&&(n.polygonOffsetFactor=this.polygonOffsetFactor),this.polygonOffsetUnits!==0&&(n.polygonOffsetUnits=this.polygonOffsetUnits),this.linewidth!==void 0&&this.linewidth!==1&&(n.linewidth=this.linewidth),this.dashSize!==void 0&&(n.dashSize=this.dashSize),this.gapSize!==void 0&&(n.gapSize=this.gapSize),this.scale!==void 0&&(n.scale=this.scale),this.dithering===!0&&(n.dithering=!0),this.alphaTest>0&&(n.alphaTest=this.alphaTest),this.alphaHash===!0&&(n.alphaHash=!0),this.alphaToCoverage===!0&&(n.alphaToCoverage=!0),this.premultipliedAlpha===!0&&(n.premultipliedAlpha=!0),this.forceSinglePass===!0&&(n.forceSinglePass=!0),this.wireframe===!0&&(n.wireframe=!0),this.wireframeLinewidth>1&&(n.wireframeLinewidth=this.wireframeLinewidth),this.wireframeLinecap!=="round"&&(n.wireframeLinecap=this.wireframeLinecap),this.wireframeLinejoin!=="round"&&(n.wireframeLinejoin=this.wireframeLinejoin),this.flatShading===!0&&(n.flatShading=!0),this.visible===!1&&(n.visible=!1),this.toneMapped===!1&&(n.toneMapped=!1),this.fog===!1&&(n.fog=!1),Object.keys(this.userData).length>0&&(n.userData=this.userData);function s(r){const o=[];for(const a in r){const c=r[a];delete c.metadata,o.push(c)}return o}if(e){const r=s(t.textures),o=s(t.images);r.length>0&&(n.textures=r),o.length>0&&(n.images=o)}return n}clone(){return new this.constructor().copy(this)}copy(t){this.name=t.name,this.blending=t.blending,this.side=t.side,this.vertexColors=t.vertexColors,this.opacity=t.opacity,this.transparent=t.transparent,this.blendSrc=t.blendSrc,this.blendDst=t.blendDst,this.blendEquation=t.blendEquation,this.blendSrcAlpha=t.blendSrcAlpha,this.blendDstAlpha=t.blendDstAlpha,this.blendEquationAlpha=t.blendEquationAlpha,this.blendColor.copy(t.blendColor),this.blendAlpha=t.blendAlpha,this.depthFunc=t.depthFunc,this.depthTest=t.depthTest,this.depthWrite=t.depthWrite,this.stencilWriteMask=t.stencilWriteMask,this.stencilFunc=t.stencilFunc,this.stencilRef=t.stencilRef,this.stencilFuncMask=t.stencilFuncMask,this.stencilFail=t.stencilFail,this.stencilZFail=t.stencilZFail,this.stencilZPass=t.stencilZPass,this.stencilWrite=t.stencilWrite;const e=t.clippingPlanes;let n=null;if(e!==null){const s=e.length;n=new Array(s);for(let r=0;r!==s;++r)n[r]=e[r].clone()}return this.clippingPlanes=n,this.clipIntersection=t.clipIntersection,this.clipShadows=t.clipShadows,this.shadowSide=t.shadowSide,this.colorWrite=t.colorWrite,this.precision=t.precision,this.polygonOffset=t.polygonOffset,this.polygonOffsetFactor=t.polygonOffsetFactor,this.polygonOffsetUnits=t.polygonOffsetUnits,this.dithering=t.dithering,this.alphaTest=t.alphaTest,this.alphaHash=t.alphaHash,this.alphaToCoverage=t.alphaToCoverage,this.premultipliedAlpha=t.premultipliedAlpha,this.forceSinglePass=t.forceSinglePass,this.visible=t.visible,this.toneMapped=t.toneMapped,this.userData=JSON.parse(JSON.stringify(t.userData)),this}dispose(){this.dispatchEvent({type:"dispose"})}set needsUpdate(t){t===!0&&this.version++}onBuild(){console.warn("Material: onBuild() has been removed.")}}class Er extends Ki{constructor(t){super(),this.isMeshBasicMaterial=!0,this.type="MeshBasicMaterial",this.color=new Xt(16777215),this.map=null,this.lightMap=null,this.lightMapIntensity=1,this.aoMap=null,this.aoMapIntensity=1,this.specularMap=null,this.alphaMap=null,this.envMap=null,this.envMapRotation=new on,this.combine=Tl,this.reflectivity=1,this.refractionRatio=.98,this.wireframe=!1,this.wireframeLinewidth=1,this.wireframeLinecap="round",this.wireframeLinejoin="round",this.fog=!0,this.setValues(t)}copy(t){return super.copy(t),this.color.copy(t.color),this.map=t.map,this.lightMap=t.lightMap,this.lightMapIntensity=t.lightMapIntensity,this.aoMap=t.aoMap,this.aoMapIntensity=t.aoMapIntensity,this.specularMap=t.specularMap,this.alphaMap=t.alphaMap,this.envMap=t.envMap,this.envMapRotation.copy(t.envMapRotation),this.combine=t.combine,this.reflectivity=t.reflectivity,this.refractionRatio=t.refractionRatio,this.wireframe=t.wireframe,this.wireframeLinewidth=t.wireframeLinewidth,this.wireframeLinecap=t.wireframeLinecap,this.wireframeLinejoin=t.wireframeLinejoin,this.fog=t.fog,this}}const me=new C,Ns=new nt;class rn{constructor(t,e,n=!1){if(Array.isArray(t))throw new TypeError("THREE.BufferAttribute: array should be a Typed Array.");this.isBufferAttribute=!0,this.name="",this.array=t,this.itemSize=e,this.count=t!==void 0?t.length/e:0,this.normalized=n,this.usage=ec,this.updateRanges=[],this.gpuType=xn,this.version=0}onUploadCallback(){}set needsUpdate(t){t===!0&&this.version++}setUsage(t){return this.usage=t,this}addUpdateRange(t,e){this.updateRanges.push({start:t,count:e})}clearUpdateRanges(){this.updateRanges.length=0}copy(t){return this.name=t.name,this.array=new t.array.constructor(t.array),this.itemSize=t.itemSize,this.count=t.count,this.normalized=t.normalized,this.usage=t.usage,this.gpuType=t.gpuType,this}copyAt(t,e,n){t*=this.itemSize,n*=e.itemSize;for(let s=0,r=this.itemSize;s<r;s++)this.array[t+s]=e.array[n+s];return this}copyArray(t){return this.array.set(t),this}applyMatrix3(t){if(this.itemSize===2)for(let e=0,n=this.count;e<n;e++)Ns.fromBufferAttribute(this,e),Ns.applyMatrix3(t),this.setXY(e,Ns.x,Ns.y);else if(this.itemSize===3)for(let e=0,n=this.count;e<n;e++)me.fromBufferAttribute(this,e),me.applyMatrix3(t),this.setXYZ(e,me.x,me.y,me.z);return this}applyMatrix4(t){for(let e=0,n=this.count;e<n;e++)me.fromBufferAttribute(this,e),me.applyMatrix4(t),this.setXYZ(e,me.x,me.y,me.z);return this}applyNormalMatrix(t){for(let e=0,n=this.count;e<n;e++)me.fromBufferAttribute(this,e),me.applyNormalMatrix(t),this.setXYZ(e,me.x,me.y,me.z);return this}transformDirection(t){for(let e=0,n=this.count;e<n;e++)me.fromBufferAttribute(this,e),me.transformDirection(t),this.setXYZ(e,me.x,me.y,me.z);return this}set(t,e=0){return this.array.set(t,e),this}getComponent(t,e){let n=this.array[t*this.itemSize+e];return this.normalized&&(n=Pi(n,this.array)),n}setComponent(t,e,n){return this.normalized&&(n=Ae(n,this.array)),this.array[t*this.itemSize+e]=n,this}getX(t){let e=this.array[t*this.itemSize];return this.normalized&&(e=Pi(e,this.array)),e}setX(t,e){return this.normalized&&(e=Ae(e,this.array)),this.array[t*this.itemSize]=e,this}getY(t){let e=this.array[t*this.itemSize+1];return this.normalized&&(e=Pi(e,this.array)),e}setY(t,e){return this.normalized&&(e=Ae(e,this.array)),this.array[t*this.itemSize+1]=e,this}getZ(t){let e=this.array[t*this.itemSize+2];return this.normalized&&(e=Pi(e,this.array)),e}setZ(t,e){return this.normalized&&(e=Ae(e,this.array)),this.array[t*this.itemSize+2]=e,this}getW(t){let e=this.array[t*this.itemSize+3];return this.normalized&&(e=Pi(e,this.array)),e}setW(t,e){return this.normalized&&(e=Ae(e,this.array)),this.array[t*this.itemSize+3]=e,this}setXY(t,e,n){return t*=this.itemSize,this.normalized&&(e=Ae(e,this.array),n=Ae(n,this.array)),this.array[t+0]=e,this.array[t+1]=n,this}setXYZ(t,e,n,s){return t*=this.itemSize,this.normalized&&(e=Ae(e,this.array),n=Ae(n,this.array),s=Ae(s,this.array)),this.array[t+0]=e,this.array[t+1]=n,this.array[t+2]=s,this}setXYZW(t,e,n,s,r){return t*=this.itemSize,this.normalized&&(e=Ae(e,this.array),n=Ae(n,this.array),s=Ae(s,this.array),r=Ae(r,this.array)),this.array[t+0]=e,this.array[t+1]=n,this.array[t+2]=s,this.array[t+3]=r,this}onUpload(t){return this.onUploadCallback=t,this}clone(){return new this.constructor(this.array,this.itemSize).copy(this)}toJSON(){const t={itemSize:this.itemSize,type:this.array.constructor.name,array:Array.from(this.array),normalized:this.normalized};return this.name!==""&&(t.name=this.name),this.usage!==ec&&(t.usage=this.usage),t}}class Xl extends rn{constructor(t,e,n){super(new Uint16Array(t),e,n)}}class $l extends rn{constructor(t,e,n){super(new Uint32Array(t),e,n)}}class Se extends rn{constructor(t,e,n){super(new Float32Array(t),e,n)}}let ed=0;const Xe=new re,Jr=new Me,bi=new C,Be=new Yi,is=new Yi,xe=new C;class Ne extends hi{constructor(){super(),this.isBufferGeometry=!0,Object.defineProperty(this,"id",{value:ed++}),this.uuid=ui(),this.name="",this.type="BufferGeometry",this.index=null,this.attributes={},this.morphAttributes={},this.morphTargetsRelative=!1,this.groups=[],this.boundingBox=null,this.boundingSphere=null,this.drawRange={start:0,count:1/0},this.userData={}}getIndex(){return this.index}setIndex(t){return Array.isArray(t)?this.index=new(Hl(t)?$l:Xl)(t,1):this.index=t,this}getAttribute(t){return this.attributes[t]}setAttribute(t,e){return this.attributes[t]=e,this}deleteAttribute(t){return delete this.attributes[t],this}hasAttribute(t){return this.attributes[t]!==void 0}addGroup(t,e,n=0){this.groups.push({start:t,count:e,materialIndex:n})}clearGroups(){this.groups=[]}setDrawRange(t,e){this.drawRange.start=t,this.drawRange.count=e}applyMatrix4(t){const e=this.attributes.position;e!==void 0&&(e.applyMatrix4(t),e.needsUpdate=!0);const n=this.attributes.normal;if(n!==void 0){const r=new Vt().getNormalMatrix(t);n.applyNormalMatrix(r),n.needsUpdate=!0}const s=this.attributes.tangent;return s!==void 0&&(s.transformDirection(t),s.needsUpdate=!0),this.boundingBox!==null&&this.computeBoundingBox(),this.boundingSphere!==null&&this.computeBoundingSphere(),this}applyQuaternion(t){return Xe.makeRotationFromQuaternion(t),this.applyMatrix4(Xe),this}rotateX(t){return Xe.makeRotationX(t),this.applyMatrix4(Xe),this}rotateY(t){return Xe.makeRotationY(t),this.applyMatrix4(Xe),this}rotateZ(t){return Xe.makeRotationZ(t),this.applyMatrix4(Xe),this}translate(t,e,n){return Xe.makeTranslation(t,e,n),this.applyMatrix4(Xe),this}scale(t,e,n){return Xe.makeScale(t,e,n),this.applyMatrix4(Xe),this}lookAt(t){return Jr.lookAt(t),Jr.updateMatrix(),this.applyMatrix4(Jr.matrix),this}center(){return this.computeBoundingBox(),this.boundingBox.getCenter(bi).negate(),this.translate(bi.x,bi.y,bi.z),this}setFromPoints(t){const e=[];for(let n=0,s=t.length;n<s;n++){const r=t[n];e.push(r.x,r.y,r.z||0)}return this.setAttribute("position",new Se(e,3)),this}computeBoundingBox(){this.boundingBox===null&&(this.boundingBox=new Yi);const t=this.attributes.position,e=this.morphAttributes.position;if(t&&t.isGLBufferAttribute){console.error("THREE.BufferGeometry.computeBoundingBox(): GLBufferAttribute requires a manual bounding box.",this),this.boundingBox.set(new C(-1/0,-1/0,-1/0),new C(1/0,1/0,1/0));return}if(t!==void 0){if(this.boundingBox.setFromBufferAttribute(t),e)for(let n=0,s=e.length;n<s;n++){const r=e[n];Be.setFromBufferAttribute(r),this.morphTargetsRelative?(xe.addVectors(this.boundingBox.min,Be.min),this.boundingBox.expandByPoint(xe),xe.addVectors(this.boundingBox.max,Be.max),this.boundingBox.expandByPoint(xe)):(this.boundingBox.expandByPoint(Be.min),this.boundingBox.expandByPoint(Be.max))}}else this.boundingBox.makeEmpty();(isNaN(this.boundingBox.min.x)||isNaN(this.boundingBox.min.y)||isNaN(this.boundingBox.min.z))&&console.error('THREE.BufferGeometry.computeBoundingBox(): Computed min/max have NaN values. The "position" attribute is likely to have NaN values.',this)}computeBoundingSphere(){this.boundingSphere===null&&(this.boundingSphere=new Sr);const t=this.attributes.position,e=this.morphAttributes.position;if(t&&t.isGLBufferAttribute){console.error("THREE.BufferGeometry.computeBoundingSphere(): GLBufferAttribute requires a manual bounding sphere.",this),this.boundingSphere.set(new C,1/0);return}if(t){const n=this.boundingSphere.center;if(Be.setFromBufferAttribute(t),e)for(let r=0,o=e.length;r<o;r++){const a=e[r];is.setFromBufferAttribute(a),this.morphTargetsRelative?(xe.addVectors(Be.min,is.min),Be.expandByPoint(xe),xe.addVectors(Be.max,is.max),Be.expandByPoint(xe)):(Be.expandByPoint(is.min),Be.expandByPoint(is.max))}Be.getCenter(n);let s=0;for(let r=0,o=t.count;r<o;r++)xe.fromBufferAttribute(t,r),s=Math.max(s,n.distanceToSquared(xe));if(e)for(let r=0,o=e.length;r<o;r++){const a=e[r],c=this.morphTargetsRelative;for(let l=0,h=a.count;l<h;l++)xe.fromBufferAttribute(a,l),c&&(bi.fromBufferAttribute(t,l),xe.add(bi)),s=Math.max(s,n.distanceToSquared(xe))}this.boundingSphere.radius=Math.sqrt(s),isNaN(this.boundingSphere.radius)&&console.error('THREE.BufferGeometry.computeBoundingSphere(): Computed radius is NaN. The "position" attribute is likely to have NaN values.',this)}}computeTangents(){const t=this.index,e=this.attributes;if(t===null||e.position===void 0||e.normal===void 0||e.uv===void 0){console.error("THREE.BufferGeometry: .computeTangents() failed. Missing required attributes (index, position, normal or uv)");return}const n=e.position,s=e.normal,r=e.uv;this.hasAttribute("tangent")===!1&&this.setAttribute("tangent",new rn(new Float32Array(4*n.count),4));const o=this.getAttribute("tangent"),a=[],c=[];for(let P=0;P<n.count;P++)a[P]=new C,c[P]=new C;const l=new C,h=new C,d=new C,u=new nt,f=new nt,g=new nt,_=new C,p=new C;function m(P,W,v){l.fromBufferAttribute(n,P),h.fromBufferAttribute(n,W),d.fromBufferAttribute(n,v),u.fromBufferAttribute(r,P),f.fromBufferAttribute(r,W),g.fromBufferAttribute(r,v),h.sub(l),d.sub(l),f.sub(u),g.sub(u);const S=1/(f.x*g.y-g.x*f.y);isFinite(S)&&(_.copy(h).multiplyScalar(g.y).addScaledVector(d,-f.y).multiplyScalar(S),p.copy(d).multiplyScalar(f.x).addScaledVector(h,-g.x).multiplyScalar(S),a[P].add(_),a[W].add(_),a[v].add(_),c[P].add(p),c[W].add(p),c[v].add(p))}let w=this.groups;w.length===0&&(w=[{start:0,count:t.count}]);for(let P=0,W=w.length;P<W;++P){const v=w[P],S=v.start,F=v.count;for(let N=S,H=S+F;N<H;N+=3)m(t.getX(N+0),t.getX(N+1),t.getX(N+2))}const x=new C,b=new C,I=new C,R=new C;function A(P){I.fromBufferAttribute(s,P),R.copy(I);const W=a[P];x.copy(W),x.sub(I.multiplyScalar(I.dot(W))).normalize(),b.crossVectors(R,W);const S=b.dot(c[P])<0?-1:1;o.setXYZW(P,x.x,x.y,x.z,S)}for(let P=0,W=w.length;P<W;++P){const v=w[P],S=v.start,F=v.count;for(let N=S,H=S+F;N<H;N+=3)A(t.getX(N+0)),A(t.getX(N+1)),A(t.getX(N+2))}}computeVertexNormals(){const t=this.index,e=this.getAttribute("position");if(e!==void 0){let n=this.getAttribute("normal");if(n===void 0)n=new rn(new Float32Array(e.count*3),3),this.setAttribute("normal",n);else for(let u=0,f=n.count;u<f;u++)n.setXYZ(u,0,0,0);const s=new C,r=new C,o=new C,a=new C,c=new C,l=new C,h=new C,d=new C;if(t)for(let u=0,f=t.count;u<f;u+=3){const g=t.getX(u+0),_=t.getX(u+1),p=t.getX(u+2);s.fromBufferAttribute(e,g),r.fromBufferAttribute(e,_),o.fromBufferAttribute(e,p),h.subVectors(o,r),d.subVectors(s,r),h.cross(d),a.fromBufferAttribute(n,g),c.fromBufferAttribute(n,_),l.fromBufferAttribute(n,p),a.add(h),c.add(h),l.add(h),n.setXYZ(g,a.x,a.y,a.z),n.setXYZ(_,c.x,c.y,c.z),n.setXYZ(p,l.x,l.y,l.z)}else for(let u=0,f=e.count;u<f;u+=3)s.fromBufferAttribute(e,u+0),r.fromBufferAttribute(e,u+1),o.fromBufferAttribute(e,u+2),h.subVectors(o,r),d.subVectors(s,r),h.cross(d),n.setXYZ(u+0,h.x,h.y,h.z),n.setXYZ(u+1,h.x,h.y,h.z),n.setXYZ(u+2,h.x,h.y,h.z);this.normalizeNormals(),n.needsUpdate=!0}}normalizeNormals(){const t=this.attributes.normal;for(let e=0,n=t.count;e<n;e++)xe.fromBufferAttribute(t,e),xe.normalize(),t.setXYZ(e,xe.x,xe.y,xe.z)}toNonIndexed(){function t(a,c){const l=a.array,h=a.itemSize,d=a.normalized,u=new l.constructor(c.length*h);let f=0,g=0;for(let _=0,p=c.length;_<p;_++){a.isInterleavedBufferAttribute?f=c[_]*a.data.stride+a.offset:f=c[_]*h;for(let m=0;m<h;m++)u[g++]=l[f++]}return new rn(u,h,d)}if(this.index===null)return console.warn("THREE.BufferGeometry.toNonIndexed(): BufferGeometry is already non-indexed."),this;const e=new Ne,n=this.index.array,s=this.attributes;for(const a in s){const c=s[a],l=t(c,n);e.setAttribute(a,l)}const r=this.morphAttributes;for(const a in r){const c=[],l=r[a];for(let h=0,d=l.length;h<d;h++){const u=l[h],f=t(u,n);c.push(f)}e.morphAttributes[a]=c}e.morphTargetsRelative=this.morphTargetsRelative;const o=this.groups;for(let a=0,c=o.length;a<c;a++){const l=o[a];e.addGroup(l.start,l.count,l.materialIndex)}return e}toJSON(){const t={metadata:{version:4.6,type:"BufferGeometry",generator:"BufferGeometry.toJSON"}};if(t.uuid=this.uuid,t.type=this.type,this.name!==""&&(t.name=this.name),Object.keys(this.userData).length>0&&(t.userData=this.userData),this.parameters!==void 0){const c=this.parameters;for(const l in c)c[l]!==void 0&&(t[l]=c[l]);return t}t.data={attributes:{}};const e=this.index;e!==null&&(t.data.index={type:e.array.constructor.name,array:Array.prototype.slice.call(e.array)});const n=this.attributes;for(const c in n){const l=n[c];t.data.attributes[c]=l.toJSON(t.data)}const s={};let r=!1;for(const c in this.morphAttributes){const l=this.morphAttributes[c],h=[];for(let d=0,u=l.length;d<u;d++){const f=l[d];h.push(f.toJSON(t.data))}h.length>0&&(s[c]=h,r=!0)}r&&(t.data.morphAttributes=s,t.data.morphTargetsRelative=this.morphTargetsRelative);const o=this.groups;o.length>0&&(t.data.groups=JSON.parse(JSON.stringify(o)));const a=this.boundingSphere;return a!==null&&(t.data.boundingSphere={center:a.center.toArray(),radius:a.radius}),t}clone(){return new this.constructor().copy(this)}copy(t){this.index=null,this.attributes={},this.morphAttributes={},this.groups=[],this.boundingBox=null,this.boundingSphere=null;const e={};this.name=t.name;const n=t.index;n!==null&&this.setIndex(n.clone(e));const s=t.attributes;for(const l in s){const h=s[l];this.setAttribute(l,h.clone(e))}const r=t.morphAttributes;for(const l in r){const h=[],d=r[l];for(let u=0,f=d.length;u<f;u++)h.push(d[u].clone(e));this.morphAttributes[l]=h}this.morphTargetsRelative=t.morphTargetsRelative;const o=t.groups;for(let l=0,h=o.length;l<h;l++){const d=o[l];this.addGroup(d.start,d.count,d.materialIndex)}const a=t.boundingBox;a!==null&&(this.boundingBox=a.clone());const c=t.boundingSphere;return c!==null&&(this.boundingSphere=c.clone()),this.drawRange.start=t.drawRange.start,this.drawRange.count=t.drawRange.count,this.userData=t.userData,this}dispose(){this.dispatchEvent({type:"dispose"})}}const gc=new re,Kn=new br,ks=new Sr,_c=new C,Fs=new C,Os=new C,Bs=new C,Qr=new C,zs=new C,vc=new C,Hs=new C;class ae extends Me{constructor(t=new Ne,e=new Er){super(),this.isMesh=!0,this.type="Mesh",this.geometry=t,this.material=e,this.updateMorphTargets()}copy(t,e){return super.copy(t,e),t.morphTargetInfluences!==void 0&&(this.morphTargetInfluences=t.morphTargetInfluences.slice()),t.morphTargetDictionary!==void 0&&(this.morphTargetDictionary=Object.assign({},t.morphTargetDictionary)),this.material=Array.isArray(t.material)?t.material.slice():t.material,this.geometry=t.geometry,this}updateMorphTargets(){const e=this.geometry.morphAttributes,n=Object.keys(e);if(n.length>0){const s=e[n[0]];if(s!==void 0){this.morphTargetInfluences=[],this.morphTargetDictionary={};for(let r=0,o=s.length;r<o;r++){const a=s[r].name||String(r);this.morphTargetInfluences.push(0),this.morphTargetDictionary[a]=r}}}}getVertexPosition(t,e){const n=this.geometry,s=n.attributes.position,r=n.morphAttributes.position,o=n.morphTargetsRelative;e.fromBufferAttribute(s,t);const a=this.morphTargetInfluences;if(r&&a){zs.set(0,0,0);for(let c=0,l=r.length;c<l;c++){const h=a[c],d=r[c];h!==0&&(Qr.fromBufferAttribute(d,t),o?zs.addScaledVector(Qr,h):zs.addScaledVector(Qr.sub(e),h))}e.add(zs)}return e}raycast(t,e){const n=this.geometry,s=this.material,r=this.matrixWorld;s!==void 0&&(n.boundingSphere===null&&n.computeBoundingSphere(),ks.copy(n.boundingSphere),ks.applyMatrix4(r),Kn.copy(t.ray).recast(t.near),!(ks.containsPoint(Kn.origin)===!1&&(Kn.intersectSphere(ks,_c)===null||Kn.origin.distanceToSquared(_c)>(t.far-t.near)**2))&&(gc.copy(r).invert(),Kn.copy(t.ray).applyMatrix4(gc),!(n.boundingBox!==null&&Kn.intersectsBox(n.boundingBox)===!1)&&this._computeIntersections(t,e,Kn)))}_computeIntersections(t,e,n){let s;const r=this.geometry,o=this.material,a=r.index,c=r.attributes.position,l=r.attributes.uv,h=r.attributes.uv1,d=r.attributes.normal,u=r.groups,f=r.drawRange;if(a!==null)if(Array.isArray(o))for(let g=0,_=u.length;g<_;g++){const p=u[g],m=o[p.materialIndex],w=Math.max(p.start,f.start),x=Math.min(a.count,Math.min(p.start+p.count,f.start+f.count));for(let b=w,I=x;b<I;b+=3){const R=a.getX(b),A=a.getX(b+1),P=a.getX(b+2);s=Vs(this,m,t,n,l,h,d,R,A,P),s&&(s.faceIndex=Math.floor(b/3),s.face.materialIndex=p.materialIndex,e.push(s))}}else{const g=Math.max(0,f.start),_=Math.min(a.count,f.start+f.count);for(let p=g,m=_;p<m;p+=3){const w=a.getX(p),x=a.getX(p+1),b=a.getX(p+2);s=Vs(this,o,t,n,l,h,d,w,x,b),s&&(s.faceIndex=Math.floor(p/3),e.push(s))}}else if(c!==void 0)if(Array.isArray(o))for(let g=0,_=u.length;g<_;g++){const p=u[g],m=o[p.materialIndex],w=Math.max(p.start,f.start),x=Math.min(c.count,Math.min(p.start+p.count,f.start+f.count));for(let b=w,I=x;b<I;b+=3){const R=b,A=b+1,P=b+2;s=Vs(this,m,t,n,l,h,d,R,A,P),s&&(s.faceIndex=Math.floor(b/3),s.face.materialIndex=p.materialIndex,e.push(s))}}else{const g=Math.max(0,f.start),_=Math.min(c.count,f.start+f.count);for(let p=g,m=_;p<m;p+=3){const w=p,x=p+1,b=p+2;s=Vs(this,o,t,n,l,h,d,w,x,b),s&&(s.faceIndex=Math.floor(p/3),e.push(s))}}}}function nd(i,t,e,n,s,r,o,a){let c;if(t.side===Re?c=n.intersectTriangle(o,r,s,!0,a):c=n.intersectTriangle(s,r,o,t.side===Bn,a),c===null)return null;Hs.copy(a),Hs.applyMatrix4(i.matrixWorld);const l=e.ray.origin.distanceTo(Hs);return l<e.near||l>e.far?null:{distance:l,point:Hs.clone(),object:i}}function Vs(i,t,e,n,s,r,o,a,c,l){i.getVertexPosition(a,Fs),i.getVertexPosition(c,Os),i.getVertexPosition(l,Bs);const h=nd(i,t,e,n,Fs,Os,Bs,vc);if(h){const d=new C;Ye.getBarycoord(vc,Fs,Os,Bs,d),s&&(h.uv=Ye.getInterpolatedAttribute(s,a,c,l,d,new nt)),r&&(h.uv1=Ye.getInterpolatedAttribute(r,a,c,l,d,new nt)),o&&(h.normal=Ye.getInterpolatedAttribute(o,a,c,l,d,new C),h.normal.dot(n.direction)>0&&h.normal.multiplyScalar(-1));const u={a,b:c,c:l,normal:new C,materialIndex:0};Ye.getNormal(Fs,Os,Bs,u.normal),h.face=u,h.barycoord=d}return h}class zn extends Ne{constructor(t=1,e=1,n=1,s=1,r=1,o=1){super(),this.type="BoxGeometry",this.parameters={width:t,height:e,depth:n,widthSegments:s,heightSegments:r,depthSegments:o};const a=this;s=Math.floor(s),r=Math.floor(r),o=Math.floor(o);const c=[],l=[],h=[],d=[];let u=0,f=0;g("z","y","x",-1,-1,n,e,t,o,r,0),g("z","y","x",1,-1,n,e,-t,o,r,1),g("x","z","y",1,1,t,n,e,s,o,2),g("x","z","y",1,-1,t,n,-e,s,o,3),g("x","y","z",1,-1,t,e,n,s,r,4),g("x","y","z",-1,-1,t,e,-n,s,r,5),this.setIndex(c),this.setAttribute("position",new Se(l,3)),this.setAttribute("normal",new Se(h,3)),this.setAttribute("uv",new Se(d,2));function g(_,p,m,w,x,b,I,R,A,P,W){const v=b/A,S=I/P,F=b/2,N=I/2,H=R/2,X=A+1,z=P+1;let J=0,G=0;const ht=new C;for(let ft=0;ft<z;ft++){const pt=ft*S-N;for(let $t=0;$t<X;$t++){const jt=$t*v-F;ht[_]=jt*w,ht[p]=pt*x,ht[m]=H,l.push(ht.x,ht.y,ht.z),ht[_]=0,ht[p]=0,ht[m]=R>0?1:-1,h.push(ht.x,ht.y,ht.z),d.push($t/A),d.push(1-ft/P),J+=1}}for(let ft=0;ft<P;ft++)for(let pt=0;pt<A;pt++){const $t=u+pt+X*ft,jt=u+pt+X*(ft+1),$=u+(pt+1)+X*(ft+1),tt=u+(pt+1)+X*ft;c.push($t,jt,tt),c.push(jt,$,tt),G+=6}a.addGroup(f,G,W),f+=G,u+=J}}copy(t){return super.copy(t),this.parameters=Object.assign({},t.parameters),this}static fromJSON(t){return new zn(t.width,t.height,t.depth,t.widthSegments,t.heightSegments,t.depthSegments)}}function $i(i){const t={};for(const e in i){t[e]={};for(const n in i[e]){const s=i[e][n];s&&(s.isColor||s.isMatrix3||s.isMatrix4||s.isVector2||s.isVector3||s.isVector4||s.isTexture||s.isQuaternion)?s.isRenderTargetTexture?(console.warn("UniformsUtils: Textures of render targets cannot be cloned via cloneUniforms() or mergeUniforms()."),t[e][n]=null):t[e][n]=s.clone():Array.isArray(s)?t[e][n]=s.slice():t[e][n]=s}}return t}function Ce(i){const t={};for(let e=0;e<i.length;e++){const n=$i(i[e]);for(const s in n)t[s]=n[s]}return t}function id(i){const t=[];for(let e=0;e<i.length;e++)t.push(i[e].clone());return t}function ql(i){const t=i.getRenderTarget();return t===null?i.outputColorSpace:t.isXRRenderTarget===!0?t.texture.colorSpace:ee.workingColorSpace}const sd={clone:$i,merge:Ce};var rd=`void main() {
	gl_Position = projectionMatrix * modelViewMatrix * vec4( position, 1.0 );
}`,od=`void main() {
	gl_FragColor = vec4( 1.0, 0.0, 0.0, 1.0 );
}`;class Hn extends Ki{constructor(t){super(),this.isShaderMaterial=!0,this.type="ShaderMaterial",this.defines={},this.uniforms={},this.uniformsGroups=[],this.vertexShader=rd,this.fragmentShader=od,this.linewidth=1,this.wireframe=!1,this.wireframeLinewidth=1,this.fog=!1,this.lights=!1,this.clipping=!1,this.forceSinglePass=!0,this.extensions={clipCullDistance:!1,multiDraw:!1},this.defaultAttributeValues={color:[1,1,1],uv:[0,0],uv1:[0,0]},this.index0AttributeName=void 0,this.uniformsNeedUpdate=!1,this.glslVersion=null,t!==void 0&&this.setValues(t)}copy(t){return super.copy(t),this.fragmentShader=t.fragmentShader,this.vertexShader=t.vertexShader,this.uniforms=$i(t.uniforms),this.uniformsGroups=id(t.uniformsGroups),this.defines=Object.assign({},t.defines),this.wireframe=t.wireframe,this.wireframeLinewidth=t.wireframeLinewidth,this.fog=t.fog,this.lights=t.lights,this.clipping=t.clipping,this.extensions=Object.assign({},t.extensions),this.glslVersion=t.glslVersion,this}toJSON(t){const e=super.toJSON(t);e.glslVersion=this.glslVersion,e.uniforms={};for(const s in this.uniforms){const o=this.uniforms[s].value;o&&o.isTexture?e.uniforms[s]={type:"t",value:o.toJSON(t).uuid}:o&&o.isColor?e.uniforms[s]={type:"c",value:o.getHex()}:o&&o.isVector2?e.uniforms[s]={type:"v2",value:o.toArray()}:o&&o.isVector3?e.uniforms[s]={type:"v3",value:o.toArray()}:o&&o.isVector4?e.uniforms[s]={type:"v4",value:o.toArray()}:o&&o.isMatrix3?e.uniforms[s]={type:"m3",value:o.toArray()}:o&&o.isMatrix4?e.uniforms[s]={type:"m4",value:o.toArray()}:e.uniforms[s]={value:o}}Object.keys(this.defines).length>0&&(e.defines=this.defines),e.vertexShader=this.vertexShader,e.fragmentShader=this.fragmentShader,e.lights=this.lights,e.clipping=this.clipping;const n={};for(const s in this.extensions)this.extensions[s]===!0&&(n[s]=!0);return Object.keys(n).length>0&&(e.extensions=n),e}}class Yl extends Me{constructor(){super(),this.isCamera=!0,this.type="Camera",this.matrixWorldInverse=new re,this.projectionMatrix=new re,this.projectionMatrixInverse=new re,this.coordinateSystem=yn}copy(t,e){return super.copy(t,e),this.matrixWorldInverse.copy(t.matrixWorldInverse),this.projectionMatrix.copy(t.projectionMatrix),this.projectionMatrixInverse.copy(t.projectionMatrixInverse),this.coordinateSystem=t.coordinateSystem,this}getWorldDirection(t){return super.getWorldDirection(t).negate()}updateMatrixWorld(t){super.updateMatrixWorld(t),this.matrixWorldInverse.copy(this.matrixWorld).invert()}updateWorldMatrix(t,e){super.updateWorldMatrix(t,e),this.matrixWorldInverse.copy(this.matrixWorld).invert()}clone(){return new this.constructor().copy(this)}}const Dn=new C,xc=new nt,yc=new nt;class He extends Yl{constructor(t=50,e=1,n=.1,s=2e3){super(),this.isPerspectiveCamera=!0,this.type="PerspectiveCamera",this.fov=t,this.zoom=1,this.near=n,this.far=s,this.focus=10,this.aspect=e,this.view=null,this.filmGauge=35,this.filmOffset=0,this.updateProjectionMatrix()}copy(t,e){return super.copy(t,e),this.fov=t.fov,this.zoom=t.zoom,this.near=t.near,this.far=t.far,this.focus=t.focus,this.aspect=t.aspect,this.view=t.view===null?null:Object.assign({},t.view),this.filmGauge=t.filmGauge,this.filmOffset=t.filmOffset,this}setFocalLength(t){const e=.5*this.getFilmHeight()/t;this.fov=_s*2*Math.atan(e),this.updateProjectionMatrix()}getFocalLength(){const t=Math.tan(Oi*.5*this.fov);return .5*this.getFilmHeight()/t}getEffectiveFOV(){return _s*2*Math.atan(Math.tan(Oi*.5*this.fov)/this.zoom)}getFilmWidth(){return this.filmGauge*Math.min(this.aspect,1)}getFilmHeight(){return this.filmGauge/Math.max(this.aspect,1)}getViewBounds(t,e,n){Dn.set(-1,-1,.5).applyMatrix4(this.projectionMatrixInverse),e.set(Dn.x,Dn.y).multiplyScalar(-t/Dn.z),Dn.set(1,1,.5).applyMatrix4(this.projectionMatrixInverse),n.set(Dn.x,Dn.y).multiplyScalar(-t/Dn.z)}getViewSize(t,e){return this.getViewBounds(t,xc,yc),e.subVectors(yc,xc)}setViewOffset(t,e,n,s,r,o){this.aspect=t/e,this.view===null&&(this.view={enabled:!0,fullWidth:1,fullHeight:1,offsetX:0,offsetY:0,width:1,height:1}),this.view.enabled=!0,this.view.fullWidth=t,this.view.fullHeight=e,this.view.offsetX=n,this.view.offsetY=s,this.view.width=r,this.view.height=o,this.updateProjectionMatrix()}clearViewOffset(){this.view!==null&&(this.view.enabled=!1),this.updateProjectionMatrix()}updateProjectionMatrix(){const t=this.near;let e=t*Math.tan(Oi*.5*this.fov)/this.zoom,n=2*e,s=this.aspect*n,r=-.5*s;const o=this.view;if(this.view!==null&&this.view.enabled){const c=o.fullWidth,l=o.fullHeight;r+=o.offsetX*s/c,e-=o.offsetY*n/l,s*=o.width/c,n*=o.height/l}const a=this.filmOffset;a!==0&&(r+=t*a/this.getFilmWidth()),this.projectionMatrix.makePerspective(r,r+s,e,e-n,t,this.far,this.coordinateSystem),this.projectionMatrixInverse.copy(this.projectionMatrix).invert()}toJSON(t){const e=super.toJSON(t);return e.object.fov=this.fov,e.object.zoom=this.zoom,e.object.near=this.near,e.object.far=this.far,e.object.focus=this.focus,e.object.aspect=this.aspect,this.view!==null&&(e.object.view=Object.assign({},this.view)),e.object.filmGauge=this.filmGauge,e.object.filmOffset=this.filmOffset,e}}const Ei=-90,Ti=1;class ad extends Me{constructor(t,e,n){super(),this.type="CubeCamera",this.renderTarget=n,this.coordinateSystem=null,this.activeMipmapLevel=0;const s=new He(Ei,Ti,t,e);s.layers=this.layers,this.add(s);const r=new He(Ei,Ti,t,e);r.layers=this.layers,this.add(r);const o=new He(Ei,Ti,t,e);o.layers=this.layers,this.add(o);const a=new He(Ei,Ti,t,e);a.layers=this.layers,this.add(a);const c=new He(Ei,Ti,t,e);c.layers=this.layers,this.add(c);const l=new He(Ei,Ti,t,e);l.layers=this.layers,this.add(l)}updateCoordinateSystem(){const t=this.coordinateSystem,e=this.children.concat(),[n,s,r,o,a,c]=e;for(const l of e)this.remove(l);if(t===yn)n.up.set(0,1,0),n.lookAt(1,0,0),s.up.set(0,1,0),s.lookAt(-1,0,0),r.up.set(0,0,-1),r.lookAt(0,1,0),o.up.set(0,0,1),o.lookAt(0,-1,0),a.up.set(0,1,0),a.lookAt(0,0,1),c.up.set(0,1,0),c.lookAt(0,0,-1);else if(t===pr)n.up.set(0,-1,0),n.lookAt(-1,0,0),s.up.set(0,-1,0),s.lookAt(1,0,0),r.up.set(0,0,1),r.lookAt(0,1,0),o.up.set(0,0,-1),o.lookAt(0,-1,0),a.up.set(0,-1,0),a.lookAt(0,0,1),c.up.set(0,-1,0),c.lookAt(0,0,-1);else throw new Error("THREE.CubeCamera.updateCoordinateSystem(): Invalid coordinate system: "+t);for(const l of e)this.add(l),l.updateMatrixWorld()}update(t,e){this.parent===null&&this.updateMatrixWorld();const{renderTarget:n,activeMipmapLevel:s}=this;this.coordinateSystem!==t.coordinateSystem&&(this.coordinateSystem=t.coordinateSystem,this.updateCoordinateSystem());const[r,o,a,c,l,h]=this.children,d=t.getRenderTarget(),u=t.getActiveCubeFace(),f=t.getActiveMipmapLevel(),g=t.xr.enabled;t.xr.enabled=!1;const _=n.texture.generateMipmaps;n.texture.generateMipmaps=!1,t.setRenderTarget(n,0,s),t.render(e,r),t.setRenderTarget(n,1,s),t.render(e,o),t.setRenderTarget(n,2,s),t.render(e,a),t.setRenderTarget(n,3,s),t.render(e,c),t.setRenderTarget(n,4,s),t.render(e,l),n.texture.generateMipmaps=_,t.setRenderTarget(n,5,s),t.render(e,h),t.setRenderTarget(d,u,f),t.xr.enabled=g,n.texture.needsPMREMUpdate=!0}}class Kl extends Ue{constructor(t,e,n,s,r,o,a,c,l,h){t=t!==void 0?t:[],e=e!==void 0?e:Vi,super(t,e,n,s,r,o,a,c,l,h),this.isCubeTexture=!0,this.flipY=!1}get images(){return this.image}set images(t){this.image=t}}class cd extends oi{constructor(t=1,e={}){super(t,t,e),this.isWebGLCubeRenderTarget=!0;const n={width:t,height:t,depth:1},s=[n,n,n,n,n,n];this.texture=new Kl(s,e.mapping,e.wrapS,e.wrapT,e.magFilter,e.minFilter,e.format,e.type,e.anisotropy,e.colorSpace),this.texture.isRenderTargetTexture=!0,this.texture.generateMipmaps=e.generateMipmaps!==void 0?e.generateMipmaps:!1,this.texture.minFilter=e.minFilter!==void 0?e.minFilter:nn}fromEquirectangularTexture(t,e){this.texture.type=e.type,this.texture.colorSpace=e.colorSpace,this.texture.generateMipmaps=e.generateMipmaps,this.texture.minFilter=e.minFilter,this.texture.magFilter=e.magFilter;const n={uniforms:{tEquirect:{value:null}},vertexShader:`

				varying vec3 vWorldDirection;

				vec3 transformDirection( in vec3 dir, in mat4 matrix ) {

					return normalize( ( matrix * vec4( dir, 0.0 ) ).xyz );

				}

				void main() {

					vWorldDirection = transformDirection( position, modelMatrix );

					#include <begin_vertex>
					#include <project_vertex>

				}
			`,fragmentShader:`

				uniform sampler2D tEquirect;

				varying vec3 vWorldDirection;

				#include <common>

				void main() {

					vec3 direction = normalize( vWorldDirection );

					vec2 sampleUV = equirectUv( direction );

					gl_FragColor = texture2D( tEquirect, sampleUV );

				}
			`},s=new zn(5,5,5),r=new Hn({name:"CubemapFromEquirect",uniforms:$i(n.uniforms),vertexShader:n.vertexShader,fragmentShader:n.fragmentShader,side:Re,blending:Fn});r.uniforms.tEquirect.value=e;const o=new ae(s,r),a=e.minFilter;return e.minFilter===ii&&(e.minFilter=nn),new ad(1,10,this).update(t,o),e.minFilter=a,o.geometry.dispose(),o.material.dispose(),this}clear(t,e,n,s){const r=t.getRenderTarget();for(let o=0;o<6;o++)t.setRenderTarget(this,o),t.clear(e,n,s);t.setRenderTarget(r)}}const to=new C,ld=new C,hd=new Vt;class en{constructor(t=new C(1,0,0),e=0){this.isPlane=!0,this.normal=t,this.constant=e}set(t,e){return this.normal.copy(t),this.constant=e,this}setComponents(t,e,n,s){return this.normal.set(t,e,n),this.constant=s,this}setFromNormalAndCoplanarPoint(t,e){return this.normal.copy(t),this.constant=-e.dot(this.normal),this}setFromCoplanarPoints(t,e,n){const s=to.subVectors(n,e).cross(ld.subVectors(t,e)).normalize();return this.setFromNormalAndCoplanarPoint(s,t),this}copy(t){return this.normal.copy(t.normal),this.constant=t.constant,this}normalize(){const t=1/this.normal.length();return this.normal.multiplyScalar(t),this.constant*=t,this}negate(){return this.constant*=-1,this.normal.negate(),this}distanceToPoint(t){return this.normal.dot(t)+this.constant}distanceToSphere(t){return this.distanceToPoint(t.center)-t.radius}projectPoint(t,e){return e.copy(t).addScaledVector(this.normal,-this.distanceToPoint(t))}intersectLine(t,e){const n=t.delta(to),s=this.normal.dot(n);if(s===0)return this.distanceToPoint(t.start)===0?e.copy(t.start):null;const r=-(t.start.dot(this.normal)+this.constant)/s;return r<0||r>1?null:e.copy(t.start).addScaledVector(n,r)}intersectsLine(t){const e=this.distanceToPoint(t.start),n=this.distanceToPoint(t.end);return e<0&&n>0||n<0&&e>0}intersectsBox(t){return t.intersectsPlane(this)}intersectsSphere(t){return t.intersectsPlane(this)}coplanarPoint(t){return t.copy(this.normal).multiplyScalar(-this.constant)}applyMatrix4(t,e){const n=e||hd.getNormalMatrix(t),s=this.coplanarPoint(to).applyMatrix4(t),r=this.normal.applyMatrix3(n).normalize();return this.constant=-s.dot(r),this}translate(t){return this.constant-=t.dot(this.normal),this}equals(t){return t.normal.equals(this.normal)&&t.constant===this.constant}clone(){return new this.constructor().copy(this)}}const Zn=new Sr,Gs=new C;class Ra{constructor(t=new en,e=new en,n=new en,s=new en,r=new en,o=new en){this.planes=[t,e,n,s,r,o]}set(t,e,n,s,r,o){const a=this.planes;return a[0].copy(t),a[1].copy(e),a[2].copy(n),a[3].copy(s),a[4].copy(r),a[5].copy(o),this}copy(t){const e=this.planes;for(let n=0;n<6;n++)e[n].copy(t.planes[n]);return this}setFromProjectionMatrix(t,e=yn){const n=this.planes,s=t.elements,r=s[0],o=s[1],a=s[2],c=s[3],l=s[4],h=s[5],d=s[6],u=s[7],f=s[8],g=s[9],_=s[10],p=s[11],m=s[12],w=s[13],x=s[14],b=s[15];if(n[0].setComponents(c-r,u-l,p-f,b-m).normalize(),n[1].setComponents(c+r,u+l,p+f,b+m).normalize(),n[2].setComponents(c+o,u+h,p+g,b+w).normalize(),n[3].setComponents(c-o,u-h,p-g,b-w).normalize(),n[4].setComponents(c-a,u-d,p-_,b-x).normalize(),e===yn)n[5].setComponents(c+a,u+d,p+_,b+x).normalize();else if(e===pr)n[5].setComponents(a,d,_,x).normalize();else throw new Error("THREE.Frustum.setFromProjectionMatrix(): Invalid coordinate system: "+e);return this}intersectsObject(t){if(t.boundingSphere!==void 0)t.boundingSphere===null&&t.computeBoundingSphere(),Zn.copy(t.boundingSphere).applyMatrix4(t.matrixWorld);else{const e=t.geometry;e.boundingSphere===null&&e.computeBoundingSphere(),Zn.copy(e.boundingSphere).applyMatrix4(t.matrixWorld)}return this.intersectsSphere(Zn)}intersectsSprite(t){return Zn.center.set(0,0,0),Zn.radius=.7071067811865476,Zn.applyMatrix4(t.matrixWorld),this.intersectsSphere(Zn)}intersectsSphere(t){const e=this.planes,n=t.center,s=-t.radius;for(let r=0;r<6;r++)if(e[r].distanceToPoint(n)<s)return!1;return!0}intersectsBox(t){const e=this.planes;for(let n=0;n<6;n++){const s=e[n];if(Gs.x=s.normal.x>0?t.max.x:t.min.x,Gs.y=s.normal.y>0?t.max.y:t.min.y,Gs.z=s.normal.z>0?t.max.z:t.min.z,s.distanceToPoint(Gs)<0)return!1}return!0}containsPoint(t){const e=this.planes;for(let n=0;n<6;n++)if(e[n].distanceToPoint(t)<0)return!1;return!0}clone(){return new this.constructor().copy(this)}}function Zl(){let i=null,t=!1,e=null,n=null;function s(r,o){e(r,o),n=i.requestAnimationFrame(s)}return{start:function(){t!==!0&&e!==null&&(n=i.requestAnimationFrame(s),t=!0)},stop:function(){i.cancelAnimationFrame(n),t=!1},setAnimationLoop:function(r){e=r},setContext:function(r){i=r}}}function ud(i){const t=new WeakMap;function e(a,c){const l=a.array,h=a.usage,d=l.byteLength,u=i.createBuffer();i.bindBuffer(c,u),i.bufferData(c,l,h),a.onUploadCallback();let f;if(l instanceof Float32Array)f=i.FLOAT;else if(l instanceof Uint16Array)a.isFloat16BufferAttribute?f=i.HALF_FLOAT:f=i.UNSIGNED_SHORT;else if(l instanceof Int16Array)f=i.SHORT;else if(l instanceof Uint32Array)f=i.UNSIGNED_INT;else if(l instanceof Int32Array)f=i.INT;else if(l instanceof Int8Array)f=i.BYTE;else if(l instanceof Uint8Array)f=i.UNSIGNED_BYTE;else if(l instanceof Uint8ClampedArray)f=i.UNSIGNED_BYTE;else throw new Error("THREE.WebGLAttributes: Unsupported buffer data format: "+l);return{buffer:u,type:f,bytesPerElement:l.BYTES_PER_ELEMENT,version:a.version,size:d}}function n(a,c,l){const h=c.array,d=c.updateRanges;if(i.bindBuffer(l,a),d.length===0)i.bufferSubData(l,0,h);else{d.sort((f,g)=>f.start-g.start);let u=0;for(let f=1;f<d.length;f++){const g=d[u],_=d[f];_.start<=g.start+g.count+1?g.count=Math.max(g.count,_.start+_.count-g.start):(++u,d[u]=_)}d.length=u+1;for(let f=0,g=d.length;f<g;f++){const _=d[f];i.bufferSubData(l,_.start*h.BYTES_PER_ELEMENT,h,_.start,_.count)}c.clearUpdateRanges()}c.onUploadCallback()}function s(a){return a.isInterleavedBufferAttribute&&(a=a.data),t.get(a)}function r(a){a.isInterleavedBufferAttribute&&(a=a.data);const c=t.get(a);c&&(i.deleteBuffer(c.buffer),t.delete(a))}function o(a,c){if(a.isInterleavedBufferAttribute&&(a=a.data),a.isGLBufferAttribute){const h=t.get(a);(!h||h.version<a.version)&&t.set(a,{buffer:a.buffer,type:a.type,bytesPerElement:a.elementSize,version:a.version});return}const l=t.get(a);if(l===void 0)t.set(a,e(a,c));else if(l.version<a.version){if(l.size!==a.array.byteLength)throw new Error("THREE.WebGLAttributes: The size of the buffer attribute's array buffer does not match the original size. Resizing buffer attributes is not supported.");n(l.buffer,a,c),l.version=a.version}}return{get:s,remove:r,update:o}}class bs extends Ne{constructor(t=1,e=1,n=1,s=1){super(),this.type="PlaneGeometry",this.parameters={width:t,height:e,widthSegments:n,heightSegments:s};const r=t/2,o=e/2,a=Math.floor(n),c=Math.floor(s),l=a+1,h=c+1,d=t/a,u=e/c,f=[],g=[],_=[],p=[];for(let m=0;m<h;m++){const w=m*u-o;for(let x=0;x<l;x++){const b=x*d-r;g.push(b,-w,0),_.push(0,0,1),p.push(x/a),p.push(1-m/c)}}for(let m=0;m<c;m++)for(let w=0;w<a;w++){const x=w+l*m,b=w+l*(m+1),I=w+1+l*(m+1),R=w+1+l*m;f.push(x,b,R),f.push(b,I,R)}this.setIndex(f),this.setAttribute("position",new Se(g,3)),this.setAttribute("normal",new Se(_,3)),this.setAttribute("uv",new Se(p,2))}copy(t){return super.copy(t),this.parameters=Object.assign({},t.parameters),this}static fromJSON(t){return new bs(t.width,t.height,t.widthSegments,t.heightSegments)}}var dd=`#ifdef USE_ALPHAHASH
	if ( diffuseColor.a < getAlphaHashThreshold( vPosition ) ) discard;
#endif`,fd=`#ifdef USE_ALPHAHASH
	const float ALPHA_HASH_SCALE = 0.05;
	float hash2D( vec2 value ) {
		return fract( 1.0e4 * sin( 17.0 * value.x + 0.1 * value.y ) * ( 0.1 + abs( sin( 13.0 * value.y + value.x ) ) ) );
	}
	float hash3D( vec3 value ) {
		return hash2D( vec2( hash2D( value.xy ), value.z ) );
	}
	float getAlphaHashThreshold( vec3 position ) {
		float maxDeriv = max(
			length( dFdx( position.xyz ) ),
			length( dFdy( position.xyz ) )
		);
		float pixScale = 1.0 / ( ALPHA_HASH_SCALE * maxDeriv );
		vec2 pixScales = vec2(
			exp2( floor( log2( pixScale ) ) ),
			exp2( ceil( log2( pixScale ) ) )
		);
		vec2 alpha = vec2(
			hash3D( floor( pixScales.x * position.xyz ) ),
			hash3D( floor( pixScales.y * position.xyz ) )
		);
		float lerpFactor = fract( log2( pixScale ) );
		float x = ( 1.0 - lerpFactor ) * alpha.x + lerpFactor * alpha.y;
		float a = min( lerpFactor, 1.0 - lerpFactor );
		vec3 cases = vec3(
			x * x / ( 2.0 * a * ( 1.0 - a ) ),
			( x - 0.5 * a ) / ( 1.0 - a ),
			1.0 - ( ( 1.0 - x ) * ( 1.0 - x ) / ( 2.0 * a * ( 1.0 - a ) ) )
		);
		float threshold = ( x < ( 1.0 - a ) )
			? ( ( x < a ) ? cases.x : cases.y )
			: cases.z;
		return clamp( threshold , 1.0e-6, 1.0 );
	}
#endif`,pd=`#ifdef USE_ALPHAMAP
	diffuseColor.a *= texture2D( alphaMap, vAlphaMapUv ).g;
#endif`,md=`#ifdef USE_ALPHAMAP
	uniform sampler2D alphaMap;
#endif`,gd=`#ifdef USE_ALPHATEST
	#ifdef ALPHA_TO_COVERAGE
	diffuseColor.a = smoothstep( alphaTest, alphaTest + fwidth( diffuseColor.a ), diffuseColor.a );
	if ( diffuseColor.a == 0.0 ) discard;
	#else
	if ( diffuseColor.a < alphaTest ) discard;
	#endif
#endif`,_d=`#ifdef USE_ALPHATEST
	uniform float alphaTest;
#endif`,vd=`#ifdef USE_AOMAP
	float ambientOcclusion = ( texture2D( aoMap, vAoMapUv ).r - 1.0 ) * aoMapIntensity + 1.0;
	reflectedLight.indirectDiffuse *= ambientOcclusion;
	#if defined( USE_CLEARCOAT ) 
		clearcoatSpecularIndirect *= ambientOcclusion;
	#endif
	#if defined( USE_SHEEN ) 
		sheenSpecularIndirect *= ambientOcclusion;
	#endif
	#if defined( USE_ENVMAP ) && defined( STANDARD )
		float dotNV = saturate( dot( geometryNormal, geometryViewDir ) );
		reflectedLight.indirectSpecular *= computeSpecularOcclusion( dotNV, ambientOcclusion, material.roughness );
	#endif
#endif`,xd=`#ifdef USE_AOMAP
	uniform sampler2D aoMap;
	uniform float aoMapIntensity;
#endif`,yd=`#ifdef USE_BATCHING
	#if ! defined( GL_ANGLE_multi_draw )
	#define gl_DrawID _gl_DrawID
	uniform int _gl_DrawID;
	#endif
	uniform highp sampler2D batchingTexture;
	uniform highp usampler2D batchingIdTexture;
	mat4 getBatchingMatrix( const in float i ) {
		int size = textureSize( batchingTexture, 0 ).x;
		int j = int( i ) * 4;
		int x = j % size;
		int y = j / size;
		vec4 v1 = texelFetch( batchingTexture, ivec2( x, y ), 0 );
		vec4 v2 = texelFetch( batchingTexture, ivec2( x + 1, y ), 0 );
		vec4 v3 = texelFetch( batchingTexture, ivec2( x + 2, y ), 0 );
		vec4 v4 = texelFetch( batchingTexture, ivec2( x + 3, y ), 0 );
		return mat4( v1, v2, v3, v4 );
	}
	float getIndirectIndex( const in int i ) {
		int size = textureSize( batchingIdTexture, 0 ).x;
		int x = i % size;
		int y = i / size;
		return float( texelFetch( batchingIdTexture, ivec2( x, y ), 0 ).r );
	}
#endif
#ifdef USE_BATCHING_COLOR
	uniform sampler2D batchingColorTexture;
	vec3 getBatchingColor( const in float i ) {
		int size = textureSize( batchingColorTexture, 0 ).x;
		int j = int( i );
		int x = j % size;
		int y = j / size;
		return texelFetch( batchingColorTexture, ivec2( x, y ), 0 ).rgb;
	}
#endif`,Md=`#ifdef USE_BATCHING
	mat4 batchingMatrix = getBatchingMatrix( getIndirectIndex( gl_DrawID ) );
#endif`,Sd=`vec3 transformed = vec3( position );
#ifdef USE_ALPHAHASH
	vPosition = vec3( position );
#endif`,bd=`vec3 objectNormal = vec3( normal );
#ifdef USE_TANGENT
	vec3 objectTangent = vec3( tangent.xyz );
#endif`,Ed=`float G_BlinnPhong_Implicit( ) {
	return 0.25;
}
float D_BlinnPhong( const in float shininess, const in float dotNH ) {
	return RECIPROCAL_PI * ( shininess * 0.5 + 1.0 ) * pow( dotNH, shininess );
}
vec3 BRDF_BlinnPhong( const in vec3 lightDir, const in vec3 viewDir, const in vec3 normal, const in vec3 specularColor, const in float shininess ) {
	vec3 halfDir = normalize( lightDir + viewDir );
	float dotNH = saturate( dot( normal, halfDir ) );
	float dotVH = saturate( dot( viewDir, halfDir ) );
	vec3 F = F_Schlick( specularColor, 1.0, dotVH );
	float G = G_BlinnPhong_Implicit( );
	float D = D_BlinnPhong( shininess, dotNH );
	return F * ( G * D );
} // validated`,Td=`#ifdef USE_IRIDESCENCE
	const mat3 XYZ_TO_REC709 = mat3(
		 3.2404542, -0.9692660,  0.0556434,
		-1.5371385,  1.8760108, -0.2040259,
		-0.4985314,  0.0415560,  1.0572252
	);
	vec3 Fresnel0ToIor( vec3 fresnel0 ) {
		vec3 sqrtF0 = sqrt( fresnel0 );
		return ( vec3( 1.0 ) + sqrtF0 ) / ( vec3( 1.0 ) - sqrtF0 );
	}
	vec3 IorToFresnel0( vec3 transmittedIor, float incidentIor ) {
		return pow2( ( transmittedIor - vec3( incidentIor ) ) / ( transmittedIor + vec3( incidentIor ) ) );
	}
	float IorToFresnel0( float transmittedIor, float incidentIor ) {
		return pow2( ( transmittedIor - incidentIor ) / ( transmittedIor + incidentIor ));
	}
	vec3 evalSensitivity( float OPD, vec3 shift ) {
		float phase = 2.0 * PI * OPD * 1.0e-9;
		vec3 val = vec3( 5.4856e-13, 4.4201e-13, 5.2481e-13 );
		vec3 pos = vec3( 1.6810e+06, 1.7953e+06, 2.2084e+06 );
		vec3 var = vec3( 4.3278e+09, 9.3046e+09, 6.6121e+09 );
		vec3 xyz = val * sqrt( 2.0 * PI * var ) * cos( pos * phase + shift ) * exp( - pow2( phase ) * var );
		xyz.x += 9.7470e-14 * sqrt( 2.0 * PI * 4.5282e+09 ) * cos( 2.2399e+06 * phase + shift[ 0 ] ) * exp( - 4.5282e+09 * pow2( phase ) );
		xyz /= 1.0685e-7;
		vec3 rgb = XYZ_TO_REC709 * xyz;
		return rgb;
	}
	vec3 evalIridescence( float outsideIOR, float eta2, float cosTheta1, float thinFilmThickness, vec3 baseF0 ) {
		vec3 I;
		float iridescenceIOR = mix( outsideIOR, eta2, smoothstep( 0.0, 0.03, thinFilmThickness ) );
		float sinTheta2Sq = pow2( outsideIOR / iridescenceIOR ) * ( 1.0 - pow2( cosTheta1 ) );
		float cosTheta2Sq = 1.0 - sinTheta2Sq;
		if ( cosTheta2Sq < 0.0 ) {
			return vec3( 1.0 );
		}
		float cosTheta2 = sqrt( cosTheta2Sq );
		float R0 = IorToFresnel0( iridescenceIOR, outsideIOR );
		float R12 = F_Schlick( R0, 1.0, cosTheta1 );
		float T121 = 1.0 - R12;
		float phi12 = 0.0;
		if ( iridescenceIOR < outsideIOR ) phi12 = PI;
		float phi21 = PI - phi12;
		vec3 baseIOR = Fresnel0ToIor( clamp( baseF0, 0.0, 0.9999 ) );		vec3 R1 = IorToFresnel0( baseIOR, iridescenceIOR );
		vec3 R23 = F_Schlick( R1, 1.0, cosTheta2 );
		vec3 phi23 = vec3( 0.0 );
		if ( baseIOR[ 0 ] < iridescenceIOR ) phi23[ 0 ] = PI;
		if ( baseIOR[ 1 ] < iridescenceIOR ) phi23[ 1 ] = PI;
		if ( baseIOR[ 2 ] < iridescenceIOR ) phi23[ 2 ] = PI;
		float OPD = 2.0 * iridescenceIOR * thinFilmThickness * cosTheta2;
		vec3 phi = vec3( phi21 ) + phi23;
		vec3 R123 = clamp( R12 * R23, 1e-5, 0.9999 );
		vec3 r123 = sqrt( R123 );
		vec3 Rs = pow2( T121 ) * R23 / ( vec3( 1.0 ) - R123 );
		vec3 C0 = R12 + Rs;
		I = C0;
		vec3 Cm = Rs - T121;
		for ( int m = 1; m <= 2; ++ m ) {
			Cm *= r123;
			vec3 Sm = 2.0 * evalSensitivity( float( m ) * OPD, float( m ) * phi );
			I += Cm * Sm;
		}
		return max( I, vec3( 0.0 ) );
	}
#endif`,wd=`#ifdef USE_BUMPMAP
	uniform sampler2D bumpMap;
	uniform float bumpScale;
	vec2 dHdxy_fwd() {
		vec2 dSTdx = dFdx( vBumpMapUv );
		vec2 dSTdy = dFdy( vBumpMapUv );
		float Hll = bumpScale * texture2D( bumpMap, vBumpMapUv ).x;
		float dBx = bumpScale * texture2D( bumpMap, vBumpMapUv + dSTdx ).x - Hll;
		float dBy = bumpScale * texture2D( bumpMap, vBumpMapUv + dSTdy ).x - Hll;
		return vec2( dBx, dBy );
	}
	vec3 perturbNormalArb( vec3 surf_pos, vec3 surf_norm, vec2 dHdxy, float faceDirection ) {
		vec3 vSigmaX = normalize( dFdx( surf_pos.xyz ) );
		vec3 vSigmaY = normalize( dFdy( surf_pos.xyz ) );
		vec3 vN = surf_norm;
		vec3 R1 = cross( vSigmaY, vN );
		vec3 R2 = cross( vN, vSigmaX );
		float fDet = dot( vSigmaX, R1 ) * faceDirection;
		vec3 vGrad = sign( fDet ) * ( dHdxy.x * R1 + dHdxy.y * R2 );
		return normalize( abs( fDet ) * surf_norm - vGrad );
	}
#endif`,Ad=`#if NUM_CLIPPING_PLANES > 0
	vec4 plane;
	#ifdef ALPHA_TO_COVERAGE
		float distanceToPlane, distanceGradient;
		float clipOpacity = 1.0;
		#pragma unroll_loop_start
		for ( int i = 0; i < UNION_CLIPPING_PLANES; i ++ ) {
			plane = clippingPlanes[ i ];
			distanceToPlane = - dot( vClipPosition, plane.xyz ) + plane.w;
			distanceGradient = fwidth( distanceToPlane ) / 2.0;
			clipOpacity *= smoothstep( - distanceGradient, distanceGradient, distanceToPlane );
			if ( clipOpacity == 0.0 ) discard;
		}
		#pragma unroll_loop_end
		#if UNION_CLIPPING_PLANES < NUM_CLIPPING_PLANES
			float unionClipOpacity = 1.0;
			#pragma unroll_loop_start
			for ( int i = UNION_CLIPPING_PLANES; i < NUM_CLIPPING_PLANES; i ++ ) {
				plane = clippingPlanes[ i ];
				distanceToPlane = - dot( vClipPosition, plane.xyz ) + plane.w;
				distanceGradient = fwidth( distanceToPlane ) / 2.0;
				unionClipOpacity *= 1.0 - smoothstep( - distanceGradient, distanceGradient, distanceToPlane );
			}
			#pragma unroll_loop_end
			clipOpacity *= 1.0 - unionClipOpacity;
		#endif
		diffuseColor.a *= clipOpacity;
		if ( diffuseColor.a == 0.0 ) discard;
	#else
		#pragma unroll_loop_start
		for ( int i = 0; i < UNION_CLIPPING_PLANES; i ++ ) {
			plane = clippingPlanes[ i ];
			if ( dot( vClipPosition, plane.xyz ) > plane.w ) discard;
		}
		#pragma unroll_loop_end
		#if UNION_CLIPPING_PLANES < NUM_CLIPPING_PLANES
			bool clipped = true;
			#pragma unroll_loop_start
			for ( int i = UNION_CLIPPING_PLANES; i < NUM_CLIPPING_PLANES; i ++ ) {
				plane = clippingPlanes[ i ];
				clipped = ( dot( vClipPosition, plane.xyz ) > plane.w ) && clipped;
			}
			#pragma unroll_loop_end
			if ( clipped ) discard;
		#endif
	#endif
#endif`,Cd=`#if NUM_CLIPPING_PLANES > 0
	varying vec3 vClipPosition;
	uniform vec4 clippingPlanes[ NUM_CLIPPING_PLANES ];
#endif`,Rd=`#if NUM_CLIPPING_PLANES > 0
	varying vec3 vClipPosition;
#endif`,Pd=`#if NUM_CLIPPING_PLANES > 0
	vClipPosition = - mvPosition.xyz;
#endif`,Ld=`#if defined( USE_COLOR_ALPHA )
	diffuseColor *= vColor;
#elif defined( USE_COLOR )
	diffuseColor.rgb *= vColor;
#endif`,Dd=`#if defined( USE_COLOR_ALPHA )
	varying vec4 vColor;
#elif defined( USE_COLOR )
	varying vec3 vColor;
#endif`,Id=`#if defined( USE_COLOR_ALPHA )
	varying vec4 vColor;
#elif defined( USE_COLOR ) || defined( USE_INSTANCING_COLOR ) || defined( USE_BATCHING_COLOR )
	varying vec3 vColor;
#endif`,Ud=`#if defined( USE_COLOR_ALPHA )
	vColor = vec4( 1.0 );
#elif defined( USE_COLOR ) || defined( USE_INSTANCING_COLOR ) || defined( USE_BATCHING_COLOR )
	vColor = vec3( 1.0 );
#endif
#ifdef USE_COLOR
	vColor *= color;
#endif
#ifdef USE_INSTANCING_COLOR
	vColor.xyz *= instanceColor.xyz;
#endif
#ifdef USE_BATCHING_COLOR
	vec3 batchingColor = getBatchingColor( getIndirectIndex( gl_DrawID ) );
	vColor.xyz *= batchingColor.xyz;
#endif`,Nd=`#define PI 3.141592653589793
#define PI2 6.283185307179586
#define PI_HALF 1.5707963267948966
#define RECIPROCAL_PI 0.3183098861837907
#define RECIPROCAL_PI2 0.15915494309189535
#define EPSILON 1e-6
#ifndef saturate
#define saturate( a ) clamp( a, 0.0, 1.0 )
#endif
#define whiteComplement( a ) ( 1.0 - saturate( a ) )
float pow2( const in float x ) { return x*x; }
vec3 pow2( const in vec3 x ) { return x*x; }
float pow3( const in float x ) { return x*x*x; }
float pow4( const in float x ) { float x2 = x*x; return x2*x2; }
float max3( const in vec3 v ) { return max( max( v.x, v.y ), v.z ); }
float average( const in vec3 v ) { return dot( v, vec3( 0.3333333 ) ); }
highp float rand( const in vec2 uv ) {
	const highp float a = 12.9898, b = 78.233, c = 43758.5453;
	highp float dt = dot( uv.xy, vec2( a,b ) ), sn = mod( dt, PI );
	return fract( sin( sn ) * c );
}
#ifdef HIGH_PRECISION
	float precisionSafeLength( vec3 v ) { return length( v ); }
#else
	float precisionSafeLength( vec3 v ) {
		float maxComponent = max3( abs( v ) );
		return length( v / maxComponent ) * maxComponent;
	}
#endif
struct IncidentLight {
	vec3 color;
	vec3 direction;
	bool visible;
};
struct ReflectedLight {
	vec3 directDiffuse;
	vec3 directSpecular;
	vec3 indirectDiffuse;
	vec3 indirectSpecular;
};
#ifdef USE_ALPHAHASH
	varying vec3 vPosition;
#endif
vec3 transformDirection( in vec3 dir, in mat4 matrix ) {
	return normalize( ( matrix * vec4( dir, 0.0 ) ).xyz );
}
vec3 inverseTransformDirection( in vec3 dir, in mat4 matrix ) {
	return normalize( ( vec4( dir, 0.0 ) * matrix ).xyz );
}
mat3 transposeMat3( const in mat3 m ) {
	mat3 tmp;
	tmp[ 0 ] = vec3( m[ 0 ].x, m[ 1 ].x, m[ 2 ].x );
	tmp[ 1 ] = vec3( m[ 0 ].y, m[ 1 ].y, m[ 2 ].y );
	tmp[ 2 ] = vec3( m[ 0 ].z, m[ 1 ].z, m[ 2 ].z );
	return tmp;
}
bool isPerspectiveMatrix( mat4 m ) {
	return m[ 2 ][ 3 ] == - 1.0;
}
vec2 equirectUv( in vec3 dir ) {
	float u = atan( dir.z, dir.x ) * RECIPROCAL_PI2 + 0.5;
	float v = asin( clamp( dir.y, - 1.0, 1.0 ) ) * RECIPROCAL_PI + 0.5;
	return vec2( u, v );
}
vec3 BRDF_Lambert( const in vec3 diffuseColor ) {
	return RECIPROCAL_PI * diffuseColor;
}
vec3 F_Schlick( const in vec3 f0, const in float f90, const in float dotVH ) {
	float fresnel = exp2( ( - 5.55473 * dotVH - 6.98316 ) * dotVH );
	return f0 * ( 1.0 - fresnel ) + ( f90 * fresnel );
}
float F_Schlick( const in float f0, const in float f90, const in float dotVH ) {
	float fresnel = exp2( ( - 5.55473 * dotVH - 6.98316 ) * dotVH );
	return f0 * ( 1.0 - fresnel ) + ( f90 * fresnel );
} // validated`,kd=`#ifdef ENVMAP_TYPE_CUBE_UV
	#define cubeUV_minMipLevel 4.0
	#define cubeUV_minTileSize 16.0
	float getFace( vec3 direction ) {
		vec3 absDirection = abs( direction );
		float face = - 1.0;
		if ( absDirection.x > absDirection.z ) {
			if ( absDirection.x > absDirection.y )
				face = direction.x > 0.0 ? 0.0 : 3.0;
			else
				face = direction.y > 0.0 ? 1.0 : 4.0;
		} else {
			if ( absDirection.z > absDirection.y )
				face = direction.z > 0.0 ? 2.0 : 5.0;
			else
				face = direction.y > 0.0 ? 1.0 : 4.0;
		}
		return face;
	}
	vec2 getUV( vec3 direction, float face ) {
		vec2 uv;
		if ( face == 0.0 ) {
			uv = vec2( direction.z, direction.y ) / abs( direction.x );
		} else if ( face == 1.0 ) {
			uv = vec2( - direction.x, - direction.z ) / abs( direction.y );
		} else if ( face == 2.0 ) {
			uv = vec2( - direction.x, direction.y ) / abs( direction.z );
		} else if ( face == 3.0 ) {
			uv = vec2( - direction.z, direction.y ) / abs( direction.x );
		} else if ( face == 4.0 ) {
			uv = vec2( - direction.x, direction.z ) / abs( direction.y );
		} else {
			uv = vec2( direction.x, direction.y ) / abs( direction.z );
		}
		return 0.5 * ( uv + 1.0 );
	}
	vec3 bilinearCubeUV( sampler2D envMap, vec3 direction, float mipInt ) {
		float face = getFace( direction );
		float filterInt = max( cubeUV_minMipLevel - mipInt, 0.0 );
		mipInt = max( mipInt, cubeUV_minMipLevel );
		float faceSize = exp2( mipInt );
		highp vec2 uv = getUV( direction, face ) * ( faceSize - 2.0 ) + 1.0;
		if ( face > 2.0 ) {
			uv.y += faceSize;
			face -= 3.0;
		}
		uv.x += face * faceSize;
		uv.x += filterInt * 3.0 * cubeUV_minTileSize;
		uv.y += 4.0 * ( exp2( CUBEUV_MAX_MIP ) - faceSize );
		uv.x *= CUBEUV_TEXEL_WIDTH;
		uv.y *= CUBEUV_TEXEL_HEIGHT;
		#ifdef texture2DGradEXT
			return texture2DGradEXT( envMap, uv, vec2( 0.0 ), vec2( 0.0 ) ).rgb;
		#else
			return texture2D( envMap, uv ).rgb;
		#endif
	}
	#define cubeUV_r0 1.0
	#define cubeUV_m0 - 2.0
	#define cubeUV_r1 0.8
	#define cubeUV_m1 - 1.0
	#define cubeUV_r4 0.4
	#define cubeUV_m4 2.0
	#define cubeUV_r5 0.305
	#define cubeUV_m5 3.0
	#define cubeUV_r6 0.21
	#define cubeUV_m6 4.0
	float roughnessToMip( float roughness ) {
		float mip = 0.0;
		if ( roughness >= cubeUV_r1 ) {
			mip = ( cubeUV_r0 - roughness ) * ( cubeUV_m1 - cubeUV_m0 ) / ( cubeUV_r0 - cubeUV_r1 ) + cubeUV_m0;
		} else if ( roughness >= cubeUV_r4 ) {
			mip = ( cubeUV_r1 - roughness ) * ( cubeUV_m4 - cubeUV_m1 ) / ( cubeUV_r1 - cubeUV_r4 ) + cubeUV_m1;
		} else if ( roughness >= cubeUV_r5 ) {
			mip = ( cubeUV_r4 - roughness ) * ( cubeUV_m5 - cubeUV_m4 ) / ( cubeUV_r4 - cubeUV_r5 ) + cubeUV_m4;
		} else if ( roughness >= cubeUV_r6 ) {
			mip = ( cubeUV_r5 - roughness ) * ( cubeUV_m6 - cubeUV_m5 ) / ( cubeUV_r5 - cubeUV_r6 ) + cubeUV_m5;
		} else {
			mip = - 2.0 * log2( 1.16 * roughness );		}
		return mip;
	}
	vec4 textureCubeUV( sampler2D envMap, vec3 sampleDir, float roughness ) {
		float mip = clamp( roughnessToMip( roughness ), cubeUV_m0, CUBEUV_MAX_MIP );
		float mipF = fract( mip );
		float mipInt = floor( mip );
		vec3 color0 = bilinearCubeUV( envMap, sampleDir, mipInt );
		if ( mipF == 0.0 ) {
			return vec4( color0, 1.0 );
		} else {
			vec3 color1 = bilinearCubeUV( envMap, sampleDir, mipInt + 1.0 );
			return vec4( mix( color0, color1, mipF ), 1.0 );
		}
	}
#endif`,Fd=`vec3 transformedNormal = objectNormal;
#ifdef USE_TANGENT
	vec3 transformedTangent = objectTangent;
#endif
#ifdef USE_BATCHING
	mat3 bm = mat3( batchingMatrix );
	transformedNormal /= vec3( dot( bm[ 0 ], bm[ 0 ] ), dot( bm[ 1 ], bm[ 1 ] ), dot( bm[ 2 ], bm[ 2 ] ) );
	transformedNormal = bm * transformedNormal;
	#ifdef USE_TANGENT
		transformedTangent = bm * transformedTangent;
	#endif
#endif
#ifdef USE_INSTANCING
	mat3 im = mat3( instanceMatrix );
	transformedNormal /= vec3( dot( im[ 0 ], im[ 0 ] ), dot( im[ 1 ], im[ 1 ] ), dot( im[ 2 ], im[ 2 ] ) );
	transformedNormal = im * transformedNormal;
	#ifdef USE_TANGENT
		transformedTangent = im * transformedTangent;
	#endif
#endif
transformedNormal = normalMatrix * transformedNormal;
#ifdef FLIP_SIDED
	transformedNormal = - transformedNormal;
#endif
#ifdef USE_TANGENT
	transformedTangent = ( modelViewMatrix * vec4( transformedTangent, 0.0 ) ).xyz;
	#ifdef FLIP_SIDED
		transformedTangent = - transformedTangent;
	#endif
#endif`,Od=`#ifdef USE_DISPLACEMENTMAP
	uniform sampler2D displacementMap;
	uniform float displacementScale;
	uniform float displacementBias;
#endif`,Bd=`#ifdef USE_DISPLACEMENTMAP
	transformed += normalize( objectNormal ) * ( texture2D( displacementMap, vDisplacementMapUv ).x * displacementScale + displacementBias );
#endif`,zd=`#ifdef USE_EMISSIVEMAP
	vec4 emissiveColor = texture2D( emissiveMap, vEmissiveMapUv );
	totalEmissiveRadiance *= emissiveColor.rgb;
#endif`,Hd=`#ifdef USE_EMISSIVEMAP
	uniform sampler2D emissiveMap;
#endif`,Vd="gl_FragColor = linearToOutputTexel( gl_FragColor );",Gd=`
const mat3 LINEAR_SRGB_TO_LINEAR_DISPLAY_P3 = mat3(
	vec3( 0.8224621, 0.177538, 0.0 ),
	vec3( 0.0331941, 0.9668058, 0.0 ),
	vec3( 0.0170827, 0.0723974, 0.9105199 )
);
const mat3 LINEAR_DISPLAY_P3_TO_LINEAR_SRGB = mat3(
	vec3( 1.2249401, - 0.2249404, 0.0 ),
	vec3( - 0.0420569, 1.0420571, 0.0 ),
	vec3( - 0.0196376, - 0.0786361, 1.0982735 )
);
vec4 LinearSRGBToLinearDisplayP3( in vec4 value ) {
	return vec4( value.rgb * LINEAR_SRGB_TO_LINEAR_DISPLAY_P3, value.a );
}
vec4 LinearDisplayP3ToLinearSRGB( in vec4 value ) {
	return vec4( value.rgb * LINEAR_DISPLAY_P3_TO_LINEAR_SRGB, value.a );
}
vec4 LinearTransferOETF( in vec4 value ) {
	return value;
}
vec4 sRGBTransferOETF( in vec4 value ) {
	return vec4( mix( pow( value.rgb, vec3( 0.41666 ) ) * 1.055 - vec3( 0.055 ), value.rgb * 12.92, vec3( lessThanEqual( value.rgb, vec3( 0.0031308 ) ) ) ), value.a );
}`,Wd=`#ifdef USE_ENVMAP
	#ifdef ENV_WORLDPOS
		vec3 cameraToFrag;
		if ( isOrthographic ) {
			cameraToFrag = normalize( vec3( - viewMatrix[ 0 ][ 2 ], - viewMatrix[ 1 ][ 2 ], - viewMatrix[ 2 ][ 2 ] ) );
		} else {
			cameraToFrag = normalize( vWorldPosition - cameraPosition );
		}
		vec3 worldNormal = inverseTransformDirection( normal, viewMatrix );
		#ifdef ENVMAP_MODE_REFLECTION
			vec3 reflectVec = reflect( cameraToFrag, worldNormal );
		#else
			vec3 reflectVec = refract( cameraToFrag, worldNormal, refractionRatio );
		#endif
	#else
		vec3 reflectVec = vReflect;
	#endif
	#ifdef ENVMAP_TYPE_CUBE
		vec4 envColor = textureCube( envMap, envMapRotation * vec3( flipEnvMap * reflectVec.x, reflectVec.yz ) );
	#else
		vec4 envColor = vec4( 0.0 );
	#endif
	#ifdef ENVMAP_BLENDING_MULTIPLY
		outgoingLight = mix( outgoingLight, outgoingLight * envColor.xyz, specularStrength * reflectivity );
	#elif defined( ENVMAP_BLENDING_MIX )
		outgoingLight = mix( outgoingLight, envColor.xyz, specularStrength * reflectivity );
	#elif defined( ENVMAP_BLENDING_ADD )
		outgoingLight += envColor.xyz * specularStrength * reflectivity;
	#endif
#endif`,Xd=`#ifdef USE_ENVMAP
	uniform float envMapIntensity;
	uniform float flipEnvMap;
	uniform mat3 envMapRotation;
	#ifdef ENVMAP_TYPE_CUBE
		uniform samplerCube envMap;
	#else
		uniform sampler2D envMap;
	#endif
	
#endif`,$d=`#ifdef USE_ENVMAP
	uniform float reflectivity;
	#if defined( USE_BUMPMAP ) || defined( USE_NORMALMAP ) || defined( PHONG ) || defined( LAMBERT )
		#define ENV_WORLDPOS
	#endif
	#ifdef ENV_WORLDPOS
		varying vec3 vWorldPosition;
		uniform float refractionRatio;
	#else
		varying vec3 vReflect;
	#endif
#endif`,qd=`#ifdef USE_ENVMAP
	#if defined( USE_BUMPMAP ) || defined( USE_NORMALMAP ) || defined( PHONG ) || defined( LAMBERT )
		#define ENV_WORLDPOS
	#endif
	#ifdef ENV_WORLDPOS
		
		varying vec3 vWorldPosition;
	#else
		varying vec3 vReflect;
		uniform float refractionRatio;
	#endif
#endif`,Yd=`#ifdef USE_ENVMAP
	#ifdef ENV_WORLDPOS
		vWorldPosition = worldPosition.xyz;
	#else
		vec3 cameraToVertex;
		if ( isOrthographic ) {
			cameraToVertex = normalize( vec3( - viewMatrix[ 0 ][ 2 ], - viewMatrix[ 1 ][ 2 ], - viewMatrix[ 2 ][ 2 ] ) );
		} else {
			cameraToVertex = normalize( worldPosition.xyz - cameraPosition );
		}
		vec3 worldNormal = inverseTransformDirection( transformedNormal, viewMatrix );
		#ifdef ENVMAP_MODE_REFLECTION
			vReflect = reflect( cameraToVertex, worldNormal );
		#else
			vReflect = refract( cameraToVertex, worldNormal, refractionRatio );
		#endif
	#endif
#endif`,Kd=`#ifdef USE_FOG
	vFogDepth = - mvPosition.z;
#endif`,Zd=`#ifdef USE_FOG
	varying float vFogDepth;
#endif`,jd=`#ifdef USE_FOG
	#ifdef FOG_EXP2
		float fogFactor = 1.0 - exp( - fogDensity * fogDensity * vFogDepth * vFogDepth );
	#else
		float fogFactor = smoothstep( fogNear, fogFar, vFogDepth );
	#endif
	gl_FragColor.rgb = mix( gl_FragColor.rgb, fogColor, fogFactor );
#endif`,Jd=`#ifdef USE_FOG
	uniform vec3 fogColor;
	varying float vFogDepth;
	#ifdef FOG_EXP2
		uniform float fogDensity;
	#else
		uniform float fogNear;
		uniform float fogFar;
	#endif
#endif`,Qd=`#ifdef USE_GRADIENTMAP
	uniform sampler2D gradientMap;
#endif
vec3 getGradientIrradiance( vec3 normal, vec3 lightDirection ) {
	float dotNL = dot( normal, lightDirection );
	vec2 coord = vec2( dotNL * 0.5 + 0.5, 0.0 );
	#ifdef USE_GRADIENTMAP
		return vec3( texture2D( gradientMap, coord ).r );
	#else
		vec2 fw = fwidth( coord ) * 0.5;
		return mix( vec3( 0.7 ), vec3( 1.0 ), smoothstep( 0.7 - fw.x, 0.7 + fw.x, coord.x ) );
	#endif
}`,tf=`#ifdef USE_LIGHTMAP
	uniform sampler2D lightMap;
	uniform float lightMapIntensity;
#endif`,ef=`LambertMaterial material;
material.diffuseColor = diffuseColor.rgb;
material.specularStrength = specularStrength;`,nf=`varying vec3 vViewPosition;
struct LambertMaterial {
	vec3 diffuseColor;
	float specularStrength;
};
void RE_Direct_Lambert( const in IncidentLight directLight, const in vec3 geometryPosition, const in vec3 geometryNormal, const in vec3 geometryViewDir, const in vec3 geometryClearcoatNormal, const in LambertMaterial material, inout ReflectedLight reflectedLight ) {
	float dotNL = saturate( dot( geometryNormal, directLight.direction ) );
	vec3 irradiance = dotNL * directLight.color;
	reflectedLight.directDiffuse += irradiance * BRDF_Lambert( material.diffuseColor );
}
void RE_IndirectDiffuse_Lambert( const in vec3 irradiance, const in vec3 geometryPosition, const in vec3 geometryNormal, const in vec3 geometryViewDir, const in vec3 geometryClearcoatNormal, const in LambertMaterial material, inout ReflectedLight reflectedLight ) {
	reflectedLight.indirectDiffuse += irradiance * BRDF_Lambert( material.diffuseColor );
}
#define RE_Direct				RE_Direct_Lambert
#define RE_IndirectDiffuse		RE_IndirectDiffuse_Lambert`,sf=`uniform bool receiveShadow;
uniform vec3 ambientLightColor;
#if defined( USE_LIGHT_PROBES )
	uniform vec3 lightProbe[ 9 ];
#endif
vec3 shGetIrradianceAt( in vec3 normal, in vec3 shCoefficients[ 9 ] ) {
	float x = normal.x, y = normal.y, z = normal.z;
	vec3 result = shCoefficients[ 0 ] * 0.886227;
	result += shCoefficients[ 1 ] * 2.0 * 0.511664 * y;
	result += shCoefficients[ 2 ] * 2.0 * 0.511664 * z;
	result += shCoefficients[ 3 ] * 2.0 * 0.511664 * x;
	result += shCoefficients[ 4 ] * 2.0 * 0.429043 * x * y;
	result += shCoefficients[ 5 ] * 2.0 * 0.429043 * y * z;
	result += shCoefficients[ 6 ] * ( 0.743125 * z * z - 0.247708 );
	result += shCoefficients[ 7 ] * 2.0 * 0.429043 * x * z;
	result += shCoefficients[ 8 ] * 0.429043 * ( x * x - y * y );
	return result;
}
vec3 getLightProbeIrradiance( const in vec3 lightProbe[ 9 ], const in vec3 normal ) {
	vec3 worldNormal = inverseTransformDirection( normal, viewMatrix );
	vec3 irradiance = shGetIrradianceAt( worldNormal, lightProbe );
	return irradiance;
}
vec3 getAmbientLightIrradiance( const in vec3 ambientLightColor ) {
	vec3 irradiance = ambientLightColor;
	return irradiance;
}
float getDistanceAttenuation( const in float lightDistance, const in float cutoffDistance, const in float decayExponent ) {
	float distanceFalloff = 1.0 / max( pow( lightDistance, decayExponent ), 0.01 );
	if ( cutoffDistance > 0.0 ) {
		distanceFalloff *= pow2( saturate( 1.0 - pow4( lightDistance / cutoffDistance ) ) );
	}
	return distanceFalloff;
}
float getSpotAttenuation( const in float coneCosine, const in float penumbraCosine, const in float angleCosine ) {
	return smoothstep( coneCosine, penumbraCosine, angleCosine );
}
#if NUM_DIR_LIGHTS > 0
	struct DirectionalLight {
		vec3 direction;
		vec3 color;
	};
	uniform DirectionalLight directionalLights[ NUM_DIR_LIGHTS ];
	void getDirectionalLightInfo( const in DirectionalLight directionalLight, out IncidentLight light ) {
		light.color = directionalLight.color;
		light.direction = directionalLight.direction;
		light.visible = true;
	}
#endif
#if NUM_POINT_LIGHTS > 0
	struct PointLight {
		vec3 position;
		vec3 color;
		float distance;
		float decay;
	};
	uniform PointLight pointLights[ NUM_POINT_LIGHTS ];
	void getPointLightInfo( const in PointLight pointLight, const in vec3 geometryPosition, out IncidentLight light ) {
		vec3 lVector = pointLight.position - geometryPosition;
		light.direction = normalize( lVector );
		float lightDistance = length( lVector );
		light.color = pointLight.color;
		light.color *= getDistanceAttenuation( lightDistance, pointLight.distance, pointLight.decay );
		light.visible = ( light.color != vec3( 0.0 ) );
	}
#endif
#if NUM_SPOT_LIGHTS > 0
	struct SpotLight {
		vec3 position;
		vec3 direction;
		vec3 color;
		float distance;
		float decay;
		float coneCos;
		float penumbraCos;
	};
	uniform SpotLight spotLights[ NUM_SPOT_LIGHTS ];
	void getSpotLightInfo( const in SpotLight spotLight, const in vec3 geometryPosition, out IncidentLight light ) {
		vec3 lVector = spotLight.position - geometryPosition;
		light.direction = normalize( lVector );
		float angleCos = dot( light.direction, spotLight.direction );
		float spotAttenuation = getSpotAttenuation( spotLight.coneCos, spotLight.penumbraCos, angleCos );
		if ( spotAttenuation > 0.0 ) {
			float lightDistance = length( lVector );
			light.color = spotLight.color * spotAttenuation;
			light.color *= getDistanceAttenuation( lightDistance, spotLight.distance, spotLight.decay );
			light.visible = ( light.color != vec3( 0.0 ) );
		} else {
			light.color = vec3( 0.0 );
			light.visible = false;
		}
	}
#endif
#if NUM_RECT_AREA_LIGHTS > 0
	struct RectAreaLight {
		vec3 color;
		vec3 position;
		vec3 halfWidth;
		vec3 halfHeight;
	};
	uniform sampler2D ltc_1;	uniform sampler2D ltc_2;
	uniform RectAreaLight rectAreaLights[ NUM_RECT_AREA_LIGHTS ];
#endif
#if NUM_HEMI_LIGHTS > 0
	struct HemisphereLight {
		vec3 direction;
		vec3 skyColor;
		vec3 groundColor;
	};
	uniform HemisphereLight hemisphereLights[ NUM_HEMI_LIGHTS ];
	vec3 getHemisphereLightIrradiance( const in HemisphereLight hemiLight, const in vec3 normal ) {
		float dotNL = dot( normal, hemiLight.direction );
		float hemiDiffuseWeight = 0.5 * dotNL + 0.5;
		vec3 irradiance = mix( hemiLight.groundColor, hemiLight.skyColor, hemiDiffuseWeight );
		return irradiance;
	}
#endif`,rf=`#ifdef USE_ENVMAP
	vec3 getIBLIrradiance( const in vec3 normal ) {
		#ifdef ENVMAP_TYPE_CUBE_UV
			vec3 worldNormal = inverseTransformDirection( normal, viewMatrix );
			vec4 envMapColor = textureCubeUV( envMap, envMapRotation * worldNormal, 1.0 );
			return PI * envMapColor.rgb * envMapIntensity;
		#else
			return vec3( 0.0 );
		#endif
	}
	vec3 getIBLRadiance( const in vec3 viewDir, const in vec3 normal, const in float roughness ) {
		#ifdef ENVMAP_TYPE_CUBE_UV
			vec3 reflectVec = reflect( - viewDir, normal );
			reflectVec = normalize( mix( reflectVec, normal, roughness * roughness) );
			reflectVec = inverseTransformDirection( reflectVec, viewMatrix );
			vec4 envMapColor = textureCubeUV( envMap, envMapRotation * reflectVec, roughness );
			return envMapColor.rgb * envMapIntensity;
		#else
			return vec3( 0.0 );
		#endif
	}
	#ifdef USE_ANISOTROPY
		vec3 getIBLAnisotropyRadiance( const in vec3 viewDir, const in vec3 normal, const in float roughness, const in vec3 bitangent, const in float anisotropy ) {
			#ifdef ENVMAP_TYPE_CUBE_UV
				vec3 bentNormal = cross( bitangent, viewDir );
				bentNormal = normalize( cross( bentNormal, bitangent ) );
				bentNormal = normalize( mix( bentNormal, normal, pow2( pow2( 1.0 - anisotropy * ( 1.0 - roughness ) ) ) ) );
				return getIBLRadiance( viewDir, bentNormal, roughness );
			#else
				return vec3( 0.0 );
			#endif
		}
	#endif
#endif`,of=`ToonMaterial material;
material.diffuseColor = diffuseColor.rgb;`,af=`varying vec3 vViewPosition;
struct ToonMaterial {
	vec3 diffuseColor;
};
void RE_Direct_Toon( const in IncidentLight directLight, const in vec3 geometryPosition, const in vec3 geometryNormal, const in vec3 geometryViewDir, const in vec3 geometryClearcoatNormal, const in ToonMaterial material, inout ReflectedLight reflectedLight ) {
	vec3 irradiance = getGradientIrradiance( geometryNormal, directLight.direction ) * directLight.color;
	reflectedLight.directDiffuse += irradiance * BRDF_Lambert( material.diffuseColor );
}
void RE_IndirectDiffuse_Toon( const in vec3 irradiance, const in vec3 geometryPosition, const in vec3 geometryNormal, const in vec3 geometryViewDir, const in vec3 geometryClearcoatNormal, const in ToonMaterial material, inout ReflectedLight reflectedLight ) {
	reflectedLight.indirectDiffuse += irradiance * BRDF_Lambert( material.diffuseColor );
}
#define RE_Direct				RE_Direct_Toon
#define RE_IndirectDiffuse		RE_IndirectDiffuse_Toon`,cf=`BlinnPhongMaterial material;
material.diffuseColor = diffuseColor.rgb;
material.specularColor = specular;
material.specularShininess = shininess;
material.specularStrength = specularStrength;`,lf=`varying vec3 vViewPosition;
struct BlinnPhongMaterial {
	vec3 diffuseColor;
	vec3 specularColor;
	float specularShininess;
	float specularStrength;
};
void RE_Direct_BlinnPhong( const in IncidentLight directLight, const in vec3 geometryPosition, const in vec3 geometryNormal, const in vec3 geometryViewDir, const in vec3 geometryClearcoatNormal, const in BlinnPhongMaterial material, inout ReflectedLight reflectedLight ) {
	float dotNL = saturate( dot( geometryNormal, directLight.direction ) );
	vec3 irradiance = dotNL * directLight.color;
	reflectedLight.directDiffuse += irradiance * BRDF_Lambert( material.diffuseColor );
	reflectedLight.directSpecular += irradiance * BRDF_BlinnPhong( directLight.direction, geometryViewDir, geometryNormal, material.specularColor, material.specularShininess ) * material.specularStrength;
}
void RE_IndirectDiffuse_BlinnPhong( const in vec3 irradiance, const in vec3 geometryPosition, const in vec3 geometryNormal, const in vec3 geometryViewDir, const in vec3 geometryClearcoatNormal, const in BlinnPhongMaterial material, inout ReflectedLight reflectedLight ) {
	reflectedLight.indirectDiffuse += irradiance * BRDF_Lambert( material.diffuseColor );
}
#define RE_Direct				RE_Direct_BlinnPhong
#define RE_IndirectDiffuse		RE_IndirectDiffuse_BlinnPhong`,hf=`PhysicalMaterial material;
material.diffuseColor = diffuseColor.rgb * ( 1.0 - metalnessFactor );
vec3 dxy = max( abs( dFdx( nonPerturbedNormal ) ), abs( dFdy( nonPerturbedNormal ) ) );
float geometryRoughness = max( max( dxy.x, dxy.y ), dxy.z );
material.roughness = max( roughnessFactor, 0.0525 );material.roughness += geometryRoughness;
material.roughness = min( material.roughness, 1.0 );
#ifdef IOR
	material.ior = ior;
	#ifdef USE_SPECULAR
		float specularIntensityFactor = specularIntensity;
		vec3 specularColorFactor = specularColor;
		#ifdef USE_SPECULAR_COLORMAP
			specularColorFactor *= texture2D( specularColorMap, vSpecularColorMapUv ).rgb;
		#endif
		#ifdef USE_SPECULAR_INTENSITYMAP
			specularIntensityFactor *= texture2D( specularIntensityMap, vSpecularIntensityMapUv ).a;
		#endif
		material.specularF90 = mix( specularIntensityFactor, 1.0, metalnessFactor );
	#else
		float specularIntensityFactor = 1.0;
		vec3 specularColorFactor = vec3( 1.0 );
		material.specularF90 = 1.0;
	#endif
	material.specularColor = mix( min( pow2( ( material.ior - 1.0 ) / ( material.ior + 1.0 ) ) * specularColorFactor, vec3( 1.0 ) ) * specularIntensityFactor, diffuseColor.rgb, metalnessFactor );
#else
	material.specularColor = mix( vec3( 0.04 ), diffuseColor.rgb, metalnessFactor );
	material.specularF90 = 1.0;
#endif
#ifdef USE_CLEARCOAT
	material.clearcoat = clearcoat;
	material.clearcoatRoughness = clearcoatRoughness;
	material.clearcoatF0 = vec3( 0.04 );
	material.clearcoatF90 = 1.0;
	#ifdef USE_CLEARCOATMAP
		material.clearcoat *= texture2D( clearcoatMap, vClearcoatMapUv ).x;
	#endif
	#ifdef USE_CLEARCOAT_ROUGHNESSMAP
		material.clearcoatRoughness *= texture2D( clearcoatRoughnessMap, vClearcoatRoughnessMapUv ).y;
	#endif
	material.clearcoat = saturate( material.clearcoat );	material.clearcoatRoughness = max( material.clearcoatRoughness, 0.0525 );
	material.clearcoatRoughness += geometryRoughness;
	material.clearcoatRoughness = min( material.clearcoatRoughness, 1.0 );
#endif
#ifdef USE_DISPERSION
	material.dispersion = dispersion;
#endif
#ifdef USE_IRIDESCENCE
	material.iridescence = iridescence;
	material.iridescenceIOR = iridescenceIOR;
	#ifdef USE_IRIDESCENCEMAP
		material.iridescence *= texture2D( iridescenceMap, vIridescenceMapUv ).r;
	#endif
	#ifdef USE_IRIDESCENCE_THICKNESSMAP
		material.iridescenceThickness = (iridescenceThicknessMaximum - iridescenceThicknessMinimum) * texture2D( iridescenceThicknessMap, vIridescenceThicknessMapUv ).g + iridescenceThicknessMinimum;
	#else
		material.iridescenceThickness = iridescenceThicknessMaximum;
	#endif
#endif
#ifdef USE_SHEEN
	material.sheenColor = sheenColor;
	#ifdef USE_SHEEN_COLORMAP
		material.sheenColor *= texture2D( sheenColorMap, vSheenColorMapUv ).rgb;
	#endif
	material.sheenRoughness = clamp( sheenRoughness, 0.07, 1.0 );
	#ifdef USE_SHEEN_ROUGHNESSMAP
		material.sheenRoughness *= texture2D( sheenRoughnessMap, vSheenRoughnessMapUv ).a;
	#endif
#endif
#ifdef USE_ANISOTROPY
	#ifdef USE_ANISOTROPYMAP
		mat2 anisotropyMat = mat2( anisotropyVector.x, anisotropyVector.y, - anisotropyVector.y, anisotropyVector.x );
		vec3 anisotropyPolar = texture2D( anisotropyMap, vAnisotropyMapUv ).rgb;
		vec2 anisotropyV = anisotropyMat * normalize( 2.0 * anisotropyPolar.rg - vec2( 1.0 ) ) * anisotropyPolar.b;
	#else
		vec2 anisotropyV = anisotropyVector;
	#endif
	material.anisotropy = length( anisotropyV );
	if( material.anisotropy == 0.0 ) {
		anisotropyV = vec2( 1.0, 0.0 );
	} else {
		anisotropyV /= material.anisotropy;
		material.anisotropy = saturate( material.anisotropy );
	}
	material.alphaT = mix( pow2( material.roughness ), 1.0, pow2( material.anisotropy ) );
	material.anisotropyT = tbn[ 0 ] * anisotropyV.x + tbn[ 1 ] * anisotropyV.y;
	material.anisotropyB = tbn[ 1 ] * anisotropyV.x - tbn[ 0 ] * anisotropyV.y;
#endif`,uf=`struct PhysicalMaterial {
	vec3 diffuseColor;
	float roughness;
	vec3 specularColor;
	float specularF90;
	float dispersion;
	#ifdef USE_CLEARCOAT
		float clearcoat;
		float clearcoatRoughness;
		vec3 clearcoatF0;
		float clearcoatF90;
	#endif
	#ifdef USE_IRIDESCENCE
		float iridescence;
		float iridescenceIOR;
		float iridescenceThickness;
		vec3 iridescenceFresnel;
		vec3 iridescenceF0;
	#endif
	#ifdef USE_SHEEN
		vec3 sheenColor;
		float sheenRoughness;
	#endif
	#ifdef IOR
		float ior;
	#endif
	#ifdef USE_TRANSMISSION
		float transmission;
		float transmissionAlpha;
		float thickness;
		float attenuationDistance;
		vec3 attenuationColor;
	#endif
	#ifdef USE_ANISOTROPY
		float anisotropy;
		float alphaT;
		vec3 anisotropyT;
		vec3 anisotropyB;
	#endif
};
vec3 clearcoatSpecularDirect = vec3( 0.0 );
vec3 clearcoatSpecularIndirect = vec3( 0.0 );
vec3 sheenSpecularDirect = vec3( 0.0 );
vec3 sheenSpecularIndirect = vec3(0.0 );
vec3 Schlick_to_F0( const in vec3 f, const in float f90, const in float dotVH ) {
    float x = clamp( 1.0 - dotVH, 0.0, 1.0 );
    float x2 = x * x;
    float x5 = clamp( x * x2 * x2, 0.0, 0.9999 );
    return ( f - vec3( f90 ) * x5 ) / ( 1.0 - x5 );
}
float V_GGX_SmithCorrelated( const in float alpha, const in float dotNL, const in float dotNV ) {
	float a2 = pow2( alpha );
	float gv = dotNL * sqrt( a2 + ( 1.0 - a2 ) * pow2( dotNV ) );
	float gl = dotNV * sqrt( a2 + ( 1.0 - a2 ) * pow2( dotNL ) );
	return 0.5 / max( gv + gl, EPSILON );
}
float D_GGX( const in float alpha, const in float dotNH ) {
	float a2 = pow2( alpha );
	float denom = pow2( dotNH ) * ( a2 - 1.0 ) + 1.0;
	return RECIPROCAL_PI * a2 / pow2( denom );
}
#ifdef USE_ANISOTROPY
	float V_GGX_SmithCorrelated_Anisotropic( const in float alphaT, const in float alphaB, const in float dotTV, const in float dotBV, const in float dotTL, const in float dotBL, const in float dotNV, const in float dotNL ) {
		float gv = dotNL * length( vec3( alphaT * dotTV, alphaB * dotBV, dotNV ) );
		float gl = dotNV * length( vec3( alphaT * dotTL, alphaB * dotBL, dotNL ) );
		float v = 0.5 / ( gv + gl );
		return saturate(v);
	}
	float D_GGX_Anisotropic( const in float alphaT, const in float alphaB, const in float dotNH, const in float dotTH, const in float dotBH ) {
		float a2 = alphaT * alphaB;
		highp vec3 v = vec3( alphaB * dotTH, alphaT * dotBH, a2 * dotNH );
		highp float v2 = dot( v, v );
		float w2 = a2 / v2;
		return RECIPROCAL_PI * a2 * pow2 ( w2 );
	}
#endif
#ifdef USE_CLEARCOAT
	vec3 BRDF_GGX_Clearcoat( const in vec3 lightDir, const in vec3 viewDir, const in vec3 normal, const in PhysicalMaterial material) {
		vec3 f0 = material.clearcoatF0;
		float f90 = material.clearcoatF90;
		float roughness = material.clearcoatRoughness;
		float alpha = pow2( roughness );
		vec3 halfDir = normalize( lightDir + viewDir );
		float dotNL = saturate( dot( normal, lightDir ) );
		float dotNV = saturate( dot( normal, viewDir ) );
		float dotNH = saturate( dot( normal, halfDir ) );
		float dotVH = saturate( dot( viewDir, halfDir ) );
		vec3 F = F_Schlick( f0, f90, dotVH );
		float V = V_GGX_SmithCorrelated( alpha, dotNL, dotNV );
		float D = D_GGX( alpha, dotNH );
		return F * ( V * D );
	}
#endif
vec3 BRDF_GGX( const in vec3 lightDir, const in vec3 viewDir, const in vec3 normal, const in PhysicalMaterial material ) {
	vec3 f0 = material.specularColor;
	float f90 = material.specularF90;
	float roughness = material.roughness;
	float alpha = pow2( roughness );
	vec3 halfDir = normalize( lightDir + viewDir );
	float dotNL = saturate( dot( normal, lightDir ) );
	float dotNV = saturate( dot( normal, viewDir ) );
	float dotNH = saturate( dot( normal, halfDir ) );
	float dotVH = saturate( dot( viewDir, halfDir ) );
	vec3 F = F_Schlick( f0, f90, dotVH );
	#ifdef USE_IRIDESCENCE
		F = mix( F, material.iridescenceFresnel, material.iridescence );
	#endif
	#ifdef USE_ANISOTROPY
		float dotTL = dot( material.anisotropyT, lightDir );
		float dotTV = dot( material.anisotropyT, viewDir );
		float dotTH = dot( material.anisotropyT, halfDir );
		float dotBL = dot( material.anisotropyB, lightDir );
		float dotBV = dot( material.anisotropyB, viewDir );
		float dotBH = dot( material.anisotropyB, halfDir );
		float V = V_GGX_SmithCorrelated_Anisotropic( material.alphaT, alpha, dotTV, dotBV, dotTL, dotBL, dotNV, dotNL );
		float D = D_GGX_Anisotropic( material.alphaT, alpha, dotNH, dotTH, dotBH );
	#else
		float V = V_GGX_SmithCorrelated( alpha, dotNL, dotNV );
		float D = D_GGX( alpha, dotNH );
	#endif
	return F * ( V * D );
}
vec2 LTC_Uv( const in vec3 N, const in vec3 V, const in float roughness ) {
	const float LUT_SIZE = 64.0;
	const float LUT_SCALE = ( LUT_SIZE - 1.0 ) / LUT_SIZE;
	const float LUT_BIAS = 0.5 / LUT_SIZE;
	float dotNV = saturate( dot( N, V ) );
	vec2 uv = vec2( roughness, sqrt( 1.0 - dotNV ) );
	uv = uv * LUT_SCALE + LUT_BIAS;
	return uv;
}
float LTC_ClippedSphereFormFactor( const in vec3 f ) {
	float l = length( f );
	return max( ( l * l + f.z ) / ( l + 1.0 ), 0.0 );
}
vec3 LTC_EdgeVectorFormFactor( const in vec3 v1, const in vec3 v2 ) {
	float x = dot( v1, v2 );
	float y = abs( x );
	float a = 0.8543985 + ( 0.4965155 + 0.0145206 * y ) * y;
	float b = 3.4175940 + ( 4.1616724 + y ) * y;
	float v = a / b;
	float theta_sintheta = ( x > 0.0 ) ? v : 0.5 * inversesqrt( max( 1.0 - x * x, 1e-7 ) ) - v;
	return cross( v1, v2 ) * theta_sintheta;
}
vec3 LTC_Evaluate( const in vec3 N, const in vec3 V, const in vec3 P, const in mat3 mInv, const in vec3 rectCoords[ 4 ] ) {
	vec3 v1 = rectCoords[ 1 ] - rectCoords[ 0 ];
	vec3 v2 = rectCoords[ 3 ] - rectCoords[ 0 ];
	vec3 lightNormal = cross( v1, v2 );
	if( dot( lightNormal, P - rectCoords[ 0 ] ) < 0.0 ) return vec3( 0.0 );
	vec3 T1, T2;
	T1 = normalize( V - N * dot( V, N ) );
	T2 = - cross( N, T1 );
	mat3 mat = mInv * transposeMat3( mat3( T1, T2, N ) );
	vec3 coords[ 4 ];
	coords[ 0 ] = mat * ( rectCoords[ 0 ] - P );
	coords[ 1 ] = mat * ( rectCoords[ 1 ] - P );
	coords[ 2 ] = mat * ( rectCoords[ 2 ] - P );
	coords[ 3 ] = mat * ( rectCoords[ 3 ] - P );
	coords[ 0 ] = normalize( coords[ 0 ] );
	coords[ 1 ] = normalize( coords[ 1 ] );
	coords[ 2 ] = normalize( coords[ 2 ] );
	coords[ 3 ] = normalize( coords[ 3 ] );
	vec3 vectorFormFactor = vec3( 0.0 );
	vectorFormFactor += LTC_EdgeVectorFormFactor( coords[ 0 ], coords[ 1 ] );
	vectorFormFactor += LTC_EdgeVectorFormFactor( coords[ 1 ], coords[ 2 ] );
	vectorFormFactor += LTC_EdgeVectorFormFactor( coords[ 2 ], coords[ 3 ] );
	vectorFormFactor += LTC_EdgeVectorFormFactor( coords[ 3 ], coords[ 0 ] );
	float result = LTC_ClippedSphereFormFactor( vectorFormFactor );
	return vec3( result );
}
#if defined( USE_SHEEN )
float D_Charlie( float roughness, float dotNH ) {
	float alpha = pow2( roughness );
	float invAlpha = 1.0 / alpha;
	float cos2h = dotNH * dotNH;
	float sin2h = max( 1.0 - cos2h, 0.0078125 );
	return ( 2.0 + invAlpha ) * pow( sin2h, invAlpha * 0.5 ) / ( 2.0 * PI );
}
float V_Neubelt( float dotNV, float dotNL ) {
	return saturate( 1.0 / ( 4.0 * ( dotNL + dotNV - dotNL * dotNV ) ) );
}
vec3 BRDF_Sheen( const in vec3 lightDir, const in vec3 viewDir, const in vec3 normal, vec3 sheenColor, const in float sheenRoughness ) {
	vec3 halfDir = normalize( lightDir + viewDir );
	float dotNL = saturate( dot( normal, lightDir ) );
	float dotNV = saturate( dot( normal, viewDir ) );
	float dotNH = saturate( dot( normal, halfDir ) );
	float D = D_Charlie( sheenRoughness, dotNH );
	float V = V_Neubelt( dotNV, dotNL );
	return sheenColor * ( D * V );
}
#endif
float IBLSheenBRDF( const in vec3 normal, const in vec3 viewDir, const in float roughness ) {
	float dotNV = saturate( dot( normal, viewDir ) );
	float r2 = roughness * roughness;
	float a = roughness < 0.25 ? -339.2 * r2 + 161.4 * roughness - 25.9 : -8.48 * r2 + 14.3 * roughness - 9.95;
	float b = roughness < 0.25 ? 44.0 * r2 - 23.7 * roughness + 3.26 : 1.97 * r2 - 3.27 * roughness + 0.72;
	float DG = exp( a * dotNV + b ) + ( roughness < 0.25 ? 0.0 : 0.1 * ( roughness - 0.25 ) );
	return saturate( DG * RECIPROCAL_PI );
}
vec2 DFGApprox( const in vec3 normal, const in vec3 viewDir, const in float roughness ) {
	float dotNV = saturate( dot( normal, viewDir ) );
	const vec4 c0 = vec4( - 1, - 0.0275, - 0.572, 0.022 );
	const vec4 c1 = vec4( 1, 0.0425, 1.04, - 0.04 );
	vec4 r = roughness * c0 + c1;
	float a004 = min( r.x * r.x, exp2( - 9.28 * dotNV ) ) * r.x + r.y;
	vec2 fab = vec2( - 1.04, 1.04 ) * a004 + r.zw;
	return fab;
}
vec3 EnvironmentBRDF( const in vec3 normal, const in vec3 viewDir, const in vec3 specularColor, const in float specularF90, const in float roughness ) {
	vec2 fab = DFGApprox( normal, viewDir, roughness );
	return specularColor * fab.x + specularF90 * fab.y;
}
#ifdef USE_IRIDESCENCE
void computeMultiscatteringIridescence( const in vec3 normal, const in vec3 viewDir, const in vec3 specularColor, const in float specularF90, const in float iridescence, const in vec3 iridescenceF0, const in float roughness, inout vec3 singleScatter, inout vec3 multiScatter ) {
#else
void computeMultiscattering( const in vec3 normal, const in vec3 viewDir, const in vec3 specularColor, const in float specularF90, const in float roughness, inout vec3 singleScatter, inout vec3 multiScatter ) {
#endif
	vec2 fab = DFGApprox( normal, viewDir, roughness );
	#ifdef USE_IRIDESCENCE
		vec3 Fr = mix( specularColor, iridescenceF0, iridescence );
	#else
		vec3 Fr = specularColor;
	#endif
	vec3 FssEss = Fr * fab.x + specularF90 * fab.y;
	float Ess = fab.x + fab.y;
	float Ems = 1.0 - Ess;
	vec3 Favg = Fr + ( 1.0 - Fr ) * 0.047619;	vec3 Fms = FssEss * Favg / ( 1.0 - Ems * Favg );
	singleScatter += FssEss;
	multiScatter += Fms * Ems;
}
#if NUM_RECT_AREA_LIGHTS > 0
	void RE_Direct_RectArea_Physical( const in RectAreaLight rectAreaLight, const in vec3 geometryPosition, const in vec3 geometryNormal, const in vec3 geometryViewDir, const in vec3 geometryClearcoatNormal, const in PhysicalMaterial material, inout ReflectedLight reflectedLight ) {
		vec3 normal = geometryNormal;
		vec3 viewDir = geometryViewDir;
		vec3 position = geometryPosition;
		vec3 lightPos = rectAreaLight.position;
		vec3 halfWidth = rectAreaLight.halfWidth;
		vec3 halfHeight = rectAreaLight.halfHeight;
		vec3 lightColor = rectAreaLight.color;
		float roughness = material.roughness;
		vec3 rectCoords[ 4 ];
		rectCoords[ 0 ] = lightPos + halfWidth - halfHeight;		rectCoords[ 1 ] = lightPos - halfWidth - halfHeight;
		rectCoords[ 2 ] = lightPos - halfWidth + halfHeight;
		rectCoords[ 3 ] = lightPos + halfWidth + halfHeight;
		vec2 uv = LTC_Uv( normal, viewDir, roughness );
		vec4 t1 = texture2D( ltc_1, uv );
		vec4 t2 = texture2D( ltc_2, uv );
		mat3 mInv = mat3(
			vec3( t1.x, 0, t1.y ),
			vec3(    0, 1,    0 ),
			vec3( t1.z, 0, t1.w )
		);
		vec3 fresnel = ( material.specularColor * t2.x + ( vec3( 1.0 ) - material.specularColor ) * t2.y );
		reflectedLight.directSpecular += lightColor * fresnel * LTC_Evaluate( normal, viewDir, position, mInv, rectCoords );
		reflectedLight.directDiffuse += lightColor * material.diffuseColor * LTC_Evaluate( normal, viewDir, position, mat3( 1.0 ), rectCoords );
	}
#endif
void RE_Direct_Physical( const in IncidentLight directLight, const in vec3 geometryPosition, const in vec3 geometryNormal, const in vec3 geometryViewDir, const in vec3 geometryClearcoatNormal, const in PhysicalMaterial material, inout ReflectedLight reflectedLight ) {
	float dotNL = saturate( dot( geometryNormal, directLight.direction ) );
	vec3 irradiance = dotNL * directLight.color;
	#ifdef USE_CLEARCOAT
		float dotNLcc = saturate( dot( geometryClearcoatNormal, directLight.direction ) );
		vec3 ccIrradiance = dotNLcc * directLight.color;
		clearcoatSpecularDirect += ccIrradiance * BRDF_GGX_Clearcoat( directLight.direction, geometryViewDir, geometryClearcoatNormal, material );
	#endif
	#ifdef USE_SHEEN
		sheenSpecularDirect += irradiance * BRDF_Sheen( directLight.direction, geometryViewDir, geometryNormal, material.sheenColor, material.sheenRoughness );
	#endif
	reflectedLight.directSpecular += irradiance * BRDF_GGX( directLight.direction, geometryViewDir, geometryNormal, material );
	reflectedLight.directDiffuse += irradiance * BRDF_Lambert( material.diffuseColor );
}
void RE_IndirectDiffuse_Physical( const in vec3 irradiance, const in vec3 geometryPosition, const in vec3 geometryNormal, const in vec3 geometryViewDir, const in vec3 geometryClearcoatNormal, const in PhysicalMaterial material, inout ReflectedLight reflectedLight ) {
	reflectedLight.indirectDiffuse += irradiance * BRDF_Lambert( material.diffuseColor );
}
void RE_IndirectSpecular_Physical( const in vec3 radiance, const in vec3 irradiance, const in vec3 clearcoatRadiance, const in vec3 geometryPosition, const in vec3 geometryNormal, const in vec3 geometryViewDir, const in vec3 geometryClearcoatNormal, const in PhysicalMaterial material, inout ReflectedLight reflectedLight) {
	#ifdef USE_CLEARCOAT
		clearcoatSpecularIndirect += clearcoatRadiance * EnvironmentBRDF( geometryClearcoatNormal, geometryViewDir, material.clearcoatF0, material.clearcoatF90, material.clearcoatRoughness );
	#endif
	#ifdef USE_SHEEN
		sheenSpecularIndirect += irradiance * material.sheenColor * IBLSheenBRDF( geometryNormal, geometryViewDir, material.sheenRoughness );
	#endif
	vec3 singleScattering = vec3( 0.0 );
	vec3 multiScattering = vec3( 0.0 );
	vec3 cosineWeightedIrradiance = irradiance * RECIPROCAL_PI;
	#ifdef USE_IRIDESCENCE
		computeMultiscatteringIridescence( geometryNormal, geometryViewDir, material.specularColor, material.specularF90, material.iridescence, material.iridescenceFresnel, material.roughness, singleScattering, multiScattering );
	#else
		computeMultiscattering( geometryNormal, geometryViewDir, material.specularColor, material.specularF90, material.roughness, singleScattering, multiScattering );
	#endif
	vec3 totalScattering = singleScattering + multiScattering;
	vec3 diffuse = material.diffuseColor * ( 1.0 - max( max( totalScattering.r, totalScattering.g ), totalScattering.b ) );
	reflectedLight.indirectSpecular += radiance * singleScattering;
	reflectedLight.indirectSpecular += multiScattering * cosineWeightedIrradiance;
	reflectedLight.indirectDiffuse += diffuse * cosineWeightedIrradiance;
}
#define RE_Direct				RE_Direct_Physical
#define RE_Direct_RectArea		RE_Direct_RectArea_Physical
#define RE_IndirectDiffuse		RE_IndirectDiffuse_Physical
#define RE_IndirectSpecular		RE_IndirectSpecular_Physical
float computeSpecularOcclusion( const in float dotNV, const in float ambientOcclusion, const in float roughness ) {
	return saturate( pow( dotNV + ambientOcclusion, exp2( - 16.0 * roughness - 1.0 ) ) - 1.0 + ambientOcclusion );
}`,df=`
vec3 geometryPosition = - vViewPosition;
vec3 geometryNormal = normal;
vec3 geometryViewDir = ( isOrthographic ) ? vec3( 0, 0, 1 ) : normalize( vViewPosition );
vec3 geometryClearcoatNormal = vec3( 0.0 );
#ifdef USE_CLEARCOAT
	geometryClearcoatNormal = clearcoatNormal;
#endif
#ifdef USE_IRIDESCENCE
	float dotNVi = saturate( dot( normal, geometryViewDir ) );
	if ( material.iridescenceThickness == 0.0 ) {
		material.iridescence = 0.0;
	} else {
		material.iridescence = saturate( material.iridescence );
	}
	if ( material.iridescence > 0.0 ) {
		material.iridescenceFresnel = evalIridescence( 1.0, material.iridescenceIOR, dotNVi, material.iridescenceThickness, material.specularColor );
		material.iridescenceF0 = Schlick_to_F0( material.iridescenceFresnel, 1.0, dotNVi );
	}
#endif
IncidentLight directLight;
#if ( NUM_POINT_LIGHTS > 0 ) && defined( RE_Direct )
	PointLight pointLight;
	#if defined( USE_SHADOWMAP ) && NUM_POINT_LIGHT_SHADOWS > 0
	PointLightShadow pointLightShadow;
	#endif
	#pragma unroll_loop_start
	for ( int i = 0; i < NUM_POINT_LIGHTS; i ++ ) {
		pointLight = pointLights[ i ];
		getPointLightInfo( pointLight, geometryPosition, directLight );
		#if defined( USE_SHADOWMAP ) && ( UNROLLED_LOOP_INDEX < NUM_POINT_LIGHT_SHADOWS )
		pointLightShadow = pointLightShadows[ i ];
		directLight.color *= ( directLight.visible && receiveShadow ) ? getPointShadow( pointShadowMap[ i ], pointLightShadow.shadowMapSize, pointLightShadow.shadowIntensity, pointLightShadow.shadowBias, pointLightShadow.shadowRadius, vPointShadowCoord[ i ], pointLightShadow.shadowCameraNear, pointLightShadow.shadowCameraFar ) : 1.0;
		#endif
		RE_Direct( directLight, geometryPosition, geometryNormal, geometryViewDir, geometryClearcoatNormal, material, reflectedLight );
	}
	#pragma unroll_loop_end
#endif
#if ( NUM_SPOT_LIGHTS > 0 ) && defined( RE_Direct )
	SpotLight spotLight;
	vec4 spotColor;
	vec3 spotLightCoord;
	bool inSpotLightMap;
	#if defined( USE_SHADOWMAP ) && NUM_SPOT_LIGHT_SHADOWS > 0
	SpotLightShadow spotLightShadow;
	#endif
	#pragma unroll_loop_start
	for ( int i = 0; i < NUM_SPOT_LIGHTS; i ++ ) {
		spotLight = spotLights[ i ];
		getSpotLightInfo( spotLight, geometryPosition, directLight );
		#if ( UNROLLED_LOOP_INDEX < NUM_SPOT_LIGHT_SHADOWS_WITH_MAPS )
		#define SPOT_LIGHT_MAP_INDEX UNROLLED_LOOP_INDEX
		#elif ( UNROLLED_LOOP_INDEX < NUM_SPOT_LIGHT_SHADOWS )
		#define SPOT_LIGHT_MAP_INDEX NUM_SPOT_LIGHT_MAPS
		#else
		#define SPOT_LIGHT_MAP_INDEX ( UNROLLED_LOOP_INDEX - NUM_SPOT_LIGHT_SHADOWS + NUM_SPOT_LIGHT_SHADOWS_WITH_MAPS )
		#endif
		#if ( SPOT_LIGHT_MAP_INDEX < NUM_SPOT_LIGHT_MAPS )
			spotLightCoord = vSpotLightCoord[ i ].xyz / vSpotLightCoord[ i ].w;
			inSpotLightMap = all( lessThan( abs( spotLightCoord * 2. - 1. ), vec3( 1.0 ) ) );
			spotColor = texture2D( spotLightMap[ SPOT_LIGHT_MAP_INDEX ], spotLightCoord.xy );
			directLight.color = inSpotLightMap ? directLight.color * spotColor.rgb : directLight.color;
		#endif
		#undef SPOT_LIGHT_MAP_INDEX
		#if defined( USE_SHADOWMAP ) && ( UNROLLED_LOOP_INDEX < NUM_SPOT_LIGHT_SHADOWS )
		spotLightShadow = spotLightShadows[ i ];
		directLight.color *= ( directLight.visible && receiveShadow ) ? getShadow( spotShadowMap[ i ], spotLightShadow.shadowMapSize, spotLightShadow.shadowIntensity, spotLightShadow.shadowBias, spotLightShadow.shadowRadius, vSpotLightCoord[ i ] ) : 1.0;
		#endif
		RE_Direct( directLight, geometryPosition, geometryNormal, geometryViewDir, geometryClearcoatNormal, material, reflectedLight );
	}
	#pragma unroll_loop_end
#endif
#if ( NUM_DIR_LIGHTS > 0 ) && defined( RE_Direct )
	DirectionalLight directionalLight;
	#if defined( USE_SHADOWMAP ) && NUM_DIR_LIGHT_SHADOWS > 0
	DirectionalLightShadow directionalLightShadow;
	#endif
	#pragma unroll_loop_start
	for ( int i = 0; i < NUM_DIR_LIGHTS; i ++ ) {
		directionalLight = directionalLights[ i ];
		getDirectionalLightInfo( directionalLight, directLight );
		#if defined( USE_SHADOWMAP ) && ( UNROLLED_LOOP_INDEX < NUM_DIR_LIGHT_SHADOWS )
		directionalLightShadow = directionalLightShadows[ i ];
		directLight.color *= ( directLight.visible && receiveShadow ) ? getShadow( directionalShadowMap[ i ], directionalLightShadow.shadowMapSize, directionalLightShadow.shadowIntensity, directionalLightShadow.shadowBias, directionalLightShadow.shadowRadius, vDirectionalShadowCoord[ i ] ) : 1.0;
		#endif
		RE_Direct( directLight, geometryPosition, geometryNormal, geometryViewDir, geometryClearcoatNormal, material, reflectedLight );
	}
	#pragma unroll_loop_end
#endif
#if ( NUM_RECT_AREA_LIGHTS > 0 ) && defined( RE_Direct_RectArea )
	RectAreaLight rectAreaLight;
	#pragma unroll_loop_start
	for ( int i = 0; i < NUM_RECT_AREA_LIGHTS; i ++ ) {
		rectAreaLight = rectAreaLights[ i ];
		RE_Direct_RectArea( rectAreaLight, geometryPosition, geometryNormal, geometryViewDir, geometryClearcoatNormal, material, reflectedLight );
	}
	#pragma unroll_loop_end
#endif
#if defined( RE_IndirectDiffuse )
	vec3 iblIrradiance = vec3( 0.0 );
	vec3 irradiance = getAmbientLightIrradiance( ambientLightColor );
	#if defined( USE_LIGHT_PROBES )
		irradiance += getLightProbeIrradiance( lightProbe, geometryNormal );
	#endif
	#if ( NUM_HEMI_LIGHTS > 0 )
		#pragma unroll_loop_start
		for ( int i = 0; i < NUM_HEMI_LIGHTS; i ++ ) {
			irradiance += getHemisphereLightIrradiance( hemisphereLights[ i ], geometryNormal );
		}
		#pragma unroll_loop_end
	#endif
#endif
#if defined( RE_IndirectSpecular )
	vec3 radiance = vec3( 0.0 );
	vec3 clearcoatRadiance = vec3( 0.0 );
#endif`,ff=`#if defined( RE_IndirectDiffuse )
	#ifdef USE_LIGHTMAP
		vec4 lightMapTexel = texture2D( lightMap, vLightMapUv );
		vec3 lightMapIrradiance = lightMapTexel.rgb * lightMapIntensity;
		irradiance += lightMapIrradiance;
	#endif
	#if defined( USE_ENVMAP ) && defined( STANDARD ) && defined( ENVMAP_TYPE_CUBE_UV )
		iblIrradiance += getIBLIrradiance( geometryNormal );
	#endif
#endif
#if defined( USE_ENVMAP ) && defined( RE_IndirectSpecular )
	#ifdef USE_ANISOTROPY
		radiance += getIBLAnisotropyRadiance( geometryViewDir, geometryNormal, material.roughness, material.anisotropyB, material.anisotropy );
	#else
		radiance += getIBLRadiance( geometryViewDir, geometryNormal, material.roughness );
	#endif
	#ifdef USE_CLEARCOAT
		clearcoatRadiance += getIBLRadiance( geometryViewDir, geometryClearcoatNormal, material.clearcoatRoughness );
	#endif
#endif`,pf=`#if defined( RE_IndirectDiffuse )
	RE_IndirectDiffuse( irradiance, geometryPosition, geometryNormal, geometryViewDir, geometryClearcoatNormal, material, reflectedLight );
#endif
#if defined( RE_IndirectSpecular )
	RE_IndirectSpecular( radiance, iblIrradiance, clearcoatRadiance, geometryPosition, geometryNormal, geometryViewDir, geometryClearcoatNormal, material, reflectedLight );
#endif`,mf=`#if defined( USE_LOGDEPTHBUF )
	gl_FragDepth = vIsPerspective == 0.0 ? gl_FragCoord.z : log2( vFragDepth ) * logDepthBufFC * 0.5;
#endif`,gf=`#if defined( USE_LOGDEPTHBUF )
	uniform float logDepthBufFC;
	varying float vFragDepth;
	varying float vIsPerspective;
#endif`,_f=`#ifdef USE_LOGDEPTHBUF
	varying float vFragDepth;
	varying float vIsPerspective;
#endif`,vf=`#ifdef USE_LOGDEPTHBUF
	vFragDepth = 1.0 + gl_Position.w;
	vIsPerspective = float( isPerspectiveMatrix( projectionMatrix ) );
#endif`,xf=`#ifdef USE_MAP
	vec4 sampledDiffuseColor = texture2D( map, vMapUv );
	#ifdef DECODE_VIDEO_TEXTURE
		sampledDiffuseColor = vec4( mix( pow( sampledDiffuseColor.rgb * 0.9478672986 + vec3( 0.0521327014 ), vec3( 2.4 ) ), sampledDiffuseColor.rgb * 0.0773993808, vec3( lessThanEqual( sampledDiffuseColor.rgb, vec3( 0.04045 ) ) ) ), sampledDiffuseColor.w );
	
	#endif
	diffuseColor *= sampledDiffuseColor;
#endif`,yf=`#ifdef USE_MAP
	uniform sampler2D map;
#endif`,Mf=`#if defined( USE_MAP ) || defined( USE_ALPHAMAP )
	#if defined( USE_POINTS_UV )
		vec2 uv = vUv;
	#else
		vec2 uv = ( uvTransform * vec3( gl_PointCoord.x, 1.0 - gl_PointCoord.y, 1 ) ).xy;
	#endif
#endif
#ifdef USE_MAP
	diffuseColor *= texture2D( map, uv );
#endif
#ifdef USE_ALPHAMAP
	diffuseColor.a *= texture2D( alphaMap, uv ).g;
#endif`,Sf=`#if defined( USE_POINTS_UV )
	varying vec2 vUv;
#else
	#if defined( USE_MAP ) || defined( USE_ALPHAMAP )
		uniform mat3 uvTransform;
	#endif
#endif
#ifdef USE_MAP
	uniform sampler2D map;
#endif
#ifdef USE_ALPHAMAP
	uniform sampler2D alphaMap;
#endif`,bf=`float metalnessFactor = metalness;
#ifdef USE_METALNESSMAP
	vec4 texelMetalness = texture2D( metalnessMap, vMetalnessMapUv );
	metalnessFactor *= texelMetalness.b;
#endif`,Ef=`#ifdef USE_METALNESSMAP
	uniform sampler2D metalnessMap;
#endif`,Tf=`#ifdef USE_INSTANCING_MORPH
	float morphTargetInfluences[ MORPHTARGETS_COUNT ];
	float morphTargetBaseInfluence = texelFetch( morphTexture, ivec2( 0, gl_InstanceID ), 0 ).r;
	for ( int i = 0; i < MORPHTARGETS_COUNT; i ++ ) {
		morphTargetInfluences[i] =  texelFetch( morphTexture, ivec2( i + 1, gl_InstanceID ), 0 ).r;
	}
#endif`,wf=`#if defined( USE_MORPHCOLORS )
	vColor *= morphTargetBaseInfluence;
	for ( int i = 0; i < MORPHTARGETS_COUNT; i ++ ) {
		#if defined( USE_COLOR_ALPHA )
			if ( morphTargetInfluences[ i ] != 0.0 ) vColor += getMorph( gl_VertexID, i, 2 ) * morphTargetInfluences[ i ];
		#elif defined( USE_COLOR )
			if ( morphTargetInfluences[ i ] != 0.0 ) vColor += getMorph( gl_VertexID, i, 2 ).rgb * morphTargetInfluences[ i ];
		#endif
	}
#endif`,Af=`#ifdef USE_MORPHNORMALS
	objectNormal *= morphTargetBaseInfluence;
	for ( int i = 0; i < MORPHTARGETS_COUNT; i ++ ) {
		if ( morphTargetInfluences[ i ] != 0.0 ) objectNormal += getMorph( gl_VertexID, i, 1 ).xyz * morphTargetInfluences[ i ];
	}
#endif`,Cf=`#ifdef USE_MORPHTARGETS
	#ifndef USE_INSTANCING_MORPH
		uniform float morphTargetBaseInfluence;
		uniform float morphTargetInfluences[ MORPHTARGETS_COUNT ];
	#endif
	uniform sampler2DArray morphTargetsTexture;
	uniform ivec2 morphTargetsTextureSize;
	vec4 getMorph( const in int vertexIndex, const in int morphTargetIndex, const in int offset ) {
		int texelIndex = vertexIndex * MORPHTARGETS_TEXTURE_STRIDE + offset;
		int y = texelIndex / morphTargetsTextureSize.x;
		int x = texelIndex - y * morphTargetsTextureSize.x;
		ivec3 morphUV = ivec3( x, y, morphTargetIndex );
		return texelFetch( morphTargetsTexture, morphUV, 0 );
	}
#endif`,Rf=`#ifdef USE_MORPHTARGETS
	transformed *= morphTargetBaseInfluence;
	for ( int i = 0; i < MORPHTARGETS_COUNT; i ++ ) {
		if ( morphTargetInfluences[ i ] != 0.0 ) transformed += getMorph( gl_VertexID, i, 0 ).xyz * morphTargetInfluences[ i ];
	}
#endif`,Pf=`float faceDirection = gl_FrontFacing ? 1.0 : - 1.0;
#ifdef FLAT_SHADED
	vec3 fdx = dFdx( vViewPosition );
	vec3 fdy = dFdy( vViewPosition );
	vec3 normal = normalize( cross( fdx, fdy ) );
#else
	vec3 normal = normalize( vNormal );
	#ifdef DOUBLE_SIDED
		normal *= faceDirection;
	#endif
#endif
#if defined( USE_NORMALMAP_TANGENTSPACE ) || defined( USE_CLEARCOAT_NORMALMAP ) || defined( USE_ANISOTROPY )
	#ifdef USE_TANGENT
		mat3 tbn = mat3( normalize( vTangent ), normalize( vBitangent ), normal );
	#else
		mat3 tbn = getTangentFrame( - vViewPosition, normal,
		#if defined( USE_NORMALMAP )
			vNormalMapUv
		#elif defined( USE_CLEARCOAT_NORMALMAP )
			vClearcoatNormalMapUv
		#else
			vUv
		#endif
		);
	#endif
	#if defined( DOUBLE_SIDED ) && ! defined( FLAT_SHADED )
		tbn[0] *= faceDirection;
		tbn[1] *= faceDirection;
	#endif
#endif
#ifdef USE_CLEARCOAT_NORMALMAP
	#ifdef USE_TANGENT
		mat3 tbn2 = mat3( normalize( vTangent ), normalize( vBitangent ), normal );
	#else
		mat3 tbn2 = getTangentFrame( - vViewPosition, normal, vClearcoatNormalMapUv );
	#endif
	#if defined( DOUBLE_SIDED ) && ! defined( FLAT_SHADED )
		tbn2[0] *= faceDirection;
		tbn2[1] *= faceDirection;
	#endif
#endif
vec3 nonPerturbedNormal = normal;`,Lf=`#ifdef USE_NORMALMAP_OBJECTSPACE
	normal = texture2D( normalMap, vNormalMapUv ).xyz * 2.0 - 1.0;
	#ifdef FLIP_SIDED
		normal = - normal;
	#endif
	#ifdef DOUBLE_SIDED
		normal = normal * faceDirection;
	#endif
	normal = normalize( normalMatrix * normal );
#elif defined( USE_NORMALMAP_TANGENTSPACE )
	vec3 mapN = texture2D( normalMap, vNormalMapUv ).xyz * 2.0 - 1.0;
	mapN.xy *= normalScale;
	normal = normalize( tbn * mapN );
#elif defined( USE_BUMPMAP )
	normal = perturbNormalArb( - vViewPosition, normal, dHdxy_fwd(), faceDirection );
#endif`,Df=`#ifndef FLAT_SHADED
	varying vec3 vNormal;
	#ifdef USE_TANGENT
		varying vec3 vTangent;
		varying vec3 vBitangent;
	#endif
#endif`,If=`#ifndef FLAT_SHADED
	varying vec3 vNormal;
	#ifdef USE_TANGENT
		varying vec3 vTangent;
		varying vec3 vBitangent;
	#endif
#endif`,Uf=`#ifndef FLAT_SHADED
	vNormal = normalize( transformedNormal );
	#ifdef USE_TANGENT
		vTangent = normalize( transformedTangent );
		vBitangent = normalize( cross( vNormal, vTangent ) * tangent.w );
	#endif
#endif`,Nf=`#ifdef USE_NORMALMAP
	uniform sampler2D normalMap;
	uniform vec2 normalScale;
#endif
#ifdef USE_NORMALMAP_OBJECTSPACE
	uniform mat3 normalMatrix;
#endif
#if ! defined ( USE_TANGENT ) && ( defined ( USE_NORMALMAP_TANGENTSPACE ) || defined ( USE_CLEARCOAT_NORMALMAP ) || defined( USE_ANISOTROPY ) )
	mat3 getTangentFrame( vec3 eye_pos, vec3 surf_norm, vec2 uv ) {
		vec3 q0 = dFdx( eye_pos.xyz );
		vec3 q1 = dFdy( eye_pos.xyz );
		vec2 st0 = dFdx( uv.st );
		vec2 st1 = dFdy( uv.st );
		vec3 N = surf_norm;
		vec3 q1perp = cross( q1, N );
		vec3 q0perp = cross( N, q0 );
		vec3 T = q1perp * st0.x + q0perp * st1.x;
		vec3 B = q1perp * st0.y + q0perp * st1.y;
		float det = max( dot( T, T ), dot( B, B ) );
		float scale = ( det == 0.0 ) ? 0.0 : inversesqrt( det );
		return mat3( T * scale, B * scale, N );
	}
#endif`,kf=`#ifdef USE_CLEARCOAT
	vec3 clearcoatNormal = nonPerturbedNormal;
#endif`,Ff=`#ifdef USE_CLEARCOAT_NORMALMAP
	vec3 clearcoatMapN = texture2D( clearcoatNormalMap, vClearcoatNormalMapUv ).xyz * 2.0 - 1.0;
	clearcoatMapN.xy *= clearcoatNormalScale;
	clearcoatNormal = normalize( tbn2 * clearcoatMapN );
#endif`,Of=`#ifdef USE_CLEARCOATMAP
	uniform sampler2D clearcoatMap;
#endif
#ifdef USE_CLEARCOAT_NORMALMAP
	uniform sampler2D clearcoatNormalMap;
	uniform vec2 clearcoatNormalScale;
#endif
#ifdef USE_CLEARCOAT_ROUGHNESSMAP
	uniform sampler2D clearcoatRoughnessMap;
#endif`,Bf=`#ifdef USE_IRIDESCENCEMAP
	uniform sampler2D iridescenceMap;
#endif
#ifdef USE_IRIDESCENCE_THICKNESSMAP
	uniform sampler2D iridescenceThicknessMap;
#endif`,zf=`#ifdef OPAQUE
diffuseColor.a = 1.0;
#endif
#ifdef USE_TRANSMISSION
diffuseColor.a *= material.transmissionAlpha;
#endif
gl_FragColor = vec4( outgoingLight, diffuseColor.a );`,Hf=`vec3 packNormalToRGB( const in vec3 normal ) {
	return normalize( normal ) * 0.5 + 0.5;
}
vec3 unpackRGBToNormal( const in vec3 rgb ) {
	return 2.0 * rgb.xyz - 1.0;
}
const float PackUpscale = 256. / 255.;const float UnpackDownscale = 255. / 256.;const float ShiftRight8 = 1. / 256.;
const float Inv255 = 1. / 255.;
const vec4 PackFactors = vec4( 1.0, 256.0, 256.0 * 256.0, 256.0 * 256.0 * 256.0 );
const vec2 UnpackFactors2 = vec2( UnpackDownscale, 1.0 / PackFactors.g );
const vec3 UnpackFactors3 = vec3( UnpackDownscale / PackFactors.rg, 1.0 / PackFactors.b );
const vec4 UnpackFactors4 = vec4( UnpackDownscale / PackFactors.rgb, 1.0 / PackFactors.a );
vec4 packDepthToRGBA( const in float v ) {
	if( v <= 0.0 )
		return vec4( 0., 0., 0., 0. );
	if( v >= 1.0 )
		return vec4( 1., 1., 1., 1. );
	float vuf;
	float af = modf( v * PackFactors.a, vuf );
	float bf = modf( vuf * ShiftRight8, vuf );
	float gf = modf( vuf * ShiftRight8, vuf );
	return vec4( vuf * Inv255, gf * PackUpscale, bf * PackUpscale, af );
}
vec3 packDepthToRGB( const in float v ) {
	if( v <= 0.0 )
		return vec3( 0., 0., 0. );
	if( v >= 1.0 )
		return vec3( 1., 1., 1. );
	float vuf;
	float bf = modf( v * PackFactors.b, vuf );
	float gf = modf( vuf * ShiftRight8, vuf );
	return vec3( vuf * Inv255, gf * PackUpscale, bf );
}
vec2 packDepthToRG( const in float v ) {
	if( v <= 0.0 )
		return vec2( 0., 0. );
	if( v >= 1.0 )
		return vec2( 1., 1. );
	float vuf;
	float gf = modf( v * 256., vuf );
	return vec2( vuf * Inv255, gf );
}
float unpackRGBAToDepth( const in vec4 v ) {
	return dot( v, UnpackFactors4 );
}
float unpackRGBToDepth( const in vec3 v ) {
	return dot( v, UnpackFactors3 );
}
float unpackRGToDepth( const in vec2 v ) {
	return v.r * UnpackFactors2.r + v.g * UnpackFactors2.g;
}
vec4 pack2HalfToRGBA( const in vec2 v ) {
	vec4 r = vec4( v.x, fract( v.x * 255.0 ), v.y, fract( v.y * 255.0 ) );
	return vec4( r.x - r.y / 255.0, r.y, r.z - r.w / 255.0, r.w );
}
vec2 unpackRGBATo2Half( const in vec4 v ) {
	return vec2( v.x + ( v.y / 255.0 ), v.z + ( v.w / 255.0 ) );
}
float viewZToOrthographicDepth( const in float viewZ, const in float near, const in float far ) {
	return ( viewZ + near ) / ( near - far );
}
float orthographicDepthToViewZ( const in float depth, const in float near, const in float far ) {
	return depth * ( near - far ) - near;
}
float viewZToPerspectiveDepth( const in float viewZ, const in float near, const in float far ) {
	return ( ( near + viewZ ) * far ) / ( ( far - near ) * viewZ );
}
float perspectiveDepthToViewZ( const in float depth, const in float near, const in float far ) {
	return ( near * far ) / ( ( far - near ) * depth - far );
}`,Vf=`#ifdef PREMULTIPLIED_ALPHA
	gl_FragColor.rgb *= gl_FragColor.a;
#endif`,Gf=`vec4 mvPosition = vec4( transformed, 1.0 );
#ifdef USE_BATCHING
	mvPosition = batchingMatrix * mvPosition;
#endif
#ifdef USE_INSTANCING
	mvPosition = instanceMatrix * mvPosition;
#endif
mvPosition = modelViewMatrix * mvPosition;
gl_Position = projectionMatrix * mvPosition;`,Wf=`#ifdef DITHERING
	gl_FragColor.rgb = dithering( gl_FragColor.rgb );
#endif`,Xf=`#ifdef DITHERING
	vec3 dithering( vec3 color ) {
		float grid_position = rand( gl_FragCoord.xy );
		vec3 dither_shift_RGB = vec3( 0.25 / 255.0, -0.25 / 255.0, 0.25 / 255.0 );
		dither_shift_RGB = mix( 2.0 * dither_shift_RGB, -2.0 * dither_shift_RGB, grid_position );
		return color + dither_shift_RGB;
	}
#endif`,$f=`float roughnessFactor = roughness;
#ifdef USE_ROUGHNESSMAP
	vec4 texelRoughness = texture2D( roughnessMap, vRoughnessMapUv );
	roughnessFactor *= texelRoughness.g;
#endif`,qf=`#ifdef USE_ROUGHNESSMAP
	uniform sampler2D roughnessMap;
#endif`,Yf=`#if NUM_SPOT_LIGHT_COORDS > 0
	varying vec4 vSpotLightCoord[ NUM_SPOT_LIGHT_COORDS ];
#endif
#if NUM_SPOT_LIGHT_MAPS > 0
	uniform sampler2D spotLightMap[ NUM_SPOT_LIGHT_MAPS ];
#endif
#ifdef USE_SHADOWMAP
	#if NUM_DIR_LIGHT_SHADOWS > 0
		uniform sampler2D directionalShadowMap[ NUM_DIR_LIGHT_SHADOWS ];
		varying vec4 vDirectionalShadowCoord[ NUM_DIR_LIGHT_SHADOWS ];
		struct DirectionalLightShadow {
			float shadowIntensity;
			float shadowBias;
			float shadowNormalBias;
			float shadowRadius;
			vec2 shadowMapSize;
		};
		uniform DirectionalLightShadow directionalLightShadows[ NUM_DIR_LIGHT_SHADOWS ];
	#endif
	#if NUM_SPOT_LIGHT_SHADOWS > 0
		uniform sampler2D spotShadowMap[ NUM_SPOT_LIGHT_SHADOWS ];
		struct SpotLightShadow {
			float shadowIntensity;
			float shadowBias;
			float shadowNormalBias;
			float shadowRadius;
			vec2 shadowMapSize;
		};
		uniform SpotLightShadow spotLightShadows[ NUM_SPOT_LIGHT_SHADOWS ];
	#endif
	#if NUM_POINT_LIGHT_SHADOWS > 0
		uniform sampler2D pointShadowMap[ NUM_POINT_LIGHT_SHADOWS ];
		varying vec4 vPointShadowCoord[ NUM_POINT_LIGHT_SHADOWS ];
		struct PointLightShadow {
			float shadowIntensity;
			float shadowBias;
			float shadowNormalBias;
			float shadowRadius;
			vec2 shadowMapSize;
			float shadowCameraNear;
			float shadowCameraFar;
		};
		uniform PointLightShadow pointLightShadows[ NUM_POINT_LIGHT_SHADOWS ];
	#endif
	float texture2DCompare( sampler2D depths, vec2 uv, float compare ) {
		return step( compare, unpackRGBAToDepth( texture2D( depths, uv ) ) );
	}
	vec2 texture2DDistribution( sampler2D shadow, vec2 uv ) {
		return unpackRGBATo2Half( texture2D( shadow, uv ) );
	}
	float VSMShadow (sampler2D shadow, vec2 uv, float compare ){
		float occlusion = 1.0;
		vec2 distribution = texture2DDistribution( shadow, uv );
		float hard_shadow = step( compare , distribution.x );
		if (hard_shadow != 1.0 ) {
			float distance = compare - distribution.x ;
			float variance = max( 0.00000, distribution.y * distribution.y );
			float softness_probability = variance / (variance + distance * distance );			softness_probability = clamp( ( softness_probability - 0.3 ) / ( 0.95 - 0.3 ), 0.0, 1.0 );			occlusion = clamp( max( hard_shadow, softness_probability ), 0.0, 1.0 );
		}
		return occlusion;
	}
	float getShadow( sampler2D shadowMap, vec2 shadowMapSize, float shadowIntensity, float shadowBias, float shadowRadius, vec4 shadowCoord ) {
		float shadow = 1.0;
		shadowCoord.xyz /= shadowCoord.w;
		shadowCoord.z += shadowBias;
		bool inFrustum = shadowCoord.x >= 0.0 && shadowCoord.x <= 1.0 && shadowCoord.y >= 0.0 && shadowCoord.y <= 1.0;
		bool frustumTest = inFrustum && shadowCoord.z <= 1.0;
		if ( frustumTest ) {
		#if defined( SHADOWMAP_TYPE_PCF )
			vec2 texelSize = vec2( 1.0 ) / shadowMapSize;
			float dx0 = - texelSize.x * shadowRadius;
			float dy0 = - texelSize.y * shadowRadius;
			float dx1 = + texelSize.x * shadowRadius;
			float dy1 = + texelSize.y * shadowRadius;
			float dx2 = dx0 / 2.0;
			float dy2 = dy0 / 2.0;
			float dx3 = dx1 / 2.0;
			float dy3 = dy1 / 2.0;
			shadow = (
				texture2DCompare( shadowMap, shadowCoord.xy + vec2( dx0, dy0 ), shadowCoord.z ) +
				texture2DCompare( shadowMap, shadowCoord.xy + vec2( 0.0, dy0 ), shadowCoord.z ) +
				texture2DCompare( shadowMap, shadowCoord.xy + vec2( dx1, dy0 ), shadowCoord.z ) +
				texture2DCompare( shadowMap, shadowCoord.xy + vec2( dx2, dy2 ), shadowCoord.z ) +
				texture2DCompare( shadowMap, shadowCoord.xy + vec2( 0.0, dy2 ), shadowCoord.z ) +
				texture2DCompare( shadowMap, shadowCoord.xy + vec2( dx3, dy2 ), shadowCoord.z ) +
				texture2DCompare( shadowMap, shadowCoord.xy + vec2( dx0, 0.0 ), shadowCoord.z ) +
				texture2DCompare( shadowMap, shadowCoord.xy + vec2( dx2, 0.0 ), shadowCoord.z ) +
				texture2DCompare( shadowMap, shadowCoord.xy, shadowCoord.z ) +
				texture2DCompare( shadowMap, shadowCoord.xy + vec2( dx3, 0.0 ), shadowCoord.z ) +
				texture2DCompare( shadowMap, shadowCoord.xy + vec2( dx1, 0.0 ), shadowCoord.z ) +
				texture2DCompare( shadowMap, shadowCoord.xy + vec2( dx2, dy3 ), shadowCoord.z ) +
				texture2DCompare( shadowMap, shadowCoord.xy + vec2( 0.0, dy3 ), shadowCoord.z ) +
				texture2DCompare( shadowMap, shadowCoord.xy + vec2( dx3, dy3 ), shadowCoord.z ) +
				texture2DCompare( shadowMap, shadowCoord.xy + vec2( dx0, dy1 ), shadowCoord.z ) +
				texture2DCompare( shadowMap, shadowCoord.xy + vec2( 0.0, dy1 ), shadowCoord.z ) +
				texture2DCompare( shadowMap, shadowCoord.xy + vec2( dx1, dy1 ), shadowCoord.z )
			) * ( 1.0 / 17.0 );
		#elif defined( SHADOWMAP_TYPE_PCF_SOFT )
			vec2 texelSize = vec2( 1.0 ) / shadowMapSize;
			float dx = texelSize.x;
			float dy = texelSize.y;
			vec2 uv = shadowCoord.xy;
			vec2 f = fract( uv * shadowMapSize + 0.5 );
			uv -= f * texelSize;
			shadow = (
				texture2DCompare( shadowMap, uv, shadowCoord.z ) +
				texture2DCompare( shadowMap, uv + vec2( dx, 0.0 ), shadowCoord.z ) +
				texture2DCompare( shadowMap, uv + vec2( 0.0, dy ), shadowCoord.z ) +
				texture2DCompare( shadowMap, uv + texelSize, shadowCoord.z ) +
				mix( texture2DCompare( shadowMap, uv + vec2( -dx, 0.0 ), shadowCoord.z ),
					 texture2DCompare( shadowMap, uv + vec2( 2.0 * dx, 0.0 ), shadowCoord.z ),
					 f.x ) +
				mix( texture2DCompare( shadowMap, uv + vec2( -dx, dy ), shadowCoord.z ),
					 texture2DCompare( shadowMap, uv + vec2( 2.0 * dx, dy ), shadowCoord.z ),
					 f.x ) +
				mix( texture2DCompare( shadowMap, uv + vec2( 0.0, -dy ), shadowCoord.z ),
					 texture2DCompare( shadowMap, uv + vec2( 0.0, 2.0 * dy ), shadowCoord.z ),
					 f.y ) +
				mix( texture2DCompare( shadowMap, uv + vec2( dx, -dy ), shadowCoord.z ),
					 texture2DCompare( shadowMap, uv + vec2( dx, 2.0 * dy ), shadowCoord.z ),
					 f.y ) +
				mix( mix( texture2DCompare( shadowMap, uv + vec2( -dx, -dy ), shadowCoord.z ),
						  texture2DCompare( shadowMap, uv + vec2( 2.0 * dx, -dy ), shadowCoord.z ),
						  f.x ),
					 mix( texture2DCompare( shadowMap, uv + vec2( -dx, 2.0 * dy ), shadowCoord.z ),
						  texture2DCompare( shadowMap, uv + vec2( 2.0 * dx, 2.0 * dy ), shadowCoord.z ),
						  f.x ),
					 f.y )
			) * ( 1.0 / 9.0 );
		#elif defined( SHADOWMAP_TYPE_VSM )
			shadow = VSMShadow( shadowMap, shadowCoord.xy, shadowCoord.z );
		#else
			shadow = texture2DCompare( shadowMap, shadowCoord.xy, shadowCoord.z );
		#endif
		}
		return mix( 1.0, shadow, shadowIntensity );
	}
	vec2 cubeToUV( vec3 v, float texelSizeY ) {
		vec3 absV = abs( v );
		float scaleToCube = 1.0 / max( absV.x, max( absV.y, absV.z ) );
		absV *= scaleToCube;
		v *= scaleToCube * ( 1.0 - 2.0 * texelSizeY );
		vec2 planar = v.xy;
		float almostATexel = 1.5 * texelSizeY;
		float almostOne = 1.0 - almostATexel;
		if ( absV.z >= almostOne ) {
			if ( v.z > 0.0 )
				planar.x = 4.0 - v.x;
		} else if ( absV.x >= almostOne ) {
			float signX = sign( v.x );
			planar.x = v.z * signX + 2.0 * signX;
		} else if ( absV.y >= almostOne ) {
			float signY = sign( v.y );
			planar.x = v.x + 2.0 * signY + 2.0;
			planar.y = v.z * signY - 2.0;
		}
		return vec2( 0.125, 0.25 ) * planar + vec2( 0.375, 0.75 );
	}
	float getPointShadow( sampler2D shadowMap, vec2 shadowMapSize, float shadowIntensity, float shadowBias, float shadowRadius, vec4 shadowCoord, float shadowCameraNear, float shadowCameraFar ) {
		float shadow = 1.0;
		vec3 lightToPosition = shadowCoord.xyz;
		
		float lightToPositionLength = length( lightToPosition );
		if ( lightToPositionLength - shadowCameraFar <= 0.0 && lightToPositionLength - shadowCameraNear >= 0.0 ) {
			float dp = ( lightToPositionLength - shadowCameraNear ) / ( shadowCameraFar - shadowCameraNear );			dp += shadowBias;
			vec3 bd3D = normalize( lightToPosition );
			vec2 texelSize = vec2( 1.0 ) / ( shadowMapSize * vec2( 4.0, 2.0 ) );
			#if defined( SHADOWMAP_TYPE_PCF ) || defined( SHADOWMAP_TYPE_PCF_SOFT ) || defined( SHADOWMAP_TYPE_VSM )
				vec2 offset = vec2( - 1, 1 ) * shadowRadius * texelSize.y;
				shadow = (
					texture2DCompare( shadowMap, cubeToUV( bd3D + offset.xyy, texelSize.y ), dp ) +
					texture2DCompare( shadowMap, cubeToUV( bd3D + offset.yyy, texelSize.y ), dp ) +
					texture2DCompare( shadowMap, cubeToUV( bd3D + offset.xyx, texelSize.y ), dp ) +
					texture2DCompare( shadowMap, cubeToUV( bd3D + offset.yyx, texelSize.y ), dp ) +
					texture2DCompare( shadowMap, cubeToUV( bd3D, texelSize.y ), dp ) +
					texture2DCompare( shadowMap, cubeToUV( bd3D + offset.xxy, texelSize.y ), dp ) +
					texture2DCompare( shadowMap, cubeToUV( bd3D + offset.yxy, texelSize.y ), dp ) +
					texture2DCompare( shadowMap, cubeToUV( bd3D + offset.xxx, texelSize.y ), dp ) +
					texture2DCompare( shadowMap, cubeToUV( bd3D + offset.yxx, texelSize.y ), dp )
				) * ( 1.0 / 9.0 );
			#else
				shadow = texture2DCompare( shadowMap, cubeToUV( bd3D, texelSize.y ), dp );
			#endif
		}
		return mix( 1.0, shadow, shadowIntensity );
	}
#endif`,Kf=`#if NUM_SPOT_LIGHT_COORDS > 0
	uniform mat4 spotLightMatrix[ NUM_SPOT_LIGHT_COORDS ];
	varying vec4 vSpotLightCoord[ NUM_SPOT_LIGHT_COORDS ];
#endif
#ifdef USE_SHADOWMAP
	#if NUM_DIR_LIGHT_SHADOWS > 0
		uniform mat4 directionalShadowMatrix[ NUM_DIR_LIGHT_SHADOWS ];
		varying vec4 vDirectionalShadowCoord[ NUM_DIR_LIGHT_SHADOWS ];
		struct DirectionalLightShadow {
			float shadowIntensity;
			float shadowBias;
			float shadowNormalBias;
			float shadowRadius;
			vec2 shadowMapSize;
		};
		uniform DirectionalLightShadow directionalLightShadows[ NUM_DIR_LIGHT_SHADOWS ];
	#endif
	#if NUM_SPOT_LIGHT_SHADOWS > 0
		struct SpotLightShadow {
			float shadowIntensity;
			float shadowBias;
			float shadowNormalBias;
			float shadowRadius;
			vec2 shadowMapSize;
		};
		uniform SpotLightShadow spotLightShadows[ NUM_SPOT_LIGHT_SHADOWS ];
	#endif
	#if NUM_POINT_LIGHT_SHADOWS > 0
		uniform mat4 pointShadowMatrix[ NUM_POINT_LIGHT_SHADOWS ];
		varying vec4 vPointShadowCoord[ NUM_POINT_LIGHT_SHADOWS ];
		struct PointLightShadow {
			float shadowIntensity;
			float shadowBias;
			float shadowNormalBias;
			float shadowRadius;
			vec2 shadowMapSize;
			float shadowCameraNear;
			float shadowCameraFar;
		};
		uniform PointLightShadow pointLightShadows[ NUM_POINT_LIGHT_SHADOWS ];
	#endif
#endif`,Zf=`#if ( defined( USE_SHADOWMAP ) && ( NUM_DIR_LIGHT_SHADOWS > 0 || NUM_POINT_LIGHT_SHADOWS > 0 ) ) || ( NUM_SPOT_LIGHT_COORDS > 0 )
	vec3 shadowWorldNormal = inverseTransformDirection( transformedNormal, viewMatrix );
	vec4 shadowWorldPosition;
#endif
#if defined( USE_SHADOWMAP )
	#if NUM_DIR_LIGHT_SHADOWS > 0
		#pragma unroll_loop_start
		for ( int i = 0; i < NUM_DIR_LIGHT_SHADOWS; i ++ ) {
			shadowWorldPosition = worldPosition + vec4( shadowWorldNormal * directionalLightShadows[ i ].shadowNormalBias, 0 );
			vDirectionalShadowCoord[ i ] = directionalShadowMatrix[ i ] * shadowWorldPosition;
		}
		#pragma unroll_loop_end
	#endif
	#if NUM_POINT_LIGHT_SHADOWS > 0
		#pragma unroll_loop_start
		for ( int i = 0; i < NUM_POINT_LIGHT_SHADOWS; i ++ ) {
			shadowWorldPosition = worldPosition + vec4( shadowWorldNormal * pointLightShadows[ i ].shadowNormalBias, 0 );
			vPointShadowCoord[ i ] = pointShadowMatrix[ i ] * shadowWorldPosition;
		}
		#pragma unroll_loop_end
	#endif
#endif
#if NUM_SPOT_LIGHT_COORDS > 0
	#pragma unroll_loop_start
	for ( int i = 0; i < NUM_SPOT_LIGHT_COORDS; i ++ ) {
		shadowWorldPosition = worldPosition;
		#if ( defined( USE_SHADOWMAP ) && UNROLLED_LOOP_INDEX < NUM_SPOT_LIGHT_SHADOWS )
			shadowWorldPosition.xyz += shadowWorldNormal * spotLightShadows[ i ].shadowNormalBias;
		#endif
		vSpotLightCoord[ i ] = spotLightMatrix[ i ] * shadowWorldPosition;
	}
	#pragma unroll_loop_end
#endif`,jf=`float getShadowMask() {
	float shadow = 1.0;
	#ifdef USE_SHADOWMAP
	#if NUM_DIR_LIGHT_SHADOWS > 0
	DirectionalLightShadow directionalLight;
	#pragma unroll_loop_start
	for ( int i = 0; i < NUM_DIR_LIGHT_SHADOWS; i ++ ) {
		directionalLight = directionalLightShadows[ i ];
		shadow *= receiveShadow ? getShadow( directionalShadowMap[ i ], directionalLight.shadowMapSize, directionalLight.shadowIntensity, directionalLight.shadowBias, directionalLight.shadowRadius, vDirectionalShadowCoord[ i ] ) : 1.0;
	}
	#pragma unroll_loop_end
	#endif
	#if NUM_SPOT_LIGHT_SHADOWS > 0
	SpotLightShadow spotLight;
	#pragma unroll_loop_start
	for ( int i = 0; i < NUM_SPOT_LIGHT_SHADOWS; i ++ ) {
		spotLight = spotLightShadows[ i ];
		shadow *= receiveShadow ? getShadow( spotShadowMap[ i ], spotLight.shadowMapSize, spotLight.shadowIntensity, spotLight.shadowBias, spotLight.shadowRadius, vSpotLightCoord[ i ] ) : 1.0;
	}
	#pragma unroll_loop_end
	#endif
	#if NUM_POINT_LIGHT_SHADOWS > 0
	PointLightShadow pointLight;
	#pragma unroll_loop_start
	for ( int i = 0; i < NUM_POINT_LIGHT_SHADOWS; i ++ ) {
		pointLight = pointLightShadows[ i ];
		shadow *= receiveShadow ? getPointShadow( pointShadowMap[ i ], pointLight.shadowMapSize, pointLight.shadowIntensity, pointLight.shadowBias, pointLight.shadowRadius, vPointShadowCoord[ i ], pointLight.shadowCameraNear, pointLight.shadowCameraFar ) : 1.0;
	}
	#pragma unroll_loop_end
	#endif
	#endif
	return shadow;
}`,Jf=`#ifdef USE_SKINNING
	mat4 boneMatX = getBoneMatrix( skinIndex.x );
	mat4 boneMatY = getBoneMatrix( skinIndex.y );
	mat4 boneMatZ = getBoneMatrix( skinIndex.z );
	mat4 boneMatW = getBoneMatrix( skinIndex.w );
#endif`,Qf=`#ifdef USE_SKINNING
	uniform mat4 bindMatrix;
	uniform mat4 bindMatrixInverse;
	uniform highp sampler2D boneTexture;
	mat4 getBoneMatrix( const in float i ) {
		int size = textureSize( boneTexture, 0 ).x;
		int j = int( i ) * 4;
		int x = j % size;
		int y = j / size;
		vec4 v1 = texelFetch( boneTexture, ivec2( x, y ), 0 );
		vec4 v2 = texelFetch( boneTexture, ivec2( x + 1, y ), 0 );
		vec4 v3 = texelFetch( boneTexture, ivec2( x + 2, y ), 0 );
		vec4 v4 = texelFetch( boneTexture, ivec2( x + 3, y ), 0 );
		return mat4( v1, v2, v3, v4 );
	}
#endif`,tp=`#ifdef USE_SKINNING
	vec4 skinVertex = bindMatrix * vec4( transformed, 1.0 );
	vec4 skinned = vec4( 0.0 );
	skinned += boneMatX * skinVertex * skinWeight.x;
	skinned += boneMatY * skinVertex * skinWeight.y;
	skinned += boneMatZ * skinVertex * skinWeight.z;
	skinned += boneMatW * skinVertex * skinWeight.w;
	transformed = ( bindMatrixInverse * skinned ).xyz;
#endif`,ep=`#ifdef USE_SKINNING
	mat4 skinMatrix = mat4( 0.0 );
	skinMatrix += skinWeight.x * boneMatX;
	skinMatrix += skinWeight.y * boneMatY;
	skinMatrix += skinWeight.z * boneMatZ;
	skinMatrix += skinWeight.w * boneMatW;
	skinMatrix = bindMatrixInverse * skinMatrix * bindMatrix;
	objectNormal = vec4( skinMatrix * vec4( objectNormal, 0.0 ) ).xyz;
	#ifdef USE_TANGENT
		objectTangent = vec4( skinMatrix * vec4( objectTangent, 0.0 ) ).xyz;
	#endif
#endif`,np=`float specularStrength;
#ifdef USE_SPECULARMAP
	vec4 texelSpecular = texture2D( specularMap, vSpecularMapUv );
	specularStrength = texelSpecular.r;
#else
	specularStrength = 1.0;
#endif`,ip=`#ifdef USE_SPECULARMAP
	uniform sampler2D specularMap;
#endif`,sp=`#if defined( TONE_MAPPING )
	gl_FragColor.rgb = toneMapping( gl_FragColor.rgb );
#endif`,rp=`#ifndef saturate
#define saturate( a ) clamp( a, 0.0, 1.0 )
#endif
uniform float toneMappingExposure;
vec3 LinearToneMapping( vec3 color ) {
	return saturate( toneMappingExposure * color );
}
vec3 ReinhardToneMapping( vec3 color ) {
	color *= toneMappingExposure;
	return saturate( color / ( vec3( 1.0 ) + color ) );
}
vec3 CineonToneMapping( vec3 color ) {
	color *= toneMappingExposure;
	color = max( vec3( 0.0 ), color - 0.004 );
	return pow( ( color * ( 6.2 * color + 0.5 ) ) / ( color * ( 6.2 * color + 1.7 ) + 0.06 ), vec3( 2.2 ) );
}
vec3 RRTAndODTFit( vec3 v ) {
	vec3 a = v * ( v + 0.0245786 ) - 0.000090537;
	vec3 b = v * ( 0.983729 * v + 0.4329510 ) + 0.238081;
	return a / b;
}
vec3 ACESFilmicToneMapping( vec3 color ) {
	const mat3 ACESInputMat = mat3(
		vec3( 0.59719, 0.07600, 0.02840 ),		vec3( 0.35458, 0.90834, 0.13383 ),
		vec3( 0.04823, 0.01566, 0.83777 )
	);
	const mat3 ACESOutputMat = mat3(
		vec3(  1.60475, -0.10208, -0.00327 ),		vec3( -0.53108,  1.10813, -0.07276 ),
		vec3( -0.07367, -0.00605,  1.07602 )
	);
	color *= toneMappingExposure / 0.6;
	color = ACESInputMat * color;
	color = RRTAndODTFit( color );
	color = ACESOutputMat * color;
	return saturate( color );
}
const mat3 LINEAR_REC2020_TO_LINEAR_SRGB = mat3(
	vec3( 1.6605, - 0.1246, - 0.0182 ),
	vec3( - 0.5876, 1.1329, - 0.1006 ),
	vec3( - 0.0728, - 0.0083, 1.1187 )
);
const mat3 LINEAR_SRGB_TO_LINEAR_REC2020 = mat3(
	vec3( 0.6274, 0.0691, 0.0164 ),
	vec3( 0.3293, 0.9195, 0.0880 ),
	vec3( 0.0433, 0.0113, 0.8956 )
);
vec3 agxDefaultContrastApprox( vec3 x ) {
	vec3 x2 = x * x;
	vec3 x4 = x2 * x2;
	return + 15.5 * x4 * x2
		- 40.14 * x4 * x
		+ 31.96 * x4
		- 6.868 * x2 * x
		+ 0.4298 * x2
		+ 0.1191 * x
		- 0.00232;
}
vec3 AgXToneMapping( vec3 color ) {
	const mat3 AgXInsetMatrix = mat3(
		vec3( 0.856627153315983, 0.137318972929847, 0.11189821299995 ),
		vec3( 0.0951212405381588, 0.761241990602591, 0.0767994186031903 ),
		vec3( 0.0482516061458583, 0.101439036467562, 0.811302368396859 )
	);
	const mat3 AgXOutsetMatrix = mat3(
		vec3( 1.1271005818144368, - 0.1413297634984383, - 0.14132976349843826 ),
		vec3( - 0.11060664309660323, 1.157823702216272, - 0.11060664309660294 ),
		vec3( - 0.016493938717834573, - 0.016493938717834257, 1.2519364065950405 )
	);
	const float AgxMinEv = - 12.47393;	const float AgxMaxEv = 4.026069;
	color *= toneMappingExposure;
	color = LINEAR_SRGB_TO_LINEAR_REC2020 * color;
	color = AgXInsetMatrix * color;
	color = max( color, 1e-10 );	color = log2( color );
	color = ( color - AgxMinEv ) / ( AgxMaxEv - AgxMinEv );
	color = clamp( color, 0.0, 1.0 );
	color = agxDefaultContrastApprox( color );
	color = AgXOutsetMatrix * color;
	color = pow( max( vec3( 0.0 ), color ), vec3( 2.2 ) );
	color = LINEAR_REC2020_TO_LINEAR_SRGB * color;
	color = clamp( color, 0.0, 1.0 );
	return color;
}
vec3 NeutralToneMapping( vec3 color ) {
	const float StartCompression = 0.8 - 0.04;
	const float Desaturation = 0.15;
	color *= toneMappingExposure;
	float x = min( color.r, min( color.g, color.b ) );
	float offset = x < 0.08 ? x - 6.25 * x * x : 0.04;
	color -= offset;
	float peak = max( color.r, max( color.g, color.b ) );
	if ( peak < StartCompression ) return color;
	float d = 1. - StartCompression;
	float newPeak = 1. - d * d / ( peak + d - StartCompression );
	color *= newPeak / peak;
	float g = 1. - 1. / ( Desaturation * ( peak - newPeak ) + 1. );
	return mix( color, vec3( newPeak ), g );
}
vec3 CustomToneMapping( vec3 color ) { return color; }`,op=`#ifdef USE_TRANSMISSION
	material.transmission = transmission;
	material.transmissionAlpha = 1.0;
	material.thickness = thickness;
	material.attenuationDistance = attenuationDistance;
	material.attenuationColor = attenuationColor;
	#ifdef USE_TRANSMISSIONMAP
		material.transmission *= texture2D( transmissionMap, vTransmissionMapUv ).r;
	#endif
	#ifdef USE_THICKNESSMAP
		material.thickness *= texture2D( thicknessMap, vThicknessMapUv ).g;
	#endif
	vec3 pos = vWorldPosition;
	vec3 v = normalize( cameraPosition - pos );
	vec3 n = inverseTransformDirection( normal, viewMatrix );
	vec4 transmitted = getIBLVolumeRefraction(
		n, v, material.roughness, material.diffuseColor, material.specularColor, material.specularF90,
		pos, modelMatrix, viewMatrix, projectionMatrix, material.dispersion, material.ior, material.thickness,
		material.attenuationColor, material.attenuationDistance );
	material.transmissionAlpha = mix( material.transmissionAlpha, transmitted.a, material.transmission );
	totalDiffuse = mix( totalDiffuse, transmitted.rgb, material.transmission );
#endif`,ap=`#ifdef USE_TRANSMISSION
	uniform float transmission;
	uniform float thickness;
	uniform float attenuationDistance;
	uniform vec3 attenuationColor;
	#ifdef USE_TRANSMISSIONMAP
		uniform sampler2D transmissionMap;
	#endif
	#ifdef USE_THICKNESSMAP
		uniform sampler2D thicknessMap;
	#endif
	uniform vec2 transmissionSamplerSize;
	uniform sampler2D transmissionSamplerMap;
	uniform mat4 modelMatrix;
	uniform mat4 projectionMatrix;
	varying vec3 vWorldPosition;
	float w0( float a ) {
		return ( 1.0 / 6.0 ) * ( a * ( a * ( - a + 3.0 ) - 3.0 ) + 1.0 );
	}
	float w1( float a ) {
		return ( 1.0 / 6.0 ) * ( a *  a * ( 3.0 * a - 6.0 ) + 4.0 );
	}
	float w2( float a ){
		return ( 1.0 / 6.0 ) * ( a * ( a * ( - 3.0 * a + 3.0 ) + 3.0 ) + 1.0 );
	}
	float w3( float a ) {
		return ( 1.0 / 6.0 ) * ( a * a * a );
	}
	float g0( float a ) {
		return w0( a ) + w1( a );
	}
	float g1( float a ) {
		return w2( a ) + w3( a );
	}
	float h0( float a ) {
		return - 1.0 + w1( a ) / ( w0( a ) + w1( a ) );
	}
	float h1( float a ) {
		return 1.0 + w3( a ) / ( w2( a ) + w3( a ) );
	}
	vec4 bicubic( sampler2D tex, vec2 uv, vec4 texelSize, float lod ) {
		uv = uv * texelSize.zw + 0.5;
		vec2 iuv = floor( uv );
		vec2 fuv = fract( uv );
		float g0x = g0( fuv.x );
		float g1x = g1( fuv.x );
		float h0x = h0( fuv.x );
		float h1x = h1( fuv.x );
		float h0y = h0( fuv.y );
		float h1y = h1( fuv.y );
		vec2 p0 = ( vec2( iuv.x + h0x, iuv.y + h0y ) - 0.5 ) * texelSize.xy;
		vec2 p1 = ( vec2( iuv.x + h1x, iuv.y + h0y ) - 0.5 ) * texelSize.xy;
		vec2 p2 = ( vec2( iuv.x + h0x, iuv.y + h1y ) - 0.5 ) * texelSize.xy;
		vec2 p3 = ( vec2( iuv.x + h1x, iuv.y + h1y ) - 0.5 ) * texelSize.xy;
		return g0( fuv.y ) * ( g0x * textureLod( tex, p0, lod ) + g1x * textureLod( tex, p1, lod ) ) +
			g1( fuv.y ) * ( g0x * textureLod( tex, p2, lod ) + g1x * textureLod( tex, p3, lod ) );
	}
	vec4 textureBicubic( sampler2D sampler, vec2 uv, float lod ) {
		vec2 fLodSize = vec2( textureSize( sampler, int( lod ) ) );
		vec2 cLodSize = vec2( textureSize( sampler, int( lod + 1.0 ) ) );
		vec2 fLodSizeInv = 1.0 / fLodSize;
		vec2 cLodSizeInv = 1.0 / cLodSize;
		vec4 fSample = bicubic( sampler, uv, vec4( fLodSizeInv, fLodSize ), floor( lod ) );
		vec4 cSample = bicubic( sampler, uv, vec4( cLodSizeInv, cLodSize ), ceil( lod ) );
		return mix( fSample, cSample, fract( lod ) );
	}
	vec3 getVolumeTransmissionRay( const in vec3 n, const in vec3 v, const in float thickness, const in float ior, const in mat4 modelMatrix ) {
		vec3 refractionVector = refract( - v, normalize( n ), 1.0 / ior );
		vec3 modelScale;
		modelScale.x = length( vec3( modelMatrix[ 0 ].xyz ) );
		modelScale.y = length( vec3( modelMatrix[ 1 ].xyz ) );
		modelScale.z = length( vec3( modelMatrix[ 2 ].xyz ) );
		return normalize( refractionVector ) * thickness * modelScale;
	}
	float applyIorToRoughness( const in float roughness, const in float ior ) {
		return roughness * clamp( ior * 2.0 - 2.0, 0.0, 1.0 );
	}
	vec4 getTransmissionSample( const in vec2 fragCoord, const in float roughness, const in float ior ) {
		float lod = log2( transmissionSamplerSize.x ) * applyIorToRoughness( roughness, ior );
		return textureBicubic( transmissionSamplerMap, fragCoord.xy, lod );
	}
	vec3 volumeAttenuation( const in float transmissionDistance, const in vec3 attenuationColor, const in float attenuationDistance ) {
		if ( isinf( attenuationDistance ) ) {
			return vec3( 1.0 );
		} else {
			vec3 attenuationCoefficient = -log( attenuationColor ) / attenuationDistance;
			vec3 transmittance = exp( - attenuationCoefficient * transmissionDistance );			return transmittance;
		}
	}
	vec4 getIBLVolumeRefraction( const in vec3 n, const in vec3 v, const in float roughness, const in vec3 diffuseColor,
		const in vec3 specularColor, const in float specularF90, const in vec3 position, const in mat4 modelMatrix,
		const in mat4 viewMatrix, const in mat4 projMatrix, const in float dispersion, const in float ior, const in float thickness,
		const in vec3 attenuationColor, const in float attenuationDistance ) {
		vec4 transmittedLight;
		vec3 transmittance;
		#ifdef USE_DISPERSION
			float halfSpread = ( ior - 1.0 ) * 0.025 * dispersion;
			vec3 iors = vec3( ior - halfSpread, ior, ior + halfSpread );
			for ( int i = 0; i < 3; i ++ ) {
				vec3 transmissionRay = getVolumeTransmissionRay( n, v, thickness, iors[ i ], modelMatrix );
				vec3 refractedRayExit = position + transmissionRay;
		
				vec4 ndcPos = projMatrix * viewMatrix * vec4( refractedRayExit, 1.0 );
				vec2 refractionCoords = ndcPos.xy / ndcPos.w;
				refractionCoords += 1.0;
				refractionCoords /= 2.0;
		
				vec4 transmissionSample = getTransmissionSample( refractionCoords, roughness, iors[ i ] );
				transmittedLight[ i ] = transmissionSample[ i ];
				transmittedLight.a += transmissionSample.a;
				transmittance[ i ] = diffuseColor[ i ] * volumeAttenuation( length( transmissionRay ), attenuationColor, attenuationDistance )[ i ];
			}
			transmittedLight.a /= 3.0;
		
		#else
		
			vec3 transmissionRay = getVolumeTransmissionRay( n, v, thickness, ior, modelMatrix );
			vec3 refractedRayExit = position + transmissionRay;
			vec4 ndcPos = projMatrix * viewMatrix * vec4( refractedRayExit, 1.0 );
			vec2 refractionCoords = ndcPos.xy / ndcPos.w;
			refractionCoords += 1.0;
			refractionCoords /= 2.0;
			transmittedLight = getTransmissionSample( refractionCoords, roughness, ior );
			transmittance = diffuseColor * volumeAttenuation( length( transmissionRay ), attenuationColor, attenuationDistance );
		
		#endif
		vec3 attenuatedColor = transmittance * transmittedLight.rgb;
		vec3 F = EnvironmentBRDF( n, v, specularColor, specularF90, roughness );
		float transmittanceFactor = ( transmittance.r + transmittance.g + transmittance.b ) / 3.0;
		return vec4( ( 1.0 - F ) * attenuatedColor, 1.0 - ( 1.0 - transmittedLight.a ) * transmittanceFactor );
	}
#endif`,cp=`#if defined( USE_UV ) || defined( USE_ANISOTROPY )
	varying vec2 vUv;
#endif
#ifdef USE_MAP
	varying vec2 vMapUv;
#endif
#ifdef USE_ALPHAMAP
	varying vec2 vAlphaMapUv;
#endif
#ifdef USE_LIGHTMAP
	varying vec2 vLightMapUv;
#endif
#ifdef USE_AOMAP
	varying vec2 vAoMapUv;
#endif
#ifdef USE_BUMPMAP
	varying vec2 vBumpMapUv;
#endif
#ifdef USE_NORMALMAP
	varying vec2 vNormalMapUv;
#endif
#ifdef USE_EMISSIVEMAP
	varying vec2 vEmissiveMapUv;
#endif
#ifdef USE_METALNESSMAP
	varying vec2 vMetalnessMapUv;
#endif
#ifdef USE_ROUGHNESSMAP
	varying vec2 vRoughnessMapUv;
#endif
#ifdef USE_ANISOTROPYMAP
	varying vec2 vAnisotropyMapUv;
#endif
#ifdef USE_CLEARCOATMAP
	varying vec2 vClearcoatMapUv;
#endif
#ifdef USE_CLEARCOAT_NORMALMAP
	varying vec2 vClearcoatNormalMapUv;
#endif
#ifdef USE_CLEARCOAT_ROUGHNESSMAP
	varying vec2 vClearcoatRoughnessMapUv;
#endif
#ifdef USE_IRIDESCENCEMAP
	varying vec2 vIridescenceMapUv;
#endif
#ifdef USE_IRIDESCENCE_THICKNESSMAP
	varying vec2 vIridescenceThicknessMapUv;
#endif
#ifdef USE_SHEEN_COLORMAP
	varying vec2 vSheenColorMapUv;
#endif
#ifdef USE_SHEEN_ROUGHNESSMAP
	varying vec2 vSheenRoughnessMapUv;
#endif
#ifdef USE_SPECULARMAP
	varying vec2 vSpecularMapUv;
#endif
#ifdef USE_SPECULAR_COLORMAP
	varying vec2 vSpecularColorMapUv;
#endif
#ifdef USE_SPECULAR_INTENSITYMAP
	varying vec2 vSpecularIntensityMapUv;
#endif
#ifdef USE_TRANSMISSIONMAP
	uniform mat3 transmissionMapTransform;
	varying vec2 vTransmissionMapUv;
#endif
#ifdef USE_THICKNESSMAP
	uniform mat3 thicknessMapTransform;
	varying vec2 vThicknessMapUv;
#endif`,lp=`#if defined( USE_UV ) || defined( USE_ANISOTROPY )
	varying vec2 vUv;
#endif
#ifdef USE_MAP
	uniform mat3 mapTransform;
	varying vec2 vMapUv;
#endif
#ifdef USE_ALPHAMAP
	uniform mat3 alphaMapTransform;
	varying vec2 vAlphaMapUv;
#endif
#ifdef USE_LIGHTMAP
	uniform mat3 lightMapTransform;
	varying vec2 vLightMapUv;
#endif
#ifdef USE_AOMAP
	uniform mat3 aoMapTransform;
	varying vec2 vAoMapUv;
#endif
#ifdef USE_BUMPMAP
	uniform mat3 bumpMapTransform;
	varying vec2 vBumpMapUv;
#endif
#ifdef USE_NORMALMAP
	uniform mat3 normalMapTransform;
	varying vec2 vNormalMapUv;
#endif
#ifdef USE_DISPLACEMENTMAP
	uniform mat3 displacementMapTransform;
	varying vec2 vDisplacementMapUv;
#endif
#ifdef USE_EMISSIVEMAP
	uniform mat3 emissiveMapTransform;
	varying vec2 vEmissiveMapUv;
#endif
#ifdef USE_METALNESSMAP
	uniform mat3 metalnessMapTransform;
	varying vec2 vMetalnessMapUv;
#endif
#ifdef USE_ROUGHNESSMAP
	uniform mat3 roughnessMapTransform;
	varying vec2 vRoughnessMapUv;
#endif
#ifdef USE_ANISOTROPYMAP
	uniform mat3 anisotropyMapTransform;
	varying vec2 vAnisotropyMapUv;
#endif
#ifdef USE_CLEARCOATMAP
	uniform mat3 clearcoatMapTransform;
	varying vec2 vClearcoatMapUv;
#endif
#ifdef USE_CLEARCOAT_NORMALMAP
	uniform mat3 clearcoatNormalMapTransform;
	varying vec2 vClearcoatNormalMapUv;
#endif
#ifdef USE_CLEARCOAT_ROUGHNESSMAP
	uniform mat3 clearcoatRoughnessMapTransform;
	varying vec2 vClearcoatRoughnessMapUv;
#endif
#ifdef USE_SHEEN_COLORMAP
	uniform mat3 sheenColorMapTransform;
	varying vec2 vSheenColorMapUv;
#endif
#ifdef USE_SHEEN_ROUGHNESSMAP
	uniform mat3 sheenRoughnessMapTransform;
	varying vec2 vSheenRoughnessMapUv;
#endif
#ifdef USE_IRIDESCENCEMAP
	uniform mat3 iridescenceMapTransform;
	varying vec2 vIridescenceMapUv;
#endif
#ifdef USE_IRIDESCENCE_THICKNESSMAP
	uniform mat3 iridescenceThicknessMapTransform;
	varying vec2 vIridescenceThicknessMapUv;
#endif
#ifdef USE_SPECULARMAP
	uniform mat3 specularMapTransform;
	varying vec2 vSpecularMapUv;
#endif
#ifdef USE_SPECULAR_COLORMAP
	uniform mat3 specularColorMapTransform;
	varying vec2 vSpecularColorMapUv;
#endif
#ifdef USE_SPECULAR_INTENSITYMAP
	uniform mat3 specularIntensityMapTransform;
	varying vec2 vSpecularIntensityMapUv;
#endif
#ifdef USE_TRANSMISSIONMAP
	uniform mat3 transmissionMapTransform;
	varying vec2 vTransmissionMapUv;
#endif
#ifdef USE_THICKNESSMAP
	uniform mat3 thicknessMapTransform;
	varying vec2 vThicknessMapUv;
#endif`,hp=`#if defined( USE_UV ) || defined( USE_ANISOTROPY )
	vUv = vec3( uv, 1 ).xy;
#endif
#ifdef USE_MAP
	vMapUv = ( mapTransform * vec3( MAP_UV, 1 ) ).xy;
#endif
#ifdef USE_ALPHAMAP
	vAlphaMapUv = ( alphaMapTransform * vec3( ALPHAMAP_UV, 1 ) ).xy;
#endif
#ifdef USE_LIGHTMAP
	vLightMapUv = ( lightMapTransform * vec3( LIGHTMAP_UV, 1 ) ).xy;
#endif
#ifdef USE_AOMAP
	vAoMapUv = ( aoMapTransform * vec3( AOMAP_UV, 1 ) ).xy;
#endif
#ifdef USE_BUMPMAP
	vBumpMapUv = ( bumpMapTransform * vec3( BUMPMAP_UV, 1 ) ).xy;
#endif
#ifdef USE_NORMALMAP
	vNormalMapUv = ( normalMapTransform * vec3( NORMALMAP_UV, 1 ) ).xy;
#endif
#ifdef USE_DISPLACEMENTMAP
	vDisplacementMapUv = ( displacementMapTransform * vec3( DISPLACEMENTMAP_UV, 1 ) ).xy;
#endif
#ifdef USE_EMISSIVEMAP
	vEmissiveMapUv = ( emissiveMapTransform * vec3( EMISSIVEMAP_UV, 1 ) ).xy;
#endif
#ifdef USE_METALNESSMAP
	vMetalnessMapUv = ( metalnessMapTransform * vec3( METALNESSMAP_UV, 1 ) ).xy;
#endif
#ifdef USE_ROUGHNESSMAP
	vRoughnessMapUv = ( roughnessMapTransform * vec3( ROUGHNESSMAP_UV, 1 ) ).xy;
#endif
#ifdef USE_ANISOTROPYMAP
	vAnisotropyMapUv = ( anisotropyMapTransform * vec3( ANISOTROPYMAP_UV, 1 ) ).xy;
#endif
#ifdef USE_CLEARCOATMAP
	vClearcoatMapUv = ( clearcoatMapTransform * vec3( CLEARCOATMAP_UV, 1 ) ).xy;
#endif
#ifdef USE_CLEARCOAT_NORMALMAP
	vClearcoatNormalMapUv = ( clearcoatNormalMapTransform * vec3( CLEARCOAT_NORMALMAP_UV, 1 ) ).xy;
#endif
#ifdef USE_CLEARCOAT_ROUGHNESSMAP
	vClearcoatRoughnessMapUv = ( clearcoatRoughnessMapTransform * vec3( CLEARCOAT_ROUGHNESSMAP_UV, 1 ) ).xy;
#endif
#ifdef USE_IRIDESCENCEMAP
	vIridescenceMapUv = ( iridescenceMapTransform * vec3( IRIDESCENCEMAP_UV, 1 ) ).xy;
#endif
#ifdef USE_IRIDESCENCE_THICKNESSMAP
	vIridescenceThicknessMapUv = ( iridescenceThicknessMapTransform * vec3( IRIDESCENCE_THICKNESSMAP_UV, 1 ) ).xy;
#endif
#ifdef USE_SHEEN_COLORMAP
	vSheenColorMapUv = ( sheenColorMapTransform * vec3( SHEEN_COLORMAP_UV, 1 ) ).xy;
#endif
#ifdef USE_SHEEN_ROUGHNESSMAP
	vSheenRoughnessMapUv = ( sheenRoughnessMapTransform * vec3( SHEEN_ROUGHNESSMAP_UV, 1 ) ).xy;
#endif
#ifdef USE_SPECULARMAP
	vSpecularMapUv = ( specularMapTransform * vec3( SPECULARMAP_UV, 1 ) ).xy;
#endif
#ifdef USE_SPECULAR_COLORMAP
	vSpecularColorMapUv = ( specularColorMapTransform * vec3( SPECULAR_COLORMAP_UV, 1 ) ).xy;
#endif
#ifdef USE_SPECULAR_INTENSITYMAP
	vSpecularIntensityMapUv = ( specularIntensityMapTransform * vec3( SPECULAR_INTENSITYMAP_UV, 1 ) ).xy;
#endif
#ifdef USE_TRANSMISSIONMAP
	vTransmissionMapUv = ( transmissionMapTransform * vec3( TRANSMISSIONMAP_UV, 1 ) ).xy;
#endif
#ifdef USE_THICKNESSMAP
	vThicknessMapUv = ( thicknessMapTransform * vec3( THICKNESSMAP_UV, 1 ) ).xy;
#endif`,up=`#if defined( USE_ENVMAP ) || defined( DISTANCE ) || defined ( USE_SHADOWMAP ) || defined ( USE_TRANSMISSION ) || NUM_SPOT_LIGHT_COORDS > 0
	vec4 worldPosition = vec4( transformed, 1.0 );
	#ifdef USE_BATCHING
		worldPosition = batchingMatrix * worldPosition;
	#endif
	#ifdef USE_INSTANCING
		worldPosition = instanceMatrix * worldPosition;
	#endif
	worldPosition = modelMatrix * worldPosition;
#endif`;const dp=`varying vec2 vUv;
uniform mat3 uvTransform;
void main() {
	vUv = ( uvTransform * vec3( uv, 1 ) ).xy;
	gl_Position = vec4( position.xy, 1.0, 1.0 );
}`,fp=`uniform sampler2D t2D;
uniform float backgroundIntensity;
varying vec2 vUv;
void main() {
	vec4 texColor = texture2D( t2D, vUv );
	#ifdef DECODE_VIDEO_TEXTURE
		texColor = vec4( mix( pow( texColor.rgb * 0.9478672986 + vec3( 0.0521327014 ), vec3( 2.4 ) ), texColor.rgb * 0.0773993808, vec3( lessThanEqual( texColor.rgb, vec3( 0.04045 ) ) ) ), texColor.w );
	#endif
	texColor.rgb *= backgroundIntensity;
	gl_FragColor = texColor;
	#include <tonemapping_fragment>
	#include <colorspace_fragment>
}`,pp=`varying vec3 vWorldDirection;
#include <common>
void main() {
	vWorldDirection = transformDirection( position, modelMatrix );
	#include <begin_vertex>
	#include <project_vertex>
	gl_Position.z = gl_Position.w;
}`,mp=`#ifdef ENVMAP_TYPE_CUBE
	uniform samplerCube envMap;
#elif defined( ENVMAP_TYPE_CUBE_UV )
	uniform sampler2D envMap;
#endif
uniform float flipEnvMap;
uniform float backgroundBlurriness;
uniform float backgroundIntensity;
uniform mat3 backgroundRotation;
varying vec3 vWorldDirection;
#include <cube_uv_reflection_fragment>
void main() {
	#ifdef ENVMAP_TYPE_CUBE
		vec4 texColor = textureCube( envMap, backgroundRotation * vec3( flipEnvMap * vWorldDirection.x, vWorldDirection.yz ) );
	#elif defined( ENVMAP_TYPE_CUBE_UV )
		vec4 texColor = textureCubeUV( envMap, backgroundRotation * vWorldDirection, backgroundBlurriness );
	#else
		vec4 texColor = vec4( 0.0, 0.0, 0.0, 1.0 );
	#endif
	texColor.rgb *= backgroundIntensity;
	gl_FragColor = texColor;
	#include <tonemapping_fragment>
	#include <colorspace_fragment>
}`,gp=`varying vec3 vWorldDirection;
#include <common>
void main() {
	vWorldDirection = transformDirection( position, modelMatrix );
	#include <begin_vertex>
	#include <project_vertex>
	gl_Position.z = gl_Position.w;
}`,_p=`uniform samplerCube tCube;
uniform float tFlip;
uniform float opacity;
varying vec3 vWorldDirection;
void main() {
	vec4 texColor = textureCube( tCube, vec3( tFlip * vWorldDirection.x, vWorldDirection.yz ) );
	gl_FragColor = texColor;
	gl_FragColor.a *= opacity;
	#include <tonemapping_fragment>
	#include <colorspace_fragment>
}`,vp=`#include <common>
#include <batching_pars_vertex>
#include <uv_pars_vertex>
#include <displacementmap_pars_vertex>
#include <morphtarget_pars_vertex>
#include <skinning_pars_vertex>
#include <logdepthbuf_pars_vertex>
#include <clipping_planes_pars_vertex>
varying vec2 vHighPrecisionZW;
void main() {
	#include <uv_vertex>
	#include <batching_vertex>
	#include <skinbase_vertex>
	#include <morphinstance_vertex>
	#ifdef USE_DISPLACEMENTMAP
		#include <beginnormal_vertex>
		#include <morphnormal_vertex>
		#include <skinnormal_vertex>
	#endif
	#include <begin_vertex>
	#include <morphtarget_vertex>
	#include <skinning_vertex>
	#include <displacementmap_vertex>
	#include <project_vertex>
	#include <logdepthbuf_vertex>
	#include <clipping_planes_vertex>
	vHighPrecisionZW = gl_Position.zw;
}`,xp=`#if DEPTH_PACKING == 3200
	uniform float opacity;
#endif
#include <common>
#include <packing>
#include <uv_pars_fragment>
#include <map_pars_fragment>
#include <alphamap_pars_fragment>
#include <alphatest_pars_fragment>
#include <alphahash_pars_fragment>
#include <logdepthbuf_pars_fragment>
#include <clipping_planes_pars_fragment>
varying vec2 vHighPrecisionZW;
void main() {
	vec4 diffuseColor = vec4( 1.0 );
	#include <clipping_planes_fragment>
	#if DEPTH_PACKING == 3200
		diffuseColor.a = opacity;
	#endif
	#include <map_fragment>
	#include <alphamap_fragment>
	#include <alphatest_fragment>
	#include <alphahash_fragment>
	#include <logdepthbuf_fragment>
	float fragCoordZ = 0.5 * vHighPrecisionZW[0] / vHighPrecisionZW[1] + 0.5;
	#if DEPTH_PACKING == 3200
		gl_FragColor = vec4( vec3( 1.0 - fragCoordZ ), opacity );
	#elif DEPTH_PACKING == 3201
		gl_FragColor = packDepthToRGBA( fragCoordZ );
	#elif DEPTH_PACKING == 3202
		gl_FragColor = vec4( packDepthToRGB( fragCoordZ ), 1.0 );
	#elif DEPTH_PACKING == 3203
		gl_FragColor = vec4( packDepthToRG( fragCoordZ ), 0.0, 1.0 );
	#endif
}`,yp=`#define DISTANCE
varying vec3 vWorldPosition;
#include <common>
#include <batching_pars_vertex>
#include <uv_pars_vertex>
#include <displacementmap_pars_vertex>
#include <morphtarget_pars_vertex>
#include <skinning_pars_vertex>
#include <clipping_planes_pars_vertex>
void main() {
	#include <uv_vertex>
	#include <batching_vertex>
	#include <skinbase_vertex>
	#include <morphinstance_vertex>
	#ifdef USE_DISPLACEMENTMAP
		#include <beginnormal_vertex>
		#include <morphnormal_vertex>
		#include <skinnormal_vertex>
	#endif
	#include <begin_vertex>
	#include <morphtarget_vertex>
	#include <skinning_vertex>
	#include <displacementmap_vertex>
	#include <project_vertex>
	#include <worldpos_vertex>
	#include <clipping_planes_vertex>
	vWorldPosition = worldPosition.xyz;
}`,Mp=`#define DISTANCE
uniform vec3 referencePosition;
uniform float nearDistance;
uniform float farDistance;
varying vec3 vWorldPosition;
#include <common>
#include <packing>
#include <uv_pars_fragment>
#include <map_pars_fragment>
#include <alphamap_pars_fragment>
#include <alphatest_pars_fragment>
#include <alphahash_pars_fragment>
#include <clipping_planes_pars_fragment>
void main () {
	vec4 diffuseColor = vec4( 1.0 );
	#include <clipping_planes_fragment>
	#include <map_fragment>
	#include <alphamap_fragment>
	#include <alphatest_fragment>
	#include <alphahash_fragment>
	float dist = length( vWorldPosition - referencePosition );
	dist = ( dist - nearDistance ) / ( farDistance - nearDistance );
	dist = saturate( dist );
	gl_FragColor = packDepthToRGBA( dist );
}`,Sp=`varying vec3 vWorldDirection;
#include <common>
void main() {
	vWorldDirection = transformDirection( position, modelMatrix );
	#include <begin_vertex>
	#include <project_vertex>
}`,bp=`uniform sampler2D tEquirect;
varying vec3 vWorldDirection;
#include <common>
void main() {
	vec3 direction = normalize( vWorldDirection );
	vec2 sampleUV = equirectUv( direction );
	gl_FragColor = texture2D( tEquirect, sampleUV );
	#include <tonemapping_fragment>
	#include <colorspace_fragment>
}`,Ep=`uniform float scale;
attribute float lineDistance;
varying float vLineDistance;
#include <common>
#include <uv_pars_vertex>
#include <color_pars_vertex>
#include <fog_pars_vertex>
#include <morphtarget_pars_vertex>
#include <logdepthbuf_pars_vertex>
#include <clipping_planes_pars_vertex>
void main() {
	vLineDistance = scale * lineDistance;
	#include <uv_vertex>
	#include <color_vertex>
	#include <morphinstance_vertex>
	#include <morphcolor_vertex>
	#include <begin_vertex>
	#include <morphtarget_vertex>
	#include <project_vertex>
	#include <logdepthbuf_vertex>
	#include <clipping_planes_vertex>
	#include <fog_vertex>
}`,Tp=`uniform vec3 diffuse;
uniform float opacity;
uniform float dashSize;
uniform float totalSize;
varying float vLineDistance;
#include <common>
#include <color_pars_fragment>
#include <uv_pars_fragment>
#include <map_pars_fragment>
#include <fog_pars_fragment>
#include <logdepthbuf_pars_fragment>
#include <clipping_planes_pars_fragment>
void main() {
	vec4 diffuseColor = vec4( diffuse, opacity );
	#include <clipping_planes_fragment>
	if ( mod( vLineDistance, totalSize ) > dashSize ) {
		discard;
	}
	vec3 outgoingLight = vec3( 0.0 );
	#include <logdepthbuf_fragment>
	#include <map_fragment>
	#include <color_fragment>
	outgoingLight = diffuseColor.rgb;
	#include <opaque_fragment>
	#include <tonemapping_fragment>
	#include <colorspace_fragment>
	#include <fog_fragment>
	#include <premultiplied_alpha_fragment>
}`,wp=`#include <common>
#include <batching_pars_vertex>
#include <uv_pars_vertex>
#include <envmap_pars_vertex>
#include <color_pars_vertex>
#include <fog_pars_vertex>
#include <morphtarget_pars_vertex>
#include <skinning_pars_vertex>
#include <logdepthbuf_pars_vertex>
#include <clipping_planes_pars_vertex>
void main() {
	#include <uv_vertex>
	#include <color_vertex>
	#include <morphinstance_vertex>
	#include <morphcolor_vertex>
	#include <batching_vertex>
	#if defined ( USE_ENVMAP ) || defined ( USE_SKINNING )
		#include <beginnormal_vertex>
		#include <morphnormal_vertex>
		#include <skinbase_vertex>
		#include <skinnormal_vertex>
		#include <defaultnormal_vertex>
	#endif
	#include <begin_vertex>
	#include <morphtarget_vertex>
	#include <skinning_vertex>
	#include <project_vertex>
	#include <logdepthbuf_vertex>
	#include <clipping_planes_vertex>
	#include <worldpos_vertex>
	#include <envmap_vertex>
	#include <fog_vertex>
}`,Ap=`uniform vec3 diffuse;
uniform float opacity;
#ifndef FLAT_SHADED
	varying vec3 vNormal;
#endif
#include <common>
#include <dithering_pars_fragment>
#include <color_pars_fragment>
#include <uv_pars_fragment>
#include <map_pars_fragment>
#include <alphamap_pars_fragment>
#include <alphatest_pars_fragment>
#include <alphahash_pars_fragment>
#include <aomap_pars_fragment>
#include <lightmap_pars_fragment>
#include <envmap_common_pars_fragment>
#include <envmap_pars_fragment>
#include <fog_pars_fragment>
#include <specularmap_pars_fragment>
#include <logdepthbuf_pars_fragment>
#include <clipping_planes_pars_fragment>
void main() {
	vec4 diffuseColor = vec4( diffuse, opacity );
	#include <clipping_planes_fragment>
	#include <logdepthbuf_fragment>
	#include <map_fragment>
	#include <color_fragment>
	#include <alphamap_fragment>
	#include <alphatest_fragment>
	#include <alphahash_fragment>
	#include <specularmap_fragment>
	ReflectedLight reflectedLight = ReflectedLight( vec3( 0.0 ), vec3( 0.0 ), vec3( 0.0 ), vec3( 0.0 ) );
	#ifdef USE_LIGHTMAP
		vec4 lightMapTexel = texture2D( lightMap, vLightMapUv );
		reflectedLight.indirectDiffuse += lightMapTexel.rgb * lightMapIntensity * RECIPROCAL_PI;
	#else
		reflectedLight.indirectDiffuse += vec3( 1.0 );
	#endif
	#include <aomap_fragment>
	reflectedLight.indirectDiffuse *= diffuseColor.rgb;
	vec3 outgoingLight = reflectedLight.indirectDiffuse;
	#include <envmap_fragment>
	#include <opaque_fragment>
	#include <tonemapping_fragment>
	#include <colorspace_fragment>
	#include <fog_fragment>
	#include <premultiplied_alpha_fragment>
	#include <dithering_fragment>
}`,Cp=`#define LAMBERT
varying vec3 vViewPosition;
#include <common>
#include <batching_pars_vertex>
#include <uv_pars_vertex>
#include <displacementmap_pars_vertex>
#include <envmap_pars_vertex>
#include <color_pars_vertex>
#include <fog_pars_vertex>
#include <normal_pars_vertex>
#include <morphtarget_pars_vertex>
#include <skinning_pars_vertex>
#include <shadowmap_pars_vertex>
#include <logdepthbuf_pars_vertex>
#include <clipping_planes_pars_vertex>
void main() {
	#include <uv_vertex>
	#include <color_vertex>
	#include <morphinstance_vertex>
	#include <morphcolor_vertex>
	#include <batching_vertex>
	#include <beginnormal_vertex>
	#include <morphnormal_vertex>
	#include <skinbase_vertex>
	#include <skinnormal_vertex>
	#include <defaultnormal_vertex>
	#include <normal_vertex>
	#include <begin_vertex>
	#include <morphtarget_vertex>
	#include <skinning_vertex>
	#include <displacementmap_vertex>
	#include <project_vertex>
	#include <logdepthbuf_vertex>
	#include <clipping_planes_vertex>
	vViewPosition = - mvPosition.xyz;
	#include <worldpos_vertex>
	#include <envmap_vertex>
	#include <shadowmap_vertex>
	#include <fog_vertex>
}`,Rp=`#define LAMBERT
uniform vec3 diffuse;
uniform vec3 emissive;
uniform float opacity;
#include <common>
#include <packing>
#include <dithering_pars_fragment>
#include <color_pars_fragment>
#include <uv_pars_fragment>
#include <map_pars_fragment>
#include <alphamap_pars_fragment>
#include <alphatest_pars_fragment>
#include <alphahash_pars_fragment>
#include <aomap_pars_fragment>
#include <lightmap_pars_fragment>
#include <emissivemap_pars_fragment>
#include <envmap_common_pars_fragment>
#include <envmap_pars_fragment>
#include <fog_pars_fragment>
#include <bsdfs>
#include <lights_pars_begin>
#include <normal_pars_fragment>
#include <lights_lambert_pars_fragment>
#include <shadowmap_pars_fragment>
#include <bumpmap_pars_fragment>
#include <normalmap_pars_fragment>
#include <specularmap_pars_fragment>
#include <logdepthbuf_pars_fragment>
#include <clipping_planes_pars_fragment>
void main() {
	vec4 diffuseColor = vec4( diffuse, opacity );
	#include <clipping_planes_fragment>
	ReflectedLight reflectedLight = ReflectedLight( vec3( 0.0 ), vec3( 0.0 ), vec3( 0.0 ), vec3( 0.0 ) );
	vec3 totalEmissiveRadiance = emissive;
	#include <logdepthbuf_fragment>
	#include <map_fragment>
	#include <color_fragment>
	#include <alphamap_fragment>
	#include <alphatest_fragment>
	#include <alphahash_fragment>
	#include <specularmap_fragment>
	#include <normal_fragment_begin>
	#include <normal_fragment_maps>
	#include <emissivemap_fragment>
	#include <lights_lambert_fragment>
	#include <lights_fragment_begin>
	#include <lights_fragment_maps>
	#include <lights_fragment_end>
	#include <aomap_fragment>
	vec3 outgoingLight = reflectedLight.directDiffuse + reflectedLight.indirectDiffuse + totalEmissiveRadiance;
	#include <envmap_fragment>
	#include <opaque_fragment>
	#include <tonemapping_fragment>
	#include <colorspace_fragment>
	#include <fog_fragment>
	#include <premultiplied_alpha_fragment>
	#include <dithering_fragment>
}`,Pp=`#define MATCAP
varying vec3 vViewPosition;
#include <common>
#include <batching_pars_vertex>
#include <uv_pars_vertex>
#include <color_pars_vertex>
#include <displacementmap_pars_vertex>
#include <fog_pars_vertex>
#include <normal_pars_vertex>
#include <morphtarget_pars_vertex>
#include <skinning_pars_vertex>
#include <logdepthbuf_pars_vertex>
#include <clipping_planes_pars_vertex>
void main() {
	#include <uv_vertex>
	#include <color_vertex>
	#include <morphinstance_vertex>
	#include <morphcolor_vertex>
	#include <batching_vertex>
	#include <beginnormal_vertex>
	#include <morphnormal_vertex>
	#include <skinbase_vertex>
	#include <skinnormal_vertex>
	#include <defaultnormal_vertex>
	#include <normal_vertex>
	#include <begin_vertex>
	#include <morphtarget_vertex>
	#include <skinning_vertex>
	#include <displacementmap_vertex>
	#include <project_vertex>
	#include <logdepthbuf_vertex>
	#include <clipping_planes_vertex>
	#include <fog_vertex>
	vViewPosition = - mvPosition.xyz;
}`,Lp=`#define MATCAP
uniform vec3 diffuse;
uniform float opacity;
uniform sampler2D matcap;
varying vec3 vViewPosition;
#include <common>
#include <dithering_pars_fragment>
#include <color_pars_fragment>
#include <uv_pars_fragment>
#include <map_pars_fragment>
#include <alphamap_pars_fragment>
#include <alphatest_pars_fragment>
#include <alphahash_pars_fragment>
#include <fog_pars_fragment>
#include <normal_pars_fragment>
#include <bumpmap_pars_fragment>
#include <normalmap_pars_fragment>
#include <logdepthbuf_pars_fragment>
#include <clipping_planes_pars_fragment>
void main() {
	vec4 diffuseColor = vec4( diffuse, opacity );
	#include <clipping_planes_fragment>
	#include <logdepthbuf_fragment>
	#include <map_fragment>
	#include <color_fragment>
	#include <alphamap_fragment>
	#include <alphatest_fragment>
	#include <alphahash_fragment>
	#include <normal_fragment_begin>
	#include <normal_fragment_maps>
	vec3 viewDir = normalize( vViewPosition );
	vec3 x = normalize( vec3( viewDir.z, 0.0, - viewDir.x ) );
	vec3 y = cross( viewDir, x );
	vec2 uv = vec2( dot( x, normal ), dot( y, normal ) ) * 0.495 + 0.5;
	#ifdef USE_MATCAP
		vec4 matcapColor = texture2D( matcap, uv );
	#else
		vec4 matcapColor = vec4( vec3( mix( 0.2, 0.8, uv.y ) ), 1.0 );
	#endif
	vec3 outgoingLight = diffuseColor.rgb * matcapColor.rgb;
	#include <opaque_fragment>
	#include <tonemapping_fragment>
	#include <colorspace_fragment>
	#include <fog_fragment>
	#include <premultiplied_alpha_fragment>
	#include <dithering_fragment>
}`,Dp=`#define NORMAL
#if defined( FLAT_SHADED ) || defined( USE_BUMPMAP ) || defined( USE_NORMALMAP_TANGENTSPACE )
	varying vec3 vViewPosition;
#endif
#include <common>
#include <batching_pars_vertex>
#include <uv_pars_vertex>
#include <displacementmap_pars_vertex>
#include <normal_pars_vertex>
#include <morphtarget_pars_vertex>
#include <skinning_pars_vertex>
#include <logdepthbuf_pars_vertex>
#include <clipping_planes_pars_vertex>
void main() {
	#include <uv_vertex>
	#include <batching_vertex>
	#include <beginnormal_vertex>
	#include <morphinstance_vertex>
	#include <morphnormal_vertex>
	#include <skinbase_vertex>
	#include <skinnormal_vertex>
	#include <defaultnormal_vertex>
	#include <normal_vertex>
	#include <begin_vertex>
	#include <morphtarget_vertex>
	#include <skinning_vertex>
	#include <displacementmap_vertex>
	#include <project_vertex>
	#include <logdepthbuf_vertex>
	#include <clipping_planes_vertex>
#if defined( FLAT_SHADED ) || defined( USE_BUMPMAP ) || defined( USE_NORMALMAP_TANGENTSPACE )
	vViewPosition = - mvPosition.xyz;
#endif
}`,Ip=`#define NORMAL
uniform float opacity;
#if defined( FLAT_SHADED ) || defined( USE_BUMPMAP ) || defined( USE_NORMALMAP_TANGENTSPACE )
	varying vec3 vViewPosition;
#endif
#include <packing>
#include <uv_pars_fragment>
#include <normal_pars_fragment>
#include <bumpmap_pars_fragment>
#include <normalmap_pars_fragment>
#include <logdepthbuf_pars_fragment>
#include <clipping_planes_pars_fragment>
void main() {
	vec4 diffuseColor = vec4( 0.0, 0.0, 0.0, opacity );
	#include <clipping_planes_fragment>
	#include <logdepthbuf_fragment>
	#include <normal_fragment_begin>
	#include <normal_fragment_maps>
	gl_FragColor = vec4( packNormalToRGB( normal ), diffuseColor.a );
	#ifdef OPAQUE
		gl_FragColor.a = 1.0;
	#endif
}`,Up=`#define PHONG
varying vec3 vViewPosition;
#include <common>
#include <batching_pars_vertex>
#include <uv_pars_vertex>
#include <displacementmap_pars_vertex>
#include <envmap_pars_vertex>
#include <color_pars_vertex>
#include <fog_pars_vertex>
#include <normal_pars_vertex>
#include <morphtarget_pars_vertex>
#include <skinning_pars_vertex>
#include <shadowmap_pars_vertex>
#include <logdepthbuf_pars_vertex>
#include <clipping_planes_pars_vertex>
void main() {
	#include <uv_vertex>
	#include <color_vertex>
	#include <morphcolor_vertex>
	#include <batching_vertex>
	#include <beginnormal_vertex>
	#include <morphinstance_vertex>
	#include <morphnormal_vertex>
	#include <skinbase_vertex>
	#include <skinnormal_vertex>
	#include <defaultnormal_vertex>
	#include <normal_vertex>
	#include <begin_vertex>
	#include <morphtarget_vertex>
	#include <skinning_vertex>
	#include <displacementmap_vertex>
	#include <project_vertex>
	#include <logdepthbuf_vertex>
	#include <clipping_planes_vertex>
	vViewPosition = - mvPosition.xyz;
	#include <worldpos_vertex>
	#include <envmap_vertex>
	#include <shadowmap_vertex>
	#include <fog_vertex>
}`,Np=`#define PHONG
uniform vec3 diffuse;
uniform vec3 emissive;
uniform vec3 specular;
uniform float shininess;
uniform float opacity;
#include <common>
#include <packing>
#include <dithering_pars_fragment>
#include <color_pars_fragment>
#include <uv_pars_fragment>
#include <map_pars_fragment>
#include <alphamap_pars_fragment>
#include <alphatest_pars_fragment>
#include <alphahash_pars_fragment>
#include <aomap_pars_fragment>
#include <lightmap_pars_fragment>
#include <emissivemap_pars_fragment>
#include <envmap_common_pars_fragment>
#include <envmap_pars_fragment>
#include <fog_pars_fragment>
#include <bsdfs>
#include <lights_pars_begin>
#include <normal_pars_fragment>
#include <lights_phong_pars_fragment>
#include <shadowmap_pars_fragment>
#include <bumpmap_pars_fragment>
#include <normalmap_pars_fragment>
#include <specularmap_pars_fragment>
#include <logdepthbuf_pars_fragment>
#include <clipping_planes_pars_fragment>
void main() {
	vec4 diffuseColor = vec4( diffuse, opacity );
	#include <clipping_planes_fragment>
	ReflectedLight reflectedLight = ReflectedLight( vec3( 0.0 ), vec3( 0.0 ), vec3( 0.0 ), vec3( 0.0 ) );
	vec3 totalEmissiveRadiance = emissive;
	#include <logdepthbuf_fragment>
	#include <map_fragment>
	#include <color_fragment>
	#include <alphamap_fragment>
	#include <alphatest_fragment>
	#include <alphahash_fragment>
	#include <specularmap_fragment>
	#include <normal_fragment_begin>
	#include <normal_fragment_maps>
	#include <emissivemap_fragment>
	#include <lights_phong_fragment>
	#include <lights_fragment_begin>
	#include <lights_fragment_maps>
	#include <lights_fragment_end>
	#include <aomap_fragment>
	vec3 outgoingLight = reflectedLight.directDiffuse + reflectedLight.indirectDiffuse + reflectedLight.directSpecular + reflectedLight.indirectSpecular + totalEmissiveRadiance;
	#include <envmap_fragment>
	#include <opaque_fragment>
	#include <tonemapping_fragment>
	#include <colorspace_fragment>
	#include <fog_fragment>
	#include <premultiplied_alpha_fragment>
	#include <dithering_fragment>
}`,kp=`#define STANDARD
varying vec3 vViewPosition;
#ifdef USE_TRANSMISSION
	varying vec3 vWorldPosition;
#endif
#include <common>
#include <batching_pars_vertex>
#include <uv_pars_vertex>
#include <displacementmap_pars_vertex>
#include <color_pars_vertex>
#include <fog_pars_vertex>
#include <normal_pars_vertex>
#include <morphtarget_pars_vertex>
#include <skinning_pars_vertex>
#include <shadowmap_pars_vertex>
#include <logdepthbuf_pars_vertex>
#include <clipping_planes_pars_vertex>
void main() {
	#include <uv_vertex>
	#include <color_vertex>
	#include <morphinstance_vertex>
	#include <morphcolor_vertex>
	#include <batching_vertex>
	#include <beginnormal_vertex>
	#include <morphnormal_vertex>
	#include <skinbase_vertex>
	#include <skinnormal_vertex>
	#include <defaultnormal_vertex>
	#include <normal_vertex>
	#include <begin_vertex>
	#include <morphtarget_vertex>
	#include <skinning_vertex>
	#include <displacementmap_vertex>
	#include <project_vertex>
	#include <logdepthbuf_vertex>
	#include <clipping_planes_vertex>
	vViewPosition = - mvPosition.xyz;
	#include <worldpos_vertex>
	#include <shadowmap_vertex>
	#include <fog_vertex>
#ifdef USE_TRANSMISSION
	vWorldPosition = worldPosition.xyz;
#endif
}`,Fp=`#define STANDARD
#ifdef PHYSICAL
	#define IOR
	#define USE_SPECULAR
#endif
uniform vec3 diffuse;
uniform vec3 emissive;
uniform float roughness;
uniform float metalness;
uniform float opacity;
#ifdef IOR
	uniform float ior;
#endif
#ifdef USE_SPECULAR
	uniform float specularIntensity;
	uniform vec3 specularColor;
	#ifdef USE_SPECULAR_COLORMAP
		uniform sampler2D specularColorMap;
	#endif
	#ifdef USE_SPECULAR_INTENSITYMAP
		uniform sampler2D specularIntensityMap;
	#endif
#endif
#ifdef USE_CLEARCOAT
	uniform float clearcoat;
	uniform float clearcoatRoughness;
#endif
#ifdef USE_DISPERSION
	uniform float dispersion;
#endif
#ifdef USE_IRIDESCENCE
	uniform float iridescence;
	uniform float iridescenceIOR;
	uniform float iridescenceThicknessMinimum;
	uniform float iridescenceThicknessMaximum;
#endif
#ifdef USE_SHEEN
	uniform vec3 sheenColor;
	uniform float sheenRoughness;
	#ifdef USE_SHEEN_COLORMAP
		uniform sampler2D sheenColorMap;
	#endif
	#ifdef USE_SHEEN_ROUGHNESSMAP
		uniform sampler2D sheenRoughnessMap;
	#endif
#endif
#ifdef USE_ANISOTROPY
	uniform vec2 anisotropyVector;
	#ifdef USE_ANISOTROPYMAP
		uniform sampler2D anisotropyMap;
	#endif
#endif
varying vec3 vViewPosition;
#include <common>
#include <packing>
#include <dithering_pars_fragment>
#include <color_pars_fragment>
#include <uv_pars_fragment>
#include <map_pars_fragment>
#include <alphamap_pars_fragment>
#include <alphatest_pars_fragment>
#include <alphahash_pars_fragment>
#include <aomap_pars_fragment>
#include <lightmap_pars_fragment>
#include <emissivemap_pars_fragment>
#include <iridescence_fragment>
#include <cube_uv_reflection_fragment>
#include <envmap_common_pars_fragment>
#include <envmap_physical_pars_fragment>
#include <fog_pars_fragment>
#include <lights_pars_begin>
#include <normal_pars_fragment>
#include <lights_physical_pars_fragment>
#include <transmission_pars_fragment>
#include <shadowmap_pars_fragment>
#include <bumpmap_pars_fragment>
#include <normalmap_pars_fragment>
#include <clearcoat_pars_fragment>
#include <iridescence_pars_fragment>
#include <roughnessmap_pars_fragment>
#include <metalnessmap_pars_fragment>
#include <logdepthbuf_pars_fragment>
#include <clipping_planes_pars_fragment>
void main() {
	vec4 diffuseColor = vec4( diffuse, opacity );
	#include <clipping_planes_fragment>
	ReflectedLight reflectedLight = ReflectedLight( vec3( 0.0 ), vec3( 0.0 ), vec3( 0.0 ), vec3( 0.0 ) );
	vec3 totalEmissiveRadiance = emissive;
	#include <logdepthbuf_fragment>
	#include <map_fragment>
	#include <color_fragment>
	#include <alphamap_fragment>
	#include <alphatest_fragment>
	#include <alphahash_fragment>
	#include <roughnessmap_fragment>
	#include <metalnessmap_fragment>
	#include <normal_fragment_begin>
	#include <normal_fragment_maps>
	#include <clearcoat_normal_fragment_begin>
	#include <clearcoat_normal_fragment_maps>
	#include <emissivemap_fragment>
	#include <lights_physical_fragment>
	#include <lights_fragment_begin>
	#include <lights_fragment_maps>
	#include <lights_fragment_end>
	#include <aomap_fragment>
	vec3 totalDiffuse = reflectedLight.directDiffuse + reflectedLight.indirectDiffuse;
	vec3 totalSpecular = reflectedLight.directSpecular + reflectedLight.indirectSpecular;
	#include <transmission_fragment>
	vec3 outgoingLight = totalDiffuse + totalSpecular + totalEmissiveRadiance;
	#ifdef USE_SHEEN
		float sheenEnergyComp = 1.0 - 0.157 * max3( material.sheenColor );
		outgoingLight = outgoingLight * sheenEnergyComp + sheenSpecularDirect + sheenSpecularIndirect;
	#endif
	#ifdef USE_CLEARCOAT
		float dotNVcc = saturate( dot( geometryClearcoatNormal, geometryViewDir ) );
		vec3 Fcc = F_Schlick( material.clearcoatF0, material.clearcoatF90, dotNVcc );
		outgoingLight = outgoingLight * ( 1.0 - material.clearcoat * Fcc ) + ( clearcoatSpecularDirect + clearcoatSpecularIndirect ) * material.clearcoat;
	#endif
	#include <opaque_fragment>
	#include <tonemapping_fragment>
	#include <colorspace_fragment>
	#include <fog_fragment>
	#include <premultiplied_alpha_fragment>
	#include <dithering_fragment>
}`,Op=`#define TOON
varying vec3 vViewPosition;
#include <common>
#include <batching_pars_vertex>
#include <uv_pars_vertex>
#include <displacementmap_pars_vertex>
#include <color_pars_vertex>
#include <fog_pars_vertex>
#include <normal_pars_vertex>
#include <morphtarget_pars_vertex>
#include <skinning_pars_vertex>
#include <shadowmap_pars_vertex>
#include <logdepthbuf_pars_vertex>
#include <clipping_planes_pars_vertex>
void main() {
	#include <uv_vertex>
	#include <color_vertex>
	#include <morphinstance_vertex>
	#include <morphcolor_vertex>
	#include <batching_vertex>
	#include <beginnormal_vertex>
	#include <morphnormal_vertex>
	#include <skinbase_vertex>
	#include <skinnormal_vertex>
	#include <defaultnormal_vertex>
	#include <normal_vertex>
	#include <begin_vertex>
	#include <morphtarget_vertex>
	#include <skinning_vertex>
	#include <displacementmap_vertex>
	#include <project_vertex>
	#include <logdepthbuf_vertex>
	#include <clipping_planes_vertex>
	vViewPosition = - mvPosition.xyz;
	#include <worldpos_vertex>
	#include <shadowmap_vertex>
	#include <fog_vertex>
}`,Bp=`#define TOON
uniform vec3 diffuse;
uniform vec3 emissive;
uniform float opacity;
#include <common>
#include <packing>
#include <dithering_pars_fragment>
#include <color_pars_fragment>
#include <uv_pars_fragment>
#include <map_pars_fragment>
#include <alphamap_pars_fragment>
#include <alphatest_pars_fragment>
#include <alphahash_pars_fragment>
#include <aomap_pars_fragment>
#include <lightmap_pars_fragment>
#include <emissivemap_pars_fragment>
#include <gradientmap_pars_fragment>
#include <fog_pars_fragment>
#include <bsdfs>
#include <lights_pars_begin>
#include <normal_pars_fragment>
#include <lights_toon_pars_fragment>
#include <shadowmap_pars_fragment>
#include <bumpmap_pars_fragment>
#include <normalmap_pars_fragment>
#include <logdepthbuf_pars_fragment>
#include <clipping_planes_pars_fragment>
void main() {
	vec4 diffuseColor = vec4( diffuse, opacity );
	#include <clipping_planes_fragment>
	ReflectedLight reflectedLight = ReflectedLight( vec3( 0.0 ), vec3( 0.0 ), vec3( 0.0 ), vec3( 0.0 ) );
	vec3 totalEmissiveRadiance = emissive;
	#include <logdepthbuf_fragment>
	#include <map_fragment>
	#include <color_fragment>
	#include <alphamap_fragment>
	#include <alphatest_fragment>
	#include <alphahash_fragment>
	#include <normal_fragment_begin>
	#include <normal_fragment_maps>
	#include <emissivemap_fragment>
	#include <lights_toon_fragment>
	#include <lights_fragment_begin>
	#include <lights_fragment_maps>
	#include <lights_fragment_end>
	#include <aomap_fragment>
	vec3 outgoingLight = reflectedLight.directDiffuse + reflectedLight.indirectDiffuse + totalEmissiveRadiance;
	#include <opaque_fragment>
	#include <tonemapping_fragment>
	#include <colorspace_fragment>
	#include <fog_fragment>
	#include <premultiplied_alpha_fragment>
	#include <dithering_fragment>
}`,zp=`uniform float size;
uniform float scale;
#include <common>
#include <color_pars_vertex>
#include <fog_pars_vertex>
#include <morphtarget_pars_vertex>
#include <logdepthbuf_pars_vertex>
#include <clipping_planes_pars_vertex>
#ifdef USE_POINTS_UV
	varying vec2 vUv;
	uniform mat3 uvTransform;
#endif
void main() {
	#ifdef USE_POINTS_UV
		vUv = ( uvTransform * vec3( uv, 1 ) ).xy;
	#endif
	#include <color_vertex>
	#include <morphinstance_vertex>
	#include <morphcolor_vertex>
	#include <begin_vertex>
	#include <morphtarget_vertex>
	#include <project_vertex>
	gl_PointSize = size;
	#ifdef USE_SIZEATTENUATION
		bool isPerspective = isPerspectiveMatrix( projectionMatrix );
		if ( isPerspective ) gl_PointSize *= ( scale / - mvPosition.z );
	#endif
	#include <logdepthbuf_vertex>
	#include <clipping_planes_vertex>
	#include <worldpos_vertex>
	#include <fog_vertex>
}`,Hp=`uniform vec3 diffuse;
uniform float opacity;
#include <common>
#include <color_pars_fragment>
#include <map_particle_pars_fragment>
#include <alphatest_pars_fragment>
#include <alphahash_pars_fragment>
#include <fog_pars_fragment>
#include <logdepthbuf_pars_fragment>
#include <clipping_planes_pars_fragment>
void main() {
	vec4 diffuseColor = vec4( diffuse, opacity );
	#include <clipping_planes_fragment>
	vec3 outgoingLight = vec3( 0.0 );
	#include <logdepthbuf_fragment>
	#include <map_particle_fragment>
	#include <color_fragment>
	#include <alphatest_fragment>
	#include <alphahash_fragment>
	outgoingLight = diffuseColor.rgb;
	#include <opaque_fragment>
	#include <tonemapping_fragment>
	#include <colorspace_fragment>
	#include <fog_fragment>
	#include <premultiplied_alpha_fragment>
}`,Vp=`#include <common>
#include <batching_pars_vertex>
#include <fog_pars_vertex>
#include <morphtarget_pars_vertex>
#include <skinning_pars_vertex>
#include <logdepthbuf_pars_vertex>
#include <shadowmap_pars_vertex>
void main() {
	#include <batching_vertex>
	#include <beginnormal_vertex>
	#include <morphinstance_vertex>
	#include <morphnormal_vertex>
	#include <skinbase_vertex>
	#include <skinnormal_vertex>
	#include <defaultnormal_vertex>
	#include <begin_vertex>
	#include <morphtarget_vertex>
	#include <skinning_vertex>
	#include <project_vertex>
	#include <logdepthbuf_vertex>
	#include <worldpos_vertex>
	#include <shadowmap_vertex>
	#include <fog_vertex>
}`,Gp=`uniform vec3 color;
uniform float opacity;
#include <common>
#include <packing>
#include <fog_pars_fragment>
#include <bsdfs>
#include <lights_pars_begin>
#include <logdepthbuf_pars_fragment>
#include <shadowmap_pars_fragment>
#include <shadowmask_pars_fragment>
void main() {
	#include <logdepthbuf_fragment>
	gl_FragColor = vec4( color, opacity * ( 1.0 - getShadowMask() ) );
	#include <tonemapping_fragment>
	#include <colorspace_fragment>
	#include <fog_fragment>
}`,Wp=`uniform float rotation;
uniform vec2 center;
#include <common>
#include <uv_pars_vertex>
#include <fog_pars_vertex>
#include <logdepthbuf_pars_vertex>
#include <clipping_planes_pars_vertex>
void main() {
	#include <uv_vertex>
	vec4 mvPosition = modelViewMatrix[ 3 ];
	vec2 scale = vec2( length( modelMatrix[ 0 ].xyz ), length( modelMatrix[ 1 ].xyz ) );
	#ifndef USE_SIZEATTENUATION
		bool isPerspective = isPerspectiveMatrix( projectionMatrix );
		if ( isPerspective ) scale *= - mvPosition.z;
	#endif
	vec2 alignedPosition = ( position.xy - ( center - vec2( 0.5 ) ) ) * scale;
	vec2 rotatedPosition;
	rotatedPosition.x = cos( rotation ) * alignedPosition.x - sin( rotation ) * alignedPosition.y;
	rotatedPosition.y = sin( rotation ) * alignedPosition.x + cos( rotation ) * alignedPosition.y;
	mvPosition.xy += rotatedPosition;
	gl_Position = projectionMatrix * mvPosition;
	#include <logdepthbuf_vertex>
	#include <clipping_planes_vertex>
	#include <fog_vertex>
}`,Xp=`uniform vec3 diffuse;
uniform float opacity;
#include <common>
#include <uv_pars_fragment>
#include <map_pars_fragment>
#include <alphamap_pars_fragment>
#include <alphatest_pars_fragment>
#include <alphahash_pars_fragment>
#include <fog_pars_fragment>
#include <logdepthbuf_pars_fragment>
#include <clipping_planes_pars_fragment>
void main() {
	vec4 diffuseColor = vec4( diffuse, opacity );
	#include <clipping_planes_fragment>
	vec3 outgoingLight = vec3( 0.0 );
	#include <logdepthbuf_fragment>
	#include <map_fragment>
	#include <alphamap_fragment>
	#include <alphatest_fragment>
	#include <alphahash_fragment>
	outgoingLight = diffuseColor.rgb;
	#include <opaque_fragment>
	#include <tonemapping_fragment>
	#include <colorspace_fragment>
	#include <fog_fragment>
}`,Ht={alphahash_fragment:dd,alphahash_pars_fragment:fd,alphamap_fragment:pd,alphamap_pars_fragment:md,alphatest_fragment:gd,alphatest_pars_fragment:_d,aomap_fragment:vd,aomap_pars_fragment:xd,batching_pars_vertex:yd,batching_vertex:Md,begin_vertex:Sd,beginnormal_vertex:bd,bsdfs:Ed,iridescence_fragment:Td,bumpmap_pars_fragment:wd,clipping_planes_fragment:Ad,clipping_planes_pars_fragment:Cd,clipping_planes_pars_vertex:Rd,clipping_planes_vertex:Pd,color_fragment:Ld,color_pars_fragment:Dd,color_pars_vertex:Id,color_vertex:Ud,common:Nd,cube_uv_reflection_fragment:kd,defaultnormal_vertex:Fd,displacementmap_pars_vertex:Od,displacementmap_vertex:Bd,emissivemap_fragment:zd,emissivemap_pars_fragment:Hd,colorspace_fragment:Vd,colorspace_pars_fragment:Gd,envmap_fragment:Wd,envmap_common_pars_fragment:Xd,envmap_pars_fragment:$d,envmap_pars_vertex:qd,envmap_physical_pars_fragment:rf,envmap_vertex:Yd,fog_vertex:Kd,fog_pars_vertex:Zd,fog_fragment:jd,fog_pars_fragment:Jd,gradientmap_pars_fragment:Qd,lightmap_pars_fragment:tf,lights_lambert_fragment:ef,lights_lambert_pars_fragment:nf,lights_pars_begin:sf,lights_toon_fragment:of,lights_toon_pars_fragment:af,lights_phong_fragment:cf,lights_phong_pars_fragment:lf,lights_physical_fragment:hf,lights_physical_pars_fragment:uf,lights_fragment_begin:df,lights_fragment_maps:ff,lights_fragment_end:pf,logdepthbuf_fragment:mf,logdepthbuf_pars_fragment:gf,logdepthbuf_pars_vertex:_f,logdepthbuf_vertex:vf,map_fragment:xf,map_pars_fragment:yf,map_particle_fragment:Mf,map_particle_pars_fragment:Sf,metalnessmap_fragment:bf,metalnessmap_pars_fragment:Ef,morphinstance_vertex:Tf,morphcolor_vertex:wf,morphnormal_vertex:Af,morphtarget_pars_vertex:Cf,morphtarget_vertex:Rf,normal_fragment_begin:Pf,normal_fragment_maps:Lf,normal_pars_fragment:Df,normal_pars_vertex:If,normal_vertex:Uf,normalmap_pars_fragment:Nf,clearcoat_normal_fragment_begin:kf,clearcoat_normal_fragment_maps:Ff,clearcoat_pars_fragment:Of,iridescence_pars_fragment:Bf,opaque_fragment:zf,packing:Hf,premultiplied_alpha_fragment:Vf,project_vertex:Gf,dithering_fragment:Wf,dithering_pars_fragment:Xf,roughnessmap_fragment:$f,roughnessmap_pars_fragment:qf,shadowmap_pars_fragment:Yf,shadowmap_pars_vertex:Kf,shadowmap_vertex:Zf,shadowmask_pars_fragment:jf,skinbase_vertex:Jf,skinning_pars_vertex:Qf,skinning_vertex:tp,skinnormal_vertex:ep,specularmap_fragment:np,specularmap_pars_fragment:ip,tonemapping_fragment:sp,tonemapping_pars_fragment:rp,transmission_fragment:op,transmission_pars_fragment:ap,uv_pars_fragment:cp,uv_pars_vertex:lp,uv_vertex:hp,worldpos_vertex:up,background_vert:dp,background_frag:fp,backgroundCube_vert:pp,backgroundCube_frag:mp,cube_vert:gp,cube_frag:_p,depth_vert:vp,depth_frag:xp,distanceRGBA_vert:yp,distanceRGBA_frag:Mp,equirect_vert:Sp,equirect_frag:bp,linedashed_vert:Ep,linedashed_frag:Tp,meshbasic_vert:wp,meshbasic_frag:Ap,meshlambert_vert:Cp,meshlambert_frag:Rp,meshmatcap_vert:Pp,meshmatcap_frag:Lp,meshnormal_vert:Dp,meshnormal_frag:Ip,meshphong_vert:Up,meshphong_frag:Np,meshphysical_vert:kp,meshphysical_frag:Fp,meshtoon_vert:Op,meshtoon_frag:Bp,points_vert:zp,points_frag:Hp,shadow_vert:Vp,shadow_frag:Gp,sprite_vert:Wp,sprite_frag:Xp},ct={common:{diffuse:{value:new Xt(16777215)},opacity:{value:1},map:{value:null},mapTransform:{value:new Vt},alphaMap:{value:null},alphaMapTransform:{value:new Vt},alphaTest:{value:0}},specularmap:{specularMap:{value:null},specularMapTransform:{value:new Vt}},envmap:{envMap:{value:null},envMapRotation:{value:new Vt},flipEnvMap:{value:-1},reflectivity:{value:1},ior:{value:1.5},refractionRatio:{value:.98}},aomap:{aoMap:{value:null},aoMapIntensity:{value:1},aoMapTransform:{value:new Vt}},lightmap:{lightMap:{value:null},lightMapIntensity:{value:1},lightMapTransform:{value:new Vt}},bumpmap:{bumpMap:{value:null},bumpMapTransform:{value:new Vt},bumpScale:{value:1}},normalmap:{normalMap:{value:null},normalMapTransform:{value:new Vt},normalScale:{value:new nt(1,1)}},displacementmap:{displacementMap:{value:null},displacementMapTransform:{value:new Vt},displacementScale:{value:1},displacementBias:{value:0}},emissivemap:{emissiveMap:{value:null},emissiveMapTransform:{value:new Vt}},metalnessmap:{metalnessMap:{value:null},metalnessMapTransform:{value:new Vt}},roughnessmap:{roughnessMap:{value:null},roughnessMapTransform:{value:new Vt}},gradientmap:{gradientMap:{value:null}},fog:{fogDensity:{value:25e-5},fogNear:{value:1},fogFar:{value:2e3},fogColor:{value:new Xt(16777215)}},lights:{ambientLightColor:{value:[]},lightProbe:{value:[]},directionalLights:{value:[],properties:{direction:{},color:{}}},directionalLightShadows:{value:[],properties:{shadowIntensity:1,shadowBias:{},shadowNormalBias:{},shadowRadius:{},shadowMapSize:{}}},directionalShadowMap:{value:[]},directionalShadowMatrix:{value:[]},spotLights:{value:[],properties:{color:{},position:{},direction:{},distance:{},coneCos:{},penumbraCos:{},decay:{}}},spotLightShadows:{value:[],properties:{shadowIntensity:1,shadowBias:{},shadowNormalBias:{},shadowRadius:{},shadowMapSize:{}}},spotLightMap:{value:[]},spotShadowMap:{value:[]},spotLightMatrix:{value:[]},pointLights:{value:[],properties:{color:{},position:{},decay:{},distance:{}}},pointLightShadows:{value:[],properties:{shadowIntensity:1,shadowBias:{},shadowNormalBias:{},shadowRadius:{},shadowMapSize:{},shadowCameraNear:{},shadowCameraFar:{}}},pointShadowMap:{value:[]},pointShadowMatrix:{value:[]},hemisphereLights:{value:[],properties:{direction:{},skyColor:{},groundColor:{}}},rectAreaLights:{value:[],properties:{color:{},position:{},width:{},height:{}}},ltc_1:{value:null},ltc_2:{value:null}},points:{diffuse:{value:new Xt(16777215)},opacity:{value:1},size:{value:1},scale:{value:1},map:{value:null},alphaMap:{value:null},alphaMapTransform:{value:new Vt},alphaTest:{value:0},uvTransform:{value:new Vt}},sprite:{diffuse:{value:new Xt(16777215)},opacity:{value:1},center:{value:new nt(.5,.5)},rotation:{value:0},map:{value:null},mapTransform:{value:new Vt},alphaMap:{value:null},alphaMapTransform:{value:new Vt},alphaTest:{value:0}}},ln={basic:{uniforms:Ce([ct.common,ct.specularmap,ct.envmap,ct.aomap,ct.lightmap,ct.fog]),vertexShader:Ht.meshbasic_vert,fragmentShader:Ht.meshbasic_frag},lambert:{uniforms:Ce([ct.common,ct.specularmap,ct.envmap,ct.aomap,ct.lightmap,ct.emissivemap,ct.bumpmap,ct.normalmap,ct.displacementmap,ct.fog,ct.lights,{emissive:{value:new Xt(0)}}]),vertexShader:Ht.meshlambert_vert,fragmentShader:Ht.meshlambert_frag},phong:{uniforms:Ce([ct.common,ct.specularmap,ct.envmap,ct.aomap,ct.lightmap,ct.emissivemap,ct.bumpmap,ct.normalmap,ct.displacementmap,ct.fog,ct.lights,{emissive:{value:new Xt(0)},specular:{value:new Xt(1118481)},shininess:{value:30}}]),vertexShader:Ht.meshphong_vert,fragmentShader:Ht.meshphong_frag},standard:{uniforms:Ce([ct.common,ct.envmap,ct.aomap,ct.lightmap,ct.emissivemap,ct.bumpmap,ct.normalmap,ct.displacementmap,ct.roughnessmap,ct.metalnessmap,ct.fog,ct.lights,{emissive:{value:new Xt(0)},roughness:{value:1},metalness:{value:0},envMapIntensity:{value:1}}]),vertexShader:Ht.meshphysical_vert,fragmentShader:Ht.meshphysical_frag},toon:{uniforms:Ce([ct.common,ct.aomap,ct.lightmap,ct.emissivemap,ct.bumpmap,ct.normalmap,ct.displacementmap,ct.gradientmap,ct.fog,ct.lights,{emissive:{value:new Xt(0)}}]),vertexShader:Ht.meshtoon_vert,fragmentShader:Ht.meshtoon_frag},matcap:{uniforms:Ce([ct.common,ct.bumpmap,ct.normalmap,ct.displacementmap,ct.fog,{matcap:{value:null}}]),vertexShader:Ht.meshmatcap_vert,fragmentShader:Ht.meshmatcap_frag},points:{uniforms:Ce([ct.points,ct.fog]),vertexShader:Ht.points_vert,fragmentShader:Ht.points_frag},dashed:{uniforms:Ce([ct.common,ct.fog,{scale:{value:1},dashSize:{value:1},totalSize:{value:2}}]),vertexShader:Ht.linedashed_vert,fragmentShader:Ht.linedashed_frag},depth:{uniforms:Ce([ct.common,ct.displacementmap]),vertexShader:Ht.depth_vert,fragmentShader:Ht.depth_frag},normal:{uniforms:Ce([ct.common,ct.bumpmap,ct.normalmap,ct.displacementmap,{opacity:{value:1}}]),vertexShader:Ht.meshnormal_vert,fragmentShader:Ht.meshnormal_frag},sprite:{uniforms:Ce([ct.sprite,ct.fog]),vertexShader:Ht.sprite_vert,fragmentShader:Ht.sprite_frag},background:{uniforms:{uvTransform:{value:new Vt},t2D:{value:null},backgroundIntensity:{value:1}},vertexShader:Ht.background_vert,fragmentShader:Ht.background_frag},backgroundCube:{uniforms:{envMap:{value:null},flipEnvMap:{value:-1},backgroundBlurriness:{value:0},backgroundIntensity:{value:1},backgroundRotation:{value:new Vt}},vertexShader:Ht.backgroundCube_vert,fragmentShader:Ht.backgroundCube_frag},cube:{uniforms:{tCube:{value:null},tFlip:{value:-1},opacity:{value:1}},vertexShader:Ht.cube_vert,fragmentShader:Ht.cube_frag},equirect:{uniforms:{tEquirect:{value:null}},vertexShader:Ht.equirect_vert,fragmentShader:Ht.equirect_frag},distanceRGBA:{uniforms:Ce([ct.common,ct.displacementmap,{referencePosition:{value:new C},nearDistance:{value:1},farDistance:{value:1e3}}]),vertexShader:Ht.distanceRGBA_vert,fragmentShader:Ht.distanceRGBA_frag},shadow:{uniforms:Ce([ct.lights,ct.fog,{color:{value:new Xt(0)},opacity:{value:1}}]),vertexShader:Ht.shadow_vert,fragmentShader:Ht.shadow_frag}};ln.physical={uniforms:Ce([ln.standard.uniforms,{clearcoat:{value:0},clearcoatMap:{value:null},clearcoatMapTransform:{value:new Vt},clearcoatNormalMap:{value:null},clearcoatNormalMapTransform:{value:new Vt},clearcoatNormalScale:{value:new nt(1,1)},clearcoatRoughness:{value:0},clearcoatRoughnessMap:{value:null},clearcoatRoughnessMapTransform:{value:new Vt},dispersion:{value:0},iridescence:{value:0},iridescenceMap:{value:null},iridescenceMapTransform:{value:new Vt},iridescenceIOR:{value:1.3},iridescenceThicknessMinimum:{value:100},iridescenceThicknessMaximum:{value:400},iridescenceThicknessMap:{value:null},iridescenceThicknessMapTransform:{value:new Vt},sheen:{value:0},sheenColor:{value:new Xt(0)},sheenColorMap:{value:null},sheenColorMapTransform:{value:new Vt},sheenRoughness:{value:1},sheenRoughnessMap:{value:null},sheenRoughnessMapTransform:{value:new Vt},transmission:{value:0},transmissionMap:{value:null},transmissionMapTransform:{value:new Vt},transmissionSamplerSize:{value:new nt},transmissionSamplerMap:{value:null},thickness:{value:0},thicknessMap:{value:null},thicknessMapTransform:{value:new Vt},attenuationDistance:{value:0},attenuationColor:{value:new Xt(0)},specularColor:{value:new Xt(1,1,1)},specularColorMap:{value:null},specularColorMapTransform:{value:new Vt},specularIntensity:{value:1},specularIntensityMap:{value:null},specularIntensityMapTransform:{value:new Vt},anisotropyVector:{value:new nt},anisotropyMap:{value:null},anisotropyMapTransform:{value:new Vt}}]),vertexShader:Ht.meshphysical_vert,fragmentShader:Ht.meshphysical_frag};const Ws={r:0,b:0,g:0},jn=new on,$p=new re;function qp(i,t,e,n,s,r,o){const a=new Xt(0);let c=r===!0?0:1,l,h,d=null,u=0,f=null;function g(w){let x=w.isScene===!0?w.background:null;return x&&x.isTexture&&(x=(w.backgroundBlurriness>0?e:t).get(x)),x}function _(w){let x=!1;const b=g(w);b===null?m(a,c):b&&b.isColor&&(m(b,1),x=!0);const I=i.xr.getEnvironmentBlendMode();I==="additive"?n.buffers.color.setClear(0,0,0,1,o):I==="alpha-blend"&&n.buffers.color.setClear(0,0,0,0,o),(i.autoClear||x)&&(n.buffers.depth.setTest(!0),n.buffers.depth.setMask(!0),n.buffers.color.setMask(!0),i.clear(i.autoClearColor,i.autoClearDepth,i.autoClearStencil))}function p(w,x){const b=g(x);b&&(b.isCubeTexture||b.mapping===yr)?(h===void 0&&(h=new ae(new zn(1,1,1),new Hn({name:"BackgroundCubeMaterial",uniforms:$i(ln.backgroundCube.uniforms),vertexShader:ln.backgroundCube.vertexShader,fragmentShader:ln.backgroundCube.fragmentShader,side:Re,depthTest:!1,depthWrite:!1,fog:!1})),h.geometry.deleteAttribute("normal"),h.geometry.deleteAttribute("uv"),h.onBeforeRender=function(I,R,A){this.matrixWorld.copyPosition(A.matrixWorld)},Object.defineProperty(h.material,"envMap",{get:function(){return this.uniforms.envMap.value}}),s.update(h)),jn.copy(x.backgroundRotation),jn.x*=-1,jn.y*=-1,jn.z*=-1,b.isCubeTexture&&b.isRenderTargetTexture===!1&&(jn.y*=-1,jn.z*=-1),h.material.uniforms.envMap.value=b,h.material.uniforms.flipEnvMap.value=b.isCubeTexture&&b.isRenderTargetTexture===!1?-1:1,h.material.uniforms.backgroundBlurriness.value=x.backgroundBlurriness,h.material.uniforms.backgroundIntensity.value=x.backgroundIntensity,h.material.uniforms.backgroundRotation.value.setFromMatrix4($p.makeRotationFromEuler(jn)),h.material.toneMapped=ee.getTransfer(b.colorSpace)!==le,(d!==b||u!==b.version||f!==i.toneMapping)&&(h.material.needsUpdate=!0,d=b,u=b.version,f=i.toneMapping),h.layers.enableAll(),w.unshift(h,h.geometry,h.material,0,0,null)):b&&b.isTexture&&(l===void 0&&(l=new ae(new bs(2,2),new Hn({name:"BackgroundMaterial",uniforms:$i(ln.background.uniforms),vertexShader:ln.background.vertexShader,fragmentShader:ln.background.fragmentShader,side:Bn,depthTest:!1,depthWrite:!1,fog:!1})),l.geometry.deleteAttribute("normal"),Object.defineProperty(l.material,"map",{get:function(){return this.uniforms.t2D.value}}),s.update(l)),l.material.uniforms.t2D.value=b,l.material.uniforms.backgroundIntensity.value=x.backgroundIntensity,l.material.toneMapped=ee.getTransfer(b.colorSpace)!==le,b.matrixAutoUpdate===!0&&b.updateMatrix(),l.material.uniforms.uvTransform.value.copy(b.matrix),(d!==b||u!==b.version||f!==i.toneMapping)&&(l.material.needsUpdate=!0,d=b,u=b.version,f=i.toneMapping),l.layers.enableAll(),w.unshift(l,l.geometry,l.material,0,0,null))}function m(w,x){w.getRGB(Ws,ql(i)),n.buffers.color.setClear(Ws.r,Ws.g,Ws.b,x,o)}return{getClearColor:function(){return a},setClearColor:function(w,x=1){a.set(w),c=x,m(a,c)},getClearAlpha:function(){return c},setClearAlpha:function(w){c=w,m(a,c)},render:_,addToRenderList:p}}function Yp(i,t){const e=i.getParameter(i.MAX_VERTEX_ATTRIBS),n={},s=u(null);let r=s,o=!1;function a(v,S,F,N,H){let X=!1;const z=d(N,F,S);r!==z&&(r=z,l(r.object)),X=f(v,N,F,H),X&&g(v,N,F,H),H!==null&&t.update(H,i.ELEMENT_ARRAY_BUFFER),(X||o)&&(o=!1,b(v,S,F,N),H!==null&&i.bindBuffer(i.ELEMENT_ARRAY_BUFFER,t.get(H).buffer))}function c(){return i.createVertexArray()}function l(v){return i.bindVertexArray(v)}function h(v){return i.deleteVertexArray(v)}function d(v,S,F){const N=F.wireframe===!0;let H=n[v.id];H===void 0&&(H={},n[v.id]=H);let X=H[S.id];X===void 0&&(X={},H[S.id]=X);let z=X[N];return z===void 0&&(z=u(c()),X[N]=z),z}function u(v){const S=[],F=[],N=[];for(let H=0;H<e;H++)S[H]=0,F[H]=0,N[H]=0;return{geometry:null,program:null,wireframe:!1,newAttributes:S,enabledAttributes:F,attributeDivisors:N,object:v,attributes:{},index:null}}function f(v,S,F,N){const H=r.attributes,X=S.attributes;let z=0;const J=F.getAttributes();for(const G in J)if(J[G].location>=0){const ft=H[G];let pt=X[G];if(pt===void 0&&(G==="instanceMatrix"&&v.instanceMatrix&&(pt=v.instanceMatrix),G==="instanceColor"&&v.instanceColor&&(pt=v.instanceColor)),ft===void 0||ft.attribute!==pt||pt&&ft.data!==pt.data)return!0;z++}return r.attributesNum!==z||r.index!==N}function g(v,S,F,N){const H={},X=S.attributes;let z=0;const J=F.getAttributes();for(const G in J)if(J[G].location>=0){let ft=X[G];ft===void 0&&(G==="instanceMatrix"&&v.instanceMatrix&&(ft=v.instanceMatrix),G==="instanceColor"&&v.instanceColor&&(ft=v.instanceColor));const pt={};pt.attribute=ft,ft&&ft.data&&(pt.data=ft.data),H[G]=pt,z++}r.attributes=H,r.attributesNum=z,r.index=N}function _(){const v=r.newAttributes;for(let S=0,F=v.length;S<F;S++)v[S]=0}function p(v){m(v,0)}function m(v,S){const F=r.newAttributes,N=r.enabledAttributes,H=r.attributeDivisors;F[v]=1,N[v]===0&&(i.enableVertexAttribArray(v),N[v]=1),H[v]!==S&&(i.vertexAttribDivisor(v,S),H[v]=S)}function w(){const v=r.newAttributes,S=r.enabledAttributes;for(let F=0,N=S.length;F<N;F++)S[F]!==v[F]&&(i.disableVertexAttribArray(F),S[F]=0)}function x(v,S,F,N,H,X,z){z===!0?i.vertexAttribIPointer(v,S,F,H,X):i.vertexAttribPointer(v,S,F,N,H,X)}function b(v,S,F,N){_();const H=N.attributes,X=F.getAttributes(),z=S.defaultAttributeValues;for(const J in X){const G=X[J];if(G.location>=0){let ht=H[J];if(ht===void 0&&(J==="instanceMatrix"&&v.instanceMatrix&&(ht=v.instanceMatrix),J==="instanceColor"&&v.instanceColor&&(ht=v.instanceColor)),ht!==void 0){const ft=ht.normalized,pt=ht.itemSize,$t=t.get(ht);if($t===void 0)continue;const jt=$t.buffer,$=$t.type,tt=$t.bytesPerElement,yt=$===i.INT||$===i.UNSIGNED_INT||ht.gpuType===ya;if(ht.isInterleavedBufferAttribute){const lt=ht.data,It=lt.stride,Dt=ht.offset;if(lt.isInstancedInterleavedBuffer){for(let Ot=0;Ot<G.locationSize;Ot++)m(G.location+Ot,lt.meshPerAttribute);v.isInstancedMesh!==!0&&N._maxInstanceCount===void 0&&(N._maxInstanceCount=lt.meshPerAttribute*lt.count)}else for(let Ot=0;Ot<G.locationSize;Ot++)p(G.location+Ot);i.bindBuffer(i.ARRAY_BUFFER,jt);for(let Ot=0;Ot<G.locationSize;Ot++)x(G.location+Ot,pt/G.locationSize,$,ft,It*tt,(Dt+pt/G.locationSize*Ot)*tt,yt)}else{if(ht.isInstancedBufferAttribute){for(let lt=0;lt<G.locationSize;lt++)m(G.location+lt,ht.meshPerAttribute);v.isInstancedMesh!==!0&&N._maxInstanceCount===void 0&&(N._maxInstanceCount=ht.meshPerAttribute*ht.count)}else for(let lt=0;lt<G.locationSize;lt++)p(G.location+lt);i.bindBuffer(i.ARRAY_BUFFER,jt);for(let lt=0;lt<G.locationSize;lt++)x(G.location+lt,pt/G.locationSize,$,ft,pt*tt,pt/G.locationSize*lt*tt,yt)}}else if(z!==void 0){const ft=z[J];if(ft!==void 0)switch(ft.length){case 2:i.vertexAttrib2fv(G.location,ft);break;case 3:i.vertexAttrib3fv(G.location,ft);break;case 4:i.vertexAttrib4fv(G.location,ft);break;default:i.vertexAttrib1fv(G.location,ft)}}}}w()}function I(){P();for(const v in n){const S=n[v];for(const F in S){const N=S[F];for(const H in N)h(N[H].object),delete N[H];delete S[F]}delete n[v]}}function R(v){if(n[v.id]===void 0)return;const S=n[v.id];for(const F in S){const N=S[F];for(const H in N)h(N[H].object),delete N[H];delete S[F]}delete n[v.id]}function A(v){for(const S in n){const F=n[S];if(F[v.id]===void 0)continue;const N=F[v.id];for(const H in N)h(N[H].object),delete N[H];delete F[v.id]}}function P(){W(),o=!0,r!==s&&(r=s,l(r.object))}function W(){s.geometry=null,s.program=null,s.wireframe=!1}return{setup:a,reset:P,resetDefaultState:W,dispose:I,releaseStatesOfGeometry:R,releaseStatesOfProgram:A,initAttributes:_,enableAttribute:p,disableUnusedAttributes:w}}function Kp(i,t,e){let n;function s(l){n=l}function r(l,h){i.drawArrays(n,l,h),e.update(h,n,1)}function o(l,h,d){d!==0&&(i.drawArraysInstanced(n,l,h,d),e.update(h,n,d))}function a(l,h,d){if(d===0)return;t.get("WEBGL_multi_draw").multiDrawArraysWEBGL(n,l,0,h,0,d);let f=0;for(let g=0;g<d;g++)f+=h[g];e.update(f,n,1)}function c(l,h,d,u){if(d===0)return;const f=t.get("WEBGL_multi_draw");if(f===null)for(let g=0;g<l.length;g++)o(l[g],h[g],u[g]);else{f.multiDrawArraysInstancedWEBGL(n,l,0,h,0,u,0,d);let g=0;for(let _=0;_<d;_++)g+=h[_];for(let _=0;_<u.length;_++)e.update(g,n,u[_])}}this.setMode=s,this.render=r,this.renderInstances=o,this.renderMultiDraw=a,this.renderMultiDrawInstances=c}function Zp(i,t,e,n){let s;function r(){if(s!==void 0)return s;if(t.has("EXT_texture_filter_anisotropic")===!0){const A=t.get("EXT_texture_filter_anisotropic");s=i.getParameter(A.MAX_TEXTURE_MAX_ANISOTROPY_EXT)}else s=0;return s}function o(A){return!(A!==sn&&n.convert(A)!==i.getParameter(i.IMPLEMENTATION_COLOR_READ_FORMAT))}function a(A){const P=A===Ss&&(t.has("EXT_color_buffer_half_float")||t.has("EXT_color_buffer_float"));return!(A!==bn&&n.convert(A)!==i.getParameter(i.IMPLEMENTATION_COLOR_READ_TYPE)&&A!==xn&&!P)}function c(A){if(A==="highp"){if(i.getShaderPrecisionFormat(i.VERTEX_SHADER,i.HIGH_FLOAT).precision>0&&i.getShaderPrecisionFormat(i.FRAGMENT_SHADER,i.HIGH_FLOAT).precision>0)return"highp";A="mediump"}return A==="mediump"&&i.getShaderPrecisionFormat(i.VERTEX_SHADER,i.MEDIUM_FLOAT).precision>0&&i.getShaderPrecisionFormat(i.FRAGMENT_SHADER,i.MEDIUM_FLOAT).precision>0?"mediump":"lowp"}let l=e.precision!==void 0?e.precision:"highp";const h=c(l);h!==l&&(console.warn("THREE.WebGLRenderer:",l,"not supported, using",h,"instead."),l=h);const d=e.logarithmicDepthBuffer===!0,u=e.reverseDepthBuffer===!0&&t.has("EXT_clip_control");if(u===!0){const A=t.get("EXT_clip_control");A.clipControlEXT(A.LOWER_LEFT_EXT,A.ZERO_TO_ONE_EXT)}const f=i.getParameter(i.MAX_TEXTURE_IMAGE_UNITS),g=i.getParameter(i.MAX_VERTEX_TEXTURE_IMAGE_UNITS),_=i.getParameter(i.MAX_TEXTURE_SIZE),p=i.getParameter(i.MAX_CUBE_MAP_TEXTURE_SIZE),m=i.getParameter(i.MAX_VERTEX_ATTRIBS),w=i.getParameter(i.MAX_VERTEX_UNIFORM_VECTORS),x=i.getParameter(i.MAX_VARYING_VECTORS),b=i.getParameter(i.MAX_FRAGMENT_UNIFORM_VECTORS),I=g>0,R=i.getParameter(i.MAX_SAMPLES);return{isWebGL2:!0,getMaxAnisotropy:r,getMaxPrecision:c,textureFormatReadable:o,textureTypeReadable:a,precision:l,logarithmicDepthBuffer:d,reverseDepthBuffer:u,maxTextures:f,maxVertexTextures:g,maxTextureSize:_,maxCubemapSize:p,maxAttributes:m,maxVertexUniforms:w,maxVaryings:x,maxFragmentUniforms:b,vertexTextures:I,maxSamples:R}}function jp(i){const t=this;let e=null,n=0,s=!1,r=!1;const o=new en,a=new Vt,c={value:null,needsUpdate:!1};this.uniform=c,this.numPlanes=0,this.numIntersection=0,this.init=function(d,u){const f=d.length!==0||u||n!==0||s;return s=u,n=d.length,f},this.beginShadows=function(){r=!0,h(null)},this.endShadows=function(){r=!1},this.setGlobalState=function(d,u){e=h(d,u,0)},this.setState=function(d,u,f){const g=d.clippingPlanes,_=d.clipIntersection,p=d.clipShadows,m=i.get(d);if(!s||g===null||g.length===0||r&&!p)r?h(null):l();else{const w=r?0:n,x=w*4;let b=m.clippingState||null;c.value=b,b=h(g,u,x,f);for(let I=0;I!==x;++I)b[I]=e[I];m.clippingState=b,this.numIntersection=_?this.numPlanes:0,this.numPlanes+=w}};function l(){c.value!==e&&(c.value=e,c.needsUpdate=n>0),t.numPlanes=n,t.numIntersection=0}function h(d,u,f,g){const _=d!==null?d.length:0;let p=null;if(_!==0){if(p=c.value,g!==!0||p===null){const m=f+_*4,w=u.matrixWorldInverse;a.getNormalMatrix(w),(p===null||p.length<m)&&(p=new Float32Array(m));for(let x=0,b=f;x!==_;++x,b+=4)o.copy(d[x]).applyMatrix4(w,a),o.normal.toArray(p,b),p[b+3]=o.constant}c.value=p,c.needsUpdate=!0}return t.numPlanes=_,t.numIntersection=0,p}}function Jp(i){let t=new WeakMap;function e(o,a){return a===Lo?o.mapping=Vi:a===Do&&(o.mapping=Gi),o}function n(o){if(o&&o.isTexture){const a=o.mapping;if(a===Lo||a===Do)if(t.has(o)){const c=t.get(o).texture;return e(c,o.mapping)}else{const c=o.image;if(c&&c.height>0){const l=new cd(c.height);return l.fromEquirectangularTexture(i,o),t.set(o,l),o.addEventListener("dispose",s),e(l.texture,o.mapping)}else return null}}return o}function s(o){const a=o.target;a.removeEventListener("dispose",s);const c=t.get(a);c!==void 0&&(t.delete(a),c.dispose())}function r(){t=new WeakMap}return{get:n,dispose:r}}class jl extends Yl{constructor(t=-1,e=1,n=1,s=-1,r=.1,o=2e3){super(),this.isOrthographicCamera=!0,this.type="OrthographicCamera",this.zoom=1,this.view=null,this.left=t,this.right=e,this.top=n,this.bottom=s,this.near=r,this.far=o,this.updateProjectionMatrix()}copy(t,e){return super.copy(t,e),this.left=t.left,this.right=t.right,this.top=t.top,this.bottom=t.bottom,this.near=t.near,this.far=t.far,this.zoom=t.zoom,this.view=t.view===null?null:Object.assign({},t.view),this}setViewOffset(t,e,n,s,r,o){this.view===null&&(this.view={enabled:!0,fullWidth:1,fullHeight:1,offsetX:0,offsetY:0,width:1,height:1}),this.view.enabled=!0,this.view.fullWidth=t,this.view.fullHeight=e,this.view.offsetX=n,this.view.offsetY=s,this.view.width=r,this.view.height=o,this.updateProjectionMatrix()}clearViewOffset(){this.view!==null&&(this.view.enabled=!1),this.updateProjectionMatrix()}updateProjectionMatrix(){const t=(this.right-this.left)/(2*this.zoom),e=(this.top-this.bottom)/(2*this.zoom),n=(this.right+this.left)/2,s=(this.top+this.bottom)/2;let r=n-t,o=n+t,a=s+e,c=s-e;if(this.view!==null&&this.view.enabled){const l=(this.right-this.left)/this.view.fullWidth/this.zoom,h=(this.top-this.bottom)/this.view.fullHeight/this.zoom;r+=l*this.view.offsetX,o=r+l*this.view.width,a-=h*this.view.offsetY,c=a-h*this.view.height}this.projectionMatrix.makeOrthographic(r,o,a,c,this.near,this.far,this.coordinateSystem),this.projectionMatrixInverse.copy(this.projectionMatrix).invert()}toJSON(t){const e=super.toJSON(t);return e.object.zoom=this.zoom,e.object.left=this.left,e.object.right=this.right,e.object.top=this.top,e.object.bottom=this.bottom,e.object.near=this.near,e.object.far=this.far,this.view!==null&&(e.object.view=Object.assign({},this.view)),e}}const Di=4,Mc=[.125,.215,.35,.446,.526,.582],ei=20,eo=new jl,Sc=new Xt;let no=null,io=0,so=0,ro=!1;const Qn=(1+Math.sqrt(5))/2,wi=1/Qn,bc=[new C(-Qn,wi,0),new C(Qn,wi,0),new C(-wi,0,Qn),new C(wi,0,Qn),new C(0,Qn,-wi),new C(0,Qn,wi),new C(-1,1,-1),new C(1,1,-1),new C(-1,1,1),new C(1,1,1)];class aa{constructor(t){this._renderer=t,this._pingPongRenderTarget=null,this._lodMax=0,this._cubeSize=0,this._lodPlanes=[],this._sizeLods=[],this._sigmas=[],this._blurMaterial=null,this._cubemapMaterial=null,this._equirectMaterial=null,this._compileMaterial(this._blurMaterial)}fromScene(t,e=0,n=.1,s=100){no=this._renderer.getRenderTarget(),io=this._renderer.getActiveCubeFace(),so=this._renderer.getActiveMipmapLevel(),ro=this._renderer.xr.enabled,this._renderer.xr.enabled=!1,this._setSize(256);const r=this._allocateTargets();return r.depthBuffer=!0,this._sceneToCubeUV(t,n,s,r),e>0&&this._blur(r,0,0,e),this._applyPMREM(r),this._cleanup(r),r}fromEquirectangular(t,e=null){return this._fromTexture(t,e)}fromCubemap(t,e=null){return this._fromTexture(t,e)}compileCubemapShader(){this._cubemapMaterial===null&&(this._cubemapMaterial=wc(),this._compileMaterial(this._cubemapMaterial))}compileEquirectangularShader(){this._equirectMaterial===null&&(this._equirectMaterial=Tc(),this._compileMaterial(this._equirectMaterial))}dispose(){this._dispose(),this._cubemapMaterial!==null&&this._cubemapMaterial.dispose(),this._equirectMaterial!==null&&this._equirectMaterial.dispose()}_setSize(t){this._lodMax=Math.floor(Math.log2(t)),this._cubeSize=Math.pow(2,this._lodMax)}_dispose(){this._blurMaterial!==null&&this._blurMaterial.dispose(),this._pingPongRenderTarget!==null&&this._pingPongRenderTarget.dispose();for(let t=0;t<this._lodPlanes.length;t++)this._lodPlanes[t].dispose()}_cleanup(t){this._renderer.setRenderTarget(no,io,so),this._renderer.xr.enabled=ro,t.scissorTest=!1,Xs(t,0,0,t.width,t.height)}_fromTexture(t,e){t.mapping===Vi||t.mapping===Gi?this._setSize(t.image.length===0?16:t.image[0].width||t.image[0].image.width):this._setSize(t.image.width/4),no=this._renderer.getRenderTarget(),io=this._renderer.getActiveCubeFace(),so=this._renderer.getActiveMipmapLevel(),ro=this._renderer.xr.enabled,this._renderer.xr.enabled=!1;const n=e||this._allocateTargets();return this._textureToCubeUV(t,n),this._applyPMREM(n),this._cleanup(n),n}_allocateTargets(){const t=3*Math.max(this._cubeSize,112),e=4*this._cubeSize,n={magFilter:nn,minFilter:nn,generateMipmaps:!1,type:Ss,format:sn,colorSpace:Xn,depthBuffer:!1},s=Ec(t,e,n);if(this._pingPongRenderTarget===null||this._pingPongRenderTarget.width!==t||this._pingPongRenderTarget.height!==e){this._pingPongRenderTarget!==null&&this._dispose(),this._pingPongRenderTarget=Ec(t,e,n);const{_lodMax:r}=this;({sizeLods:this._sizeLods,lodPlanes:this._lodPlanes,sigmas:this._sigmas}=Qp(r)),this._blurMaterial=tm(r,t,e)}return s}_compileMaterial(t){const e=new ae(this._lodPlanes[0],t);this._renderer.compile(e,eo)}_sceneToCubeUV(t,e,n,s){const a=new He(90,1,e,n),c=[1,-1,1,1,1,1],l=[1,1,1,-1,-1,-1],h=this._renderer,d=h.autoClear,u=h.toneMapping;h.getClearColor(Sc),h.toneMapping=On,h.autoClear=!1;const f=new Er({name:"PMREM.Background",side:Re,depthWrite:!1,depthTest:!1}),g=new ae(new zn,f);let _=!1;const p=t.background;p?p.isColor&&(f.color.copy(p),t.background=null,_=!0):(f.color.copy(Sc),_=!0);for(let m=0;m<6;m++){const w=m%3;w===0?(a.up.set(0,c[m],0),a.lookAt(l[m],0,0)):w===1?(a.up.set(0,0,c[m]),a.lookAt(0,l[m],0)):(a.up.set(0,c[m],0),a.lookAt(0,0,l[m]));const x=this._cubeSize;Xs(s,w*x,m>2?x:0,x,x),h.setRenderTarget(s),_&&h.render(g,a),h.render(t,a)}g.geometry.dispose(),g.material.dispose(),h.toneMapping=u,h.autoClear=d,t.background=p}_textureToCubeUV(t,e){const n=this._renderer,s=t.mapping===Vi||t.mapping===Gi;s?(this._cubemapMaterial===null&&(this._cubemapMaterial=wc()),this._cubemapMaterial.uniforms.flipEnvMap.value=t.isRenderTargetTexture===!1?-1:1):this._equirectMaterial===null&&(this._equirectMaterial=Tc());const r=s?this._cubemapMaterial:this._equirectMaterial,o=new ae(this._lodPlanes[0],r),a=r.uniforms;a.envMap.value=t;const c=this._cubeSize;Xs(e,0,0,3*c,2*c),n.setRenderTarget(e),n.render(o,eo)}_applyPMREM(t){const e=this._renderer,n=e.autoClear;e.autoClear=!1;const s=this._lodPlanes.length;for(let r=1;r<s;r++){const o=Math.sqrt(this._sigmas[r]*this._sigmas[r]-this._sigmas[r-1]*this._sigmas[r-1]),a=bc[(s-r-1)%bc.length];this._blur(t,r-1,r,o,a)}e.autoClear=n}_blur(t,e,n,s,r){const o=this._pingPongRenderTarget;this._halfBlur(t,o,e,n,s,"latitudinal",r),this._halfBlur(o,t,n,n,s,"longitudinal",r)}_halfBlur(t,e,n,s,r,o,a){const c=this._renderer,l=this._blurMaterial;o!=="latitudinal"&&o!=="longitudinal"&&console.error("blur direction must be either latitudinal or longitudinal!");const h=3,d=new ae(this._lodPlanes[s],l),u=l.uniforms,f=this._sizeLods[n]-1,g=isFinite(r)?Math.PI/(2*f):2*Math.PI/(2*ei-1),_=r/g,p=isFinite(r)?1+Math.floor(h*_):ei;p>ei&&console.warn(`sigmaRadians, ${r}, is too large and will clip, as it requested ${p} samples when the maximum is set to ${ei}`);const m=[];let w=0;for(let A=0;A<ei;++A){const P=A/_,W=Math.exp(-P*P/2);m.push(W),A===0?w+=W:A<p&&(w+=2*W)}for(let A=0;A<m.length;A++)m[A]=m[A]/w;u.envMap.value=t.texture,u.samples.value=p,u.weights.value=m,u.latitudinal.value=o==="latitudinal",a&&(u.poleAxis.value=a);const{_lodMax:x}=this;u.dTheta.value=g,u.mipInt.value=x-n;const b=this._sizeLods[s],I=3*b*(s>x-Di?s-x+Di:0),R=4*(this._cubeSize-b);Xs(e,I,R,3*b,2*b),c.setRenderTarget(e),c.render(d,eo)}}function Qp(i){const t=[],e=[],n=[];let s=i;const r=i-Di+1+Mc.length;for(let o=0;o<r;o++){const a=Math.pow(2,s);e.push(a);let c=1/a;o>i-Di?c=Mc[o-i+Di-1]:o===0&&(c=0),n.push(c);const l=1/(a-2),h=-l,d=1+l,u=[h,h,d,h,d,d,h,h,d,d,h,d],f=6,g=6,_=3,p=2,m=1,w=new Float32Array(_*g*f),x=new Float32Array(p*g*f),b=new Float32Array(m*g*f);for(let R=0;R<f;R++){const A=R%3*2/3-1,P=R>2?0:-1,W=[A,P,0,A+2/3,P,0,A+2/3,P+1,0,A,P,0,A+2/3,P+1,0,A,P+1,0];w.set(W,_*g*R),x.set(u,p*g*R);const v=[R,R,R,R,R,R];b.set(v,m*g*R)}const I=new Ne;I.setAttribute("position",new rn(w,_)),I.setAttribute("uv",new rn(x,p)),I.setAttribute("faceIndex",new rn(b,m)),t.push(I),s>Di&&s--}return{lodPlanes:t,sizeLods:e,sigmas:n}}function Ec(i,t,e){const n=new oi(i,t,e);return n.texture.mapping=yr,n.texture.name="PMREM.cubeUv",n.scissorTest=!0,n}function Xs(i,t,e,n,s){i.viewport.set(t,e,n,s),i.scissor.set(t,e,n,s)}function tm(i,t,e){const n=new Float32Array(ei),s=new C(0,1,0);return new Hn({name:"SphericalGaussianBlur",defines:{n:ei,CUBEUV_TEXEL_WIDTH:1/t,CUBEUV_TEXEL_HEIGHT:1/e,CUBEUV_MAX_MIP:`${i}.0`},uniforms:{envMap:{value:null},samples:{value:1},weights:{value:n},latitudinal:{value:!1},dTheta:{value:0},mipInt:{value:0},poleAxis:{value:s}},vertexShader:Pa(),fragmentShader:`

			precision mediump float;
			precision mediump int;

			varying vec3 vOutputDirection;

			uniform sampler2D envMap;
			uniform int samples;
			uniform float weights[ n ];
			uniform bool latitudinal;
			uniform float dTheta;
			uniform float mipInt;
			uniform vec3 poleAxis;

			#define ENVMAP_TYPE_CUBE_UV
			#include <cube_uv_reflection_fragment>

			vec3 getSample( float theta, vec3 axis ) {

				float cosTheta = cos( theta );
				// Rodrigues' axis-angle rotation
				vec3 sampleDirection = vOutputDirection * cosTheta
					+ cross( axis, vOutputDirection ) * sin( theta )
					+ axis * dot( axis, vOutputDirection ) * ( 1.0 - cosTheta );

				return bilinearCubeUV( envMap, sampleDirection, mipInt );

			}

			void main() {

				vec3 axis = latitudinal ? poleAxis : cross( poleAxis, vOutputDirection );

				if ( all( equal( axis, vec3( 0.0 ) ) ) ) {

					axis = vec3( vOutputDirection.z, 0.0, - vOutputDirection.x );

				}

				axis = normalize( axis );

				gl_FragColor = vec4( 0.0, 0.0, 0.0, 1.0 );
				gl_FragColor.rgb += weights[ 0 ] * getSample( 0.0, axis );

				for ( int i = 1; i < n; i++ ) {

					if ( i >= samples ) {

						break;

					}

					float theta = dTheta * float( i );
					gl_FragColor.rgb += weights[ i ] * getSample( -1.0 * theta, axis );
					gl_FragColor.rgb += weights[ i ] * getSample( theta, axis );

				}

			}
		`,blending:Fn,depthTest:!1,depthWrite:!1})}function Tc(){return new Hn({name:"EquirectangularToCubeUV",uniforms:{envMap:{value:null}},vertexShader:Pa(),fragmentShader:`

			precision mediump float;
			precision mediump int;

			varying vec3 vOutputDirection;

			uniform sampler2D envMap;

			#include <common>

			void main() {

				vec3 outputDirection = normalize( vOutputDirection );
				vec2 uv = equirectUv( outputDirection );

				gl_FragColor = vec4( texture2D ( envMap, uv ).rgb, 1.0 );

			}
		`,blending:Fn,depthTest:!1,depthWrite:!1})}function wc(){return new Hn({name:"CubemapToCubeUV",uniforms:{envMap:{value:null},flipEnvMap:{value:-1}},vertexShader:Pa(),fragmentShader:`

			precision mediump float;
			precision mediump int;

			uniform float flipEnvMap;

			varying vec3 vOutputDirection;

			uniform samplerCube envMap;

			void main() {

				gl_FragColor = textureCube( envMap, vec3( flipEnvMap * vOutputDirection.x, vOutputDirection.yz ) );

			}
		`,blending:Fn,depthTest:!1,depthWrite:!1})}function Pa(){return`

		precision mediump float;
		precision mediump int;

		attribute float faceIndex;

		varying vec3 vOutputDirection;

		// RH coordinate system; PMREM face-indexing convention
		vec3 getDirection( vec2 uv, float face ) {

			uv = 2.0 * uv - 1.0;

			vec3 direction = vec3( uv, 1.0 );

			if ( face == 0.0 ) {

				direction = direction.zyx; // ( 1, v, u ) pos x

			} else if ( face == 1.0 ) {

				direction = direction.xzy;
				direction.xz *= -1.0; // ( -u, 1, -v ) pos y

			} else if ( face == 2.0 ) {

				direction.x *= -1.0; // ( -u, v, 1 ) pos z

			} else if ( face == 3.0 ) {

				direction = direction.zyx;
				direction.xz *= -1.0; // ( -1, v, -u ) neg x

			} else if ( face == 4.0 ) {

				direction = direction.xzy;
				direction.xy *= -1.0; // ( -u, -1, v ) neg y

			} else if ( face == 5.0 ) {

				direction.z *= -1.0; // ( u, v, -1 ) neg z

			}

			return direction;

		}

		void main() {

			vOutputDirection = getDirection( uv, faceIndex );
			gl_Position = vec4( position, 1.0 );

		}
	`}function em(i){let t=new WeakMap,e=null;function n(a){if(a&&a.isTexture){const c=a.mapping,l=c===Lo||c===Do,h=c===Vi||c===Gi;if(l||h){let d=t.get(a);const u=d!==void 0?d.texture.pmremVersion:0;if(a.isRenderTargetTexture&&a.pmremVersion!==u)return e===null&&(e=new aa(i)),d=l?e.fromEquirectangular(a,d):e.fromCubemap(a,d),d.texture.pmremVersion=a.pmremVersion,t.set(a,d),d.texture;if(d!==void 0)return d.texture;{const f=a.image;return l&&f&&f.height>0||h&&f&&s(f)?(e===null&&(e=new aa(i)),d=l?e.fromEquirectangular(a):e.fromCubemap(a),d.texture.pmremVersion=a.pmremVersion,t.set(a,d),a.addEventListener("dispose",r),d.texture):null}}}return a}function s(a){let c=0;const l=6;for(let h=0;h<l;h++)a[h]!==void 0&&c++;return c===l}function r(a){const c=a.target;c.removeEventListener("dispose",r);const l=t.get(c);l!==void 0&&(t.delete(c),l.dispose())}function o(){t=new WeakMap,e!==null&&(e.dispose(),e=null)}return{get:n,dispose:o}}function nm(i){const t={};function e(n){if(t[n]!==void 0)return t[n];let s;switch(n){case"WEBGL_depth_texture":s=i.getExtension("WEBGL_depth_texture")||i.getExtension("MOZ_WEBGL_depth_texture")||i.getExtension("WEBKIT_WEBGL_depth_texture");break;case"EXT_texture_filter_anisotropic":s=i.getExtension("EXT_texture_filter_anisotropic")||i.getExtension("MOZ_EXT_texture_filter_anisotropic")||i.getExtension("WEBKIT_EXT_texture_filter_anisotropic");break;case"WEBGL_compressed_texture_s3tc":s=i.getExtension("WEBGL_compressed_texture_s3tc")||i.getExtension("MOZ_WEBGL_compressed_texture_s3tc")||i.getExtension("WEBKIT_WEBGL_compressed_texture_s3tc");break;case"WEBGL_compressed_texture_pvrtc":s=i.getExtension("WEBGL_compressed_texture_pvrtc")||i.getExtension("WEBKIT_WEBGL_compressed_texture_pvrtc");break;default:s=i.getExtension(n)}return t[n]=s,s}return{has:function(n){return e(n)!==null},init:function(){e("EXT_color_buffer_float"),e("WEBGL_clip_cull_distance"),e("OES_texture_float_linear"),e("EXT_color_buffer_half_float"),e("WEBGL_multisampled_render_to_texture"),e("WEBGL_render_shared_exponent")},get:function(n){const s=e(n);return s===null&&lr("THREE.WebGLRenderer: "+n+" extension not supported."),s}}}function im(i,t,e,n){const s={},r=new WeakMap;function o(d){const u=d.target;u.index!==null&&t.remove(u.index);for(const g in u.attributes)t.remove(u.attributes[g]);for(const g in u.morphAttributes){const _=u.morphAttributes[g];for(let p=0,m=_.length;p<m;p++)t.remove(_[p])}u.removeEventListener("dispose",o),delete s[u.id];const f=r.get(u);f&&(t.remove(f),r.delete(u)),n.releaseStatesOfGeometry(u),u.isInstancedBufferGeometry===!0&&delete u._maxInstanceCount,e.memory.geometries--}function a(d,u){return s[u.id]===!0||(u.addEventListener("dispose",o),s[u.id]=!0,e.memory.geometries++),u}function c(d){const u=d.attributes;for(const g in u)t.update(u[g],i.ARRAY_BUFFER);const f=d.morphAttributes;for(const g in f){const _=f[g];for(let p=0,m=_.length;p<m;p++)t.update(_[p],i.ARRAY_BUFFER)}}function l(d){const u=[],f=d.index,g=d.attributes.position;let _=0;if(f!==null){const w=f.array;_=f.version;for(let x=0,b=w.length;x<b;x+=3){const I=w[x+0],R=w[x+1],A=w[x+2];u.push(I,R,R,A,A,I)}}else if(g!==void 0){const w=g.array;_=g.version;for(let x=0,b=w.length/3-1;x<b;x+=3){const I=x+0,R=x+1,A=x+2;u.push(I,R,R,A,A,I)}}else return;const p=new(Hl(u)?$l:Xl)(u,1);p.version=_;const m=r.get(d);m&&t.remove(m),r.set(d,p)}function h(d){const u=r.get(d);if(u){const f=d.index;f!==null&&u.version<f.version&&l(d)}else l(d);return r.get(d)}return{get:a,update:c,getWireframeAttribute:h}}function sm(i,t,e){let n;function s(u){n=u}let r,o;function a(u){r=u.type,o=u.bytesPerElement}function c(u,f){i.drawElements(n,f,r,u*o),e.update(f,n,1)}function l(u,f,g){g!==0&&(i.drawElementsInstanced(n,f,r,u*o,g),e.update(f,n,g))}function h(u,f,g){if(g===0)return;t.get("WEBGL_multi_draw").multiDrawElementsWEBGL(n,f,0,r,u,0,g);let p=0;for(let m=0;m<g;m++)p+=f[m];e.update(p,n,1)}function d(u,f,g,_){if(g===0)return;const p=t.get("WEBGL_multi_draw");if(p===null)for(let m=0;m<u.length;m++)l(u[m]/o,f[m],_[m]);else{p.multiDrawElementsInstancedWEBGL(n,f,0,r,u,0,_,0,g);let m=0;for(let w=0;w<g;w++)m+=f[w];for(let w=0;w<_.length;w++)e.update(m,n,_[w])}}this.setMode=s,this.setIndex=a,this.render=c,this.renderInstances=l,this.renderMultiDraw=h,this.renderMultiDrawInstances=d}function rm(i){const t={geometries:0,textures:0},e={frame:0,calls:0,triangles:0,points:0,lines:0};function n(r,o,a){switch(e.calls++,o){case i.TRIANGLES:e.triangles+=a*(r/3);break;case i.LINES:e.lines+=a*(r/2);break;case i.LINE_STRIP:e.lines+=a*(r-1);break;case i.LINE_LOOP:e.lines+=a*r;break;case i.POINTS:e.points+=a*r;break;default:console.error("THREE.WebGLInfo: Unknown draw mode:",o);break}}function s(){e.calls=0,e.triangles=0,e.points=0,e.lines=0}return{memory:t,render:e,programs:null,autoReset:!0,reset:s,update:n}}function om(i,t,e){const n=new WeakMap,s=new se;function r(o,a,c){const l=o.morphTargetInfluences,h=a.morphAttributes.position||a.morphAttributes.normal||a.morphAttributes.color,d=h!==void 0?h.length:0;let u=n.get(a);if(u===void 0||u.count!==d){let v=function(){P.dispose(),n.delete(a),a.removeEventListener("dispose",v)};var f=v;u!==void 0&&u.texture.dispose();const g=a.morphAttributes.position!==void 0,_=a.morphAttributes.normal!==void 0,p=a.morphAttributes.color!==void 0,m=a.morphAttributes.position||[],w=a.morphAttributes.normal||[],x=a.morphAttributes.color||[];let b=0;g===!0&&(b=1),_===!0&&(b=2),p===!0&&(b=3);let I=a.attributes.position.count*b,R=1;I>t.maxTextureSize&&(R=Math.ceil(I/t.maxTextureSize),I=t.maxTextureSize);const A=new Float32Array(I*R*4*d),P=new Gl(A,I,R,d);P.type=xn,P.needsUpdate=!0;const W=b*4;for(let S=0;S<d;S++){const F=m[S],N=w[S],H=x[S],X=I*R*4*S;for(let z=0;z<F.count;z++){const J=z*W;g===!0&&(s.fromBufferAttribute(F,z),A[X+J+0]=s.x,A[X+J+1]=s.y,A[X+J+2]=s.z,A[X+J+3]=0),_===!0&&(s.fromBufferAttribute(N,z),A[X+J+4]=s.x,A[X+J+5]=s.y,A[X+J+6]=s.z,A[X+J+7]=0),p===!0&&(s.fromBufferAttribute(H,z),A[X+J+8]=s.x,A[X+J+9]=s.y,A[X+J+10]=s.z,A[X+J+11]=H.itemSize===4?s.w:1)}}u={count:d,texture:P,size:new nt(I,R)},n.set(a,u),a.addEventListener("dispose",v)}if(o.isInstancedMesh===!0&&o.morphTexture!==null)c.getUniforms().setValue(i,"morphTexture",o.morphTexture,e);else{let g=0;for(let p=0;p<l.length;p++)g+=l[p];const _=a.morphTargetsRelative?1:1-g;c.getUniforms().setValue(i,"morphTargetBaseInfluence",_),c.getUniforms().setValue(i,"morphTargetInfluences",l)}c.getUniforms().setValue(i,"morphTargetsTexture",u.texture,e),c.getUniforms().setValue(i,"morphTargetsTextureSize",u.size)}return{update:r}}function am(i,t,e,n){let s=new WeakMap;function r(c){const l=n.render.frame,h=c.geometry,d=t.get(c,h);if(s.get(d)!==l&&(t.update(d),s.set(d,l)),c.isInstancedMesh&&(c.hasEventListener("dispose",a)===!1&&c.addEventListener("dispose",a),s.get(c)!==l&&(e.update(c.instanceMatrix,i.ARRAY_BUFFER),c.instanceColor!==null&&e.update(c.instanceColor,i.ARRAY_BUFFER),s.set(c,l))),c.isSkinnedMesh){const u=c.skeleton;s.get(u)!==l&&(u.update(),s.set(u,l))}return d}function o(){s=new WeakMap}function a(c){const l=c.target;l.removeEventListener("dispose",a),e.remove(l.instanceMatrix),l.instanceColor!==null&&e.remove(l.instanceColor)}return{update:r,dispose:o}}class Jl extends Ue{constructor(t,e,n,s,r,o,a,c,l,h=Fi){if(h!==Fi&&h!==Xi)throw new Error("DepthTexture format must be either THREE.DepthFormat or THREE.DepthStencilFormat");n===void 0&&h===Fi&&(n=ri),n===void 0&&h===Xi&&(n=Wi),super(null,s,r,o,a,c,h,n,l),this.isDepthTexture=!0,this.image={width:t,height:e},this.magFilter=a!==void 0?a:Ke,this.minFilter=c!==void 0?c:Ke,this.flipY=!1,this.generateMipmaps=!1,this.compareFunction=null}copy(t){return super.copy(t),this.compareFunction=t.compareFunction,this}toJSON(t){const e=super.toJSON(t);return this.compareFunction!==null&&(e.compareFunction=this.compareFunction),e}}const Ql=new Ue,Ac=new Jl(1,1),th=new Gl,eh=new $u,nh=new Kl,Cc=[],Rc=[],Pc=new Float32Array(16),Lc=new Float32Array(9),Dc=new Float32Array(4);function Zi(i,t,e){const n=i[0];if(n<=0||n>0)return i;const s=t*e;let r=Cc[s];if(r===void 0&&(r=new Float32Array(s),Cc[s]=r),t!==0){n.toArray(r,0);for(let o=1,a=0;o!==t;++o)a+=e,i[o].toArray(r,a)}return r}function _e(i,t){if(i.length!==t.length)return!1;for(let e=0,n=i.length;e<n;e++)if(i[e]!==t[e])return!1;return!0}function ve(i,t){for(let e=0,n=t.length;e<n;e++)i[e]=t[e]}function Tr(i,t){let e=Rc[t];e===void 0&&(e=new Int32Array(t),Rc[t]=e);for(let n=0;n!==t;++n)e[n]=i.allocateTextureUnit();return e}function cm(i,t){const e=this.cache;e[0]!==t&&(i.uniform1f(this.addr,t),e[0]=t)}function lm(i,t){const e=this.cache;if(t.x!==void 0)(e[0]!==t.x||e[1]!==t.y)&&(i.uniform2f(this.addr,t.x,t.y),e[0]=t.x,e[1]=t.y);else{if(_e(e,t))return;i.uniform2fv(this.addr,t),ve(e,t)}}function hm(i,t){const e=this.cache;if(t.x!==void 0)(e[0]!==t.x||e[1]!==t.y||e[2]!==t.z)&&(i.uniform3f(this.addr,t.x,t.y,t.z),e[0]=t.x,e[1]=t.y,e[2]=t.z);else if(t.r!==void 0)(e[0]!==t.r||e[1]!==t.g||e[2]!==t.b)&&(i.uniform3f(this.addr,t.r,t.g,t.b),e[0]=t.r,e[1]=t.g,e[2]=t.b);else{if(_e(e,t))return;i.uniform3fv(this.addr,t),ve(e,t)}}function um(i,t){const e=this.cache;if(t.x!==void 0)(e[0]!==t.x||e[1]!==t.y||e[2]!==t.z||e[3]!==t.w)&&(i.uniform4f(this.addr,t.x,t.y,t.z,t.w),e[0]=t.x,e[1]=t.y,e[2]=t.z,e[3]=t.w);else{if(_e(e,t))return;i.uniform4fv(this.addr,t),ve(e,t)}}function dm(i,t){const e=this.cache,n=t.elements;if(n===void 0){if(_e(e,t))return;i.uniformMatrix2fv(this.addr,!1,t),ve(e,t)}else{if(_e(e,n))return;Dc.set(n),i.uniformMatrix2fv(this.addr,!1,Dc),ve(e,n)}}function fm(i,t){const e=this.cache,n=t.elements;if(n===void 0){if(_e(e,t))return;i.uniformMatrix3fv(this.addr,!1,t),ve(e,t)}else{if(_e(e,n))return;Lc.set(n),i.uniformMatrix3fv(this.addr,!1,Lc),ve(e,n)}}function pm(i,t){const e=this.cache,n=t.elements;if(n===void 0){if(_e(e,t))return;i.uniformMatrix4fv(this.addr,!1,t),ve(e,t)}else{if(_e(e,n))return;Pc.set(n),i.uniformMatrix4fv(this.addr,!1,Pc),ve(e,n)}}function mm(i,t){const e=this.cache;e[0]!==t&&(i.uniform1i(this.addr,t),e[0]=t)}function gm(i,t){const e=this.cache;if(t.x!==void 0)(e[0]!==t.x||e[1]!==t.y)&&(i.uniform2i(this.addr,t.x,t.y),e[0]=t.x,e[1]=t.y);else{if(_e(e,t))return;i.uniform2iv(this.addr,t),ve(e,t)}}function _m(i,t){const e=this.cache;if(t.x!==void 0)(e[0]!==t.x||e[1]!==t.y||e[2]!==t.z)&&(i.uniform3i(this.addr,t.x,t.y,t.z),e[0]=t.x,e[1]=t.y,e[2]=t.z);else{if(_e(e,t))return;i.uniform3iv(this.addr,t),ve(e,t)}}function vm(i,t){const e=this.cache;if(t.x!==void 0)(e[0]!==t.x||e[1]!==t.y||e[2]!==t.z||e[3]!==t.w)&&(i.uniform4i(this.addr,t.x,t.y,t.z,t.w),e[0]=t.x,e[1]=t.y,e[2]=t.z,e[3]=t.w);else{if(_e(e,t))return;i.uniform4iv(this.addr,t),ve(e,t)}}function xm(i,t){const e=this.cache;e[0]!==t&&(i.uniform1ui(this.addr,t),e[0]=t)}function ym(i,t){const e=this.cache;if(t.x!==void 0)(e[0]!==t.x||e[1]!==t.y)&&(i.uniform2ui(this.addr,t.x,t.y),e[0]=t.x,e[1]=t.y);else{if(_e(e,t))return;i.uniform2uiv(this.addr,t),ve(e,t)}}function Mm(i,t){const e=this.cache;if(t.x!==void 0)(e[0]!==t.x||e[1]!==t.y||e[2]!==t.z)&&(i.uniform3ui(this.addr,t.x,t.y,t.z),e[0]=t.x,e[1]=t.y,e[2]=t.z);else{if(_e(e,t))return;i.uniform3uiv(this.addr,t),ve(e,t)}}function Sm(i,t){const e=this.cache;if(t.x!==void 0)(e[0]!==t.x||e[1]!==t.y||e[2]!==t.z||e[3]!==t.w)&&(i.uniform4ui(this.addr,t.x,t.y,t.z,t.w),e[0]=t.x,e[1]=t.y,e[2]=t.z,e[3]=t.w);else{if(_e(e,t))return;i.uniform4uiv(this.addr,t),ve(e,t)}}function bm(i,t,e){const n=this.cache,s=e.allocateTextureUnit();n[0]!==s&&(i.uniform1i(this.addr,s),n[0]=s);let r;this.type===i.SAMPLER_2D_SHADOW?(Ac.compareFunction=Bl,r=Ac):r=Ql,e.setTexture2D(t||r,s)}function Em(i,t,e){const n=this.cache,s=e.allocateTextureUnit();n[0]!==s&&(i.uniform1i(this.addr,s),n[0]=s),e.setTexture3D(t||eh,s)}function Tm(i,t,e){const n=this.cache,s=e.allocateTextureUnit();n[0]!==s&&(i.uniform1i(this.addr,s),n[0]=s),e.setTextureCube(t||nh,s)}function wm(i,t,e){const n=this.cache,s=e.allocateTextureUnit();n[0]!==s&&(i.uniform1i(this.addr,s),n[0]=s),e.setTexture2DArray(t||th,s)}function Am(i){switch(i){case 5126:return cm;case 35664:return lm;case 35665:return hm;case 35666:return um;case 35674:return dm;case 35675:return fm;case 35676:return pm;case 5124:case 35670:return mm;case 35667:case 35671:return gm;case 35668:case 35672:return _m;case 35669:case 35673:return vm;case 5125:return xm;case 36294:return ym;case 36295:return Mm;case 36296:return Sm;case 35678:case 36198:case 36298:case 36306:case 35682:return bm;case 35679:case 36299:case 36307:return Em;case 35680:case 36300:case 36308:case 36293:return Tm;case 36289:case 36303:case 36311:case 36292:return wm}}function Cm(i,t){i.uniform1fv(this.addr,t)}function Rm(i,t){const e=Zi(t,this.size,2);i.uniform2fv(this.addr,e)}function Pm(i,t){const e=Zi(t,this.size,3);i.uniform3fv(this.addr,e)}function Lm(i,t){const e=Zi(t,this.size,4);i.uniform4fv(this.addr,e)}function Dm(i,t){const e=Zi(t,this.size,4);i.uniformMatrix2fv(this.addr,!1,e)}function Im(i,t){const e=Zi(t,this.size,9);i.uniformMatrix3fv(this.addr,!1,e)}function Um(i,t){const e=Zi(t,this.size,16);i.uniformMatrix4fv(this.addr,!1,e)}function Nm(i,t){i.uniform1iv(this.addr,t)}function km(i,t){i.uniform2iv(this.addr,t)}function Fm(i,t){i.uniform3iv(this.addr,t)}function Om(i,t){i.uniform4iv(this.addr,t)}function Bm(i,t){i.uniform1uiv(this.addr,t)}function zm(i,t){i.uniform2uiv(this.addr,t)}function Hm(i,t){i.uniform3uiv(this.addr,t)}function Vm(i,t){i.uniform4uiv(this.addr,t)}function Gm(i,t,e){const n=this.cache,s=t.length,r=Tr(e,s);_e(n,r)||(i.uniform1iv(this.addr,r),ve(n,r));for(let o=0;o!==s;++o)e.setTexture2D(t[o]||Ql,r[o])}function Wm(i,t,e){const n=this.cache,s=t.length,r=Tr(e,s);_e(n,r)||(i.uniform1iv(this.addr,r),ve(n,r));for(let o=0;o!==s;++o)e.setTexture3D(t[o]||eh,r[o])}function Xm(i,t,e){const n=this.cache,s=t.length,r=Tr(e,s);_e(n,r)||(i.uniform1iv(this.addr,r),ve(n,r));for(let o=0;o!==s;++o)e.setTextureCube(t[o]||nh,r[o])}function $m(i,t,e){const n=this.cache,s=t.length,r=Tr(e,s);_e(n,r)||(i.uniform1iv(this.addr,r),ve(n,r));for(let o=0;o!==s;++o)e.setTexture2DArray(t[o]||th,r[o])}function qm(i){switch(i){case 5126:return Cm;case 35664:return Rm;case 35665:return Pm;case 35666:return Lm;case 35674:return Dm;case 35675:return Im;case 35676:return Um;case 5124:case 35670:return Nm;case 35667:case 35671:return km;case 35668:case 35672:return Fm;case 35669:case 35673:return Om;case 5125:return Bm;case 36294:return zm;case 36295:return Hm;case 36296:return Vm;case 35678:case 36198:case 36298:case 36306:case 35682:return Gm;case 35679:case 36299:case 36307:return Wm;case 35680:case 36300:case 36308:case 36293:return Xm;case 36289:case 36303:case 36311:case 36292:return $m}}class Ym{constructor(t,e,n){this.id=t,this.addr=n,this.cache=[],this.type=e.type,this.setValue=Am(e.type)}}class Km{constructor(t,e,n){this.id=t,this.addr=n,this.cache=[],this.type=e.type,this.size=e.size,this.setValue=qm(e.type)}}class Zm{constructor(t){this.id=t,this.seq=[],this.map={}}setValue(t,e,n){const s=this.seq;for(let r=0,o=s.length;r!==o;++r){const a=s[r];a.setValue(t,e[a.id],n)}}}const oo=/(\w+)(\])?(\[|\.)?/g;function Ic(i,t){i.seq.push(t),i.map[t.id]=t}function jm(i,t,e){const n=i.name,s=n.length;for(oo.lastIndex=0;;){const r=oo.exec(n),o=oo.lastIndex;let a=r[1];const c=r[2]==="]",l=r[3];if(c&&(a=a|0),l===void 0||l==="["&&o+2===s){Ic(e,l===void 0?new Ym(a,i,t):new Km(a,i,t));break}else{let d=e.map[a];d===void 0&&(d=new Zm(a),Ic(e,d)),e=d}}}class hr{constructor(t,e){this.seq=[],this.map={};const n=t.getProgramParameter(e,t.ACTIVE_UNIFORMS);for(let s=0;s<n;++s){const r=t.getActiveUniform(e,s),o=t.getUniformLocation(e,r.name);jm(r,o,this)}}setValue(t,e,n,s){const r=this.map[e];r!==void 0&&r.setValue(t,n,s)}setOptional(t,e,n){const s=e[n];s!==void 0&&this.setValue(t,n,s)}static upload(t,e,n,s){for(let r=0,o=e.length;r!==o;++r){const a=e[r],c=n[a.id];c.needsUpdate!==!1&&a.setValue(t,c.value,s)}}static seqWithValue(t,e){const n=[];for(let s=0,r=t.length;s!==r;++s){const o=t[s];o.id in e&&n.push(o)}return n}}function Uc(i,t,e){const n=i.createShader(t);return i.shaderSource(n,e),i.compileShader(n),n}const Jm=37297;let Qm=0;function tg(i,t){const e=i.split(`
`),n=[],s=Math.max(t-6,0),r=Math.min(t+6,e.length);for(let o=s;o<r;o++){const a=o+1;n.push(`${a===t?">":" "} ${a}: ${e[o]}`)}return n.join(`
`)}function eg(i){const t=ee.getPrimaries(ee.workingColorSpace),e=ee.getPrimaries(i);let n;switch(t===e?n="":t===fr&&e===dr?n="LinearDisplayP3ToLinearSRGB":t===dr&&e===fr&&(n="LinearSRGBToLinearDisplayP3"),i){case Xn:case Mr:return[n,"LinearTransferOETF"];case cn:case wa:return[n,"sRGBTransferOETF"];default:return console.warn("THREE.WebGLProgram: Unsupported color space:",i),[n,"LinearTransferOETF"]}}function Nc(i,t,e){const n=i.getShaderParameter(t,i.COMPILE_STATUS),s=i.getShaderInfoLog(t).trim();if(n&&s==="")return"";const r=/ERROR: 0:(\d+)/.exec(s);if(r){const o=parseInt(r[1]);return e.toUpperCase()+`

`+s+`

`+tg(i.getShaderSource(t),o)}else return s}function ng(i,t){const e=eg(t);return`vec4 ${i}( vec4 value ) { return ${e[0]}( ${e[1]}( value ) ); }`}function ig(i,t){let e;switch(t){case su:e="Linear";break;case ru:e="Reinhard";break;case ou:e="Cineon";break;case wl:e="ACESFilmic";break;case cu:e="AgX";break;case lu:e="Neutral";break;case au:e="Custom";break;default:console.warn("THREE.WebGLProgram: Unsupported toneMapping:",t),e="Linear"}return"vec3 "+i+"( vec3 color ) { return "+e+"ToneMapping( color ); }"}const $s=new C;function sg(){ee.getLuminanceCoefficients($s);const i=$s.x.toFixed(4),t=$s.y.toFixed(4),e=$s.z.toFixed(4);return["float luminance( const in vec3 rgb ) {",`	const vec3 weights = vec3( ${i}, ${t}, ${e} );`,"	return dot( weights, rgb );","}"].join(`
`)}function rg(i){return[i.extensionClipCullDistance?"#extension GL_ANGLE_clip_cull_distance : require":"",i.extensionMultiDraw?"#extension GL_ANGLE_multi_draw : require":""].filter(as).join(`
`)}function og(i){const t=[];for(const e in i){const n=i[e];n!==!1&&t.push("#define "+e+" "+n)}return t.join(`
`)}function ag(i,t){const e={},n=i.getProgramParameter(t,i.ACTIVE_ATTRIBUTES);for(let s=0;s<n;s++){const r=i.getActiveAttrib(t,s),o=r.name;let a=1;r.type===i.FLOAT_MAT2&&(a=2),r.type===i.FLOAT_MAT3&&(a=3),r.type===i.FLOAT_MAT4&&(a=4),e[o]={type:r.type,location:i.getAttribLocation(t,o),locationSize:a}}return e}function as(i){return i!==""}function kc(i,t){const e=t.numSpotLightShadows+t.numSpotLightMaps-t.numSpotLightShadowsWithMaps;return i.replace(/NUM_DIR_LIGHTS/g,t.numDirLights).replace(/NUM_SPOT_LIGHTS/g,t.numSpotLights).replace(/NUM_SPOT_LIGHT_MAPS/g,t.numSpotLightMaps).replace(/NUM_SPOT_LIGHT_COORDS/g,e).replace(/NUM_RECT_AREA_LIGHTS/g,t.numRectAreaLights).replace(/NUM_POINT_LIGHTS/g,t.numPointLights).replace(/NUM_HEMI_LIGHTS/g,t.numHemiLights).replace(/NUM_DIR_LIGHT_SHADOWS/g,t.numDirLightShadows).replace(/NUM_SPOT_LIGHT_SHADOWS_WITH_MAPS/g,t.numSpotLightShadowsWithMaps).replace(/NUM_SPOT_LIGHT_SHADOWS/g,t.numSpotLightShadows).replace(/NUM_POINT_LIGHT_SHADOWS/g,t.numPointLightShadows)}function Fc(i,t){return i.replace(/NUM_CLIPPING_PLANES/g,t.numClippingPlanes).replace(/UNION_CLIPPING_PLANES/g,t.numClippingPlanes-t.numClipIntersection)}const cg=/^[ \t]*#include +<([\w\d./]+)>/gm;function ca(i){return i.replace(cg,hg)}const lg=new Map;function hg(i,t){let e=Ht[t];if(e===void 0){const n=lg.get(t);if(n!==void 0)e=Ht[n],console.warn('THREE.WebGLRenderer: Shader chunk "%s" has been deprecated. Use "%s" instead.',t,n);else throw new Error("Can not resolve #include <"+t+">")}return ca(e)}const ug=/#pragma unroll_loop_start\s+for\s*\(\s*int\s+i\s*=\s*(\d+)\s*;\s*i\s*<\s*(\d+)\s*;\s*i\s*\+\+\s*\)\s*{([\s\S]+?)}\s+#pragma unroll_loop_end/g;function Oc(i){return i.replace(ug,dg)}function dg(i,t,e,n){let s="";for(let r=parseInt(t);r<parseInt(e);r++)s+=n.replace(/\[\s*i\s*\]/g,"[ "+r+" ]").replace(/UNROLLED_LOOP_INDEX/g,r);return s}function Bc(i){let t=`precision ${i.precision} float;
	precision ${i.precision} int;
	precision ${i.precision} sampler2D;
	precision ${i.precision} samplerCube;
	precision ${i.precision} sampler3D;
	precision ${i.precision} sampler2DArray;
	precision ${i.precision} sampler2DShadow;
	precision ${i.precision} samplerCubeShadow;
	precision ${i.precision} sampler2DArrayShadow;
	precision ${i.precision} isampler2D;
	precision ${i.precision} isampler3D;
	precision ${i.precision} isamplerCube;
	precision ${i.precision} isampler2DArray;
	precision ${i.precision} usampler2D;
	precision ${i.precision} usampler3D;
	precision ${i.precision} usamplerCube;
	precision ${i.precision} usampler2DArray;
	`;return i.precision==="highp"?t+=`
#define HIGH_PRECISION`:i.precision==="mediump"?t+=`
#define MEDIUM_PRECISION`:i.precision==="lowp"&&(t+=`
#define LOW_PRECISION`),t}function fg(i){let t="SHADOWMAP_TYPE_BASIC";return i.shadowMapType===El?t="SHADOWMAP_TYPE_PCF":i.shadowMapType===Fh?t="SHADOWMAP_TYPE_PCF_SOFT":i.shadowMapType===vn&&(t="SHADOWMAP_TYPE_VSM"),t}function pg(i){let t="ENVMAP_TYPE_CUBE";if(i.envMap)switch(i.envMapMode){case Vi:case Gi:t="ENVMAP_TYPE_CUBE";break;case yr:t="ENVMAP_TYPE_CUBE_UV";break}return t}function mg(i){let t="ENVMAP_MODE_REFLECTION";if(i.envMap)switch(i.envMapMode){case Gi:t="ENVMAP_MODE_REFRACTION";break}return t}function gg(i){let t="ENVMAP_BLENDING_NONE";if(i.envMap)switch(i.combine){case Tl:t="ENVMAP_BLENDING_MULTIPLY";break;case nu:t="ENVMAP_BLENDING_MIX";break;case iu:t="ENVMAP_BLENDING_ADD";break}return t}function _g(i){const t=i.envMapCubeUVHeight;if(t===null)return null;const e=Math.log2(t)-2,n=1/t;return{texelWidth:1/(3*Math.max(Math.pow(2,e),7*16)),texelHeight:n,maxMip:e}}function vg(i,t,e,n){const s=i.getContext(),r=e.defines;let o=e.vertexShader,a=e.fragmentShader;const c=fg(e),l=pg(e),h=mg(e),d=gg(e),u=_g(e),f=rg(e),g=og(r),_=s.createProgram();let p,m,w=e.glslVersion?"#version "+e.glslVersion+`
`:"";e.isRawShaderMaterial?(p=["#define SHADER_TYPE "+e.shaderType,"#define SHADER_NAME "+e.shaderName,g].filter(as).join(`
`),p.length>0&&(p+=`
`),m=["#define SHADER_TYPE "+e.shaderType,"#define SHADER_NAME "+e.shaderName,g].filter(as).join(`
`),m.length>0&&(m+=`
`)):(p=[Bc(e),"#define SHADER_TYPE "+e.shaderType,"#define SHADER_NAME "+e.shaderName,g,e.extensionClipCullDistance?"#define USE_CLIP_DISTANCE":"",e.batching?"#define USE_BATCHING":"",e.batchingColor?"#define USE_BATCHING_COLOR":"",e.instancing?"#define USE_INSTANCING":"",e.instancingColor?"#define USE_INSTANCING_COLOR":"",e.instancingMorph?"#define USE_INSTANCING_MORPH":"",e.useFog&&e.fog?"#define USE_FOG":"",e.useFog&&e.fogExp2?"#define FOG_EXP2":"",e.map?"#define USE_MAP":"",e.envMap?"#define USE_ENVMAP":"",e.envMap?"#define "+h:"",e.lightMap?"#define USE_LIGHTMAP":"",e.aoMap?"#define USE_AOMAP":"",e.bumpMap?"#define USE_BUMPMAP":"",e.normalMap?"#define USE_NORMALMAP":"",e.normalMapObjectSpace?"#define USE_NORMALMAP_OBJECTSPACE":"",e.normalMapTangentSpace?"#define USE_NORMALMAP_TANGENTSPACE":"",e.displacementMap?"#define USE_DISPLACEMENTMAP":"",e.emissiveMap?"#define USE_EMISSIVEMAP":"",e.anisotropy?"#define USE_ANISOTROPY":"",e.anisotropyMap?"#define USE_ANISOTROPYMAP":"",e.clearcoatMap?"#define USE_CLEARCOATMAP":"",e.clearcoatRoughnessMap?"#define USE_CLEARCOAT_ROUGHNESSMAP":"",e.clearcoatNormalMap?"#define USE_CLEARCOAT_NORMALMAP":"",e.iridescenceMap?"#define USE_IRIDESCENCEMAP":"",e.iridescenceThicknessMap?"#define USE_IRIDESCENCE_THICKNESSMAP":"",e.specularMap?"#define USE_SPECULARMAP":"",e.specularColorMap?"#define USE_SPECULAR_COLORMAP":"",e.specularIntensityMap?"#define USE_SPECULAR_INTENSITYMAP":"",e.roughnessMap?"#define USE_ROUGHNESSMAP":"",e.metalnessMap?"#define USE_METALNESSMAP":"",e.alphaMap?"#define USE_ALPHAMAP":"",e.alphaHash?"#define USE_ALPHAHASH":"",e.transmission?"#define USE_TRANSMISSION":"",e.transmissionMap?"#define USE_TRANSMISSIONMAP":"",e.thicknessMap?"#define USE_THICKNESSMAP":"",e.sheenColorMap?"#define USE_SHEEN_COLORMAP":"",e.sheenRoughnessMap?"#define USE_SHEEN_ROUGHNESSMAP":"",e.mapUv?"#define MAP_UV "+e.mapUv:"",e.alphaMapUv?"#define ALPHAMAP_UV "+e.alphaMapUv:"",e.lightMapUv?"#define LIGHTMAP_UV "+e.lightMapUv:"",e.aoMapUv?"#define AOMAP_UV "+e.aoMapUv:"",e.emissiveMapUv?"#define EMISSIVEMAP_UV "+e.emissiveMapUv:"",e.bumpMapUv?"#define BUMPMAP_UV "+e.bumpMapUv:"",e.normalMapUv?"#define NORMALMAP_UV "+e.normalMapUv:"",e.displacementMapUv?"#define DISPLACEMENTMAP_UV "+e.displacementMapUv:"",e.metalnessMapUv?"#define METALNESSMAP_UV "+e.metalnessMapUv:"",e.roughnessMapUv?"#define ROUGHNESSMAP_UV "+e.roughnessMapUv:"",e.anisotropyMapUv?"#define ANISOTROPYMAP_UV "+e.anisotropyMapUv:"",e.clearcoatMapUv?"#define CLEARCOATMAP_UV "+e.clearcoatMapUv:"",e.clearcoatNormalMapUv?"#define CLEARCOAT_NORMALMAP_UV "+e.clearcoatNormalMapUv:"",e.clearcoatRoughnessMapUv?"#define CLEARCOAT_ROUGHNESSMAP_UV "+e.clearcoatRoughnessMapUv:"",e.iridescenceMapUv?"#define IRIDESCENCEMAP_UV "+e.iridescenceMapUv:"",e.iridescenceThicknessMapUv?"#define IRIDESCENCE_THICKNESSMAP_UV "+e.iridescenceThicknessMapUv:"",e.sheenColorMapUv?"#define SHEEN_COLORMAP_UV "+e.sheenColorMapUv:"",e.sheenRoughnessMapUv?"#define SHEEN_ROUGHNESSMAP_UV "+e.sheenRoughnessMapUv:"",e.specularMapUv?"#define SPECULARMAP_UV "+e.specularMapUv:"",e.specularColorMapUv?"#define SPECULAR_COLORMAP_UV "+e.specularColorMapUv:"",e.specularIntensityMapUv?"#define SPECULAR_INTENSITYMAP_UV "+e.specularIntensityMapUv:"",e.transmissionMapUv?"#define TRANSMISSIONMAP_UV "+e.transmissionMapUv:"",e.thicknessMapUv?"#define THICKNESSMAP_UV "+e.thicknessMapUv:"",e.vertexTangents&&e.flatShading===!1?"#define USE_TANGENT":"",e.vertexColors?"#define USE_COLOR":"",e.vertexAlphas?"#define USE_COLOR_ALPHA":"",e.vertexUv1s?"#define USE_UV1":"",e.vertexUv2s?"#define USE_UV2":"",e.vertexUv3s?"#define USE_UV3":"",e.pointsUvs?"#define USE_POINTS_UV":"",e.flatShading?"#define FLAT_SHADED":"",e.skinning?"#define USE_SKINNING":"",e.morphTargets?"#define USE_MORPHTARGETS":"",e.morphNormals&&e.flatShading===!1?"#define USE_MORPHNORMALS":"",e.morphColors?"#define USE_MORPHCOLORS":"",e.morphTargetsCount>0?"#define MORPHTARGETS_TEXTURE_STRIDE "+e.morphTextureStride:"",e.morphTargetsCount>0?"#define MORPHTARGETS_COUNT "+e.morphTargetsCount:"",e.doubleSided?"#define DOUBLE_SIDED":"",e.flipSided?"#define FLIP_SIDED":"",e.shadowMapEnabled?"#define USE_SHADOWMAP":"",e.shadowMapEnabled?"#define "+c:"",e.sizeAttenuation?"#define USE_SIZEATTENUATION":"",e.numLightProbes>0?"#define USE_LIGHT_PROBES":"",e.logarithmicDepthBuffer?"#define USE_LOGDEPTHBUF":"",e.reverseDepthBuffer?"#define USE_REVERSEDEPTHBUF":"","uniform mat4 modelMatrix;","uniform mat4 modelViewMatrix;","uniform mat4 projectionMatrix;","uniform mat4 viewMatrix;","uniform mat3 normalMatrix;","uniform vec3 cameraPosition;","uniform bool isOrthographic;","#ifdef USE_INSTANCING","	attribute mat4 instanceMatrix;","#endif","#ifdef USE_INSTANCING_COLOR","	attribute vec3 instanceColor;","#endif","#ifdef USE_INSTANCING_MORPH","	uniform sampler2D morphTexture;","#endif","attribute vec3 position;","attribute vec3 normal;","attribute vec2 uv;","#ifdef USE_UV1","	attribute vec2 uv1;","#endif","#ifdef USE_UV2","	attribute vec2 uv2;","#endif","#ifdef USE_UV3","	attribute vec2 uv3;","#endif","#ifdef USE_TANGENT","	attribute vec4 tangent;","#endif","#if defined( USE_COLOR_ALPHA )","	attribute vec4 color;","#elif defined( USE_COLOR )","	attribute vec3 color;","#endif","#ifdef USE_SKINNING","	attribute vec4 skinIndex;","	attribute vec4 skinWeight;","#endif",`
`].filter(as).join(`
`),m=[Bc(e),"#define SHADER_TYPE "+e.shaderType,"#define SHADER_NAME "+e.shaderName,g,e.useFog&&e.fog?"#define USE_FOG":"",e.useFog&&e.fogExp2?"#define FOG_EXP2":"",e.alphaToCoverage?"#define ALPHA_TO_COVERAGE":"",e.map?"#define USE_MAP":"",e.matcap?"#define USE_MATCAP":"",e.envMap?"#define USE_ENVMAP":"",e.envMap?"#define "+l:"",e.envMap?"#define "+h:"",e.envMap?"#define "+d:"",u?"#define CUBEUV_TEXEL_WIDTH "+u.texelWidth:"",u?"#define CUBEUV_TEXEL_HEIGHT "+u.texelHeight:"",u?"#define CUBEUV_MAX_MIP "+u.maxMip+".0":"",e.lightMap?"#define USE_LIGHTMAP":"",e.aoMap?"#define USE_AOMAP":"",e.bumpMap?"#define USE_BUMPMAP":"",e.normalMap?"#define USE_NORMALMAP":"",e.normalMapObjectSpace?"#define USE_NORMALMAP_OBJECTSPACE":"",e.normalMapTangentSpace?"#define USE_NORMALMAP_TANGENTSPACE":"",e.emissiveMap?"#define USE_EMISSIVEMAP":"",e.anisotropy?"#define USE_ANISOTROPY":"",e.anisotropyMap?"#define USE_ANISOTROPYMAP":"",e.clearcoat?"#define USE_CLEARCOAT":"",e.clearcoatMap?"#define USE_CLEARCOATMAP":"",e.clearcoatRoughnessMap?"#define USE_CLEARCOAT_ROUGHNESSMAP":"",e.clearcoatNormalMap?"#define USE_CLEARCOAT_NORMALMAP":"",e.dispersion?"#define USE_DISPERSION":"",e.iridescence?"#define USE_IRIDESCENCE":"",e.iridescenceMap?"#define USE_IRIDESCENCEMAP":"",e.iridescenceThicknessMap?"#define USE_IRIDESCENCE_THICKNESSMAP":"",e.specularMap?"#define USE_SPECULARMAP":"",e.specularColorMap?"#define USE_SPECULAR_COLORMAP":"",e.specularIntensityMap?"#define USE_SPECULAR_INTENSITYMAP":"",e.roughnessMap?"#define USE_ROUGHNESSMAP":"",e.metalnessMap?"#define USE_METALNESSMAP":"",e.alphaMap?"#define USE_ALPHAMAP":"",e.alphaTest?"#define USE_ALPHATEST":"",e.alphaHash?"#define USE_ALPHAHASH":"",e.sheen?"#define USE_SHEEN":"",e.sheenColorMap?"#define USE_SHEEN_COLORMAP":"",e.sheenRoughnessMap?"#define USE_SHEEN_ROUGHNESSMAP":"",e.transmission?"#define USE_TRANSMISSION":"",e.transmissionMap?"#define USE_TRANSMISSIONMAP":"",e.thicknessMap?"#define USE_THICKNESSMAP":"",e.vertexTangents&&e.flatShading===!1?"#define USE_TANGENT":"",e.vertexColors||e.instancingColor||e.batchingColor?"#define USE_COLOR":"",e.vertexAlphas?"#define USE_COLOR_ALPHA":"",e.vertexUv1s?"#define USE_UV1":"",e.vertexUv2s?"#define USE_UV2":"",e.vertexUv3s?"#define USE_UV3":"",e.pointsUvs?"#define USE_POINTS_UV":"",e.gradientMap?"#define USE_GRADIENTMAP":"",e.flatShading?"#define FLAT_SHADED":"",e.doubleSided?"#define DOUBLE_SIDED":"",e.flipSided?"#define FLIP_SIDED":"",e.shadowMapEnabled?"#define USE_SHADOWMAP":"",e.shadowMapEnabled?"#define "+c:"",e.premultipliedAlpha?"#define PREMULTIPLIED_ALPHA":"",e.numLightProbes>0?"#define USE_LIGHT_PROBES":"",e.decodeVideoTexture?"#define DECODE_VIDEO_TEXTURE":"",e.logarithmicDepthBuffer?"#define USE_LOGDEPTHBUF":"",e.reverseDepthBuffer?"#define USE_REVERSEDEPTHBUF":"","uniform mat4 viewMatrix;","uniform vec3 cameraPosition;","uniform bool isOrthographic;",e.toneMapping!==On?"#define TONE_MAPPING":"",e.toneMapping!==On?Ht.tonemapping_pars_fragment:"",e.toneMapping!==On?ig("toneMapping",e.toneMapping):"",e.dithering?"#define DITHERING":"",e.opaque?"#define OPAQUE":"",Ht.colorspace_pars_fragment,ng("linearToOutputTexel",e.outputColorSpace),sg(),e.useDepthPacking?"#define DEPTH_PACKING "+e.depthPacking:"",`
`].filter(as).join(`
`)),o=ca(o),o=kc(o,e),o=Fc(o,e),a=ca(a),a=kc(a,e),a=Fc(a,e),o=Oc(o),a=Oc(a),e.isRawShaderMaterial!==!0&&(w=`#version 300 es
`,p=[f,"#define attribute in","#define varying out","#define texture2D texture"].join(`
`)+`
`+p,m=["#define varying in",e.glslVersion===nc?"":"layout(location = 0) out highp vec4 pc_fragColor;",e.glslVersion===nc?"":"#define gl_FragColor pc_fragColor","#define gl_FragDepthEXT gl_FragDepth","#define texture2D texture","#define textureCube texture","#define texture2DProj textureProj","#define texture2DLodEXT textureLod","#define texture2DProjLodEXT textureProjLod","#define textureCubeLodEXT textureLod","#define texture2DGradEXT textureGrad","#define texture2DProjGradEXT textureProjGrad","#define textureCubeGradEXT textureGrad"].join(`
`)+`
`+m);const x=w+p+o,b=w+m+a,I=Uc(s,s.VERTEX_SHADER,x),R=Uc(s,s.FRAGMENT_SHADER,b);s.attachShader(_,I),s.attachShader(_,R),e.index0AttributeName!==void 0?s.bindAttribLocation(_,0,e.index0AttributeName):e.morphTargets===!0&&s.bindAttribLocation(_,0,"position"),s.linkProgram(_);function A(S){if(i.debug.checkShaderErrors){const F=s.getProgramInfoLog(_).trim(),N=s.getShaderInfoLog(I).trim(),H=s.getShaderInfoLog(R).trim();let X=!0,z=!0;if(s.getProgramParameter(_,s.LINK_STATUS)===!1)if(X=!1,typeof i.debug.onShaderError=="function")i.debug.onShaderError(s,_,I,R);else{const J=Nc(s,I,"vertex"),G=Nc(s,R,"fragment");console.error("THREE.WebGLProgram: Shader Error "+s.getError()+" - VALIDATE_STATUS "+s.getProgramParameter(_,s.VALIDATE_STATUS)+`

Material Name: `+S.name+`
Material Type: `+S.type+`

Program Info Log: `+F+`
`+J+`
`+G)}else F!==""?console.warn("THREE.WebGLProgram: Program Info Log:",F):(N===""||H==="")&&(z=!1);z&&(S.diagnostics={runnable:X,programLog:F,vertexShader:{log:N,prefix:p},fragmentShader:{log:H,prefix:m}})}s.deleteShader(I),s.deleteShader(R),P=new hr(s,_),W=ag(s,_)}let P;this.getUniforms=function(){return P===void 0&&A(this),P};let W;this.getAttributes=function(){return W===void 0&&A(this),W};let v=e.rendererExtensionParallelShaderCompile===!1;return this.isReady=function(){return v===!1&&(v=s.getProgramParameter(_,Jm)),v},this.destroy=function(){n.releaseStatesOfProgram(this),s.deleteProgram(_),this.program=void 0},this.type=e.shaderType,this.name=e.shaderName,this.id=Qm++,this.cacheKey=t,this.usedTimes=1,this.program=_,this.vertexShader=I,this.fragmentShader=R,this}let xg=0;class yg{constructor(){this.shaderCache=new Map,this.materialCache=new Map}update(t){const e=t.vertexShader,n=t.fragmentShader,s=this._getShaderStage(e),r=this._getShaderStage(n),o=this._getShaderCacheForMaterial(t);return o.has(s)===!1&&(o.add(s),s.usedTimes++),o.has(r)===!1&&(o.add(r),r.usedTimes++),this}remove(t){const e=this.materialCache.get(t);for(const n of e)n.usedTimes--,n.usedTimes===0&&this.shaderCache.delete(n.code);return this.materialCache.delete(t),this}getVertexShaderID(t){return this._getShaderStage(t.vertexShader).id}getFragmentShaderID(t){return this._getShaderStage(t.fragmentShader).id}dispose(){this.shaderCache.clear(),this.materialCache.clear()}_getShaderCacheForMaterial(t){const e=this.materialCache;let n=e.get(t);return n===void 0&&(n=new Set,e.set(t,n)),n}_getShaderStage(t){const e=this.shaderCache;let n=e.get(t);return n===void 0&&(n=new Mg(t),e.set(t,n)),n}}class Mg{constructor(t){this.id=xg++,this.code=t,this.usedTimes=0}}function Sg(i,t,e,n,s,r,o){const a=new Ca,c=new yg,l=new Set,h=[],d=s.logarithmicDepthBuffer,u=s.reverseDepthBuffer,f=s.vertexTextures;let g=s.precision;const _={MeshDepthMaterial:"depth",MeshDistanceMaterial:"distanceRGBA",MeshNormalMaterial:"normal",MeshBasicMaterial:"basic",MeshLambertMaterial:"lambert",MeshPhongMaterial:"phong",MeshToonMaterial:"toon",MeshStandardMaterial:"physical",MeshPhysicalMaterial:"physical",MeshMatcapMaterial:"matcap",LineBasicMaterial:"basic",LineDashedMaterial:"dashed",PointsMaterial:"points",ShadowMaterial:"shadow",SpriteMaterial:"sprite"};function p(v){return l.add(v),v===0?"uv":`uv${v}`}function m(v,S,F,N,H){const X=N.fog,z=H.geometry,J=v.isMeshStandardMaterial?N.environment:null,G=(v.isMeshStandardMaterial?e:t).get(v.envMap||J),ht=G&&G.mapping===yr?G.image.height:null,ft=_[v.type];v.precision!==null&&(g=s.getMaxPrecision(v.precision),g!==v.precision&&console.warn("THREE.WebGLProgram.getParameters:",v.precision,"not supported, using",g,"instead."));const pt=z.morphAttributes.position||z.morphAttributes.normal||z.morphAttributes.color,$t=pt!==void 0?pt.length:0;let jt=0;z.morphAttributes.position!==void 0&&(jt=1),z.morphAttributes.normal!==void 0&&(jt=2),z.morphAttributes.color!==void 0&&(jt=3);let $,tt,yt,lt;if(ft){const Le=ln[ft];$=Le.vertexShader,tt=Le.fragmentShader}else $=v.vertexShader,tt=v.fragmentShader,c.update(v),yt=c.getVertexShaderID(v),lt=c.getFragmentShaderID(v);const It=i.getRenderTarget(),Dt=H.isInstancedMesh===!0,Ot=H.isBatchedMesh===!0,Gt=!!v.map,K=!!v.matcap,T=!!G,rt=!!v.aoMap,st=!!v.lightMap,Q=!!v.bumpMap,ot=!!v.normalMap,Ct=!!v.displacementMap,mt=!!v.emissiveMap,E=!!v.metalnessMap,y=!!v.roughnessMap,k=v.anisotropy>0,q=v.clearcoat>0,Z=v.dispersion>0,Y=v.iridescence>0,bt=v.sheen>0,at=v.transmission>0,vt=k&&!!v.anisotropyMap,Yt=q&&!!v.clearcoatMap,et=q&&!!v.clearcoatNormalMap,xt=q&&!!v.clearcoatRoughnessMap,kt=Y&&!!v.iridescenceMap,Ft=Y&&!!v.iridescenceThicknessMap,Mt=bt&&!!v.sheenColorMap,Kt=bt&&!!v.sheenRoughnessMap,Bt=!!v.specularMap,oe=!!v.specularColorMap,L=!!v.specularIntensityMap,gt=at&&!!v.transmissionMap,V=at&&!!v.thicknessMap,j=!!v.gradientMap,ut=!!v.alphaMap,_t=v.alphaTest>0,Zt=!!v.alphaHash,pe=!!v.extensions;let Pe=On;v.toneMapped&&(It===null||It.isXRRenderTarget===!0)&&(Pe=i.toneMapping);const Jt={shaderID:ft,shaderType:v.type,shaderName:v.name,vertexShader:$,fragmentShader:tt,defines:v.defines,customVertexShaderID:yt,customFragmentShaderID:lt,isRawShaderMaterial:v.isRawShaderMaterial===!0,glslVersion:v.glslVersion,precision:g,batching:Ot,batchingColor:Ot&&H._colorsTexture!==null,instancing:Dt,instancingColor:Dt&&H.instanceColor!==null,instancingMorph:Dt&&H.morphTexture!==null,supportsVertexTextures:f,outputColorSpace:It===null?i.outputColorSpace:It.isXRRenderTarget===!0?It.texture.colorSpace:Xn,alphaToCoverage:!!v.alphaToCoverage,map:Gt,matcap:K,envMap:T,envMapMode:T&&G.mapping,envMapCubeUVHeight:ht,aoMap:rt,lightMap:st,bumpMap:Q,normalMap:ot,displacementMap:f&&Ct,emissiveMap:mt,normalMapObjectSpace:ot&&v.normalMapType===fu,normalMapTangentSpace:ot&&v.normalMapType===Ol,metalnessMap:E,roughnessMap:y,anisotropy:k,anisotropyMap:vt,clearcoat:q,clearcoatMap:Yt,clearcoatNormalMap:et,clearcoatRoughnessMap:xt,dispersion:Z,iridescence:Y,iridescenceMap:kt,iridescenceThicknessMap:Ft,sheen:bt,sheenColorMap:Mt,sheenRoughnessMap:Kt,specularMap:Bt,specularColorMap:oe,specularIntensityMap:L,transmission:at,transmissionMap:gt,thicknessMap:V,gradientMap:j,opaque:v.transparent===!1&&v.blending===ki&&v.alphaToCoverage===!1,alphaMap:ut,alphaTest:_t,alphaHash:Zt,combine:v.combine,mapUv:Gt&&p(v.map.channel),aoMapUv:rt&&p(v.aoMap.channel),lightMapUv:st&&p(v.lightMap.channel),bumpMapUv:Q&&p(v.bumpMap.channel),normalMapUv:ot&&p(v.normalMap.channel),displacementMapUv:Ct&&p(v.displacementMap.channel),emissiveMapUv:mt&&p(v.emissiveMap.channel),metalnessMapUv:E&&p(v.metalnessMap.channel),roughnessMapUv:y&&p(v.roughnessMap.channel),anisotropyMapUv:vt&&p(v.anisotropyMap.channel),clearcoatMapUv:Yt&&p(v.clearcoatMap.channel),clearcoatNormalMapUv:et&&p(v.clearcoatNormalMap.channel),clearcoatRoughnessMapUv:xt&&p(v.clearcoatRoughnessMap.channel),iridescenceMapUv:kt&&p(v.iridescenceMap.channel),iridescenceThicknessMapUv:Ft&&p(v.iridescenceThicknessMap.channel),sheenColorMapUv:Mt&&p(v.sheenColorMap.channel),sheenRoughnessMapUv:Kt&&p(v.sheenRoughnessMap.channel),specularMapUv:Bt&&p(v.specularMap.channel),specularColorMapUv:oe&&p(v.specularColorMap.channel),specularIntensityMapUv:L&&p(v.specularIntensityMap.channel),transmissionMapUv:gt&&p(v.transmissionMap.channel),thicknessMapUv:V&&p(v.thicknessMap.channel),alphaMapUv:ut&&p(v.alphaMap.channel),vertexTangents:!!z.attributes.tangent&&(ot||k),vertexColors:v.vertexColors,vertexAlphas:v.vertexColors===!0&&!!z.attributes.color&&z.attributes.color.itemSize===4,pointsUvs:H.isPoints===!0&&!!z.attributes.uv&&(Gt||ut),fog:!!X,useFog:v.fog===!0,fogExp2:!!X&&X.isFogExp2,flatShading:v.flatShading===!0,sizeAttenuation:v.sizeAttenuation===!0,logarithmicDepthBuffer:d,reverseDepthBuffer:u,skinning:H.isSkinnedMesh===!0,morphTargets:z.morphAttributes.position!==void 0,morphNormals:z.morphAttributes.normal!==void 0,morphColors:z.morphAttributes.color!==void 0,morphTargetsCount:$t,morphTextureStride:jt,numDirLights:S.directional.length,numPointLights:S.point.length,numSpotLights:S.spot.length,numSpotLightMaps:S.spotLightMap.length,numRectAreaLights:S.rectArea.length,numHemiLights:S.hemi.length,numDirLightShadows:S.directionalShadowMap.length,numPointLightShadows:S.pointShadowMap.length,numSpotLightShadows:S.spotShadowMap.length,numSpotLightShadowsWithMaps:S.numSpotLightShadowsWithMaps,numLightProbes:S.numLightProbes,numClippingPlanes:o.numPlanes,numClipIntersection:o.numIntersection,dithering:v.dithering,shadowMapEnabled:i.shadowMap.enabled&&F.length>0,shadowMapType:i.shadowMap.type,toneMapping:Pe,decodeVideoTexture:Gt&&v.map.isVideoTexture===!0&&ee.getTransfer(v.map.colorSpace)===le,premultipliedAlpha:v.premultipliedAlpha,doubleSided:v.side===qe,flipSided:v.side===Re,useDepthPacking:v.depthPacking>=0,depthPacking:v.depthPacking||0,index0AttributeName:v.index0AttributeName,extensionClipCullDistance:pe&&v.extensions.clipCullDistance===!0&&n.has("WEBGL_clip_cull_distance"),extensionMultiDraw:(pe&&v.extensions.multiDraw===!0||Ot)&&n.has("WEBGL_multi_draw"),rendererExtensionParallelShaderCompile:n.has("KHR_parallel_shader_compile"),customProgramCacheKey:v.customProgramCacheKey()};return Jt.vertexUv1s=l.has(1),Jt.vertexUv2s=l.has(2),Jt.vertexUv3s=l.has(3),l.clear(),Jt}function w(v){const S=[];if(v.shaderID?S.push(v.shaderID):(S.push(v.customVertexShaderID),S.push(v.customFragmentShaderID)),v.defines!==void 0)for(const F in v.defines)S.push(F),S.push(v.defines[F]);return v.isRawShaderMaterial===!1&&(x(S,v),b(S,v),S.push(i.outputColorSpace)),S.push(v.customProgramCacheKey),S.join()}function x(v,S){v.push(S.precision),v.push(S.outputColorSpace),v.push(S.envMapMode),v.push(S.envMapCubeUVHeight),v.push(S.mapUv),v.push(S.alphaMapUv),v.push(S.lightMapUv),v.push(S.aoMapUv),v.push(S.bumpMapUv),v.push(S.normalMapUv),v.push(S.displacementMapUv),v.push(S.emissiveMapUv),v.push(S.metalnessMapUv),v.push(S.roughnessMapUv),v.push(S.anisotropyMapUv),v.push(S.clearcoatMapUv),v.push(S.clearcoatNormalMapUv),v.push(S.clearcoatRoughnessMapUv),v.push(S.iridescenceMapUv),v.push(S.iridescenceThicknessMapUv),v.push(S.sheenColorMapUv),v.push(S.sheenRoughnessMapUv),v.push(S.specularMapUv),v.push(S.specularColorMapUv),v.push(S.specularIntensityMapUv),v.push(S.transmissionMapUv),v.push(S.thicknessMapUv),v.push(S.combine),v.push(S.fogExp2),v.push(S.sizeAttenuation),v.push(S.morphTargetsCount),v.push(S.morphAttributeCount),v.push(S.numDirLights),v.push(S.numPointLights),v.push(S.numSpotLights),v.push(S.numSpotLightMaps),v.push(S.numHemiLights),v.push(S.numRectAreaLights),v.push(S.numDirLightShadows),v.push(S.numPointLightShadows),v.push(S.numSpotLightShadows),v.push(S.numSpotLightShadowsWithMaps),v.push(S.numLightProbes),v.push(S.shadowMapType),v.push(S.toneMapping),v.push(S.numClippingPlanes),v.push(S.numClipIntersection),v.push(S.depthPacking)}function b(v,S){a.disableAll(),S.supportsVertexTextures&&a.enable(0),S.instancing&&a.enable(1),S.instancingColor&&a.enable(2),S.instancingMorph&&a.enable(3),S.matcap&&a.enable(4),S.envMap&&a.enable(5),S.normalMapObjectSpace&&a.enable(6),S.normalMapTangentSpace&&a.enable(7),S.clearcoat&&a.enable(8),S.iridescence&&a.enable(9),S.alphaTest&&a.enable(10),S.vertexColors&&a.enable(11),S.vertexAlphas&&a.enable(12),S.vertexUv1s&&a.enable(13),S.vertexUv2s&&a.enable(14),S.vertexUv3s&&a.enable(15),S.vertexTangents&&a.enable(16),S.anisotropy&&a.enable(17),S.alphaHash&&a.enable(18),S.batching&&a.enable(19),S.dispersion&&a.enable(20),S.batchingColor&&a.enable(21),v.push(a.mask),a.disableAll(),S.fog&&a.enable(0),S.useFog&&a.enable(1),S.flatShading&&a.enable(2),S.logarithmicDepthBuffer&&a.enable(3),S.reverseDepthBuffer&&a.enable(4),S.skinning&&a.enable(5),S.morphTargets&&a.enable(6),S.morphNormals&&a.enable(7),S.morphColors&&a.enable(8),S.premultipliedAlpha&&a.enable(9),S.shadowMapEnabled&&a.enable(10),S.doubleSided&&a.enable(11),S.flipSided&&a.enable(12),S.useDepthPacking&&a.enable(13),S.dithering&&a.enable(14),S.transmission&&a.enable(15),S.sheen&&a.enable(16),S.opaque&&a.enable(17),S.pointsUvs&&a.enable(18),S.decodeVideoTexture&&a.enable(19),S.alphaToCoverage&&a.enable(20),v.push(a.mask)}function I(v){const S=_[v.type];let F;if(S){const N=ln[S];F=sd.clone(N.uniforms)}else F=v.uniforms;return F}function R(v,S){let F;for(let N=0,H=h.length;N<H;N++){const X=h[N];if(X.cacheKey===S){F=X,++F.usedTimes;break}}return F===void 0&&(F=new vg(i,S,v,r),h.push(F)),F}function A(v){if(--v.usedTimes===0){const S=h.indexOf(v);h[S]=h[h.length-1],h.pop(),v.destroy()}}function P(v){c.remove(v)}function W(){c.dispose()}return{getParameters:m,getProgramCacheKey:w,getUniforms:I,acquireProgram:R,releaseProgram:A,releaseShaderCache:P,programs:h,dispose:W}}function bg(){let i=new WeakMap;function t(o){return i.has(o)}function e(o){let a=i.get(o);return a===void 0&&(a={},i.set(o,a)),a}function n(o){i.delete(o)}function s(o,a,c){i.get(o)[a]=c}function r(){i=new WeakMap}return{has:t,get:e,remove:n,update:s,dispose:r}}function Eg(i,t){return i.groupOrder!==t.groupOrder?i.groupOrder-t.groupOrder:i.renderOrder!==t.renderOrder?i.renderOrder-t.renderOrder:i.material.id!==t.material.id?i.material.id-t.material.id:i.z!==t.z?i.z-t.z:i.id-t.id}function zc(i,t){return i.groupOrder!==t.groupOrder?i.groupOrder-t.groupOrder:i.renderOrder!==t.renderOrder?i.renderOrder-t.renderOrder:i.z!==t.z?t.z-i.z:i.id-t.id}function Hc(){const i=[];let t=0;const e=[],n=[],s=[];function r(){t=0,e.length=0,n.length=0,s.length=0}function o(d,u,f,g,_,p){let m=i[t];return m===void 0?(m={id:d.id,object:d,geometry:u,material:f,groupOrder:g,renderOrder:d.renderOrder,z:_,group:p},i[t]=m):(m.id=d.id,m.object=d,m.geometry=u,m.material=f,m.groupOrder=g,m.renderOrder=d.renderOrder,m.z=_,m.group=p),t++,m}function a(d,u,f,g,_,p){const m=o(d,u,f,g,_,p);f.transmission>0?n.push(m):f.transparent===!0?s.push(m):e.push(m)}function c(d,u,f,g,_,p){const m=o(d,u,f,g,_,p);f.transmission>0?n.unshift(m):f.transparent===!0?s.unshift(m):e.unshift(m)}function l(d,u){e.length>1&&e.sort(d||Eg),n.length>1&&n.sort(u||zc),s.length>1&&s.sort(u||zc)}function h(){for(let d=t,u=i.length;d<u;d++){const f=i[d];if(f.id===null)break;f.id=null,f.object=null,f.geometry=null,f.material=null,f.group=null}}return{opaque:e,transmissive:n,transparent:s,init:r,push:a,unshift:c,finish:h,sort:l}}function Tg(){let i=new WeakMap;function t(n,s){const r=i.get(n);let o;return r===void 0?(o=new Hc,i.set(n,[o])):s>=r.length?(o=new Hc,r.push(o)):o=r[s],o}function e(){i=new WeakMap}return{get:t,dispose:e}}function wg(){const i={};return{get:function(t){if(i[t.id]!==void 0)return i[t.id];let e;switch(t.type){case"DirectionalLight":e={direction:new C,color:new Xt};break;case"SpotLight":e={position:new C,direction:new C,color:new Xt,distance:0,coneCos:0,penumbraCos:0,decay:0};break;case"PointLight":e={position:new C,color:new Xt,distance:0,decay:0};break;case"HemisphereLight":e={direction:new C,skyColor:new Xt,groundColor:new Xt};break;case"RectAreaLight":e={color:new Xt,position:new C,halfWidth:new C,halfHeight:new C};break}return i[t.id]=e,e}}}function Ag(){const i={};return{get:function(t){if(i[t.id]!==void 0)return i[t.id];let e;switch(t.type){case"DirectionalLight":e={shadowIntensity:1,shadowBias:0,shadowNormalBias:0,shadowRadius:1,shadowMapSize:new nt};break;case"SpotLight":e={shadowIntensity:1,shadowBias:0,shadowNormalBias:0,shadowRadius:1,shadowMapSize:new nt};break;case"PointLight":e={shadowIntensity:1,shadowBias:0,shadowNormalBias:0,shadowRadius:1,shadowMapSize:new nt,shadowCameraNear:1,shadowCameraFar:1e3};break}return i[t.id]=e,e}}}let Cg=0;function Rg(i,t){return(t.castShadow?2:0)-(i.castShadow?2:0)+(t.map?1:0)-(i.map?1:0)}function Pg(i){const t=new wg,e=Ag(),n={version:0,hash:{directionalLength:-1,pointLength:-1,spotLength:-1,rectAreaLength:-1,hemiLength:-1,numDirectionalShadows:-1,numPointShadows:-1,numSpotShadows:-1,numSpotMaps:-1,numLightProbes:-1},ambient:[0,0,0],probe:[],directional:[],directionalShadow:[],directionalShadowMap:[],directionalShadowMatrix:[],spot:[],spotLightMap:[],spotShadow:[],spotShadowMap:[],spotLightMatrix:[],rectArea:[],rectAreaLTC1:null,rectAreaLTC2:null,point:[],pointShadow:[],pointShadowMap:[],pointShadowMatrix:[],hemi:[],numSpotLightShadowsWithMaps:0,numLightProbes:0};for(let l=0;l<9;l++)n.probe.push(new C);const s=new C,r=new re,o=new re;function a(l){let h=0,d=0,u=0;for(let W=0;W<9;W++)n.probe[W].set(0,0,0);let f=0,g=0,_=0,p=0,m=0,w=0,x=0,b=0,I=0,R=0,A=0;l.sort(Rg);for(let W=0,v=l.length;W<v;W++){const S=l[W],F=S.color,N=S.intensity,H=S.distance,X=S.shadow&&S.shadow.map?S.shadow.map.texture:null;if(S.isAmbientLight)h+=F.r*N,d+=F.g*N,u+=F.b*N;else if(S.isLightProbe){for(let z=0;z<9;z++)n.probe[z].addScaledVector(S.sh.coefficients[z],N);A++}else if(S.isDirectionalLight){const z=t.get(S);if(z.color.copy(S.color).multiplyScalar(S.intensity),S.castShadow){const J=S.shadow,G=e.get(S);G.shadowIntensity=J.intensity,G.shadowBias=J.bias,G.shadowNormalBias=J.normalBias,G.shadowRadius=J.radius,G.shadowMapSize=J.mapSize,n.directionalShadow[f]=G,n.directionalShadowMap[f]=X,n.directionalShadowMatrix[f]=S.shadow.matrix,w++}n.directional[f]=z,f++}else if(S.isSpotLight){const z=t.get(S);z.position.setFromMatrixPosition(S.matrixWorld),z.color.copy(F).multiplyScalar(N),z.distance=H,z.coneCos=Math.cos(S.angle),z.penumbraCos=Math.cos(S.angle*(1-S.penumbra)),z.decay=S.decay,n.spot[_]=z;const J=S.shadow;if(S.map&&(n.spotLightMap[I]=S.map,I++,J.updateMatrices(S),S.castShadow&&R++),n.spotLightMatrix[_]=J.matrix,S.castShadow){const G=e.get(S);G.shadowIntensity=J.intensity,G.shadowBias=J.bias,G.shadowNormalBias=J.normalBias,G.shadowRadius=J.radius,G.shadowMapSize=J.mapSize,n.spotShadow[_]=G,n.spotShadowMap[_]=X,b++}_++}else if(S.isRectAreaLight){const z=t.get(S);z.color.copy(F).multiplyScalar(N),z.halfWidth.set(S.width*.5,0,0),z.halfHeight.set(0,S.height*.5,0),n.rectArea[p]=z,p++}else if(S.isPointLight){const z=t.get(S);if(z.color.copy(S.color).multiplyScalar(S.intensity),z.distance=S.distance,z.decay=S.decay,S.castShadow){const J=S.shadow,G=e.get(S);G.shadowIntensity=J.intensity,G.shadowBias=J.bias,G.shadowNormalBias=J.normalBias,G.shadowRadius=J.radius,G.shadowMapSize=J.mapSize,G.shadowCameraNear=J.camera.near,G.shadowCameraFar=J.camera.far,n.pointShadow[g]=G,n.pointShadowMap[g]=X,n.pointShadowMatrix[g]=S.shadow.matrix,x++}n.point[g]=z,g++}else if(S.isHemisphereLight){const z=t.get(S);z.skyColor.copy(S.color).multiplyScalar(N),z.groundColor.copy(S.groundColor).multiplyScalar(N),n.hemi[m]=z,m++}}p>0&&(i.has("OES_texture_float_linear")===!0?(n.rectAreaLTC1=ct.LTC_FLOAT_1,n.rectAreaLTC2=ct.LTC_FLOAT_2):(n.rectAreaLTC1=ct.LTC_HALF_1,n.rectAreaLTC2=ct.LTC_HALF_2)),n.ambient[0]=h,n.ambient[1]=d,n.ambient[2]=u;const P=n.hash;(P.directionalLength!==f||P.pointLength!==g||P.spotLength!==_||P.rectAreaLength!==p||P.hemiLength!==m||P.numDirectionalShadows!==w||P.numPointShadows!==x||P.numSpotShadows!==b||P.numSpotMaps!==I||P.numLightProbes!==A)&&(n.directional.length=f,n.spot.length=_,n.rectArea.length=p,n.point.length=g,n.hemi.length=m,n.directionalShadow.length=w,n.directionalShadowMap.length=w,n.pointShadow.length=x,n.pointShadowMap.length=x,n.spotShadow.length=b,n.spotShadowMap.length=b,n.directionalShadowMatrix.length=w,n.pointShadowMatrix.length=x,n.spotLightMatrix.length=b+I-R,n.spotLightMap.length=I,n.numSpotLightShadowsWithMaps=R,n.numLightProbes=A,P.directionalLength=f,P.pointLength=g,P.spotLength=_,P.rectAreaLength=p,P.hemiLength=m,P.numDirectionalShadows=w,P.numPointShadows=x,P.numSpotShadows=b,P.numSpotMaps=I,P.numLightProbes=A,n.version=Cg++)}function c(l,h){let d=0,u=0,f=0,g=0,_=0;const p=h.matrixWorldInverse;for(let m=0,w=l.length;m<w;m++){const x=l[m];if(x.isDirectionalLight){const b=n.directional[d];b.direction.setFromMatrixPosition(x.matrixWorld),s.setFromMatrixPosition(x.target.matrixWorld),b.direction.sub(s),b.direction.transformDirection(p),d++}else if(x.isSpotLight){const b=n.spot[f];b.position.setFromMatrixPosition(x.matrixWorld),b.position.applyMatrix4(p),b.direction.setFromMatrixPosition(x.matrixWorld),s.setFromMatrixPosition(x.target.matrixWorld),b.direction.sub(s),b.direction.transformDirection(p),f++}else if(x.isRectAreaLight){const b=n.rectArea[g];b.position.setFromMatrixPosition(x.matrixWorld),b.position.applyMatrix4(p),o.identity(),r.copy(x.matrixWorld),r.premultiply(p),o.extractRotation(r),b.halfWidth.set(x.width*.5,0,0),b.halfHeight.set(0,x.height*.5,0),b.halfWidth.applyMatrix4(o),b.halfHeight.applyMatrix4(o),g++}else if(x.isPointLight){const b=n.point[u];b.position.setFromMatrixPosition(x.matrixWorld),b.position.applyMatrix4(p),u++}else if(x.isHemisphereLight){const b=n.hemi[_];b.direction.setFromMatrixPosition(x.matrixWorld),b.direction.transformDirection(p),_++}}}return{setup:a,setupView:c,state:n}}function Vc(i){const t=new Pg(i),e=[],n=[];function s(h){l.camera=h,e.length=0,n.length=0}function r(h){e.push(h)}function o(h){n.push(h)}function a(){t.setup(e)}function c(h){t.setupView(e,h)}const l={lightsArray:e,shadowsArray:n,camera:null,lights:t,transmissionRenderTarget:{}};return{init:s,state:l,setupLights:a,setupLightsView:c,pushLight:r,pushShadow:o}}function Lg(i){let t=new WeakMap;function e(s,r=0){const o=t.get(s);let a;return o===void 0?(a=new Vc(i),t.set(s,[a])):r>=o.length?(a=new Vc(i),o.push(a)):a=o[r],a}function n(){t=new WeakMap}return{get:e,dispose:n}}class Dg extends Ki{constructor(t){super(),this.isMeshDepthMaterial=!0,this.type="MeshDepthMaterial",this.depthPacking=uu,this.map=null,this.alphaMap=null,this.displacementMap=null,this.displacementScale=1,this.displacementBias=0,this.wireframe=!1,this.wireframeLinewidth=1,this.setValues(t)}copy(t){return super.copy(t),this.depthPacking=t.depthPacking,this.map=t.map,this.alphaMap=t.alphaMap,this.displacementMap=t.displacementMap,this.displacementScale=t.displacementScale,this.displacementBias=t.displacementBias,this.wireframe=t.wireframe,this.wireframeLinewidth=t.wireframeLinewidth,this}}class Ig extends Ki{constructor(t){super(),this.isMeshDistanceMaterial=!0,this.type="MeshDistanceMaterial",this.map=null,this.alphaMap=null,this.displacementMap=null,this.displacementScale=1,this.displacementBias=0,this.setValues(t)}copy(t){return super.copy(t),this.map=t.map,this.alphaMap=t.alphaMap,this.displacementMap=t.displacementMap,this.displacementScale=t.displacementScale,this.displacementBias=t.displacementBias,this}}const Ug=`void main() {
	gl_Position = vec4( position, 1.0 );
}`,Ng=`uniform sampler2D shadow_pass;
uniform vec2 resolution;
uniform float radius;
#include <packing>
void main() {
	const float samples = float( VSM_SAMPLES );
	float mean = 0.0;
	float squared_mean = 0.0;
	float uvStride = samples <= 1.0 ? 0.0 : 2.0 / ( samples - 1.0 );
	float uvStart = samples <= 1.0 ? 0.0 : - 1.0;
	for ( float i = 0.0; i < samples; i ++ ) {
		float uvOffset = uvStart + i * uvStride;
		#ifdef HORIZONTAL_PASS
			vec2 distribution = unpackRGBATo2Half( texture2D( shadow_pass, ( gl_FragCoord.xy + vec2( uvOffset, 0.0 ) * radius ) / resolution ) );
			mean += distribution.x;
			squared_mean += distribution.y * distribution.y + distribution.x * distribution.x;
		#else
			float depth = unpackRGBAToDepth( texture2D( shadow_pass, ( gl_FragCoord.xy + vec2( 0.0, uvOffset ) * radius ) / resolution ) );
			mean += depth;
			squared_mean += depth * depth;
		#endif
	}
	mean = mean / samples;
	squared_mean = squared_mean / samples;
	float std_dev = sqrt( squared_mean - mean * mean );
	gl_FragColor = pack2HalfToRGBA( vec2( mean, std_dev ) );
}`;function kg(i,t,e){let n=new Ra;const s=new nt,r=new nt,o=new se,a=new Dg({depthPacking:du}),c=new Ig,l={},h=e.maxTextureSize,d={[Bn]:Re,[Re]:Bn,[qe]:qe},u=new Hn({defines:{VSM_SAMPLES:8},uniforms:{shadow_pass:{value:null},resolution:{value:new nt},radius:{value:4}},vertexShader:Ug,fragmentShader:Ng}),f=u.clone();f.defines.HORIZONTAL_PASS=1;const g=new Ne;g.setAttribute("position",new rn(new Float32Array([-1,-1,.5,3,-1,.5,-1,3,.5]),3));const _=new ae(g,u),p=this;this.enabled=!1,this.autoUpdate=!0,this.needsUpdate=!1,this.type=El;let m=this.type;this.render=function(R,A,P){if(p.enabled===!1||p.autoUpdate===!1&&p.needsUpdate===!1||R.length===0)return;const W=i.getRenderTarget(),v=i.getActiveCubeFace(),S=i.getActiveMipmapLevel(),F=i.state;F.setBlending(Fn),F.buffers.color.setClear(1,1,1,1),F.buffers.depth.setTest(!0),F.setScissorTest(!1);const N=m!==vn&&this.type===vn,H=m===vn&&this.type!==vn;for(let X=0,z=R.length;X<z;X++){const J=R[X],G=J.shadow;if(G===void 0){console.warn("THREE.WebGLShadowMap:",J,"has no shadow.");continue}if(G.autoUpdate===!1&&G.needsUpdate===!1)continue;s.copy(G.mapSize);const ht=G.getFrameExtents();if(s.multiply(ht),r.copy(G.mapSize),(s.x>h||s.y>h)&&(s.x>h&&(r.x=Math.floor(h/ht.x),s.x=r.x*ht.x,G.mapSize.x=r.x),s.y>h&&(r.y=Math.floor(h/ht.y),s.y=r.y*ht.y,G.mapSize.y=r.y)),G.map===null||N===!0||H===!0){const pt=this.type!==vn?{minFilter:Ke,magFilter:Ke}:{};G.map!==null&&G.map.dispose(),G.map=new oi(s.x,s.y,pt),G.map.texture.name=J.name+".shadowMap",G.camera.updateProjectionMatrix()}i.setRenderTarget(G.map),i.clear();const ft=G.getViewportCount();for(let pt=0;pt<ft;pt++){const $t=G.getViewport(pt);o.set(r.x*$t.x,r.y*$t.y,r.x*$t.z,r.y*$t.w),F.viewport(o),G.updateMatrices(J,pt),n=G.getFrustum(),b(A,P,G.camera,J,this.type)}G.isPointLightShadow!==!0&&this.type===vn&&w(G,P),G.needsUpdate=!1}m=this.type,p.needsUpdate=!1,i.setRenderTarget(W,v,S)};function w(R,A){const P=t.update(_);u.defines.VSM_SAMPLES!==R.blurSamples&&(u.defines.VSM_SAMPLES=R.blurSamples,f.defines.VSM_SAMPLES=R.blurSamples,u.needsUpdate=!0,f.needsUpdate=!0),R.mapPass===null&&(R.mapPass=new oi(s.x,s.y)),u.uniforms.shadow_pass.value=R.map.texture,u.uniforms.resolution.value=R.mapSize,u.uniforms.radius.value=R.radius,i.setRenderTarget(R.mapPass),i.clear(),i.renderBufferDirect(A,null,P,u,_,null),f.uniforms.shadow_pass.value=R.mapPass.texture,f.uniforms.resolution.value=R.mapSize,f.uniforms.radius.value=R.radius,i.setRenderTarget(R.map),i.clear(),i.renderBufferDirect(A,null,P,f,_,null)}function x(R,A,P,W){let v=null;const S=P.isPointLight===!0?R.customDistanceMaterial:R.customDepthMaterial;if(S!==void 0)v=S;else if(v=P.isPointLight===!0?c:a,i.localClippingEnabled&&A.clipShadows===!0&&Array.isArray(A.clippingPlanes)&&A.clippingPlanes.length!==0||A.displacementMap&&A.displacementScale!==0||A.alphaMap&&A.alphaTest>0||A.map&&A.alphaTest>0){const F=v.uuid,N=A.uuid;let H=l[F];H===void 0&&(H={},l[F]=H);let X=H[N];X===void 0&&(X=v.clone(),H[N]=X,A.addEventListener("dispose",I)),v=X}if(v.visible=A.visible,v.wireframe=A.wireframe,W===vn?v.side=A.shadowSide!==null?A.shadowSide:A.side:v.side=A.shadowSide!==null?A.shadowSide:d[A.side],v.alphaMap=A.alphaMap,v.alphaTest=A.alphaTest,v.map=A.map,v.clipShadows=A.clipShadows,v.clippingPlanes=A.clippingPlanes,v.clipIntersection=A.clipIntersection,v.displacementMap=A.displacementMap,v.displacementScale=A.displacementScale,v.displacementBias=A.displacementBias,v.wireframeLinewidth=A.wireframeLinewidth,v.linewidth=A.linewidth,P.isPointLight===!0&&v.isMeshDistanceMaterial===!0){const F=i.properties.get(v);F.light=P}return v}function b(R,A,P,W,v){if(R.visible===!1)return;if(R.layers.test(A.layers)&&(R.isMesh||R.isLine||R.isPoints)&&(R.castShadow||R.receiveShadow&&v===vn)&&(!R.frustumCulled||n.intersectsObject(R))){R.modelViewMatrix.multiplyMatrices(P.matrixWorldInverse,R.matrixWorld);const N=t.update(R),H=R.material;if(Array.isArray(H)){const X=N.groups;for(let z=0,J=X.length;z<J;z++){const G=X[z],ht=H[G.materialIndex];if(ht&&ht.visible){const ft=x(R,ht,W,v);R.onBeforeShadow(i,R,A,P,N,ft,G),i.renderBufferDirect(P,null,N,ft,R,G),R.onAfterShadow(i,R,A,P,N,ft,G)}}}else if(H.visible){const X=x(R,H,W,v);R.onBeforeShadow(i,R,A,P,N,X,null),i.renderBufferDirect(P,null,N,X,R,null),R.onAfterShadow(i,R,A,P,N,X,null)}}const F=R.children;for(let N=0,H=F.length;N<H;N++)b(F[N],A,P,W,v)}function I(R){R.target.removeEventListener("dispose",I);for(const P in l){const W=l[P],v=R.target.uuid;v in W&&(W[v].dispose(),delete W[v])}}}const Fg={[Eo]:To,[wo]:Ro,[Ao]:Po,[Hi]:Co,[To]:Eo,[Ro]:wo,[Po]:Ao,[Co]:Hi};function Og(i){function t(){let L=!1;const gt=new se;let V=null;const j=new se(0,0,0,0);return{setMask:function(ut){V!==ut&&!L&&(i.colorMask(ut,ut,ut,ut),V=ut)},setLocked:function(ut){L=ut},setClear:function(ut,_t,Zt,pe,Pe){Pe===!0&&(ut*=pe,_t*=pe,Zt*=pe),gt.set(ut,_t,Zt,pe),j.equals(gt)===!1&&(i.clearColor(ut,_t,Zt,pe),j.copy(gt))},reset:function(){L=!1,V=null,j.set(-1,0,0,0)}}}function e(){let L=!1,gt=!1,V=null,j=null,ut=null;return{setReversed:function(_t){gt=_t},setTest:function(_t){_t?yt(i.DEPTH_TEST):lt(i.DEPTH_TEST)},setMask:function(_t){V!==_t&&!L&&(i.depthMask(_t),V=_t)},setFunc:function(_t){if(gt&&(_t=Fg[_t]),j!==_t){switch(_t){case Eo:i.depthFunc(i.NEVER);break;case To:i.depthFunc(i.ALWAYS);break;case wo:i.depthFunc(i.LESS);break;case Hi:i.depthFunc(i.LEQUAL);break;case Ao:i.depthFunc(i.EQUAL);break;case Co:i.depthFunc(i.GEQUAL);break;case Ro:i.depthFunc(i.GREATER);break;case Po:i.depthFunc(i.NOTEQUAL);break;default:i.depthFunc(i.LEQUAL)}j=_t}},setLocked:function(_t){L=_t},setClear:function(_t){ut!==_t&&(i.clearDepth(_t),ut=_t)},reset:function(){L=!1,V=null,j=null,ut=null}}}function n(){let L=!1,gt=null,V=null,j=null,ut=null,_t=null,Zt=null,pe=null,Pe=null;return{setTest:function(Jt){L||(Jt?yt(i.STENCIL_TEST):lt(i.STENCIL_TEST))},setMask:function(Jt){gt!==Jt&&!L&&(i.stencilMask(Jt),gt=Jt)},setFunc:function(Jt,Le,un){(V!==Jt||j!==Le||ut!==un)&&(i.stencilFunc(Jt,Le,un),V=Jt,j=Le,ut=un)},setOp:function(Jt,Le,un){(_t!==Jt||Zt!==Le||pe!==un)&&(i.stencilOp(Jt,Le,un),_t=Jt,Zt=Le,pe=un)},setLocked:function(Jt){L=Jt},setClear:function(Jt){Pe!==Jt&&(i.clearStencil(Jt),Pe=Jt)},reset:function(){L=!1,gt=null,V=null,j=null,ut=null,_t=null,Zt=null,pe=null,Pe=null}}}const s=new t,r=new e,o=new n,a=new WeakMap,c=new WeakMap;let l={},h={},d=new WeakMap,u=[],f=null,g=!1,_=null,p=null,m=null,w=null,x=null,b=null,I=null,R=new Xt(0,0,0),A=0,P=!1,W=null,v=null,S=null,F=null,N=null;const H=i.getParameter(i.MAX_COMBINED_TEXTURE_IMAGE_UNITS);let X=!1,z=0;const J=i.getParameter(i.VERSION);J.indexOf("WebGL")!==-1?(z=parseFloat(/^WebGL (\d)/.exec(J)[1]),X=z>=1):J.indexOf("OpenGL ES")!==-1&&(z=parseFloat(/^OpenGL ES (\d)/.exec(J)[1]),X=z>=2);let G=null,ht={};const ft=i.getParameter(i.SCISSOR_BOX),pt=i.getParameter(i.VIEWPORT),$t=new se().fromArray(ft),jt=new se().fromArray(pt);function $(L,gt,V,j){const ut=new Uint8Array(4),_t=i.createTexture();i.bindTexture(L,_t),i.texParameteri(L,i.TEXTURE_MIN_FILTER,i.NEAREST),i.texParameteri(L,i.TEXTURE_MAG_FILTER,i.NEAREST);for(let Zt=0;Zt<V;Zt++)L===i.TEXTURE_3D||L===i.TEXTURE_2D_ARRAY?i.texImage3D(gt,0,i.RGBA,1,1,j,0,i.RGBA,i.UNSIGNED_BYTE,ut):i.texImage2D(gt+Zt,0,i.RGBA,1,1,0,i.RGBA,i.UNSIGNED_BYTE,ut);return _t}const tt={};tt[i.TEXTURE_2D]=$(i.TEXTURE_2D,i.TEXTURE_2D,1),tt[i.TEXTURE_CUBE_MAP]=$(i.TEXTURE_CUBE_MAP,i.TEXTURE_CUBE_MAP_POSITIVE_X,6),tt[i.TEXTURE_2D_ARRAY]=$(i.TEXTURE_2D_ARRAY,i.TEXTURE_2D_ARRAY,1,1),tt[i.TEXTURE_3D]=$(i.TEXTURE_3D,i.TEXTURE_3D,1,1),s.setClear(0,0,0,1),r.setClear(1),o.setClear(0),yt(i.DEPTH_TEST),r.setFunc(Hi),st(!1),Q(Za),yt(i.CULL_FACE),T(Fn);function yt(L){l[L]!==!0&&(i.enable(L),l[L]=!0)}function lt(L){l[L]!==!1&&(i.disable(L),l[L]=!1)}function It(L,gt){return h[L]!==gt?(i.bindFramebuffer(L,gt),h[L]=gt,L===i.DRAW_FRAMEBUFFER&&(h[i.FRAMEBUFFER]=gt),L===i.FRAMEBUFFER&&(h[i.DRAW_FRAMEBUFFER]=gt),!0):!1}function Dt(L,gt){let V=u,j=!1;if(L){V=d.get(gt),V===void 0&&(V=[],d.set(gt,V));const ut=L.textures;if(V.length!==ut.length||V[0]!==i.COLOR_ATTACHMENT0){for(let _t=0,Zt=ut.length;_t<Zt;_t++)V[_t]=i.COLOR_ATTACHMENT0+_t;V.length=ut.length,j=!0}}else V[0]!==i.BACK&&(V[0]=i.BACK,j=!0);j&&i.drawBuffers(V)}function Ot(L){return f!==L?(i.useProgram(L),f=L,!0):!1}const Gt={[ti]:i.FUNC_ADD,[Bh]:i.FUNC_SUBTRACT,[zh]:i.FUNC_REVERSE_SUBTRACT};Gt[Hh]=i.MIN,Gt[Vh]=i.MAX;const K={[Gh]:i.ZERO,[Wh]:i.ONE,[Xh]:i.SRC_COLOR,[So]:i.SRC_ALPHA,[jh]:i.SRC_ALPHA_SATURATE,[Kh]:i.DST_COLOR,[qh]:i.DST_ALPHA,[$h]:i.ONE_MINUS_SRC_COLOR,[bo]:i.ONE_MINUS_SRC_ALPHA,[Zh]:i.ONE_MINUS_DST_COLOR,[Yh]:i.ONE_MINUS_DST_ALPHA,[Jh]:i.CONSTANT_COLOR,[Qh]:i.ONE_MINUS_CONSTANT_COLOR,[tu]:i.CONSTANT_ALPHA,[eu]:i.ONE_MINUS_CONSTANT_ALPHA};function T(L,gt,V,j,ut,_t,Zt,pe,Pe,Jt){if(L===Fn){g===!0&&(lt(i.BLEND),g=!1);return}if(g===!1&&(yt(i.BLEND),g=!0),L!==Oh){if(L!==_||Jt!==P){if((p!==ti||x!==ti)&&(i.blendEquation(i.FUNC_ADD),p=ti,x=ti),Jt)switch(L){case ki:i.blendFuncSeparate(i.ONE,i.ONE_MINUS_SRC_ALPHA,i.ONE,i.ONE_MINUS_SRC_ALPHA);break;case ja:i.blendFunc(i.ONE,i.ONE);break;case Ja:i.blendFuncSeparate(i.ZERO,i.ONE_MINUS_SRC_COLOR,i.ZERO,i.ONE);break;case Qa:i.blendFuncSeparate(i.ZERO,i.SRC_COLOR,i.ZERO,i.SRC_ALPHA);break;default:console.error("THREE.WebGLState: Invalid blending: ",L);break}else switch(L){case ki:i.blendFuncSeparate(i.SRC_ALPHA,i.ONE_MINUS_SRC_ALPHA,i.ONE,i.ONE_MINUS_SRC_ALPHA);break;case ja:i.blendFunc(i.SRC_ALPHA,i.ONE);break;case Ja:i.blendFuncSeparate(i.ZERO,i.ONE_MINUS_SRC_COLOR,i.ZERO,i.ONE);break;case Qa:i.blendFunc(i.ZERO,i.SRC_COLOR);break;default:console.error("THREE.WebGLState: Invalid blending: ",L);break}m=null,w=null,b=null,I=null,R.set(0,0,0),A=0,_=L,P=Jt}return}ut=ut||gt,_t=_t||V,Zt=Zt||j,(gt!==p||ut!==x)&&(i.blendEquationSeparate(Gt[gt],Gt[ut]),p=gt,x=ut),(V!==m||j!==w||_t!==b||Zt!==I)&&(i.blendFuncSeparate(K[V],K[j],K[_t],K[Zt]),m=V,w=j,b=_t,I=Zt),(pe.equals(R)===!1||Pe!==A)&&(i.blendColor(pe.r,pe.g,pe.b,Pe),R.copy(pe),A=Pe),_=L,P=!1}function rt(L,gt){L.side===qe?lt(i.CULL_FACE):yt(i.CULL_FACE);let V=L.side===Re;gt&&(V=!V),st(V),L.blending===ki&&L.transparent===!1?T(Fn):T(L.blending,L.blendEquation,L.blendSrc,L.blendDst,L.blendEquationAlpha,L.blendSrcAlpha,L.blendDstAlpha,L.blendColor,L.blendAlpha,L.premultipliedAlpha),r.setFunc(L.depthFunc),r.setTest(L.depthTest),r.setMask(L.depthWrite),s.setMask(L.colorWrite);const j=L.stencilWrite;o.setTest(j),j&&(o.setMask(L.stencilWriteMask),o.setFunc(L.stencilFunc,L.stencilRef,L.stencilFuncMask),o.setOp(L.stencilFail,L.stencilZFail,L.stencilZPass)),Ct(L.polygonOffset,L.polygonOffsetFactor,L.polygonOffsetUnits),L.alphaToCoverage===!0?yt(i.SAMPLE_ALPHA_TO_COVERAGE):lt(i.SAMPLE_ALPHA_TO_COVERAGE)}function st(L){W!==L&&(L?i.frontFace(i.CW):i.frontFace(i.CCW),W=L)}function Q(L){L!==Nh?(yt(i.CULL_FACE),L!==v&&(L===Za?i.cullFace(i.BACK):L===kh?i.cullFace(i.FRONT):i.cullFace(i.FRONT_AND_BACK))):lt(i.CULL_FACE),v=L}function ot(L){L!==S&&(X&&i.lineWidth(L),S=L)}function Ct(L,gt,V){L?(yt(i.POLYGON_OFFSET_FILL),(F!==gt||N!==V)&&(i.polygonOffset(gt,V),F=gt,N=V)):lt(i.POLYGON_OFFSET_FILL)}function mt(L){L?yt(i.SCISSOR_TEST):lt(i.SCISSOR_TEST)}function E(L){L===void 0&&(L=i.TEXTURE0+H-1),G!==L&&(i.activeTexture(L),G=L)}function y(L,gt,V){V===void 0&&(G===null?V=i.TEXTURE0+H-1:V=G);let j=ht[V];j===void 0&&(j={type:void 0,texture:void 0},ht[V]=j),(j.type!==L||j.texture!==gt)&&(G!==V&&(i.activeTexture(V),G=V),i.bindTexture(L,gt||tt[L]),j.type=L,j.texture=gt)}function k(){const L=ht[G];L!==void 0&&L.type!==void 0&&(i.bindTexture(L.type,null),L.type=void 0,L.texture=void 0)}function q(){try{i.compressedTexImage2D.apply(i,arguments)}catch(L){console.error("THREE.WebGLState:",L)}}function Z(){try{i.compressedTexImage3D.apply(i,arguments)}catch(L){console.error("THREE.WebGLState:",L)}}function Y(){try{i.texSubImage2D.apply(i,arguments)}catch(L){console.error("THREE.WebGLState:",L)}}function bt(){try{i.texSubImage3D.apply(i,arguments)}catch(L){console.error("THREE.WebGLState:",L)}}function at(){try{i.compressedTexSubImage2D.apply(i,arguments)}catch(L){console.error("THREE.WebGLState:",L)}}function vt(){try{i.compressedTexSubImage3D.apply(i,arguments)}catch(L){console.error("THREE.WebGLState:",L)}}function Yt(){try{i.texStorage2D.apply(i,arguments)}catch(L){console.error("THREE.WebGLState:",L)}}function et(){try{i.texStorage3D.apply(i,arguments)}catch(L){console.error("THREE.WebGLState:",L)}}function xt(){try{i.texImage2D.apply(i,arguments)}catch(L){console.error("THREE.WebGLState:",L)}}function kt(){try{i.texImage3D.apply(i,arguments)}catch(L){console.error("THREE.WebGLState:",L)}}function Ft(L){$t.equals(L)===!1&&(i.scissor(L.x,L.y,L.z,L.w),$t.copy(L))}function Mt(L){jt.equals(L)===!1&&(i.viewport(L.x,L.y,L.z,L.w),jt.copy(L))}function Kt(L,gt){let V=c.get(gt);V===void 0&&(V=new WeakMap,c.set(gt,V));let j=V.get(L);j===void 0&&(j=i.getUniformBlockIndex(gt,L.name),V.set(L,j))}function Bt(L,gt){const j=c.get(gt).get(L);a.get(gt)!==j&&(i.uniformBlockBinding(gt,j,L.__bindingPointIndex),a.set(gt,j))}function oe(){i.disable(i.BLEND),i.disable(i.CULL_FACE),i.disable(i.DEPTH_TEST),i.disable(i.POLYGON_OFFSET_FILL),i.disable(i.SCISSOR_TEST),i.disable(i.STENCIL_TEST),i.disable(i.SAMPLE_ALPHA_TO_COVERAGE),i.blendEquation(i.FUNC_ADD),i.blendFunc(i.ONE,i.ZERO),i.blendFuncSeparate(i.ONE,i.ZERO,i.ONE,i.ZERO),i.blendColor(0,0,0,0),i.colorMask(!0,!0,!0,!0),i.clearColor(0,0,0,0),i.depthMask(!0),i.depthFunc(i.LESS),i.clearDepth(1),i.stencilMask(4294967295),i.stencilFunc(i.ALWAYS,0,4294967295),i.stencilOp(i.KEEP,i.KEEP,i.KEEP),i.clearStencil(0),i.cullFace(i.BACK),i.frontFace(i.CCW),i.polygonOffset(0,0),i.activeTexture(i.TEXTURE0),i.bindFramebuffer(i.FRAMEBUFFER,null),i.bindFramebuffer(i.DRAW_FRAMEBUFFER,null),i.bindFramebuffer(i.READ_FRAMEBUFFER,null),i.useProgram(null),i.lineWidth(1),i.scissor(0,0,i.canvas.width,i.canvas.height),i.viewport(0,0,i.canvas.width,i.canvas.height),l={},G=null,ht={},h={},d=new WeakMap,u=[],f=null,g=!1,_=null,p=null,m=null,w=null,x=null,b=null,I=null,R=new Xt(0,0,0),A=0,P=!1,W=null,v=null,S=null,F=null,N=null,$t.set(0,0,i.canvas.width,i.canvas.height),jt.set(0,0,i.canvas.width,i.canvas.height),s.reset(),r.reset(),o.reset()}return{buffers:{color:s,depth:r,stencil:o},enable:yt,disable:lt,bindFramebuffer:It,drawBuffers:Dt,useProgram:Ot,setBlending:T,setMaterial:rt,setFlipSided:st,setCullFace:Q,setLineWidth:ot,setPolygonOffset:Ct,setScissorTest:mt,activeTexture:E,bindTexture:y,unbindTexture:k,compressedTexImage2D:q,compressedTexImage3D:Z,texImage2D:xt,texImage3D:kt,updateUBOMapping:Kt,uniformBlockBinding:Bt,texStorage2D:Yt,texStorage3D:et,texSubImage2D:Y,texSubImage3D:bt,compressedTexSubImage2D:at,compressedTexSubImage3D:vt,scissor:Ft,viewport:Mt,reset:oe}}function Gc(i,t,e,n){const s=Bg(n);switch(e){case Ll:return i*t;case Il:return i*t;case Ul:return i*t*2;case Nl:return i*t/s.components*s.byteLength;case ba:return i*t/s.components*s.byteLength;case kl:return i*t*2/s.components*s.byteLength;case Ea:return i*t*2/s.components*s.byteLength;case Dl:return i*t*3/s.components*s.byteLength;case sn:return i*t*4/s.components*s.byteLength;case Ta:return i*t*4/s.components*s.byteLength;case sr:case rr:return Math.floor((i+3)/4)*Math.floor((t+3)/4)*8;case or:case ar:return Math.floor((i+3)/4)*Math.floor((t+3)/4)*16;case ko:case Oo:return Math.max(i,16)*Math.max(t,8)/4;case No:case Fo:return Math.max(i,8)*Math.max(t,8)/2;case Bo:case zo:return Math.floor((i+3)/4)*Math.floor((t+3)/4)*8;case Ho:return Math.floor((i+3)/4)*Math.floor((t+3)/4)*16;case Vo:return Math.floor((i+3)/4)*Math.floor((t+3)/4)*16;case Go:return Math.floor((i+4)/5)*Math.floor((t+3)/4)*16;case Wo:return Math.floor((i+4)/5)*Math.floor((t+4)/5)*16;case Xo:return Math.floor((i+5)/6)*Math.floor((t+4)/5)*16;case $o:return Math.floor((i+5)/6)*Math.floor((t+5)/6)*16;case qo:return Math.floor((i+7)/8)*Math.floor((t+4)/5)*16;case Yo:return Math.floor((i+7)/8)*Math.floor((t+5)/6)*16;case Ko:return Math.floor((i+7)/8)*Math.floor((t+7)/8)*16;case Zo:return Math.floor((i+9)/10)*Math.floor((t+4)/5)*16;case jo:return Math.floor((i+9)/10)*Math.floor((t+5)/6)*16;case Jo:return Math.floor((i+9)/10)*Math.floor((t+7)/8)*16;case Qo:return Math.floor((i+9)/10)*Math.floor((t+9)/10)*16;case ta:return Math.floor((i+11)/12)*Math.floor((t+9)/10)*16;case ea:return Math.floor((i+11)/12)*Math.floor((t+11)/12)*16;case cr:case na:case ia:return Math.ceil(i/4)*Math.ceil(t/4)*16;case Fl:case sa:return Math.ceil(i/4)*Math.ceil(t/4)*8;case ra:case oa:return Math.ceil(i/4)*Math.ceil(t/4)*16}throw new Error(`Unable to determine texture byte length for ${e} format.`)}function Bg(i){switch(i){case bn:case Cl:return{byteLength:1,components:1};case gs:case Rl:case Ss:return{byteLength:2,components:1};case Ma:case Sa:return{byteLength:2,components:4};case ri:case ya:case xn:return{byteLength:4,components:1};case Pl:return{byteLength:4,components:3}}throw new Error(`Unknown texture type ${i}.`)}function zg(i,t,e,n,s,r,o){const a=t.has("WEBGL_multisampled_render_to_texture")?t.get("WEBGL_multisampled_render_to_texture"):null,c=typeof navigator>"u"?!1:/OculusBrowser/g.test(navigator.userAgent),l=new nt,h=new WeakMap;let d;const u=new WeakMap;let f=!1;try{f=typeof OffscreenCanvas<"u"&&new OffscreenCanvas(1,1).getContext("2d")!==null}catch{}function g(E,y){return f?new OffscreenCanvas(E,y):mr("canvas")}function _(E,y,k){let q=1;const Z=mt(E);if((Z.width>k||Z.height>k)&&(q=k/Math.max(Z.width,Z.height)),q<1)if(typeof HTMLImageElement<"u"&&E instanceof HTMLImageElement||typeof HTMLCanvasElement<"u"&&E instanceof HTMLCanvasElement||typeof ImageBitmap<"u"&&E instanceof ImageBitmap||typeof VideoFrame<"u"&&E instanceof VideoFrame){const Y=Math.floor(q*Z.width),bt=Math.floor(q*Z.height);d===void 0&&(d=g(Y,bt));const at=y?g(Y,bt):d;return at.width=Y,at.height=bt,at.getContext("2d").drawImage(E,0,0,Y,bt),console.warn("THREE.WebGLRenderer: Texture has been resized from ("+Z.width+"x"+Z.height+") to ("+Y+"x"+bt+")."),at}else return"data"in E&&console.warn("THREE.WebGLRenderer: Image in DataTexture is too big ("+Z.width+"x"+Z.height+")."),E;return E}function p(E){return E.generateMipmaps&&E.minFilter!==Ke&&E.minFilter!==nn}function m(E){i.generateMipmap(E)}function w(E,y,k,q,Z=!1){if(E!==null){if(i[E]!==void 0)return i[E];console.warn("THREE.WebGLRenderer: Attempt to use non-existing WebGL internal format '"+E+"'")}let Y=y;if(y===i.RED&&(k===i.FLOAT&&(Y=i.R32F),k===i.HALF_FLOAT&&(Y=i.R16F),k===i.UNSIGNED_BYTE&&(Y=i.R8)),y===i.RED_INTEGER&&(k===i.UNSIGNED_BYTE&&(Y=i.R8UI),k===i.UNSIGNED_SHORT&&(Y=i.R16UI),k===i.UNSIGNED_INT&&(Y=i.R32UI),k===i.BYTE&&(Y=i.R8I),k===i.SHORT&&(Y=i.R16I),k===i.INT&&(Y=i.R32I)),y===i.RG&&(k===i.FLOAT&&(Y=i.RG32F),k===i.HALF_FLOAT&&(Y=i.RG16F),k===i.UNSIGNED_BYTE&&(Y=i.RG8)),y===i.RG_INTEGER&&(k===i.UNSIGNED_BYTE&&(Y=i.RG8UI),k===i.UNSIGNED_SHORT&&(Y=i.RG16UI),k===i.UNSIGNED_INT&&(Y=i.RG32UI),k===i.BYTE&&(Y=i.RG8I),k===i.SHORT&&(Y=i.RG16I),k===i.INT&&(Y=i.RG32I)),y===i.RGB_INTEGER&&(k===i.UNSIGNED_BYTE&&(Y=i.RGB8UI),k===i.UNSIGNED_SHORT&&(Y=i.RGB16UI),k===i.UNSIGNED_INT&&(Y=i.RGB32UI),k===i.BYTE&&(Y=i.RGB8I),k===i.SHORT&&(Y=i.RGB16I),k===i.INT&&(Y=i.RGB32I)),y===i.RGBA_INTEGER&&(k===i.UNSIGNED_BYTE&&(Y=i.RGBA8UI),k===i.UNSIGNED_SHORT&&(Y=i.RGBA16UI),k===i.UNSIGNED_INT&&(Y=i.RGBA32UI),k===i.BYTE&&(Y=i.RGBA8I),k===i.SHORT&&(Y=i.RGBA16I),k===i.INT&&(Y=i.RGBA32I)),y===i.RGB&&k===i.UNSIGNED_INT_5_9_9_9_REV&&(Y=i.RGB9_E5),y===i.RGBA){const bt=Z?ur:ee.getTransfer(q);k===i.FLOAT&&(Y=i.RGBA32F),k===i.HALF_FLOAT&&(Y=i.RGBA16F),k===i.UNSIGNED_BYTE&&(Y=bt===le?i.SRGB8_ALPHA8:i.RGBA8),k===i.UNSIGNED_SHORT_4_4_4_4&&(Y=i.RGBA4),k===i.UNSIGNED_SHORT_5_5_5_1&&(Y=i.RGB5_A1)}return(Y===i.R16F||Y===i.R32F||Y===i.RG16F||Y===i.RG32F||Y===i.RGBA16F||Y===i.RGBA32F)&&t.get("EXT_color_buffer_float"),Y}function x(E,y){let k;return E?y===null||y===ri||y===Wi?k=i.DEPTH24_STENCIL8:y===xn?k=i.DEPTH32F_STENCIL8:y===gs&&(k=i.DEPTH24_STENCIL8,console.warn("DepthTexture: 16 bit depth attachment is not supported with stencil. Using 24-bit attachment.")):y===null||y===ri||y===Wi?k=i.DEPTH_COMPONENT24:y===xn?k=i.DEPTH_COMPONENT32F:y===gs&&(k=i.DEPTH_COMPONENT16),k}function b(E,y){return p(E)===!0||E.isFramebufferTexture&&E.minFilter!==Ke&&E.minFilter!==nn?Math.log2(Math.max(y.width,y.height))+1:E.mipmaps!==void 0&&E.mipmaps.length>0?E.mipmaps.length:E.isCompressedTexture&&Array.isArray(E.image)?y.mipmaps.length:1}function I(E){const y=E.target;y.removeEventListener("dispose",I),A(y),y.isVideoTexture&&h.delete(y)}function R(E){const y=E.target;y.removeEventListener("dispose",R),W(y)}function A(E){const y=n.get(E);if(y.__webglInit===void 0)return;const k=E.source,q=u.get(k);if(q){const Z=q[y.__cacheKey];Z.usedTimes--,Z.usedTimes===0&&P(E),Object.keys(q).length===0&&u.delete(k)}n.remove(E)}function P(E){const y=n.get(E);i.deleteTexture(y.__webglTexture);const k=E.source,q=u.get(k);delete q[y.__cacheKey],o.memory.textures--}function W(E){const y=n.get(E);if(E.depthTexture&&E.depthTexture.dispose(),E.isWebGLCubeRenderTarget)for(let q=0;q<6;q++){if(Array.isArray(y.__webglFramebuffer[q]))for(let Z=0;Z<y.__webglFramebuffer[q].length;Z++)i.deleteFramebuffer(y.__webglFramebuffer[q][Z]);else i.deleteFramebuffer(y.__webglFramebuffer[q]);y.__webglDepthbuffer&&i.deleteRenderbuffer(y.__webglDepthbuffer[q])}else{if(Array.isArray(y.__webglFramebuffer))for(let q=0;q<y.__webglFramebuffer.length;q++)i.deleteFramebuffer(y.__webglFramebuffer[q]);else i.deleteFramebuffer(y.__webglFramebuffer);if(y.__webglDepthbuffer&&i.deleteRenderbuffer(y.__webglDepthbuffer),y.__webglMultisampledFramebuffer&&i.deleteFramebuffer(y.__webglMultisampledFramebuffer),y.__webglColorRenderbuffer)for(let q=0;q<y.__webglColorRenderbuffer.length;q++)y.__webglColorRenderbuffer[q]&&i.deleteRenderbuffer(y.__webglColorRenderbuffer[q]);y.__webglDepthRenderbuffer&&i.deleteRenderbuffer(y.__webglDepthRenderbuffer)}const k=E.textures;for(let q=0,Z=k.length;q<Z;q++){const Y=n.get(k[q]);Y.__webglTexture&&(i.deleteTexture(Y.__webglTexture),o.memory.textures--),n.remove(k[q])}n.remove(E)}let v=0;function S(){v=0}function F(){const E=v;return E>=s.maxTextures&&console.warn("THREE.WebGLTextures: Trying to use "+E+" texture units while this GPU supports only "+s.maxTextures),v+=1,E}function N(E){const y=[];return y.push(E.wrapS),y.push(E.wrapT),y.push(E.wrapR||0),y.push(E.magFilter),y.push(E.minFilter),y.push(E.anisotropy),y.push(E.internalFormat),y.push(E.format),y.push(E.type),y.push(E.generateMipmaps),y.push(E.premultiplyAlpha),y.push(E.flipY),y.push(E.unpackAlignment),y.push(E.colorSpace),y.join()}function H(E,y){const k=n.get(E);if(E.isVideoTexture&&ot(E),E.isRenderTargetTexture===!1&&E.version>0&&k.__version!==E.version){const q=E.image;if(q===null)console.warn("THREE.WebGLRenderer: Texture marked for update but no image data found.");else if(q.complete===!1)console.warn("THREE.WebGLRenderer: Texture marked for update but image is incomplete");else{jt(k,E,y);return}}e.bindTexture(i.TEXTURE_2D,k.__webglTexture,i.TEXTURE0+y)}function X(E,y){const k=n.get(E);if(E.version>0&&k.__version!==E.version){jt(k,E,y);return}e.bindTexture(i.TEXTURE_2D_ARRAY,k.__webglTexture,i.TEXTURE0+y)}function z(E,y){const k=n.get(E);if(E.version>0&&k.__version!==E.version){jt(k,E,y);return}e.bindTexture(i.TEXTURE_3D,k.__webglTexture,i.TEXTURE0+y)}function J(E,y){const k=n.get(E);if(E.version>0&&k.__version!==E.version){$(k,E,y);return}e.bindTexture(i.TEXTURE_CUBE_MAP,k.__webglTexture,i.TEXTURE0+y)}const G={[Io]:i.REPEAT,[ni]:i.CLAMP_TO_EDGE,[Uo]:i.MIRRORED_REPEAT},ht={[Ke]:i.NEAREST,[hu]:i.NEAREST_MIPMAP_NEAREST,[ws]:i.NEAREST_MIPMAP_LINEAR,[nn]:i.LINEAR,[Ir]:i.LINEAR_MIPMAP_NEAREST,[ii]:i.LINEAR_MIPMAP_LINEAR},ft={[pu]:i.NEVER,[yu]:i.ALWAYS,[mu]:i.LESS,[Bl]:i.LEQUAL,[gu]:i.EQUAL,[xu]:i.GEQUAL,[_u]:i.GREATER,[vu]:i.NOTEQUAL};function pt(E,y){if(y.type===xn&&t.has("OES_texture_float_linear")===!1&&(y.magFilter===nn||y.magFilter===Ir||y.magFilter===ws||y.magFilter===ii||y.minFilter===nn||y.minFilter===Ir||y.minFilter===ws||y.minFilter===ii)&&console.warn("THREE.WebGLRenderer: Unable to use linear filtering with floating point textures. OES_texture_float_linear not supported on this device."),i.texParameteri(E,i.TEXTURE_WRAP_S,G[y.wrapS]),i.texParameteri(E,i.TEXTURE_WRAP_T,G[y.wrapT]),(E===i.TEXTURE_3D||E===i.TEXTURE_2D_ARRAY)&&i.texParameteri(E,i.TEXTURE_WRAP_R,G[y.wrapR]),i.texParameteri(E,i.TEXTURE_MAG_FILTER,ht[y.magFilter]),i.texParameteri(E,i.TEXTURE_MIN_FILTER,ht[y.minFilter]),y.compareFunction&&(i.texParameteri(E,i.TEXTURE_COMPARE_MODE,i.COMPARE_REF_TO_TEXTURE),i.texParameteri(E,i.TEXTURE_COMPARE_FUNC,ft[y.compareFunction])),t.has("EXT_texture_filter_anisotropic")===!0){if(y.magFilter===Ke||y.minFilter!==ws&&y.minFilter!==ii||y.type===xn&&t.has("OES_texture_float_linear")===!1)return;if(y.anisotropy>1||n.get(y).__currentAnisotropy){const k=t.get("EXT_texture_filter_anisotropic");i.texParameterf(E,k.TEXTURE_MAX_ANISOTROPY_EXT,Math.min(y.anisotropy,s.getMaxAnisotropy())),n.get(y).__currentAnisotropy=y.anisotropy}}}function $t(E,y){let k=!1;E.__webglInit===void 0&&(E.__webglInit=!0,y.addEventListener("dispose",I));const q=y.source;let Z=u.get(q);Z===void 0&&(Z={},u.set(q,Z));const Y=N(y);if(Y!==E.__cacheKey){Z[Y]===void 0&&(Z[Y]={texture:i.createTexture(),usedTimes:0},o.memory.textures++,k=!0),Z[Y].usedTimes++;const bt=Z[E.__cacheKey];bt!==void 0&&(Z[E.__cacheKey].usedTimes--,bt.usedTimes===0&&P(y)),E.__cacheKey=Y,E.__webglTexture=Z[Y].texture}return k}function jt(E,y,k){let q=i.TEXTURE_2D;(y.isDataArrayTexture||y.isCompressedArrayTexture)&&(q=i.TEXTURE_2D_ARRAY),y.isData3DTexture&&(q=i.TEXTURE_3D);const Z=$t(E,y),Y=y.source;e.bindTexture(q,E.__webglTexture,i.TEXTURE0+k);const bt=n.get(Y);if(Y.version!==bt.__version||Z===!0){e.activeTexture(i.TEXTURE0+k);const at=ee.getPrimaries(ee.workingColorSpace),vt=y.colorSpace===In?null:ee.getPrimaries(y.colorSpace),Yt=y.colorSpace===In||at===vt?i.NONE:i.BROWSER_DEFAULT_WEBGL;i.pixelStorei(i.UNPACK_FLIP_Y_WEBGL,y.flipY),i.pixelStorei(i.UNPACK_PREMULTIPLY_ALPHA_WEBGL,y.premultiplyAlpha),i.pixelStorei(i.UNPACK_ALIGNMENT,y.unpackAlignment),i.pixelStorei(i.UNPACK_COLORSPACE_CONVERSION_WEBGL,Yt);let et=_(y.image,!1,s.maxTextureSize);et=Ct(y,et);const xt=r.convert(y.format,y.colorSpace),kt=r.convert(y.type);let Ft=w(y.internalFormat,xt,kt,y.colorSpace,y.isVideoTexture);pt(q,y);let Mt;const Kt=y.mipmaps,Bt=y.isVideoTexture!==!0,oe=bt.__version===void 0||Z===!0,L=Y.dataReady,gt=b(y,et);if(y.isDepthTexture)Ft=x(y.format===Xi,y.type),oe&&(Bt?e.texStorage2D(i.TEXTURE_2D,1,Ft,et.width,et.height):e.texImage2D(i.TEXTURE_2D,0,Ft,et.width,et.height,0,xt,kt,null));else if(y.isDataTexture)if(Kt.length>0){Bt&&oe&&e.texStorage2D(i.TEXTURE_2D,gt,Ft,Kt[0].width,Kt[0].height);for(let V=0,j=Kt.length;V<j;V++)Mt=Kt[V],Bt?L&&e.texSubImage2D(i.TEXTURE_2D,V,0,0,Mt.width,Mt.height,xt,kt,Mt.data):e.texImage2D(i.TEXTURE_2D,V,Ft,Mt.width,Mt.height,0,xt,kt,Mt.data);y.generateMipmaps=!1}else Bt?(oe&&e.texStorage2D(i.TEXTURE_2D,gt,Ft,et.width,et.height),L&&e.texSubImage2D(i.TEXTURE_2D,0,0,0,et.width,et.height,xt,kt,et.data)):e.texImage2D(i.TEXTURE_2D,0,Ft,et.width,et.height,0,xt,kt,et.data);else if(y.isCompressedTexture)if(y.isCompressedArrayTexture){Bt&&oe&&e.texStorage3D(i.TEXTURE_2D_ARRAY,gt,Ft,Kt[0].width,Kt[0].height,et.depth);for(let V=0,j=Kt.length;V<j;V++)if(Mt=Kt[V],y.format!==sn)if(xt!==null)if(Bt){if(L)if(y.layerUpdates.size>0){const ut=Gc(Mt.width,Mt.height,y.format,y.type);for(const _t of y.layerUpdates){const Zt=Mt.data.subarray(_t*ut/Mt.data.BYTES_PER_ELEMENT,(_t+1)*ut/Mt.data.BYTES_PER_ELEMENT);e.compressedTexSubImage3D(i.TEXTURE_2D_ARRAY,V,0,0,_t,Mt.width,Mt.height,1,xt,Zt,0,0)}y.clearLayerUpdates()}else e.compressedTexSubImage3D(i.TEXTURE_2D_ARRAY,V,0,0,0,Mt.width,Mt.height,et.depth,xt,Mt.data,0,0)}else e.compressedTexImage3D(i.TEXTURE_2D_ARRAY,V,Ft,Mt.width,Mt.height,et.depth,0,Mt.data,0,0);else console.warn("THREE.WebGLRenderer: Attempt to load unsupported compressed texture format in .uploadTexture()");else Bt?L&&e.texSubImage3D(i.TEXTURE_2D_ARRAY,V,0,0,0,Mt.width,Mt.height,et.depth,xt,kt,Mt.data):e.texImage3D(i.TEXTURE_2D_ARRAY,V,Ft,Mt.width,Mt.height,et.depth,0,xt,kt,Mt.data)}else{Bt&&oe&&e.texStorage2D(i.TEXTURE_2D,gt,Ft,Kt[0].width,Kt[0].height);for(let V=0,j=Kt.length;V<j;V++)Mt=Kt[V],y.format!==sn?xt!==null?Bt?L&&e.compressedTexSubImage2D(i.TEXTURE_2D,V,0,0,Mt.width,Mt.height,xt,Mt.data):e.compressedTexImage2D(i.TEXTURE_2D,V,Ft,Mt.width,Mt.height,0,Mt.data):console.warn("THREE.WebGLRenderer: Attempt to load unsupported compressed texture format in .uploadTexture()"):Bt?L&&e.texSubImage2D(i.TEXTURE_2D,V,0,0,Mt.width,Mt.height,xt,kt,Mt.data):e.texImage2D(i.TEXTURE_2D,V,Ft,Mt.width,Mt.height,0,xt,kt,Mt.data)}else if(y.isDataArrayTexture)if(Bt){if(oe&&e.texStorage3D(i.TEXTURE_2D_ARRAY,gt,Ft,et.width,et.height,et.depth),L)if(y.layerUpdates.size>0){const V=Gc(et.width,et.height,y.format,y.type);for(const j of y.layerUpdates){const ut=et.data.subarray(j*V/et.data.BYTES_PER_ELEMENT,(j+1)*V/et.data.BYTES_PER_ELEMENT);e.texSubImage3D(i.TEXTURE_2D_ARRAY,0,0,0,j,et.width,et.height,1,xt,kt,ut)}y.clearLayerUpdates()}else e.texSubImage3D(i.TEXTURE_2D_ARRAY,0,0,0,0,et.width,et.height,et.depth,xt,kt,et.data)}else e.texImage3D(i.TEXTURE_2D_ARRAY,0,Ft,et.width,et.height,et.depth,0,xt,kt,et.data);else if(y.isData3DTexture)Bt?(oe&&e.texStorage3D(i.TEXTURE_3D,gt,Ft,et.width,et.height,et.depth),L&&e.texSubImage3D(i.TEXTURE_3D,0,0,0,0,et.width,et.height,et.depth,xt,kt,et.data)):e.texImage3D(i.TEXTURE_3D,0,Ft,et.width,et.height,et.depth,0,xt,kt,et.data);else if(y.isFramebufferTexture){if(oe)if(Bt)e.texStorage2D(i.TEXTURE_2D,gt,Ft,et.width,et.height);else{let V=et.width,j=et.height;for(let ut=0;ut<gt;ut++)e.texImage2D(i.TEXTURE_2D,ut,Ft,V,j,0,xt,kt,null),V>>=1,j>>=1}}else if(Kt.length>0){if(Bt&&oe){const V=mt(Kt[0]);e.texStorage2D(i.TEXTURE_2D,gt,Ft,V.width,V.height)}for(let V=0,j=Kt.length;V<j;V++)Mt=Kt[V],Bt?L&&e.texSubImage2D(i.TEXTURE_2D,V,0,0,xt,kt,Mt):e.texImage2D(i.TEXTURE_2D,V,Ft,xt,kt,Mt);y.generateMipmaps=!1}else if(Bt){if(oe){const V=mt(et);e.texStorage2D(i.TEXTURE_2D,gt,Ft,V.width,V.height)}L&&e.texSubImage2D(i.TEXTURE_2D,0,0,0,xt,kt,et)}else e.texImage2D(i.TEXTURE_2D,0,Ft,xt,kt,et);p(y)&&m(q),bt.__version=Y.version,y.onUpdate&&y.onUpdate(y)}E.__version=y.version}function $(E,y,k){if(y.image.length!==6)return;const q=$t(E,y),Z=y.source;e.bindTexture(i.TEXTURE_CUBE_MAP,E.__webglTexture,i.TEXTURE0+k);const Y=n.get(Z);if(Z.version!==Y.__version||q===!0){e.activeTexture(i.TEXTURE0+k);const bt=ee.getPrimaries(ee.workingColorSpace),at=y.colorSpace===In?null:ee.getPrimaries(y.colorSpace),vt=y.colorSpace===In||bt===at?i.NONE:i.BROWSER_DEFAULT_WEBGL;i.pixelStorei(i.UNPACK_FLIP_Y_WEBGL,y.flipY),i.pixelStorei(i.UNPACK_PREMULTIPLY_ALPHA_WEBGL,y.premultiplyAlpha),i.pixelStorei(i.UNPACK_ALIGNMENT,y.unpackAlignment),i.pixelStorei(i.UNPACK_COLORSPACE_CONVERSION_WEBGL,vt);const Yt=y.isCompressedTexture||y.image[0].isCompressedTexture,et=y.image[0]&&y.image[0].isDataTexture,xt=[];for(let j=0;j<6;j++)!Yt&&!et?xt[j]=_(y.image[j],!0,s.maxCubemapSize):xt[j]=et?y.image[j].image:y.image[j],xt[j]=Ct(y,xt[j]);const kt=xt[0],Ft=r.convert(y.format,y.colorSpace),Mt=r.convert(y.type),Kt=w(y.internalFormat,Ft,Mt,y.colorSpace),Bt=y.isVideoTexture!==!0,oe=Y.__version===void 0||q===!0,L=Z.dataReady;let gt=b(y,kt);pt(i.TEXTURE_CUBE_MAP,y);let V;if(Yt){Bt&&oe&&e.texStorage2D(i.TEXTURE_CUBE_MAP,gt,Kt,kt.width,kt.height);for(let j=0;j<6;j++){V=xt[j].mipmaps;for(let ut=0;ut<V.length;ut++){const _t=V[ut];y.format!==sn?Ft!==null?Bt?L&&e.compressedTexSubImage2D(i.TEXTURE_CUBE_MAP_POSITIVE_X+j,ut,0,0,_t.width,_t.height,Ft,_t.data):e.compressedTexImage2D(i.TEXTURE_CUBE_MAP_POSITIVE_X+j,ut,Kt,_t.width,_t.height,0,_t.data):console.warn("THREE.WebGLRenderer: Attempt to load unsupported compressed texture format in .setTextureCube()"):Bt?L&&e.texSubImage2D(i.TEXTURE_CUBE_MAP_POSITIVE_X+j,ut,0,0,_t.width,_t.height,Ft,Mt,_t.data):e.texImage2D(i.TEXTURE_CUBE_MAP_POSITIVE_X+j,ut,Kt,_t.width,_t.height,0,Ft,Mt,_t.data)}}}else{if(V=y.mipmaps,Bt&&oe){V.length>0&&gt++;const j=mt(xt[0]);e.texStorage2D(i.TEXTURE_CUBE_MAP,gt,Kt,j.width,j.height)}for(let j=0;j<6;j++)if(et){Bt?L&&e.texSubImage2D(i.TEXTURE_CUBE_MAP_POSITIVE_X+j,0,0,0,xt[j].width,xt[j].height,Ft,Mt,xt[j].data):e.texImage2D(i.TEXTURE_CUBE_MAP_POSITIVE_X+j,0,Kt,xt[j].width,xt[j].height,0,Ft,Mt,xt[j].data);for(let ut=0;ut<V.length;ut++){const Zt=V[ut].image[j].image;Bt?L&&e.texSubImage2D(i.TEXTURE_CUBE_MAP_POSITIVE_X+j,ut+1,0,0,Zt.width,Zt.height,Ft,Mt,Zt.data):e.texImage2D(i.TEXTURE_CUBE_MAP_POSITIVE_X+j,ut+1,Kt,Zt.width,Zt.height,0,Ft,Mt,Zt.data)}}else{Bt?L&&e.texSubImage2D(i.TEXTURE_CUBE_MAP_POSITIVE_X+j,0,0,0,Ft,Mt,xt[j]):e.texImage2D(i.TEXTURE_CUBE_MAP_POSITIVE_X+j,0,Kt,Ft,Mt,xt[j]);for(let ut=0;ut<V.length;ut++){const _t=V[ut];Bt?L&&e.texSubImage2D(i.TEXTURE_CUBE_MAP_POSITIVE_X+j,ut+1,0,0,Ft,Mt,_t.image[j]):e.texImage2D(i.TEXTURE_CUBE_MAP_POSITIVE_X+j,ut+1,Kt,Ft,Mt,_t.image[j])}}}p(y)&&m(i.TEXTURE_CUBE_MAP),Y.__version=Z.version,y.onUpdate&&y.onUpdate(y)}E.__version=y.version}function tt(E,y,k,q,Z,Y){const bt=r.convert(k.format,k.colorSpace),at=r.convert(k.type),vt=w(k.internalFormat,bt,at,k.colorSpace);if(!n.get(y).__hasExternalTextures){const et=Math.max(1,y.width>>Y),xt=Math.max(1,y.height>>Y);Z===i.TEXTURE_3D||Z===i.TEXTURE_2D_ARRAY?e.texImage3D(Z,Y,vt,et,xt,y.depth,0,bt,at,null):e.texImage2D(Z,Y,vt,et,xt,0,bt,at,null)}e.bindFramebuffer(i.FRAMEBUFFER,E),Q(y)?a.framebufferTexture2DMultisampleEXT(i.FRAMEBUFFER,q,Z,n.get(k).__webglTexture,0,st(y)):(Z===i.TEXTURE_2D||Z>=i.TEXTURE_CUBE_MAP_POSITIVE_X&&Z<=i.TEXTURE_CUBE_MAP_NEGATIVE_Z)&&i.framebufferTexture2D(i.FRAMEBUFFER,q,Z,n.get(k).__webglTexture,Y),e.bindFramebuffer(i.FRAMEBUFFER,null)}function yt(E,y,k){if(i.bindRenderbuffer(i.RENDERBUFFER,E),y.depthBuffer){const q=y.depthTexture,Z=q&&q.isDepthTexture?q.type:null,Y=x(y.stencilBuffer,Z),bt=y.stencilBuffer?i.DEPTH_STENCIL_ATTACHMENT:i.DEPTH_ATTACHMENT,at=st(y);Q(y)?a.renderbufferStorageMultisampleEXT(i.RENDERBUFFER,at,Y,y.width,y.height):k?i.renderbufferStorageMultisample(i.RENDERBUFFER,at,Y,y.width,y.height):i.renderbufferStorage(i.RENDERBUFFER,Y,y.width,y.height),i.framebufferRenderbuffer(i.FRAMEBUFFER,bt,i.RENDERBUFFER,E)}else{const q=y.textures;for(let Z=0;Z<q.length;Z++){const Y=q[Z],bt=r.convert(Y.format,Y.colorSpace),at=r.convert(Y.type),vt=w(Y.internalFormat,bt,at,Y.colorSpace),Yt=st(y);k&&Q(y)===!1?i.renderbufferStorageMultisample(i.RENDERBUFFER,Yt,vt,y.width,y.height):Q(y)?a.renderbufferStorageMultisampleEXT(i.RENDERBUFFER,Yt,vt,y.width,y.height):i.renderbufferStorage(i.RENDERBUFFER,vt,y.width,y.height)}}i.bindRenderbuffer(i.RENDERBUFFER,null)}function lt(E,y){if(y&&y.isWebGLCubeRenderTarget)throw new Error("Depth Texture with cube render targets is not supported");if(e.bindFramebuffer(i.FRAMEBUFFER,E),!(y.depthTexture&&y.depthTexture.isDepthTexture))throw new Error("renderTarget.depthTexture must be an instance of THREE.DepthTexture");(!n.get(y.depthTexture).__webglTexture||y.depthTexture.image.width!==y.width||y.depthTexture.image.height!==y.height)&&(y.depthTexture.image.width=y.width,y.depthTexture.image.height=y.height,y.depthTexture.needsUpdate=!0),H(y.depthTexture,0);const q=n.get(y.depthTexture).__webglTexture,Z=st(y);if(y.depthTexture.format===Fi)Q(y)?a.framebufferTexture2DMultisampleEXT(i.FRAMEBUFFER,i.DEPTH_ATTACHMENT,i.TEXTURE_2D,q,0,Z):i.framebufferTexture2D(i.FRAMEBUFFER,i.DEPTH_ATTACHMENT,i.TEXTURE_2D,q,0);else if(y.depthTexture.format===Xi)Q(y)?a.framebufferTexture2DMultisampleEXT(i.FRAMEBUFFER,i.DEPTH_STENCIL_ATTACHMENT,i.TEXTURE_2D,q,0,Z):i.framebufferTexture2D(i.FRAMEBUFFER,i.DEPTH_STENCIL_ATTACHMENT,i.TEXTURE_2D,q,0);else throw new Error("Unknown depthTexture format")}function It(E){const y=n.get(E),k=E.isWebGLCubeRenderTarget===!0;if(y.__boundDepthTexture!==E.depthTexture){const q=E.depthTexture;if(y.__depthDisposeCallback&&y.__depthDisposeCallback(),q){const Z=()=>{delete y.__boundDepthTexture,delete y.__depthDisposeCallback,q.removeEventListener("dispose",Z)};q.addEventListener("dispose",Z),y.__depthDisposeCallback=Z}y.__boundDepthTexture=q}if(E.depthTexture&&!y.__autoAllocateDepthBuffer){if(k)throw new Error("target.depthTexture not supported in Cube render targets");lt(y.__webglFramebuffer,E)}else if(k){y.__webglDepthbuffer=[];for(let q=0;q<6;q++)if(e.bindFramebuffer(i.FRAMEBUFFER,y.__webglFramebuffer[q]),y.__webglDepthbuffer[q]===void 0)y.__webglDepthbuffer[q]=i.createRenderbuffer(),yt(y.__webglDepthbuffer[q],E,!1);else{const Z=E.stencilBuffer?i.DEPTH_STENCIL_ATTACHMENT:i.DEPTH_ATTACHMENT,Y=y.__webglDepthbuffer[q];i.bindRenderbuffer(i.RENDERBUFFER,Y),i.framebufferRenderbuffer(i.FRAMEBUFFER,Z,i.RENDERBUFFER,Y)}}else if(e.bindFramebuffer(i.FRAMEBUFFER,y.__webglFramebuffer),y.__webglDepthbuffer===void 0)y.__webglDepthbuffer=i.createRenderbuffer(),yt(y.__webglDepthbuffer,E,!1);else{const q=E.stencilBuffer?i.DEPTH_STENCIL_ATTACHMENT:i.DEPTH_ATTACHMENT,Z=y.__webglDepthbuffer;i.bindRenderbuffer(i.RENDERBUFFER,Z),i.framebufferRenderbuffer(i.FRAMEBUFFER,q,i.RENDERBUFFER,Z)}e.bindFramebuffer(i.FRAMEBUFFER,null)}function Dt(E,y,k){const q=n.get(E);y!==void 0&&tt(q.__webglFramebuffer,E,E.texture,i.COLOR_ATTACHMENT0,i.TEXTURE_2D,0),k!==void 0&&It(E)}function Ot(E){const y=E.texture,k=n.get(E),q=n.get(y);E.addEventListener("dispose",R);const Z=E.textures,Y=E.isWebGLCubeRenderTarget===!0,bt=Z.length>1;if(bt||(q.__webglTexture===void 0&&(q.__webglTexture=i.createTexture()),q.__version=y.version,o.memory.textures++),Y){k.__webglFramebuffer=[];for(let at=0;at<6;at++)if(y.mipmaps&&y.mipmaps.length>0){k.__webglFramebuffer[at]=[];for(let vt=0;vt<y.mipmaps.length;vt++)k.__webglFramebuffer[at][vt]=i.createFramebuffer()}else k.__webglFramebuffer[at]=i.createFramebuffer()}else{if(y.mipmaps&&y.mipmaps.length>0){k.__webglFramebuffer=[];for(let at=0;at<y.mipmaps.length;at++)k.__webglFramebuffer[at]=i.createFramebuffer()}else k.__webglFramebuffer=i.createFramebuffer();if(bt)for(let at=0,vt=Z.length;at<vt;at++){const Yt=n.get(Z[at]);Yt.__webglTexture===void 0&&(Yt.__webglTexture=i.createTexture(),o.memory.textures++)}if(E.samples>0&&Q(E)===!1){k.__webglMultisampledFramebuffer=i.createFramebuffer(),k.__webglColorRenderbuffer=[],e.bindFramebuffer(i.FRAMEBUFFER,k.__webglMultisampledFramebuffer);for(let at=0;at<Z.length;at++){const vt=Z[at];k.__webglColorRenderbuffer[at]=i.createRenderbuffer(),i.bindRenderbuffer(i.RENDERBUFFER,k.__webglColorRenderbuffer[at]);const Yt=r.convert(vt.format,vt.colorSpace),et=r.convert(vt.type),xt=w(vt.internalFormat,Yt,et,vt.colorSpace,E.isXRRenderTarget===!0),kt=st(E);i.renderbufferStorageMultisample(i.RENDERBUFFER,kt,xt,E.width,E.height),i.framebufferRenderbuffer(i.FRAMEBUFFER,i.COLOR_ATTACHMENT0+at,i.RENDERBUFFER,k.__webglColorRenderbuffer[at])}i.bindRenderbuffer(i.RENDERBUFFER,null),E.depthBuffer&&(k.__webglDepthRenderbuffer=i.createRenderbuffer(),yt(k.__webglDepthRenderbuffer,E,!0)),e.bindFramebuffer(i.FRAMEBUFFER,null)}}if(Y){e.bindTexture(i.TEXTURE_CUBE_MAP,q.__webglTexture),pt(i.TEXTURE_CUBE_MAP,y);for(let at=0;at<6;at++)if(y.mipmaps&&y.mipmaps.length>0)for(let vt=0;vt<y.mipmaps.length;vt++)tt(k.__webglFramebuffer[at][vt],E,y,i.COLOR_ATTACHMENT0,i.TEXTURE_CUBE_MAP_POSITIVE_X+at,vt);else tt(k.__webglFramebuffer[at],E,y,i.COLOR_ATTACHMENT0,i.TEXTURE_CUBE_MAP_POSITIVE_X+at,0);p(y)&&m(i.TEXTURE_CUBE_MAP),e.unbindTexture()}else if(bt){for(let at=0,vt=Z.length;at<vt;at++){const Yt=Z[at],et=n.get(Yt);e.bindTexture(i.TEXTURE_2D,et.__webglTexture),pt(i.TEXTURE_2D,Yt),tt(k.__webglFramebuffer,E,Yt,i.COLOR_ATTACHMENT0+at,i.TEXTURE_2D,0),p(Yt)&&m(i.TEXTURE_2D)}e.unbindTexture()}else{let at=i.TEXTURE_2D;if((E.isWebGL3DRenderTarget||E.isWebGLArrayRenderTarget)&&(at=E.isWebGL3DRenderTarget?i.TEXTURE_3D:i.TEXTURE_2D_ARRAY),e.bindTexture(at,q.__webglTexture),pt(at,y),y.mipmaps&&y.mipmaps.length>0)for(let vt=0;vt<y.mipmaps.length;vt++)tt(k.__webglFramebuffer[vt],E,y,i.COLOR_ATTACHMENT0,at,vt);else tt(k.__webglFramebuffer,E,y,i.COLOR_ATTACHMENT0,at,0);p(y)&&m(at),e.unbindTexture()}E.depthBuffer&&It(E)}function Gt(E){const y=E.textures;for(let k=0,q=y.length;k<q;k++){const Z=y[k];if(p(Z)){const Y=E.isWebGLCubeRenderTarget?i.TEXTURE_CUBE_MAP:i.TEXTURE_2D,bt=n.get(Z).__webglTexture;e.bindTexture(Y,bt),m(Y),e.unbindTexture()}}}const K=[],T=[];function rt(E){if(E.samples>0){if(Q(E)===!1){const y=E.textures,k=E.width,q=E.height;let Z=i.COLOR_BUFFER_BIT;const Y=E.stencilBuffer?i.DEPTH_STENCIL_ATTACHMENT:i.DEPTH_ATTACHMENT,bt=n.get(E),at=y.length>1;if(at)for(let vt=0;vt<y.length;vt++)e.bindFramebuffer(i.FRAMEBUFFER,bt.__webglMultisampledFramebuffer),i.framebufferRenderbuffer(i.FRAMEBUFFER,i.COLOR_ATTACHMENT0+vt,i.RENDERBUFFER,null),e.bindFramebuffer(i.FRAMEBUFFER,bt.__webglFramebuffer),i.framebufferTexture2D(i.DRAW_FRAMEBUFFER,i.COLOR_ATTACHMENT0+vt,i.TEXTURE_2D,null,0);e.bindFramebuffer(i.READ_FRAMEBUFFER,bt.__webglMultisampledFramebuffer),e.bindFramebuffer(i.DRAW_FRAMEBUFFER,bt.__webglFramebuffer);for(let vt=0;vt<y.length;vt++){if(E.resolveDepthBuffer&&(E.depthBuffer&&(Z|=i.DEPTH_BUFFER_BIT),E.stencilBuffer&&E.resolveStencilBuffer&&(Z|=i.STENCIL_BUFFER_BIT)),at){i.framebufferRenderbuffer(i.READ_FRAMEBUFFER,i.COLOR_ATTACHMENT0,i.RENDERBUFFER,bt.__webglColorRenderbuffer[vt]);const Yt=n.get(y[vt]).__webglTexture;i.framebufferTexture2D(i.DRAW_FRAMEBUFFER,i.COLOR_ATTACHMENT0,i.TEXTURE_2D,Yt,0)}i.blitFramebuffer(0,0,k,q,0,0,k,q,Z,i.NEAREST),c===!0&&(K.length=0,T.length=0,K.push(i.COLOR_ATTACHMENT0+vt),E.depthBuffer&&E.resolveDepthBuffer===!1&&(K.push(Y),T.push(Y),i.invalidateFramebuffer(i.DRAW_FRAMEBUFFER,T)),i.invalidateFramebuffer(i.READ_FRAMEBUFFER,K))}if(e.bindFramebuffer(i.READ_FRAMEBUFFER,null),e.bindFramebuffer(i.DRAW_FRAMEBUFFER,null),at)for(let vt=0;vt<y.length;vt++){e.bindFramebuffer(i.FRAMEBUFFER,bt.__webglMultisampledFramebuffer),i.framebufferRenderbuffer(i.FRAMEBUFFER,i.COLOR_ATTACHMENT0+vt,i.RENDERBUFFER,bt.__webglColorRenderbuffer[vt]);const Yt=n.get(y[vt]).__webglTexture;e.bindFramebuffer(i.FRAMEBUFFER,bt.__webglFramebuffer),i.framebufferTexture2D(i.DRAW_FRAMEBUFFER,i.COLOR_ATTACHMENT0+vt,i.TEXTURE_2D,Yt,0)}e.bindFramebuffer(i.DRAW_FRAMEBUFFER,bt.__webglMultisampledFramebuffer)}else if(E.depthBuffer&&E.resolveDepthBuffer===!1&&c){const y=E.stencilBuffer?i.DEPTH_STENCIL_ATTACHMENT:i.DEPTH_ATTACHMENT;i.invalidateFramebuffer(i.DRAW_FRAMEBUFFER,[y])}}}function st(E){return Math.min(s.maxSamples,E.samples)}function Q(E){const y=n.get(E);return E.samples>0&&t.has("WEBGL_multisampled_render_to_texture")===!0&&y.__useRenderToTexture!==!1}function ot(E){const y=o.render.frame;h.get(E)!==y&&(h.set(E,y),E.update())}function Ct(E,y){const k=E.colorSpace,q=E.format,Z=E.type;return E.isCompressedTexture===!0||E.isVideoTexture===!0||k!==Xn&&k!==In&&(ee.getTransfer(k)===le?(q!==sn||Z!==bn)&&console.warn("THREE.WebGLTextures: sRGB encoded textures have to use RGBAFormat and UnsignedByteType."):console.error("THREE.WebGLTextures: Unsupported texture color space:",k)),y}function mt(E){return typeof HTMLImageElement<"u"&&E instanceof HTMLImageElement?(l.width=E.naturalWidth||E.width,l.height=E.naturalHeight||E.height):typeof VideoFrame<"u"&&E instanceof VideoFrame?(l.width=E.displayWidth,l.height=E.displayHeight):(l.width=E.width,l.height=E.height),l}this.allocateTextureUnit=F,this.resetTextureUnits=S,this.setTexture2D=H,this.setTexture2DArray=X,this.setTexture3D=z,this.setTextureCube=J,this.rebindTextures=Dt,this.setupRenderTarget=Ot,this.updateRenderTargetMipmap=Gt,this.updateMultisampleRenderTarget=rt,this.setupDepthRenderbuffer=It,this.setupFrameBufferTexture=tt,this.useMultisampledRTT=Q}function Hg(i,t){function e(n,s=In){let r;const o=ee.getTransfer(s);if(n===bn)return i.UNSIGNED_BYTE;if(n===Ma)return i.UNSIGNED_SHORT_4_4_4_4;if(n===Sa)return i.UNSIGNED_SHORT_5_5_5_1;if(n===Pl)return i.UNSIGNED_INT_5_9_9_9_REV;if(n===Cl)return i.BYTE;if(n===Rl)return i.SHORT;if(n===gs)return i.UNSIGNED_SHORT;if(n===ya)return i.INT;if(n===ri)return i.UNSIGNED_INT;if(n===xn)return i.FLOAT;if(n===Ss)return i.HALF_FLOAT;if(n===Ll)return i.ALPHA;if(n===Dl)return i.RGB;if(n===sn)return i.RGBA;if(n===Il)return i.LUMINANCE;if(n===Ul)return i.LUMINANCE_ALPHA;if(n===Fi)return i.DEPTH_COMPONENT;if(n===Xi)return i.DEPTH_STENCIL;if(n===Nl)return i.RED;if(n===ba)return i.RED_INTEGER;if(n===kl)return i.RG;if(n===Ea)return i.RG_INTEGER;if(n===Ta)return i.RGBA_INTEGER;if(n===sr||n===rr||n===or||n===ar)if(o===le)if(r=t.get("WEBGL_compressed_texture_s3tc_srgb"),r!==null){if(n===sr)return r.COMPRESSED_SRGB_S3TC_DXT1_EXT;if(n===rr)return r.COMPRESSED_SRGB_ALPHA_S3TC_DXT1_EXT;if(n===or)return r.COMPRESSED_SRGB_ALPHA_S3TC_DXT3_EXT;if(n===ar)return r.COMPRESSED_SRGB_ALPHA_S3TC_DXT5_EXT}else return null;else if(r=t.get("WEBGL_compressed_texture_s3tc"),r!==null){if(n===sr)return r.COMPRESSED_RGB_S3TC_DXT1_EXT;if(n===rr)return r.COMPRESSED_RGBA_S3TC_DXT1_EXT;if(n===or)return r.COMPRESSED_RGBA_S3TC_DXT3_EXT;if(n===ar)return r.COMPRESSED_RGBA_S3TC_DXT5_EXT}else return null;if(n===No||n===ko||n===Fo||n===Oo)if(r=t.get("WEBGL_compressed_texture_pvrtc"),r!==null){if(n===No)return r.COMPRESSED_RGB_PVRTC_4BPPV1_IMG;if(n===ko)return r.COMPRESSED_RGB_PVRTC_2BPPV1_IMG;if(n===Fo)return r.COMPRESSED_RGBA_PVRTC_4BPPV1_IMG;if(n===Oo)return r.COMPRESSED_RGBA_PVRTC_2BPPV1_IMG}else return null;if(n===Bo||n===zo||n===Ho)if(r=t.get("WEBGL_compressed_texture_etc"),r!==null){if(n===Bo||n===zo)return o===le?r.COMPRESSED_SRGB8_ETC2:r.COMPRESSED_RGB8_ETC2;if(n===Ho)return o===le?r.COMPRESSED_SRGB8_ALPHA8_ETC2_EAC:r.COMPRESSED_RGBA8_ETC2_EAC}else return null;if(n===Vo||n===Go||n===Wo||n===Xo||n===$o||n===qo||n===Yo||n===Ko||n===Zo||n===jo||n===Jo||n===Qo||n===ta||n===ea)if(r=t.get("WEBGL_compressed_texture_astc"),r!==null){if(n===Vo)return o===le?r.COMPRESSED_SRGB8_ALPHA8_ASTC_4x4_KHR:r.COMPRESSED_RGBA_ASTC_4x4_KHR;if(n===Go)return o===le?r.COMPRESSED_SRGB8_ALPHA8_ASTC_5x4_KHR:r.COMPRESSED_RGBA_ASTC_5x4_KHR;if(n===Wo)return o===le?r.COMPRESSED_SRGB8_ALPHA8_ASTC_5x5_KHR:r.COMPRESSED_RGBA_ASTC_5x5_KHR;if(n===Xo)return o===le?r.COMPRESSED_SRGB8_ALPHA8_ASTC_6x5_KHR:r.COMPRESSED_RGBA_ASTC_6x5_KHR;if(n===$o)return o===le?r.COMPRESSED_SRGB8_ALPHA8_ASTC_6x6_KHR:r.COMPRESSED_RGBA_ASTC_6x6_KHR;if(n===qo)return o===le?r.COMPRESSED_SRGB8_ALPHA8_ASTC_8x5_KHR:r.COMPRESSED_RGBA_ASTC_8x5_KHR;if(n===Yo)return o===le?r.COMPRESSED_SRGB8_ALPHA8_ASTC_8x6_KHR:r.COMPRESSED_RGBA_ASTC_8x6_KHR;if(n===Ko)return o===le?r.COMPRESSED_SRGB8_ALPHA8_ASTC_8x8_KHR:r.COMPRESSED_RGBA_ASTC_8x8_KHR;if(n===Zo)return o===le?r.COMPRESSED_SRGB8_ALPHA8_ASTC_10x5_KHR:r.COMPRESSED_RGBA_ASTC_10x5_KHR;if(n===jo)return o===le?r.COMPRESSED_SRGB8_ALPHA8_ASTC_10x6_KHR:r.COMPRESSED_RGBA_ASTC_10x6_KHR;if(n===Jo)return o===le?r.COMPRESSED_SRGB8_ALPHA8_ASTC_10x8_KHR:r.COMPRESSED_RGBA_ASTC_10x8_KHR;if(n===Qo)return o===le?r.COMPRESSED_SRGB8_ALPHA8_ASTC_10x10_KHR:r.COMPRESSED_RGBA_ASTC_10x10_KHR;if(n===ta)return o===le?r.COMPRESSED_SRGB8_ALPHA8_ASTC_12x10_KHR:r.COMPRESSED_RGBA_ASTC_12x10_KHR;if(n===ea)return o===le?r.COMPRESSED_SRGB8_ALPHA8_ASTC_12x12_KHR:r.COMPRESSED_RGBA_ASTC_12x12_KHR}else return null;if(n===cr||n===na||n===ia)if(r=t.get("EXT_texture_compression_bptc"),r!==null){if(n===cr)return o===le?r.COMPRESSED_SRGB_ALPHA_BPTC_UNORM_EXT:r.COMPRESSED_RGBA_BPTC_UNORM_EXT;if(n===na)return r.COMPRESSED_RGB_BPTC_SIGNED_FLOAT_EXT;if(n===ia)return r.COMPRESSED_RGB_BPTC_UNSIGNED_FLOAT_EXT}else return null;if(n===Fl||n===sa||n===ra||n===oa)if(r=t.get("EXT_texture_compression_rgtc"),r!==null){if(n===cr)return r.COMPRESSED_RED_RGTC1_EXT;if(n===sa)return r.COMPRESSED_SIGNED_RED_RGTC1_EXT;if(n===ra)return r.COMPRESSED_RED_GREEN_RGTC2_EXT;if(n===oa)return r.COMPRESSED_SIGNED_RED_GREEN_RGTC2_EXT}else return null;return n===Wi?i.UNSIGNED_INT_24_8:i[n]!==void 0?i[n]:null}return{convert:e}}class Vg extends He{constructor(t=[]){super(),this.isArrayCamera=!0,this.cameras=t}}class Ii extends Me{constructor(){super(),this.isGroup=!0,this.type="Group"}}const Gg={type:"move"};class ao{constructor(){this._targetRay=null,this._grip=null,this._hand=null}getHandSpace(){return this._hand===null&&(this._hand=new Ii,this._hand.matrixAutoUpdate=!1,this._hand.visible=!1,this._hand.joints={},this._hand.inputState={pinching:!1}),this._hand}getTargetRaySpace(){return this._targetRay===null&&(this._targetRay=new Ii,this._targetRay.matrixAutoUpdate=!1,this._targetRay.visible=!1,this._targetRay.hasLinearVelocity=!1,this._targetRay.linearVelocity=new C,this._targetRay.hasAngularVelocity=!1,this._targetRay.angularVelocity=new C),this._targetRay}getGripSpace(){return this._grip===null&&(this._grip=new Ii,this._grip.matrixAutoUpdate=!1,this._grip.visible=!1,this._grip.hasLinearVelocity=!1,this._grip.linearVelocity=new C,this._grip.hasAngularVelocity=!1,this._grip.angularVelocity=new C),this._grip}dispatchEvent(t){return this._targetRay!==null&&this._targetRay.dispatchEvent(t),this._grip!==null&&this._grip.dispatchEvent(t),this._hand!==null&&this._hand.dispatchEvent(t),this}connect(t){if(t&&t.hand){const e=this._hand;if(e)for(const n of t.hand.values())this._getHandJoint(e,n)}return this.dispatchEvent({type:"connected",data:t}),this}disconnect(t){return this.dispatchEvent({type:"disconnected",data:t}),this._targetRay!==null&&(this._targetRay.visible=!1),this._grip!==null&&(this._grip.visible=!1),this._hand!==null&&(this._hand.visible=!1),this}update(t,e,n){let s=null,r=null,o=null;const a=this._targetRay,c=this._grip,l=this._hand;if(t&&e.session.visibilityState!=="visible-blurred"){if(l&&t.hand){o=!0;for(const _ of t.hand.values()){const p=e.getJointPose(_,n),m=this._getHandJoint(l,_);p!==null&&(m.matrix.fromArray(p.transform.matrix),m.matrix.decompose(m.position,m.rotation,m.scale),m.matrixWorldNeedsUpdate=!0,m.jointRadius=p.radius),m.visible=p!==null}const h=l.joints["index-finger-tip"],d=l.joints["thumb-tip"],u=h.position.distanceTo(d.position),f=.02,g=.005;l.inputState.pinching&&u>f+g?(l.inputState.pinching=!1,this.dispatchEvent({type:"pinchend",handedness:t.handedness,target:this})):!l.inputState.pinching&&u<=f-g&&(l.inputState.pinching=!0,this.dispatchEvent({type:"pinchstart",handedness:t.handedness,target:this}))}else c!==null&&t.gripSpace&&(r=e.getPose(t.gripSpace,n),r!==null&&(c.matrix.fromArray(r.transform.matrix),c.matrix.decompose(c.position,c.rotation,c.scale),c.matrixWorldNeedsUpdate=!0,r.linearVelocity?(c.hasLinearVelocity=!0,c.linearVelocity.copy(r.linearVelocity)):c.hasLinearVelocity=!1,r.angularVelocity?(c.hasAngularVelocity=!0,c.angularVelocity.copy(r.angularVelocity)):c.hasAngularVelocity=!1));a!==null&&(s=e.getPose(t.targetRaySpace,n),s===null&&r!==null&&(s=r),s!==null&&(a.matrix.fromArray(s.transform.matrix),a.matrix.decompose(a.position,a.rotation,a.scale),a.matrixWorldNeedsUpdate=!0,s.linearVelocity?(a.hasLinearVelocity=!0,a.linearVelocity.copy(s.linearVelocity)):a.hasLinearVelocity=!1,s.angularVelocity?(a.hasAngularVelocity=!0,a.angularVelocity.copy(s.angularVelocity)):a.hasAngularVelocity=!1,this.dispatchEvent(Gg)))}return a!==null&&(a.visible=s!==null),c!==null&&(c.visible=r!==null),l!==null&&(l.visible=o!==null),this}_getHandJoint(t,e){if(t.joints[e.jointName]===void 0){const n=new Ii;n.matrixAutoUpdate=!1,n.visible=!1,t.joints[e.jointName]=n,t.add(n)}return t.joints[e.jointName]}}const Wg=`
void main() {

	gl_Position = vec4( position, 1.0 );

}`,Xg=`
uniform sampler2DArray depthColor;
uniform float depthWidth;
uniform float depthHeight;

void main() {

	vec2 coord = vec2( gl_FragCoord.x / depthWidth, gl_FragCoord.y / depthHeight );

	if ( coord.x >= 1.0 ) {

		gl_FragDepth = texture( depthColor, vec3( coord.x - 1.0, coord.y, 1 ) ).r;

	} else {

		gl_FragDepth = texture( depthColor, vec3( coord.x, coord.y, 0 ) ).r;

	}

}`;class $g{constructor(){this.texture=null,this.mesh=null,this.depthNear=0,this.depthFar=0}init(t,e,n){if(this.texture===null){const s=new Ue,r=t.properties.get(s);r.__webglTexture=e.texture,(e.depthNear!=n.depthNear||e.depthFar!=n.depthFar)&&(this.depthNear=e.depthNear,this.depthFar=e.depthFar),this.texture=s}}getMesh(t){if(this.texture!==null&&this.mesh===null){const e=t.cameras[0].viewport,n=new Hn({vertexShader:Wg,fragmentShader:Xg,uniforms:{depthColor:{value:this.texture},depthWidth:{value:e.z},depthHeight:{value:e.w}}});this.mesh=new ae(new bs(20,20),n)}return this.mesh}reset(){this.texture=null,this.mesh=null}getDepthTexture(){return this.texture}}class qg extends hi{constructor(t,e){super();const n=this;let s=null,r=1,o=null,a="local-floor",c=1,l=null,h=null,d=null,u=null,f=null,g=null;const _=new $g,p=e.getContextAttributes();let m=null,w=null;const x=[],b=[],I=new nt;let R=null;const A=new He;A.layers.enable(1),A.viewport=new se;const P=new He;P.layers.enable(2),P.viewport=new se;const W=[A,P],v=new Vg;v.layers.enable(1),v.layers.enable(2);let S=null,F=null;this.cameraAutoUpdate=!0,this.enabled=!1,this.isPresenting=!1,this.getController=function($){let tt=x[$];return tt===void 0&&(tt=new ao,x[$]=tt),tt.getTargetRaySpace()},this.getControllerGrip=function($){let tt=x[$];return tt===void 0&&(tt=new ao,x[$]=tt),tt.getGripSpace()},this.getHand=function($){let tt=x[$];return tt===void 0&&(tt=new ao,x[$]=tt),tt.getHandSpace()};function N($){const tt=b.indexOf($.inputSource);if(tt===-1)return;const yt=x[tt];yt!==void 0&&(yt.update($.inputSource,$.frame,l||o),yt.dispatchEvent({type:$.type,data:$.inputSource}))}function H(){s.removeEventListener("select",N),s.removeEventListener("selectstart",N),s.removeEventListener("selectend",N),s.removeEventListener("squeeze",N),s.removeEventListener("squeezestart",N),s.removeEventListener("squeezeend",N),s.removeEventListener("end",H),s.removeEventListener("inputsourceschange",X);for(let $=0;$<x.length;$++){const tt=b[$];tt!==null&&(b[$]=null,x[$].disconnect(tt))}S=null,F=null,_.reset(),t.setRenderTarget(m),f=null,u=null,d=null,s=null,w=null,jt.stop(),n.isPresenting=!1,t.setPixelRatio(R),t.setSize(I.width,I.height,!1),n.dispatchEvent({type:"sessionend"})}this.setFramebufferScaleFactor=function($){r=$,n.isPresenting===!0&&console.warn("THREE.WebXRManager: Cannot change framebuffer scale while presenting.")},this.setReferenceSpaceType=function($){a=$,n.isPresenting===!0&&console.warn("THREE.WebXRManager: Cannot change reference space type while presenting.")},this.getReferenceSpace=function(){return l||o},this.setReferenceSpace=function($){l=$},this.getBaseLayer=function(){return u!==null?u:f},this.getBinding=function(){return d},this.getFrame=function(){return g},this.getSession=function(){return s},this.setSession=async function($){if(s=$,s!==null){if(m=t.getRenderTarget(),s.addEventListener("select",N),s.addEventListener("selectstart",N),s.addEventListener("selectend",N),s.addEventListener("squeeze",N),s.addEventListener("squeezestart",N),s.addEventListener("squeezeend",N),s.addEventListener("end",H),s.addEventListener("inputsourceschange",X),p.xrCompatible!==!0&&await e.makeXRCompatible(),R=t.getPixelRatio(),t.getSize(I),s.renderState.layers===void 0){const tt={antialias:p.antialias,alpha:!0,depth:p.depth,stencil:p.stencil,framebufferScaleFactor:r};f=new XRWebGLLayer(s,e,tt),s.updateRenderState({baseLayer:f}),t.setPixelRatio(1),t.setSize(f.framebufferWidth,f.framebufferHeight,!1),w=new oi(f.framebufferWidth,f.framebufferHeight,{format:sn,type:bn,colorSpace:t.outputColorSpace,stencilBuffer:p.stencil})}else{let tt=null,yt=null,lt=null;p.depth&&(lt=p.stencil?e.DEPTH24_STENCIL8:e.DEPTH_COMPONENT24,tt=p.stencil?Xi:Fi,yt=p.stencil?Wi:ri);const It={colorFormat:e.RGBA8,depthFormat:lt,scaleFactor:r};d=new XRWebGLBinding(s,e),u=d.createProjectionLayer(It),s.updateRenderState({layers:[u]}),t.setPixelRatio(1),t.setSize(u.textureWidth,u.textureHeight,!1),w=new oi(u.textureWidth,u.textureHeight,{format:sn,type:bn,depthTexture:new Jl(u.textureWidth,u.textureHeight,yt,void 0,void 0,void 0,void 0,void 0,void 0,tt),stencilBuffer:p.stencil,colorSpace:t.outputColorSpace,samples:p.antialias?4:0,resolveDepthBuffer:u.ignoreDepthValues===!1})}w.isXRRenderTarget=!0,this.setFoveation(c),l=null,o=await s.requestReferenceSpace(a),jt.setContext(s),jt.start(),n.isPresenting=!0,n.dispatchEvent({type:"sessionstart"})}},this.getEnvironmentBlendMode=function(){if(s!==null)return s.environmentBlendMode},this.getDepthTexture=function(){return _.getDepthTexture()};function X($){for(let tt=0;tt<$.removed.length;tt++){const yt=$.removed[tt],lt=b.indexOf(yt);lt>=0&&(b[lt]=null,x[lt].disconnect(yt))}for(let tt=0;tt<$.added.length;tt++){const yt=$.added[tt];let lt=b.indexOf(yt);if(lt===-1){for(let Dt=0;Dt<x.length;Dt++)if(Dt>=b.length){b.push(yt),lt=Dt;break}else if(b[Dt]===null){b[Dt]=yt,lt=Dt;break}if(lt===-1)break}const It=x[lt];It&&It.connect(yt)}}const z=new C,J=new C;function G($,tt,yt){z.setFromMatrixPosition(tt.matrixWorld),J.setFromMatrixPosition(yt.matrixWorld);const lt=z.distanceTo(J),It=tt.projectionMatrix.elements,Dt=yt.projectionMatrix.elements,Ot=It[14]/(It[10]-1),Gt=It[14]/(It[10]+1),K=(It[9]+1)/It[5],T=(It[9]-1)/It[5],rt=(It[8]-1)/It[0],st=(Dt[8]+1)/Dt[0],Q=Ot*rt,ot=Ot*st,Ct=lt/(-rt+st),mt=Ct*-rt;if(tt.matrixWorld.decompose($.position,$.quaternion,$.scale),$.translateX(mt),$.translateZ(Ct),$.matrixWorld.compose($.position,$.quaternion,$.scale),$.matrixWorldInverse.copy($.matrixWorld).invert(),It[10]===-1)$.projectionMatrix.copy(tt.projectionMatrix),$.projectionMatrixInverse.copy(tt.projectionMatrixInverse);else{const E=Ot+Ct,y=Gt+Ct,k=Q-mt,q=ot+(lt-mt),Z=K*Gt/y*E,Y=T*Gt/y*E;$.projectionMatrix.makePerspective(k,q,Z,Y,E,y),$.projectionMatrixInverse.copy($.projectionMatrix).invert()}}function ht($,tt){tt===null?$.matrixWorld.copy($.matrix):$.matrixWorld.multiplyMatrices(tt.matrixWorld,$.matrix),$.matrixWorldInverse.copy($.matrixWorld).invert()}this.updateCamera=function($){if(s===null)return;let tt=$.near,yt=$.far;_.texture!==null&&(_.depthNear>0&&(tt=_.depthNear),_.depthFar>0&&(yt=_.depthFar)),v.near=P.near=A.near=tt,v.far=P.far=A.far=yt,(S!==v.near||F!==v.far)&&(s.updateRenderState({depthNear:v.near,depthFar:v.far}),S=v.near,F=v.far);const lt=$.parent,It=v.cameras;ht(v,lt);for(let Dt=0;Dt<It.length;Dt++)ht(It[Dt],lt);It.length===2?G(v,A,P):v.projectionMatrix.copy(A.projectionMatrix),ft($,v,lt)};function ft($,tt,yt){yt===null?$.matrix.copy(tt.matrixWorld):($.matrix.copy(yt.matrixWorld),$.matrix.invert(),$.matrix.multiply(tt.matrixWorld)),$.matrix.decompose($.position,$.quaternion,$.scale),$.updateMatrixWorld(!0),$.projectionMatrix.copy(tt.projectionMatrix),$.projectionMatrixInverse.copy(tt.projectionMatrixInverse),$.isPerspectiveCamera&&($.fov=_s*2*Math.atan(1/$.projectionMatrix.elements[5]),$.zoom=1)}this.getCamera=function(){return v},this.getFoveation=function(){if(!(u===null&&f===null))return c},this.setFoveation=function($){c=$,u!==null&&(u.fixedFoveation=$),f!==null&&f.fixedFoveation!==void 0&&(f.fixedFoveation=$)},this.hasDepthSensing=function(){return _.texture!==null},this.getDepthSensingMesh=function(){return _.getMesh(v)};let pt=null;function $t($,tt){if(h=tt.getViewerPose(l||o),g=tt,h!==null){const yt=h.views;f!==null&&(t.setRenderTargetFramebuffer(w,f.framebuffer),t.setRenderTarget(w));let lt=!1;yt.length!==v.cameras.length&&(v.cameras.length=0,lt=!0);for(let Dt=0;Dt<yt.length;Dt++){const Ot=yt[Dt];let Gt=null;if(f!==null)Gt=f.getViewport(Ot);else{const T=d.getViewSubImage(u,Ot);Gt=T.viewport,Dt===0&&(t.setRenderTargetTextures(w,T.colorTexture,u.ignoreDepthValues?void 0:T.depthStencilTexture),t.setRenderTarget(w))}let K=W[Dt];K===void 0&&(K=new He,K.layers.enable(Dt),K.viewport=new se,W[Dt]=K),K.matrix.fromArray(Ot.transform.matrix),K.matrix.decompose(K.position,K.quaternion,K.scale),K.projectionMatrix.fromArray(Ot.projectionMatrix),K.projectionMatrixInverse.copy(K.projectionMatrix).invert(),K.viewport.set(Gt.x,Gt.y,Gt.width,Gt.height),Dt===0&&(v.matrix.copy(K.matrix),v.matrix.decompose(v.position,v.quaternion,v.scale)),lt===!0&&v.cameras.push(K)}const It=s.enabledFeatures;if(It&&It.includes("depth-sensing")){const Dt=d.getDepthInformation(yt[0]);Dt&&Dt.isValid&&Dt.texture&&_.init(t,Dt,s.renderState)}}for(let yt=0;yt<x.length;yt++){const lt=b[yt],It=x[yt];lt!==null&&It!==void 0&&It.update(lt,tt,l||o)}pt&&pt($,tt),tt.detectedPlanes&&n.dispatchEvent({type:"planesdetected",data:tt}),g=null}const jt=new Zl;jt.setAnimationLoop($t),this.setAnimationLoop=function($){pt=$},this.dispose=function(){}}}const Jn=new on,Yg=new re;function Kg(i,t){function e(p,m){p.matrixAutoUpdate===!0&&p.updateMatrix(),m.value.copy(p.matrix)}function n(p,m){m.color.getRGB(p.fogColor.value,ql(i)),m.isFog?(p.fogNear.value=m.near,p.fogFar.value=m.far):m.isFogExp2&&(p.fogDensity.value=m.density)}function s(p,m,w,x,b){m.isMeshBasicMaterial||m.isMeshLambertMaterial?r(p,m):m.isMeshToonMaterial?(r(p,m),d(p,m)):m.isMeshPhongMaterial?(r(p,m),h(p,m)):m.isMeshStandardMaterial?(r(p,m),u(p,m),m.isMeshPhysicalMaterial&&f(p,m,b)):m.isMeshMatcapMaterial?(r(p,m),g(p,m)):m.isMeshDepthMaterial?r(p,m):m.isMeshDistanceMaterial?(r(p,m),_(p,m)):m.isMeshNormalMaterial?r(p,m):m.isLineBasicMaterial?(o(p,m),m.isLineDashedMaterial&&a(p,m)):m.isPointsMaterial?c(p,m,w,x):m.isSpriteMaterial?l(p,m):m.isShadowMaterial?(p.color.value.copy(m.color),p.opacity.value=m.opacity):m.isShaderMaterial&&(m.uniformsNeedUpdate=!1)}function r(p,m){p.opacity.value=m.opacity,m.color&&p.diffuse.value.copy(m.color),m.emissive&&p.emissive.value.copy(m.emissive).multiplyScalar(m.emissiveIntensity),m.map&&(p.map.value=m.map,e(m.map,p.mapTransform)),m.alphaMap&&(p.alphaMap.value=m.alphaMap,e(m.alphaMap,p.alphaMapTransform)),m.bumpMap&&(p.bumpMap.value=m.bumpMap,e(m.bumpMap,p.bumpMapTransform),p.bumpScale.value=m.bumpScale,m.side===Re&&(p.bumpScale.value*=-1)),m.normalMap&&(p.normalMap.value=m.normalMap,e(m.normalMap,p.normalMapTransform),p.normalScale.value.copy(m.normalScale),m.side===Re&&p.normalScale.value.negate()),m.displacementMap&&(p.displacementMap.value=m.displacementMap,e(m.displacementMap,p.displacementMapTransform),p.displacementScale.value=m.displacementScale,p.displacementBias.value=m.displacementBias),m.emissiveMap&&(p.emissiveMap.value=m.emissiveMap,e(m.emissiveMap,p.emissiveMapTransform)),m.specularMap&&(p.specularMap.value=m.specularMap,e(m.specularMap,p.specularMapTransform)),m.alphaTest>0&&(p.alphaTest.value=m.alphaTest);const w=t.get(m),x=w.envMap,b=w.envMapRotation;x&&(p.envMap.value=x,Jn.copy(b),Jn.x*=-1,Jn.y*=-1,Jn.z*=-1,x.isCubeTexture&&x.isRenderTargetTexture===!1&&(Jn.y*=-1,Jn.z*=-1),p.envMapRotation.value.setFromMatrix4(Yg.makeRotationFromEuler(Jn)),p.flipEnvMap.value=x.isCubeTexture&&x.isRenderTargetTexture===!1?-1:1,p.reflectivity.value=m.reflectivity,p.ior.value=m.ior,p.refractionRatio.value=m.refractionRatio),m.lightMap&&(p.lightMap.value=m.lightMap,p.lightMapIntensity.value=m.lightMapIntensity,e(m.lightMap,p.lightMapTransform)),m.aoMap&&(p.aoMap.value=m.aoMap,p.aoMapIntensity.value=m.aoMapIntensity,e(m.aoMap,p.aoMapTransform))}function o(p,m){p.diffuse.value.copy(m.color),p.opacity.value=m.opacity,m.map&&(p.map.value=m.map,e(m.map,p.mapTransform))}function a(p,m){p.dashSize.value=m.dashSize,p.totalSize.value=m.dashSize+m.gapSize,p.scale.value=m.scale}function c(p,m,w,x){p.diffuse.value.copy(m.color),p.opacity.value=m.opacity,p.size.value=m.size*w,p.scale.value=x*.5,m.map&&(p.map.value=m.map,e(m.map,p.uvTransform)),m.alphaMap&&(p.alphaMap.value=m.alphaMap,e(m.alphaMap,p.alphaMapTransform)),m.alphaTest>0&&(p.alphaTest.value=m.alphaTest)}function l(p,m){p.diffuse.value.copy(m.color),p.opacity.value=m.opacity,p.rotation.value=m.rotation,m.map&&(p.map.value=m.map,e(m.map,p.mapTransform)),m.alphaMap&&(p.alphaMap.value=m.alphaMap,e(m.alphaMap,p.alphaMapTransform)),m.alphaTest>0&&(p.alphaTest.value=m.alphaTest)}function h(p,m){p.specular.value.copy(m.specular),p.shininess.value=Math.max(m.shininess,1e-4)}function d(p,m){m.gradientMap&&(p.gradientMap.value=m.gradientMap)}function u(p,m){p.metalness.value=m.metalness,m.metalnessMap&&(p.metalnessMap.value=m.metalnessMap,e(m.metalnessMap,p.metalnessMapTransform)),p.roughness.value=m.roughness,m.roughnessMap&&(p.roughnessMap.value=m.roughnessMap,e(m.roughnessMap,p.roughnessMapTransform)),m.envMap&&(p.envMapIntensity.value=m.envMapIntensity)}function f(p,m,w){p.ior.value=m.ior,m.sheen>0&&(p.sheenColor.value.copy(m.sheenColor).multiplyScalar(m.sheen),p.sheenRoughness.value=m.sheenRoughness,m.sheenColorMap&&(p.sheenColorMap.value=m.sheenColorMap,e(m.sheenColorMap,p.sheenColorMapTransform)),m.sheenRoughnessMap&&(p.sheenRoughnessMap.value=m.sheenRoughnessMap,e(m.sheenRoughnessMap,p.sheenRoughnessMapTransform))),m.clearcoat>0&&(p.clearcoat.value=m.clearcoat,p.clearcoatRoughness.value=m.clearcoatRoughness,m.clearcoatMap&&(p.clearcoatMap.value=m.clearcoatMap,e(m.clearcoatMap,p.clearcoatMapTransform)),m.clearcoatRoughnessMap&&(p.clearcoatRoughnessMap.value=m.clearcoatRoughnessMap,e(m.clearcoatRoughnessMap,p.clearcoatRoughnessMapTransform)),m.clearcoatNormalMap&&(p.clearcoatNormalMap.value=m.clearcoatNormalMap,e(m.clearcoatNormalMap,p.clearcoatNormalMapTransform),p.clearcoatNormalScale.value.copy(m.clearcoatNormalScale),m.side===Re&&p.clearcoatNormalScale.value.negate())),m.dispersion>0&&(p.dispersion.value=m.dispersion),m.iridescence>0&&(p.iridescence.value=m.iridescence,p.iridescenceIOR.value=m.iridescenceIOR,p.iridescenceThicknessMinimum.value=m.iridescenceThicknessRange[0],p.iridescenceThicknessMaximum.value=m.iridescenceThicknessRange[1],m.iridescenceMap&&(p.iridescenceMap.value=m.iridescenceMap,e(m.iridescenceMap,p.iridescenceMapTransform)),m.iridescenceThicknessMap&&(p.iridescenceThicknessMap.value=m.iridescenceThicknessMap,e(m.iridescenceThicknessMap,p.iridescenceThicknessMapTransform))),m.transmission>0&&(p.transmission.value=m.transmission,p.transmissionSamplerMap.value=w.texture,p.transmissionSamplerSize.value.set(w.width,w.height),m.transmissionMap&&(p.transmissionMap.value=m.transmissionMap,e(m.transmissionMap,p.transmissionMapTransform)),p.thickness.value=m.thickness,m.thicknessMap&&(p.thicknessMap.value=m.thicknessMap,e(m.thicknessMap,p.thicknessMapTransform)),p.attenuationDistance.value=m.attenuationDistance,p.attenuationColor.value.copy(m.attenuationColor)),m.anisotropy>0&&(p.anisotropyVector.value.set(m.anisotropy*Math.cos(m.anisotropyRotation),m.anisotropy*Math.sin(m.anisotropyRotation)),m.anisotropyMap&&(p.anisotropyMap.value=m.anisotropyMap,e(m.anisotropyMap,p.anisotropyMapTransform))),p.specularIntensity.value=m.specularIntensity,p.specularColor.value.copy(m.specularColor),m.specularColorMap&&(p.specularColorMap.value=m.specularColorMap,e(m.specularColorMap,p.specularColorMapTransform)),m.specularIntensityMap&&(p.specularIntensityMap.value=m.specularIntensityMap,e(m.specularIntensityMap,p.specularIntensityMapTransform))}function g(p,m){m.matcap&&(p.matcap.value=m.matcap)}function _(p,m){const w=t.get(m).light;p.referencePosition.value.setFromMatrixPosition(w.matrixWorld),p.nearDistance.value=w.shadow.camera.near,p.farDistance.value=w.shadow.camera.far}return{refreshFogUniforms:n,refreshMaterialUniforms:s}}function Zg(i,t,e,n){let s={},r={},o=[];const a=i.getParameter(i.MAX_UNIFORM_BUFFER_BINDINGS);function c(w,x){const b=x.program;n.uniformBlockBinding(w,b)}function l(w,x){let b=s[w.id];b===void 0&&(g(w),b=h(w),s[w.id]=b,w.addEventListener("dispose",p));const I=x.program;n.updateUBOMapping(w,I);const R=t.render.frame;r[w.id]!==R&&(u(w),r[w.id]=R)}function h(w){const x=d();w.__bindingPointIndex=x;const b=i.createBuffer(),I=w.__size,R=w.usage;return i.bindBuffer(i.UNIFORM_BUFFER,b),i.bufferData(i.UNIFORM_BUFFER,I,R),i.bindBuffer(i.UNIFORM_BUFFER,null),i.bindBufferBase(i.UNIFORM_BUFFER,x,b),b}function d(){for(let w=0;w<a;w++)if(o.indexOf(w)===-1)return o.push(w),w;return console.error("THREE.WebGLRenderer: Maximum number of simultaneously usable uniforms groups reached."),0}function u(w){const x=s[w.id],b=w.uniforms,I=w.__cache;i.bindBuffer(i.UNIFORM_BUFFER,x);for(let R=0,A=b.length;R<A;R++){const P=Array.isArray(b[R])?b[R]:[b[R]];for(let W=0,v=P.length;W<v;W++){const S=P[W];if(f(S,R,W,I)===!0){const F=S.__offset,N=Array.isArray(S.value)?S.value:[S.value];let H=0;for(let X=0;X<N.length;X++){const z=N[X],J=_(z);typeof z=="number"||typeof z=="boolean"?(S.__data[0]=z,i.bufferSubData(i.UNIFORM_BUFFER,F+H,S.__data)):z.isMatrix3?(S.__data[0]=z.elements[0],S.__data[1]=z.elements[1],S.__data[2]=z.elements[2],S.__data[3]=0,S.__data[4]=z.elements[3],S.__data[5]=z.elements[4],S.__data[6]=z.elements[5],S.__data[7]=0,S.__data[8]=z.elements[6],S.__data[9]=z.elements[7],S.__data[10]=z.elements[8],S.__data[11]=0):(z.toArray(S.__data,H),H+=J.storage/Float32Array.BYTES_PER_ELEMENT)}i.bufferSubData(i.UNIFORM_BUFFER,F,S.__data)}}}i.bindBuffer(i.UNIFORM_BUFFER,null)}function f(w,x,b,I){const R=w.value,A=x+"_"+b;if(I[A]===void 0)return typeof R=="number"||typeof R=="boolean"?I[A]=R:I[A]=R.clone(),!0;{const P=I[A];if(typeof R=="number"||typeof R=="boolean"){if(P!==R)return I[A]=R,!0}else if(P.equals(R)===!1)return P.copy(R),!0}return!1}function g(w){const x=w.uniforms;let b=0;const I=16;for(let A=0,P=x.length;A<P;A++){const W=Array.isArray(x[A])?x[A]:[x[A]];for(let v=0,S=W.length;v<S;v++){const F=W[v],N=Array.isArray(F.value)?F.value:[F.value];for(let H=0,X=N.length;H<X;H++){const z=N[H],J=_(z),G=b%I,ht=G%J.boundary,ft=G+ht;b+=ht,ft!==0&&I-ft<J.storage&&(b+=I-ft),F.__data=new Float32Array(J.storage/Float32Array.BYTES_PER_ELEMENT),F.__offset=b,b+=J.storage}}}const R=b%I;return R>0&&(b+=I-R),w.__size=b,w.__cache={},this}function _(w){const x={boundary:0,storage:0};return typeof w=="number"||typeof w=="boolean"?(x.boundary=4,x.storage=4):w.isVector2?(x.boundary=8,x.storage=8):w.isVector3||w.isColor?(x.boundary=16,x.storage=12):w.isVector4?(x.boundary=16,x.storage=16):w.isMatrix3?(x.boundary=48,x.storage=48):w.isMatrix4?(x.boundary=64,x.storage=64):w.isTexture?console.warn("THREE.WebGLRenderer: Texture samplers can not be part of an uniforms group."):console.warn("THREE.WebGLRenderer: Unsupported uniform value type.",w),x}function p(w){const x=w.target;x.removeEventListener("dispose",p);const b=o.indexOf(x.__bindingPointIndex);o.splice(b,1),i.deleteBuffer(s[x.id]),delete s[x.id],delete r[x.id]}function m(){for(const w in s)i.deleteBuffer(s[w]);o=[],s={},r={}}return{bind:c,update:l,dispose:m}}class jg{constructor(t={}){const{canvas:e=Fu(),context:n=null,depth:s=!0,stencil:r=!1,alpha:o=!1,antialias:a=!1,premultipliedAlpha:c=!0,preserveDrawingBuffer:l=!1,powerPreference:h="default",failIfMajorPerformanceCaveat:d=!1}=t;this.isWebGLRenderer=!0;let u;if(n!==null){if(typeof WebGLRenderingContext<"u"&&n instanceof WebGLRenderingContext)throw new Error("THREE.WebGLRenderer: WebGL 1 is not supported since r163.");u=n.getContextAttributes().alpha}else u=o;const f=new Uint32Array(4),g=new Int32Array(4);let _=null,p=null;const m=[],w=[];this.domElement=e,this.debug={checkShaderErrors:!0,onShaderError:null},this.autoClear=!0,this.autoClearColor=!0,this.autoClearDepth=!0,this.autoClearStencil=!0,this.sortObjects=!0,this.clippingPlanes=[],this.localClippingEnabled=!1,this._outputColorSpace=cn,this.toneMapping=On,this.toneMappingExposure=1;const x=this;let b=!1,I=0,R=0,A=null,P=-1,W=null;const v=new se,S=new se;let F=null;const N=new Xt(0);let H=0,X=e.width,z=e.height,J=1,G=null,ht=null;const ft=new se(0,0,X,z),pt=new se(0,0,X,z);let $t=!1;const jt=new Ra;let $=!1,tt=!1;const yt=new re,lt=new re,It=new C,Dt=new se,Ot={background:null,fog:null,environment:null,overrideMaterial:null,isScene:!0};let Gt=!1;function K(){return A===null?J:1}let T=n;function rt(M,D){return e.getContext(M,D)}try{const M={alpha:!0,depth:s,stencil:r,antialias:a,premultipliedAlpha:c,preserveDrawingBuffer:l,powerPreference:h,failIfMajorPerformanceCaveat:d};if("setAttribute"in e&&e.setAttribute("data-engine",`three.js r${xa}`),e.addEventListener("webglcontextlost",j,!1),e.addEventListener("webglcontextrestored",ut,!1),e.addEventListener("webglcontextcreationerror",_t,!1),T===null){const D="webgl2";if(T=rt(D,M),T===null)throw rt(D)?new Error("Error creating WebGL context with your selected attributes."):new Error("Error creating WebGL context.")}}catch(M){throw console.error("THREE.WebGLRenderer: "+M.message),M}let st,Q,ot,Ct,mt,E,y,k,q,Z,Y,bt,at,vt,Yt,et,xt,kt,Ft,Mt,Kt,Bt,oe,L;function gt(){st=new nm(T),st.init(),Bt=new Hg(T,st),Q=new Zp(T,st,t,Bt),ot=new Og(T),Q.reverseDepthBuffer&&ot.buffers.depth.setReversed(!0),Ct=new rm(T),mt=new bg,E=new zg(T,st,ot,mt,Q,Bt,Ct),y=new Jp(x),k=new em(x),q=new ud(T),oe=new Yp(T,q),Z=new im(T,q,Ct,oe),Y=new am(T,Z,q,Ct),Ft=new om(T,Q,E),et=new jp(mt),bt=new Sg(x,y,k,st,Q,oe,et),at=new Kg(x,mt),vt=new Tg,Yt=new Lg(st),kt=new qp(x,y,k,ot,Y,u,c),xt=new kg(x,Y,Q),L=new Zg(T,Ct,Q,ot),Mt=new Kp(T,st,Ct),Kt=new sm(T,st,Ct),Ct.programs=bt.programs,x.capabilities=Q,x.extensions=st,x.properties=mt,x.renderLists=vt,x.shadowMap=xt,x.state=ot,x.info=Ct}gt();const V=new qg(x,T);this.xr=V,this.getContext=function(){return T},this.getContextAttributes=function(){return T.getContextAttributes()},this.forceContextLoss=function(){const M=st.get("WEBGL_lose_context");M&&M.loseContext()},this.forceContextRestore=function(){const M=st.get("WEBGL_lose_context");M&&M.restoreContext()},this.getPixelRatio=function(){return J},this.setPixelRatio=function(M){M!==void 0&&(J=M,this.setSize(X,z,!1))},this.getSize=function(M){return M.set(X,z)},this.setSize=function(M,D,O=!0){if(V.isPresenting){console.warn("THREE.WebGLRenderer: Can't change size while VR device is presenting.");return}X=M,z=D,e.width=Math.floor(M*J),e.height=Math.floor(D*J),O===!0&&(e.style.width=M+"px",e.style.height=D+"px"),this.setViewport(0,0,M,D)},this.getDrawingBufferSize=function(M){return M.set(X*J,z*J).floor()},this.setDrawingBufferSize=function(M,D,O){X=M,z=D,J=O,e.width=Math.floor(M*O),e.height=Math.floor(D*O),this.setViewport(0,0,M,D)},this.getCurrentViewport=function(M){return M.copy(v)},this.getViewport=function(M){return M.copy(ft)},this.setViewport=function(M,D,O,B){M.isVector4?ft.set(M.x,M.y,M.z,M.w):ft.set(M,D,O,B),ot.viewport(v.copy(ft).multiplyScalar(J).round())},this.getScissor=function(M){return M.copy(pt)},this.setScissor=function(M,D,O,B){M.isVector4?pt.set(M.x,M.y,M.z,M.w):pt.set(M,D,O,B),ot.scissor(S.copy(pt).multiplyScalar(J).round())},this.getScissorTest=function(){return $t},this.setScissorTest=function(M){ot.setScissorTest($t=M)},this.setOpaqueSort=function(M){G=M},this.setTransparentSort=function(M){ht=M},this.getClearColor=function(M){return M.copy(kt.getClearColor())},this.setClearColor=function(){kt.setClearColor.apply(kt,arguments)},this.getClearAlpha=function(){return kt.getClearAlpha()},this.setClearAlpha=function(){kt.setClearAlpha.apply(kt,arguments)},this.clear=function(M=!0,D=!0,O=!0){let B=0;if(M){let U=!1;if(A!==null){const it=A.texture.format;U=it===Ta||it===Ea||it===ba}if(U){const it=A.texture.type,dt=it===bn||it===ri||it===gs||it===Wi||it===Ma||it===Sa,St=kt.getClearColor(),Et=kt.getClearAlpha(),Ut=St.r,Nt=St.g,wt=St.b;dt?(f[0]=Ut,f[1]=Nt,f[2]=wt,f[3]=Et,T.clearBufferuiv(T.COLOR,0,f)):(g[0]=Ut,g[1]=Nt,g[2]=wt,g[3]=Et,T.clearBufferiv(T.COLOR,0,g))}else B|=T.COLOR_BUFFER_BIT}D&&(B|=T.DEPTH_BUFFER_BIT,T.clearDepth(this.capabilities.reverseDepthBuffer?0:1)),O&&(B|=T.STENCIL_BUFFER_BIT,this.state.buffers.stencil.setMask(4294967295)),T.clear(B)},this.clearColor=function(){this.clear(!0,!1,!1)},this.clearDepth=function(){this.clear(!1,!0,!1)},this.clearStencil=function(){this.clear(!1,!1,!0)},this.dispose=function(){e.removeEventListener("webglcontextlost",j,!1),e.removeEventListener("webglcontextrestored",ut,!1),e.removeEventListener("webglcontextcreationerror",_t,!1),vt.dispose(),Yt.dispose(),mt.dispose(),y.dispose(),k.dispose(),Y.dispose(),oe.dispose(),L.dispose(),bt.dispose(),V.dispose(),V.removeEventListener("sessionstart",Va),V.removeEventListener("sessionend",Ga),$n.stop()};function j(M){M.preventDefault(),console.log("THREE.WebGLRenderer: Context Lost."),b=!0}function ut(){console.log("THREE.WebGLRenderer: Context Restored."),b=!1;const M=Ct.autoReset,D=xt.enabled,O=xt.autoUpdate,B=xt.needsUpdate,U=xt.type;gt(),Ct.autoReset=M,xt.enabled=D,xt.autoUpdate=O,xt.needsUpdate=B,xt.type=U}function _t(M){console.error("THREE.WebGLRenderer: A WebGL context could not be created. Reason: ",M.statusMessage)}function Zt(M){const D=M.target;D.removeEventListener("dispose",Zt),pe(D)}function pe(M){Pe(M),mt.remove(M)}function Pe(M){const D=mt.get(M).programs;D!==void 0&&(D.forEach(function(O){bt.releaseProgram(O)}),M.isShaderMaterial&&bt.releaseShaderCache(M))}this.renderBufferDirect=function(M,D,O,B,U,it){D===null&&(D=Ot);const dt=U.isMesh&&U.matrixWorld.determinant()<0,St=Lh(M,D,O,B,U);ot.setMaterial(B,dt);let Et=O.index,Ut=1;if(B.wireframe===!0){if(Et=Z.getWireframeAttribute(O),Et===void 0)return;Ut=2}const Nt=O.drawRange,wt=O.attributes.position;let ne=Nt.start*Ut,ce=(Nt.start+Nt.count)*Ut;it!==null&&(ne=Math.max(ne,it.start*Ut),ce=Math.min(ce,(it.start+it.count)*Ut)),Et!==null?(ne=Math.max(ne,0),ce=Math.min(ce,Et.count)):wt!=null&&(ne=Math.max(ne,0),ce=Math.min(ce,wt.count));const ue=ce-ne;if(ue<0||ue===1/0)return;oe.setup(U,B,St,O,Et);let ke,Qt=Mt;if(Et!==null&&(ke=q.get(Et),Qt=Kt,Qt.setIndex(ke)),U.isMesh)B.wireframe===!0?(ot.setLineWidth(B.wireframeLinewidth*K()),Qt.setMode(T.LINES)):Qt.setMode(T.TRIANGLES);else if(U.isLine){let Rt=B.linewidth;Rt===void 0&&(Rt=1),ot.setLineWidth(Rt*K()),U.isLineSegments?Qt.setMode(T.LINES):U.isLineLoop?Qt.setMode(T.LINE_LOOP):Qt.setMode(T.LINE_STRIP)}else U.isPoints?Qt.setMode(T.POINTS):U.isSprite&&Qt.setMode(T.TRIANGLES);if(U.isBatchedMesh)if(U._multiDrawInstances!==null)Qt.renderMultiDrawInstances(U._multiDrawStarts,U._multiDrawCounts,U._multiDrawCount,U._multiDrawInstances);else if(st.get("WEBGL_multi_draw"))Qt.renderMultiDraw(U._multiDrawStarts,U._multiDrawCounts,U._multiDrawCount);else{const Rt=U._multiDrawStarts,be=U._multiDrawCounts,te=U._multiDrawCount,Ze=Et?q.get(Et).bytesPerElement:1,di=mt.get(B).currentProgram.getUniforms();for(let Fe=0;Fe<te;Fe++)di.setValue(T,"_gl_DrawID",Fe),Qt.render(Rt[Fe]/Ze,be[Fe])}else if(U.isInstancedMesh)Qt.renderInstances(ne,ue,U.count);else if(O.isInstancedBufferGeometry){const Rt=O._maxInstanceCount!==void 0?O._maxInstanceCount:1/0,be=Math.min(O.instanceCount,Rt);Qt.renderInstances(ne,ue,be)}else Qt.render(ne,ue)};function Jt(M,D,O){M.transparent===!0&&M.side===qe&&M.forceSinglePass===!1?(M.side=Re,M.needsUpdate=!0,Ts(M,D,O),M.side=Bn,M.needsUpdate=!0,Ts(M,D,O),M.side=qe):Ts(M,D,O)}this.compile=function(M,D,O=null){O===null&&(O=M),p=Yt.get(O),p.init(D),w.push(p),O.traverseVisible(function(U){U.isLight&&U.layers.test(D.layers)&&(p.pushLight(U),U.castShadow&&p.pushShadow(U))}),M!==O&&M.traverseVisible(function(U){U.isLight&&U.layers.test(D.layers)&&(p.pushLight(U),U.castShadow&&p.pushShadow(U))}),p.setupLights();const B=new Set;return M.traverse(function(U){if(!(U.isMesh||U.isPoints||U.isLine||U.isSprite))return;const it=U.material;if(it)if(Array.isArray(it))for(let dt=0;dt<it.length;dt++){const St=it[dt];Jt(St,O,U),B.add(St)}else Jt(it,O,U),B.add(it)}),w.pop(),p=null,B},this.compileAsync=function(M,D,O=null){const B=this.compile(M,D,O);return new Promise(U=>{function it(){if(B.forEach(function(dt){mt.get(dt).currentProgram.isReady()&&B.delete(dt)}),B.size===0){U(M);return}setTimeout(it,10)}st.get("KHR_parallel_shader_compile")!==null?it():setTimeout(it,10)})};let Le=null;function un(M){Le&&Le(M)}function Va(){$n.stop()}function Ga(){$n.start()}const $n=new Zl;$n.setAnimationLoop(un),typeof self<"u"&&$n.setContext(self),this.setAnimationLoop=function(M){Le=M,V.setAnimationLoop(M),M===null?$n.stop():$n.start()},V.addEventListener("sessionstart",Va),V.addEventListener("sessionend",Ga),this.render=function(M,D){if(D!==void 0&&D.isCamera!==!0){console.error("THREE.WebGLRenderer.render: camera is not an instance of THREE.Camera.");return}if(b===!0)return;if(M.matrixWorldAutoUpdate===!0&&M.updateMatrixWorld(),D.parent===null&&D.matrixWorldAutoUpdate===!0&&D.updateMatrixWorld(),V.enabled===!0&&V.isPresenting===!0&&(V.cameraAutoUpdate===!0&&V.updateCamera(D),D=V.getCamera()),M.isScene===!0&&M.onBeforeRender(x,M,D,A),p=Yt.get(M,w.length),p.init(D),w.push(p),lt.multiplyMatrices(D.projectionMatrix,D.matrixWorldInverse),jt.setFromProjectionMatrix(lt),tt=this.localClippingEnabled,$=et.init(this.clippingPlanes,tt),_=vt.get(M,m.length),_.init(),m.push(_),V.enabled===!0&&V.isPresenting===!0){const it=x.xr.getDepthSensingMesh();it!==null&&Rr(it,D,-1/0,x.sortObjects)}Rr(M,D,0,x.sortObjects),_.finish(),x.sortObjects===!0&&_.sort(G,ht),Gt=V.enabled===!1||V.isPresenting===!1||V.hasDepthSensing()===!1,Gt&&kt.addToRenderList(_,M),this.info.render.frame++,$===!0&&et.beginShadows();const O=p.state.shadowsArray;xt.render(O,M,D),$===!0&&et.endShadows(),this.info.autoReset===!0&&this.info.reset();const B=_.opaque,U=_.transmissive;if(p.setupLights(),D.isArrayCamera){const it=D.cameras;if(U.length>0)for(let dt=0,St=it.length;dt<St;dt++){const Et=it[dt];Xa(B,U,M,Et)}Gt&&kt.render(M);for(let dt=0,St=it.length;dt<St;dt++){const Et=it[dt];Wa(_,M,Et,Et.viewport)}}else U.length>0&&Xa(B,U,M,D),Gt&&kt.render(M),Wa(_,M,D);A!==null&&(E.updateMultisampleRenderTarget(A),E.updateRenderTargetMipmap(A)),M.isScene===!0&&M.onAfterRender(x,M,D),oe.resetDefaultState(),P=-1,W=null,w.pop(),w.length>0?(p=w[w.length-1],$===!0&&et.setGlobalState(x.clippingPlanes,p.state.camera)):p=null,m.pop(),m.length>0?_=m[m.length-1]:_=null};function Rr(M,D,O,B){if(M.visible===!1)return;if(M.layers.test(D.layers)){if(M.isGroup)O=M.renderOrder;else if(M.isLOD)M.autoUpdate===!0&&M.update(D);else if(M.isLight)p.pushLight(M),M.castShadow&&p.pushShadow(M);else if(M.isSprite){if(!M.frustumCulled||jt.intersectsSprite(M)){B&&Dt.setFromMatrixPosition(M.matrixWorld).applyMatrix4(lt);const dt=Y.update(M),St=M.material;St.visible&&_.push(M,dt,St,O,Dt.z,null)}}else if((M.isMesh||M.isLine||M.isPoints)&&(!M.frustumCulled||jt.intersectsObject(M))){const dt=Y.update(M),St=M.material;if(B&&(M.boundingSphere!==void 0?(M.boundingSphere===null&&M.computeBoundingSphere(),Dt.copy(M.boundingSphere.center)):(dt.boundingSphere===null&&dt.computeBoundingSphere(),Dt.copy(dt.boundingSphere.center)),Dt.applyMatrix4(M.matrixWorld).applyMatrix4(lt)),Array.isArray(St)){const Et=dt.groups;for(let Ut=0,Nt=Et.length;Ut<Nt;Ut++){const wt=Et[Ut],ne=St[wt.materialIndex];ne&&ne.visible&&_.push(M,dt,ne,O,Dt.z,wt)}}else St.visible&&_.push(M,dt,St,O,Dt.z,null)}}const it=M.children;for(let dt=0,St=it.length;dt<St;dt++)Rr(it[dt],D,O,B)}function Wa(M,D,O,B){const U=M.opaque,it=M.transmissive,dt=M.transparent;p.setupLightsView(O),$===!0&&et.setGlobalState(x.clippingPlanes,O),B&&ot.viewport(v.copy(B)),U.length>0&&Es(U,D,O),it.length>0&&Es(it,D,O),dt.length>0&&Es(dt,D,O),ot.buffers.depth.setTest(!0),ot.buffers.depth.setMask(!0),ot.buffers.color.setMask(!0),ot.setPolygonOffset(!1)}function Xa(M,D,O,B){if((O.isScene===!0?O.overrideMaterial:null)!==null)return;p.state.transmissionRenderTarget[B.id]===void 0&&(p.state.transmissionRenderTarget[B.id]=new oi(1,1,{generateMipmaps:!0,type:st.has("EXT_color_buffer_half_float")||st.has("EXT_color_buffer_float")?Ss:bn,minFilter:ii,samples:4,stencilBuffer:r,resolveDepthBuffer:!1,resolveStencilBuffer:!1,colorSpace:ee.workingColorSpace}));const it=p.state.transmissionRenderTarget[B.id],dt=B.viewport||v;it.setSize(dt.z,dt.w);const St=x.getRenderTarget();x.setRenderTarget(it),x.getClearColor(N),H=x.getClearAlpha(),H<1&&x.setClearColor(16777215,.5),x.clear(),Gt&&kt.render(O);const Et=x.toneMapping;x.toneMapping=On;const Ut=B.viewport;if(B.viewport!==void 0&&(B.viewport=void 0),p.setupLightsView(B),$===!0&&et.setGlobalState(x.clippingPlanes,B),Es(M,O,B),E.updateMultisampleRenderTarget(it),E.updateRenderTargetMipmap(it),st.has("WEBGL_multisampled_render_to_texture")===!1){let Nt=!1;for(let wt=0,ne=D.length;wt<ne;wt++){const ce=D[wt],ue=ce.object,ke=ce.geometry,Qt=ce.material,Rt=ce.group;if(Qt.side===qe&&ue.layers.test(B.layers)){const be=Qt.side;Qt.side=Re,Qt.needsUpdate=!0,$a(ue,O,B,ke,Qt,Rt),Qt.side=be,Qt.needsUpdate=!0,Nt=!0}}Nt===!0&&(E.updateMultisampleRenderTarget(it),E.updateRenderTargetMipmap(it))}x.setRenderTarget(St),x.setClearColor(N,H),Ut!==void 0&&(B.viewport=Ut),x.toneMapping=Et}function Es(M,D,O){const B=D.isScene===!0?D.overrideMaterial:null;for(let U=0,it=M.length;U<it;U++){const dt=M[U],St=dt.object,Et=dt.geometry,Ut=B===null?dt.material:B,Nt=dt.group;St.layers.test(O.layers)&&$a(St,D,O,Et,Ut,Nt)}}function $a(M,D,O,B,U,it){M.onBeforeRender(x,D,O,B,U,it),M.modelViewMatrix.multiplyMatrices(O.matrixWorldInverse,M.matrixWorld),M.normalMatrix.getNormalMatrix(M.modelViewMatrix),U.onBeforeRender(x,D,O,B,M,it),U.transparent===!0&&U.side===qe&&U.forceSinglePass===!1?(U.side=Re,U.needsUpdate=!0,x.renderBufferDirect(O,D,B,U,M,it),U.side=Bn,U.needsUpdate=!0,x.renderBufferDirect(O,D,B,U,M,it),U.side=qe):x.renderBufferDirect(O,D,B,U,M,it),M.onAfterRender(x,D,O,B,U,it)}function Ts(M,D,O){D.isScene!==!0&&(D=Ot);const B=mt.get(M),U=p.state.lights,it=p.state.shadowsArray,dt=U.state.version,St=bt.getParameters(M,U.state,it,D,O),Et=bt.getProgramCacheKey(St);let Ut=B.programs;B.environment=M.isMeshStandardMaterial?D.environment:null,B.fog=D.fog,B.envMap=(M.isMeshStandardMaterial?k:y).get(M.envMap||B.environment),B.envMapRotation=B.environment!==null&&M.envMap===null?D.environmentRotation:M.envMapRotation,Ut===void 0&&(M.addEventListener("dispose",Zt),Ut=new Map,B.programs=Ut);let Nt=Ut.get(Et);if(Nt!==void 0){if(B.currentProgram===Nt&&B.lightsStateVersion===dt)return Ya(M,St),Nt}else St.uniforms=bt.getUniforms(M),M.onBeforeCompile(St,x),Nt=bt.acquireProgram(St,Et),Ut.set(Et,Nt),B.uniforms=St.uniforms;const wt=B.uniforms;return(!M.isShaderMaterial&&!M.isRawShaderMaterial||M.clipping===!0)&&(wt.clippingPlanes=et.uniform),Ya(M,St),B.needsLights=Ih(M),B.lightsStateVersion=dt,B.needsLights&&(wt.ambientLightColor.value=U.state.ambient,wt.lightProbe.value=U.state.probe,wt.directionalLights.value=U.state.directional,wt.directionalLightShadows.value=U.state.directionalShadow,wt.spotLights.value=U.state.spot,wt.spotLightShadows.value=U.state.spotShadow,wt.rectAreaLights.value=U.state.rectArea,wt.ltc_1.value=U.state.rectAreaLTC1,wt.ltc_2.value=U.state.rectAreaLTC2,wt.pointLights.value=U.state.point,wt.pointLightShadows.value=U.state.pointShadow,wt.hemisphereLights.value=U.state.hemi,wt.directionalShadowMap.value=U.state.directionalShadowMap,wt.directionalShadowMatrix.value=U.state.directionalShadowMatrix,wt.spotShadowMap.value=U.state.spotShadowMap,wt.spotLightMatrix.value=U.state.spotLightMatrix,wt.spotLightMap.value=U.state.spotLightMap,wt.pointShadowMap.value=U.state.pointShadowMap,wt.pointShadowMatrix.value=U.state.pointShadowMatrix),B.currentProgram=Nt,B.uniformsList=null,Nt}function qa(M){if(M.uniformsList===null){const D=M.currentProgram.getUniforms();M.uniformsList=hr.seqWithValue(D.seq,M.uniforms)}return M.uniformsList}function Ya(M,D){const O=mt.get(M);O.outputColorSpace=D.outputColorSpace,O.batching=D.batching,O.batchingColor=D.batchingColor,O.instancing=D.instancing,O.instancingColor=D.instancingColor,O.instancingMorph=D.instancingMorph,O.skinning=D.skinning,O.morphTargets=D.morphTargets,O.morphNormals=D.morphNormals,O.morphColors=D.morphColors,O.morphTargetsCount=D.morphTargetsCount,O.numClippingPlanes=D.numClippingPlanes,O.numIntersection=D.numClipIntersection,O.vertexAlphas=D.vertexAlphas,O.vertexTangents=D.vertexTangents,O.toneMapping=D.toneMapping}function Lh(M,D,O,B,U){D.isScene!==!0&&(D=Ot),E.resetTextureUnits();const it=D.fog,dt=B.isMeshStandardMaterial?D.environment:null,St=A===null?x.outputColorSpace:A.isXRRenderTarget===!0?A.texture.colorSpace:Xn,Et=(B.isMeshStandardMaterial?k:y).get(B.envMap||dt),Ut=B.vertexColors===!0&&!!O.attributes.color&&O.attributes.color.itemSize===4,Nt=!!O.attributes.tangent&&(!!B.normalMap||B.anisotropy>0),wt=!!O.morphAttributes.position,ne=!!O.morphAttributes.normal,ce=!!O.morphAttributes.color;let ue=On;B.toneMapped&&(A===null||A.isXRRenderTarget===!0)&&(ue=x.toneMapping);const ke=O.morphAttributes.position||O.morphAttributes.normal||O.morphAttributes.color,Qt=ke!==void 0?ke.length:0,Rt=mt.get(B),be=p.state.lights;if($===!0&&(tt===!0||M!==W)){const We=M===W&&B.id===P;et.setState(B,M,We)}let te=!1;B.version===Rt.__version?(Rt.needsLights&&Rt.lightsStateVersion!==be.state.version||Rt.outputColorSpace!==St||U.isBatchedMesh&&Rt.batching===!1||!U.isBatchedMesh&&Rt.batching===!0||U.isBatchedMesh&&Rt.batchingColor===!0&&U.colorTexture===null||U.isBatchedMesh&&Rt.batchingColor===!1&&U.colorTexture!==null||U.isInstancedMesh&&Rt.instancing===!1||!U.isInstancedMesh&&Rt.instancing===!0||U.isSkinnedMesh&&Rt.skinning===!1||!U.isSkinnedMesh&&Rt.skinning===!0||U.isInstancedMesh&&Rt.instancingColor===!0&&U.instanceColor===null||U.isInstancedMesh&&Rt.instancingColor===!1&&U.instanceColor!==null||U.isInstancedMesh&&Rt.instancingMorph===!0&&U.morphTexture===null||U.isInstancedMesh&&Rt.instancingMorph===!1&&U.morphTexture!==null||Rt.envMap!==Et||B.fog===!0&&Rt.fog!==it||Rt.numClippingPlanes!==void 0&&(Rt.numClippingPlanes!==et.numPlanes||Rt.numIntersection!==et.numIntersection)||Rt.vertexAlphas!==Ut||Rt.vertexTangents!==Nt||Rt.morphTargets!==wt||Rt.morphNormals!==ne||Rt.morphColors!==ce||Rt.toneMapping!==ue||Rt.morphTargetsCount!==Qt)&&(te=!0):(te=!0,Rt.__version=B.version);let Ze=Rt.currentProgram;te===!0&&(Ze=Ts(B,D,U));let di=!1,Fe=!1,Pr=!1;const fe=Ze.getUniforms(),wn=Rt.uniforms;if(ot.useProgram(Ze.program)&&(di=!0,Fe=!0,Pr=!0),B.id!==P&&(P=B.id,Fe=!0),di||W!==M){Q.reverseDepthBuffer?(yt.copy(M.projectionMatrix),Bu(yt),zu(yt),fe.setValue(T,"projectionMatrix",yt)):fe.setValue(T,"projectionMatrix",M.projectionMatrix),fe.setValue(T,"viewMatrix",M.matrixWorldInverse);const We=fe.map.cameraPosition;We!==void 0&&We.setValue(T,It.setFromMatrixPosition(M.matrixWorld)),Q.logarithmicDepthBuffer&&fe.setValue(T,"logDepthBufFC",2/(Math.log(M.far+1)/Math.LN2)),(B.isMeshPhongMaterial||B.isMeshToonMaterial||B.isMeshLambertMaterial||B.isMeshBasicMaterial||B.isMeshStandardMaterial||B.isShaderMaterial)&&fe.setValue(T,"isOrthographic",M.isOrthographicCamera===!0),W!==M&&(W=M,Fe=!0,Pr=!0)}if(U.isSkinnedMesh){fe.setOptional(T,U,"bindMatrix"),fe.setOptional(T,U,"bindMatrixInverse");const We=U.skeleton;We&&(We.boneTexture===null&&We.computeBoneTexture(),fe.setValue(T,"boneTexture",We.boneTexture,E))}U.isBatchedMesh&&(fe.setOptional(T,U,"batchingTexture"),fe.setValue(T,"batchingTexture",U._matricesTexture,E),fe.setOptional(T,U,"batchingIdTexture"),fe.setValue(T,"batchingIdTexture",U._indirectTexture,E),fe.setOptional(T,U,"batchingColorTexture"),U._colorsTexture!==null&&fe.setValue(T,"batchingColorTexture",U._colorsTexture,E));const Lr=O.morphAttributes;if((Lr.position!==void 0||Lr.normal!==void 0||Lr.color!==void 0)&&Ft.update(U,O,Ze),(Fe||Rt.receiveShadow!==U.receiveShadow)&&(Rt.receiveShadow=U.receiveShadow,fe.setValue(T,"receiveShadow",U.receiveShadow)),B.isMeshGouraudMaterial&&B.envMap!==null&&(wn.envMap.value=Et,wn.flipEnvMap.value=Et.isCubeTexture&&Et.isRenderTargetTexture===!1?-1:1),B.isMeshStandardMaterial&&B.envMap===null&&D.environment!==null&&(wn.envMapIntensity.value=D.environmentIntensity),Fe&&(fe.setValue(T,"toneMappingExposure",x.toneMappingExposure),Rt.needsLights&&Dh(wn,Pr),it&&B.fog===!0&&at.refreshFogUniforms(wn,it),at.refreshMaterialUniforms(wn,B,J,z,p.state.transmissionRenderTarget[M.id]),hr.upload(T,qa(Rt),wn,E)),B.isShaderMaterial&&B.uniformsNeedUpdate===!0&&(hr.upload(T,qa(Rt),wn,E),B.uniformsNeedUpdate=!1),B.isSpriteMaterial&&fe.setValue(T,"center",U.center),fe.setValue(T,"modelViewMatrix",U.modelViewMatrix),fe.setValue(T,"normalMatrix",U.normalMatrix),fe.setValue(T,"modelMatrix",U.matrixWorld),B.isShaderMaterial||B.isRawShaderMaterial){const We=B.uniformsGroups;for(let Dr=0,Uh=We.length;Dr<Uh;Dr++){const Ka=We[Dr];L.update(Ka,Ze),L.bind(Ka,Ze)}}return Ze}function Dh(M,D){M.ambientLightColor.needsUpdate=D,M.lightProbe.needsUpdate=D,M.directionalLights.needsUpdate=D,M.directionalLightShadows.needsUpdate=D,M.pointLights.needsUpdate=D,M.pointLightShadows.needsUpdate=D,M.spotLights.needsUpdate=D,M.spotLightShadows.needsUpdate=D,M.rectAreaLights.needsUpdate=D,M.hemisphereLights.needsUpdate=D}function Ih(M){return M.isMeshLambertMaterial||M.isMeshToonMaterial||M.isMeshPhongMaterial||M.isMeshStandardMaterial||M.isShadowMaterial||M.isShaderMaterial&&M.lights===!0}this.getActiveCubeFace=function(){return I},this.getActiveMipmapLevel=function(){return R},this.getRenderTarget=function(){return A},this.setRenderTargetTextures=function(M,D,O){mt.get(M.texture).__webglTexture=D,mt.get(M.depthTexture).__webglTexture=O;const B=mt.get(M);B.__hasExternalTextures=!0,B.__autoAllocateDepthBuffer=O===void 0,B.__autoAllocateDepthBuffer||st.has("WEBGL_multisampled_render_to_texture")===!0&&(console.warn("THREE.WebGLRenderer: Render-to-texture extension was disabled because an external texture was provided"),B.__useRenderToTexture=!1)},this.setRenderTargetFramebuffer=function(M,D){const O=mt.get(M);O.__webglFramebuffer=D,O.__useDefaultFramebuffer=D===void 0},this.setRenderTarget=function(M,D=0,O=0){A=M,I=D,R=O;let B=!0,U=null,it=!1,dt=!1;if(M){const Et=mt.get(M);if(Et.__useDefaultFramebuffer!==void 0)ot.bindFramebuffer(T.FRAMEBUFFER,null),B=!1;else if(Et.__webglFramebuffer===void 0)E.setupRenderTarget(M);else if(Et.__hasExternalTextures)E.rebindTextures(M,mt.get(M.texture).__webglTexture,mt.get(M.depthTexture).__webglTexture);else if(M.depthBuffer){const wt=M.depthTexture;if(Et.__boundDepthTexture!==wt){if(wt!==null&&mt.has(wt)&&(M.width!==wt.image.width||M.height!==wt.image.height))throw new Error("WebGLRenderTarget: Attached DepthTexture is initialized to the incorrect size.");E.setupDepthRenderbuffer(M)}}const Ut=M.texture;(Ut.isData3DTexture||Ut.isDataArrayTexture||Ut.isCompressedArrayTexture)&&(dt=!0);const Nt=mt.get(M).__webglFramebuffer;M.isWebGLCubeRenderTarget?(Array.isArray(Nt[D])?U=Nt[D][O]:U=Nt[D],it=!0):M.samples>0&&E.useMultisampledRTT(M)===!1?U=mt.get(M).__webglMultisampledFramebuffer:Array.isArray(Nt)?U=Nt[O]:U=Nt,v.copy(M.viewport),S.copy(M.scissor),F=M.scissorTest}else v.copy(ft).multiplyScalar(J).floor(),S.copy(pt).multiplyScalar(J).floor(),F=$t;if(ot.bindFramebuffer(T.FRAMEBUFFER,U)&&B&&ot.drawBuffers(M,U),ot.viewport(v),ot.scissor(S),ot.setScissorTest(F),it){const Et=mt.get(M.texture);T.framebufferTexture2D(T.FRAMEBUFFER,T.COLOR_ATTACHMENT0,T.TEXTURE_CUBE_MAP_POSITIVE_X+D,Et.__webglTexture,O)}else if(dt){const Et=mt.get(M.texture),Ut=D||0;T.framebufferTextureLayer(T.FRAMEBUFFER,T.COLOR_ATTACHMENT0,Et.__webglTexture,O||0,Ut)}P=-1},this.readRenderTargetPixels=function(M,D,O,B,U,it,dt){if(!(M&&M.isWebGLRenderTarget)){console.error("THREE.WebGLRenderer.readRenderTargetPixels: renderTarget is not THREE.WebGLRenderTarget.");return}let St=mt.get(M).__webglFramebuffer;if(M.isWebGLCubeRenderTarget&&dt!==void 0&&(St=St[dt]),St){ot.bindFramebuffer(T.FRAMEBUFFER,St);try{const Et=M.texture,Ut=Et.format,Nt=Et.type;if(!Q.textureFormatReadable(Ut)){console.error("THREE.WebGLRenderer.readRenderTargetPixels: renderTarget is not in RGBA or implementation defined format.");return}if(!Q.textureTypeReadable(Nt)){console.error("THREE.WebGLRenderer.readRenderTargetPixels: renderTarget is not in UnsignedByteType or implementation defined type.");return}D>=0&&D<=M.width-B&&O>=0&&O<=M.height-U&&T.readPixels(D,O,B,U,Bt.convert(Ut),Bt.convert(Nt),it)}finally{const Et=A!==null?mt.get(A).__webglFramebuffer:null;ot.bindFramebuffer(T.FRAMEBUFFER,Et)}}},this.readRenderTargetPixelsAsync=async function(M,D,O,B,U,it,dt){if(!(M&&M.isWebGLRenderTarget))throw new Error("THREE.WebGLRenderer.readRenderTargetPixels: renderTarget is not THREE.WebGLRenderTarget.");let St=mt.get(M).__webglFramebuffer;if(M.isWebGLCubeRenderTarget&&dt!==void 0&&(St=St[dt]),St){const Et=M.texture,Ut=Et.format,Nt=Et.type;if(!Q.textureFormatReadable(Ut))throw new Error("THREE.WebGLRenderer.readRenderTargetPixelsAsync: renderTarget is not in RGBA or implementation defined format.");if(!Q.textureTypeReadable(Nt))throw new Error("THREE.WebGLRenderer.readRenderTargetPixelsAsync: renderTarget is not in UnsignedByteType or implementation defined type.");if(D>=0&&D<=M.width-B&&O>=0&&O<=M.height-U){ot.bindFramebuffer(T.FRAMEBUFFER,St);const wt=T.createBuffer();T.bindBuffer(T.PIXEL_PACK_BUFFER,wt),T.bufferData(T.PIXEL_PACK_BUFFER,it.byteLength,T.STREAM_READ),T.readPixels(D,O,B,U,Bt.convert(Ut),Bt.convert(Nt),0);const ne=A!==null?mt.get(A).__webglFramebuffer:null;ot.bindFramebuffer(T.FRAMEBUFFER,ne);const ce=T.fenceSync(T.SYNC_GPU_COMMANDS_COMPLETE,0);return T.flush(),await Ou(T,ce,4),T.bindBuffer(T.PIXEL_PACK_BUFFER,wt),T.getBufferSubData(T.PIXEL_PACK_BUFFER,0,it),T.deleteBuffer(wt),T.deleteSync(ce),it}else throw new Error("THREE.WebGLRenderer.readRenderTargetPixelsAsync: requested read bounds are out of range.")}},this.copyFramebufferToTexture=function(M,D=null,O=0){M.isTexture!==!0&&(lr("WebGLRenderer: copyFramebufferToTexture function signature has changed."),D=arguments[0]||null,M=arguments[1]);const B=Math.pow(2,-O),U=Math.floor(M.image.width*B),it=Math.floor(M.image.height*B),dt=D!==null?D.x:0,St=D!==null?D.y:0;E.setTexture2D(M,0),T.copyTexSubImage2D(T.TEXTURE_2D,O,0,0,dt,St,U,it),ot.unbindTexture()},this.copyTextureToTexture=function(M,D,O=null,B=null,U=0){M.isTexture!==!0&&(lr("WebGLRenderer: copyTextureToTexture function signature has changed."),B=arguments[0]||null,M=arguments[1],D=arguments[2],U=arguments[3]||0,O=null);let it,dt,St,Et,Ut,Nt;O!==null?(it=O.max.x-O.min.x,dt=O.max.y-O.min.y,St=O.min.x,Et=O.min.y):(it=M.image.width,dt=M.image.height,St=0,Et=0),B!==null?(Ut=B.x,Nt=B.y):(Ut=0,Nt=0);const wt=Bt.convert(D.format),ne=Bt.convert(D.type);E.setTexture2D(D,0),T.pixelStorei(T.UNPACK_FLIP_Y_WEBGL,D.flipY),T.pixelStorei(T.UNPACK_PREMULTIPLY_ALPHA_WEBGL,D.premultiplyAlpha),T.pixelStorei(T.UNPACK_ALIGNMENT,D.unpackAlignment);const ce=T.getParameter(T.UNPACK_ROW_LENGTH),ue=T.getParameter(T.UNPACK_IMAGE_HEIGHT),ke=T.getParameter(T.UNPACK_SKIP_PIXELS),Qt=T.getParameter(T.UNPACK_SKIP_ROWS),Rt=T.getParameter(T.UNPACK_SKIP_IMAGES),be=M.isCompressedTexture?M.mipmaps[U]:M.image;T.pixelStorei(T.UNPACK_ROW_LENGTH,be.width),T.pixelStorei(T.UNPACK_IMAGE_HEIGHT,be.height),T.pixelStorei(T.UNPACK_SKIP_PIXELS,St),T.pixelStorei(T.UNPACK_SKIP_ROWS,Et),M.isDataTexture?T.texSubImage2D(T.TEXTURE_2D,U,Ut,Nt,it,dt,wt,ne,be.data):M.isCompressedTexture?T.compressedTexSubImage2D(T.TEXTURE_2D,U,Ut,Nt,be.width,be.height,wt,be.data):T.texSubImage2D(T.TEXTURE_2D,U,Ut,Nt,it,dt,wt,ne,be),T.pixelStorei(T.UNPACK_ROW_LENGTH,ce),T.pixelStorei(T.UNPACK_IMAGE_HEIGHT,ue),T.pixelStorei(T.UNPACK_SKIP_PIXELS,ke),T.pixelStorei(T.UNPACK_SKIP_ROWS,Qt),T.pixelStorei(T.UNPACK_SKIP_IMAGES,Rt),U===0&&D.generateMipmaps&&T.generateMipmap(T.TEXTURE_2D),ot.unbindTexture()},this.copyTextureToTexture3D=function(M,D,O=null,B=null,U=0){M.isTexture!==!0&&(lr("WebGLRenderer: copyTextureToTexture3D function signature has changed."),O=arguments[0]||null,B=arguments[1]||null,M=arguments[2],D=arguments[3],U=arguments[4]||0);let it,dt,St,Et,Ut,Nt,wt,ne,ce;const ue=M.isCompressedTexture?M.mipmaps[U]:M.image;O!==null?(it=O.max.x-O.min.x,dt=O.max.y-O.min.y,St=O.max.z-O.min.z,Et=O.min.x,Ut=O.min.y,Nt=O.min.z):(it=ue.width,dt=ue.height,St=ue.depth,Et=0,Ut=0,Nt=0),B!==null?(wt=B.x,ne=B.y,ce=B.z):(wt=0,ne=0,ce=0);const ke=Bt.convert(D.format),Qt=Bt.convert(D.type);let Rt;if(D.isData3DTexture)E.setTexture3D(D,0),Rt=T.TEXTURE_3D;else if(D.isDataArrayTexture||D.isCompressedArrayTexture)E.setTexture2DArray(D,0),Rt=T.TEXTURE_2D_ARRAY;else{console.warn("THREE.WebGLRenderer.copyTextureToTexture3D: only supports THREE.DataTexture3D and THREE.DataTexture2DArray.");return}T.pixelStorei(T.UNPACK_FLIP_Y_WEBGL,D.flipY),T.pixelStorei(T.UNPACK_PREMULTIPLY_ALPHA_WEBGL,D.premultiplyAlpha),T.pixelStorei(T.UNPACK_ALIGNMENT,D.unpackAlignment);const be=T.getParameter(T.UNPACK_ROW_LENGTH),te=T.getParameter(T.UNPACK_IMAGE_HEIGHT),Ze=T.getParameter(T.UNPACK_SKIP_PIXELS),di=T.getParameter(T.UNPACK_SKIP_ROWS),Fe=T.getParameter(T.UNPACK_SKIP_IMAGES);T.pixelStorei(T.UNPACK_ROW_LENGTH,ue.width),T.pixelStorei(T.UNPACK_IMAGE_HEIGHT,ue.height),T.pixelStorei(T.UNPACK_SKIP_PIXELS,Et),T.pixelStorei(T.UNPACK_SKIP_ROWS,Ut),T.pixelStorei(T.UNPACK_SKIP_IMAGES,Nt),M.isDataTexture||M.isData3DTexture?T.texSubImage3D(Rt,U,wt,ne,ce,it,dt,St,ke,Qt,ue.data):D.isCompressedArrayTexture?T.compressedTexSubImage3D(Rt,U,wt,ne,ce,it,dt,St,ke,ue.data):T.texSubImage3D(Rt,U,wt,ne,ce,it,dt,St,ke,Qt,ue),T.pixelStorei(T.UNPACK_ROW_LENGTH,be),T.pixelStorei(T.UNPACK_IMAGE_HEIGHT,te),T.pixelStorei(T.UNPACK_SKIP_PIXELS,Ze),T.pixelStorei(T.UNPACK_SKIP_ROWS,di),T.pixelStorei(T.UNPACK_SKIP_IMAGES,Fe),U===0&&D.generateMipmaps&&T.generateMipmap(Rt),ot.unbindTexture()},this.initRenderTarget=function(M){mt.get(M).__webglFramebuffer===void 0&&E.setupRenderTarget(M)},this.initTexture=function(M){M.isCubeTexture?E.setTextureCube(M,0):M.isData3DTexture?E.setTexture3D(M,0):M.isDataArrayTexture||M.isCompressedArrayTexture?E.setTexture2DArray(M,0):E.setTexture2D(M,0),ot.unbindTexture()},this.resetState=function(){I=0,R=0,A=null,ot.reset(),oe.reset()},typeof __THREE_DEVTOOLS__<"u"&&__THREE_DEVTOOLS__.dispatchEvent(new CustomEvent("observe",{detail:this}))}get coordinateSystem(){return yn}get outputColorSpace(){return this._outputColorSpace}set outputColorSpace(t){this._outputColorSpace=t;const e=this.getContext();e.drawingBufferColorSpace=t===wa?"display-p3":"srgb",e.unpackColorSpace=ee.workingColorSpace===Mr?"display-p3":"srgb"}}class La{constructor(t,e=1,n=1e3){this.isFog=!0,this.name="",this.color=new Xt(t),this.near=e,this.far=n}clone(){return new La(this.color,this.near,this.far)}toJSON(){return{type:"Fog",name:this.name,color:this.color.getHex(),near:this.near,far:this.far}}}class ih extends Me{constructor(){super(),this.isScene=!0,this.type="Scene",this.background=null,this.environment=null,this.fog=null,this.backgroundBlurriness=0,this.backgroundIntensity=1,this.backgroundRotation=new on,this.environmentIntensity=1,this.environmentRotation=new on,this.overrideMaterial=null,typeof __THREE_DEVTOOLS__<"u"&&__THREE_DEVTOOLS__.dispatchEvent(new CustomEvent("observe",{detail:this}))}copy(t,e){return super.copy(t,e),t.background!==null&&(this.background=t.background.clone()),t.environment!==null&&(this.environment=t.environment.clone()),t.fog!==null&&(this.fog=t.fog.clone()),this.backgroundBlurriness=t.backgroundBlurriness,this.backgroundIntensity=t.backgroundIntensity,this.backgroundRotation.copy(t.backgroundRotation),this.environmentIntensity=t.environmentIntensity,this.environmentRotation.copy(t.environmentRotation),t.overrideMaterial!==null&&(this.overrideMaterial=t.overrideMaterial.clone()),this.matrixAutoUpdate=t.matrixAutoUpdate,this}toJSON(t){const e=super.toJSON(t);return this.fog!==null&&(e.object.fog=this.fog.toJSON()),this.backgroundBlurriness>0&&(e.object.backgroundBlurriness=this.backgroundBlurriness),this.backgroundIntensity!==1&&(e.object.backgroundIntensity=this.backgroundIntensity),e.object.backgroundRotation=this.backgroundRotation.toArray(),this.environmentIntensity!==1&&(e.object.environmentIntensity=this.environmentIntensity),e.object.environmentRotation=this.environmentRotation.toArray(),e}}class Da extends Ki{constructor(t){super(),this.isLineBasicMaterial=!0,this.type="LineBasicMaterial",this.color=new Xt(16777215),this.map=null,this.linewidth=1,this.linecap="round",this.linejoin="round",this.fog=!0,this.setValues(t)}copy(t){return super.copy(t),this.color.copy(t.color),this.map=t.map,this.linewidth=t.linewidth,this.linecap=t.linecap,this.linejoin=t.linejoin,this.fog=t.fog,this}}const gr=new C,_r=new C,Wc=new re,ss=new br,qs=new Sr,co=new C,Xc=new C;class Jg extends Me{constructor(t=new Ne,e=new Da){super(),this.isLine=!0,this.type="Line",this.geometry=t,this.material=e,this.updateMorphTargets()}copy(t,e){return super.copy(t,e),this.material=Array.isArray(t.material)?t.material.slice():t.material,this.geometry=t.geometry,this}computeLineDistances(){const t=this.geometry;if(t.index===null){const e=t.attributes.position,n=[0];for(let s=1,r=e.count;s<r;s++)gr.fromBufferAttribute(e,s-1),_r.fromBufferAttribute(e,s),n[s]=n[s-1],n[s]+=gr.distanceTo(_r);t.setAttribute("lineDistance",new Se(n,1))}else console.warn("THREE.Line.computeLineDistances(): Computation only possible with non-indexed BufferGeometry.");return this}raycast(t,e){const n=this.geometry,s=this.matrixWorld,r=t.params.Line.threshold,o=n.drawRange;if(n.boundingSphere===null&&n.computeBoundingSphere(),qs.copy(n.boundingSphere),qs.applyMatrix4(s),qs.radius+=r,t.ray.intersectsSphere(qs)===!1)return;Wc.copy(s).invert(),ss.copy(t.ray).applyMatrix4(Wc);const a=r/((this.scale.x+this.scale.y+this.scale.z)/3),c=a*a,l=this.isLineSegments?2:1,h=n.index,u=n.attributes.position;if(h!==null){const f=Math.max(0,o.start),g=Math.min(h.count,o.start+o.count);for(let _=f,p=g-1;_<p;_+=l){const m=h.getX(_),w=h.getX(_+1),x=Ys(this,t,ss,c,m,w);x&&e.push(x)}if(this.isLineLoop){const _=h.getX(g-1),p=h.getX(f),m=Ys(this,t,ss,c,_,p);m&&e.push(m)}}else{const f=Math.max(0,o.start),g=Math.min(u.count,o.start+o.count);for(let _=f,p=g-1;_<p;_+=l){const m=Ys(this,t,ss,c,_,_+1);m&&e.push(m)}if(this.isLineLoop){const _=Ys(this,t,ss,c,g-1,f);_&&e.push(_)}}}updateMorphTargets(){const e=this.geometry.morphAttributes,n=Object.keys(e);if(n.length>0){const s=e[n[0]];if(s!==void 0){this.morphTargetInfluences=[],this.morphTargetDictionary={};for(let r=0,o=s.length;r<o;r++){const a=s[r].name||String(r);this.morphTargetInfluences.push(0),this.morphTargetDictionary[a]=r}}}}}function Ys(i,t,e,n,s,r){const o=i.geometry.attributes.position;if(gr.fromBufferAttribute(o,s),_r.fromBufferAttribute(o,r),e.distanceSqToSegment(gr,_r,co,Xc)>n)return;co.applyMatrix4(i.matrixWorld);const c=t.ray.origin.distanceTo(co);if(!(c<t.near||c>t.far))return{distance:c,point:Xc.clone().applyMatrix4(i.matrixWorld),index:s,face:null,faceIndex:null,barycoord:null,object:i}}const $c=new C,qc=new C;class sh extends Jg{constructor(t,e){super(t,e),this.isLineSegments=!0,this.type="LineSegments"}computeLineDistances(){const t=this.geometry;if(t.index===null){const e=t.attributes.position,n=[];for(let s=0,r=e.count;s<r;s+=2)$c.fromBufferAttribute(e,s),qc.fromBufferAttribute(e,s+1),n[s]=s===0?0:n[s-1],n[s+1]=n[s]+$c.distanceTo(qc);t.setAttribute("lineDistance",new Se(n,1))}else console.warn("THREE.LineSegments.computeLineDistances(): Computation only possible with non-indexed BufferGeometry.");return this}}class hn{constructor(){this.type="Curve",this.arcLengthDivisions=200}getPoint(){return console.warn("THREE.Curve: .getPoint() not implemented."),null}getPointAt(t,e){const n=this.getUtoTmapping(t);return this.getPoint(n,e)}getPoints(t=5){const e=[];for(let n=0;n<=t;n++)e.push(this.getPoint(n/t));return e}getSpacedPoints(t=5){const e=[];for(let n=0;n<=t;n++)e.push(this.getPointAt(n/t));return e}getLength(){const t=this.getLengths();return t[t.length-1]}getLengths(t=this.arcLengthDivisions){if(this.cacheArcLengths&&this.cacheArcLengths.length===t+1&&!this.needsUpdate)return this.cacheArcLengths;this.needsUpdate=!1;const e=[];let n,s=this.getPoint(0),r=0;e.push(0);for(let o=1;o<=t;o++)n=this.getPoint(o/t),r+=n.distanceTo(s),e.push(r),s=n;return this.cacheArcLengths=e,e}updateArcLengths(){this.needsUpdate=!0,this.getLengths()}getUtoTmapping(t,e){const n=this.getLengths();let s=0;const r=n.length;let o;e?o=e:o=t*n[r-1];let a=0,c=r-1,l;for(;a<=c;)if(s=Math.floor(a+(c-a)/2),l=n[s]-o,l<0)a=s+1;else if(l>0)c=s-1;else{c=s;break}if(s=c,n[s]===o)return s/(r-1);const h=n[s],u=n[s+1]-h,f=(o-h)/u;return(s+f)/(r-1)}getTangent(t,e){let s=t-1e-4,r=t+1e-4;s<0&&(s=0),r>1&&(r=1);const o=this.getPoint(s),a=this.getPoint(r),c=e||(o.isVector2?new nt:new C);return c.copy(a).sub(o).normalize(),c}getTangentAt(t,e){const n=this.getUtoTmapping(t);return this.getTangent(n,e)}computeFrenetFrames(t,e){const n=new C,s=[],r=[],o=[],a=new C,c=new re;for(let f=0;f<=t;f++){const g=f/t;s[f]=this.getTangentAt(g,new C)}r[0]=new C,o[0]=new C;let l=Number.MAX_VALUE;const h=Math.abs(s[0].x),d=Math.abs(s[0].y),u=Math.abs(s[0].z);h<=l&&(l=h,n.set(1,0,0)),d<=l&&(l=d,n.set(0,1,0)),u<=l&&n.set(0,0,1),a.crossVectors(s[0],n).normalize(),r[0].crossVectors(s[0],a),o[0].crossVectors(s[0],r[0]);for(let f=1;f<=t;f++){if(r[f]=r[f-1].clone(),o[f]=o[f-1].clone(),a.crossVectors(s[f-1],s[f]),a.length()>Number.EPSILON){a.normalize();const g=Math.acos(ye(s[f-1].dot(s[f]),-1,1));r[f].applyMatrix4(c.makeRotationAxis(a,g))}o[f].crossVectors(s[f],r[f])}if(e===!0){let f=Math.acos(ye(r[0].dot(r[t]),-1,1));f/=t,s[0].dot(a.crossVectors(r[0],r[t]))>0&&(f=-f);for(let g=1;g<=t;g++)r[g].applyMatrix4(c.makeRotationAxis(s[g],f*g)),o[g].crossVectors(s[g],r[g])}return{tangents:s,normals:r,binormals:o}}clone(){return new this.constructor().copy(this)}copy(t){return this.arcLengthDivisions=t.arcLengthDivisions,this}toJSON(){const t={metadata:{version:4.6,type:"Curve",generator:"Curve.toJSON"}};return t.arcLengthDivisions=this.arcLengthDivisions,t.type=this.type,t}fromJSON(t){return this.arcLengthDivisions=t.arcLengthDivisions,this}}class Ia extends hn{constructor(t=0,e=0,n=1,s=1,r=0,o=Math.PI*2,a=!1,c=0){super(),this.isEllipseCurve=!0,this.type="EllipseCurve",this.aX=t,this.aY=e,this.xRadius=n,this.yRadius=s,this.aStartAngle=r,this.aEndAngle=o,this.aClockwise=a,this.aRotation=c}getPoint(t,e=new nt){const n=e,s=Math.PI*2;let r=this.aEndAngle-this.aStartAngle;const o=Math.abs(r)<Number.EPSILON;for(;r<0;)r+=s;for(;r>s;)r-=s;r<Number.EPSILON&&(o?r=0:r=s),this.aClockwise===!0&&!o&&(r===s?r=-s:r=r-s);const a=this.aStartAngle+t*r;let c=this.aX+this.xRadius*Math.cos(a),l=this.aY+this.yRadius*Math.sin(a);if(this.aRotation!==0){const h=Math.cos(this.aRotation),d=Math.sin(this.aRotation),u=c-this.aX,f=l-this.aY;c=u*h-f*d+this.aX,l=u*d+f*h+this.aY}return n.set(c,l)}copy(t){return super.copy(t),this.aX=t.aX,this.aY=t.aY,this.xRadius=t.xRadius,this.yRadius=t.yRadius,this.aStartAngle=t.aStartAngle,this.aEndAngle=t.aEndAngle,this.aClockwise=t.aClockwise,this.aRotation=t.aRotation,this}toJSON(){const t=super.toJSON();return t.aX=this.aX,t.aY=this.aY,t.xRadius=this.xRadius,t.yRadius=this.yRadius,t.aStartAngle=this.aStartAngle,t.aEndAngle=this.aEndAngle,t.aClockwise=this.aClockwise,t.aRotation=this.aRotation,t}fromJSON(t){return super.fromJSON(t),this.aX=t.aX,this.aY=t.aY,this.xRadius=t.xRadius,this.yRadius=t.yRadius,this.aStartAngle=t.aStartAngle,this.aEndAngle=t.aEndAngle,this.aClockwise=t.aClockwise,this.aRotation=t.aRotation,this}}class Qg extends Ia{constructor(t,e,n,s,r,o){super(t,e,n,n,s,r,o),this.isArcCurve=!0,this.type="ArcCurve"}}function Ua(){let i=0,t=0,e=0,n=0;function s(r,o,a,c){i=r,t=a,e=-3*r+3*o-2*a-c,n=2*r-2*o+a+c}return{initCatmullRom:function(r,o,a,c,l){s(o,a,l*(a-r),l*(c-o))},initNonuniformCatmullRom:function(r,o,a,c,l,h,d){let u=(o-r)/l-(a-r)/(l+h)+(a-o)/h,f=(a-o)/h-(c-o)/(h+d)+(c-a)/d;u*=h,f*=h,s(o,a,u,f)},calc:function(r){const o=r*r,a=o*r;return i+t*r+e*o+n*a}}}const Ks=new C,lo=new Ua,ho=new Ua,uo=new Ua;class rh extends hn{constructor(t=[],e=!1,n="centripetal",s=.5){super(),this.isCatmullRomCurve3=!0,this.type="CatmullRomCurve3",this.points=t,this.closed=e,this.curveType=n,this.tension=s}getPoint(t,e=new C){const n=e,s=this.points,r=s.length,o=(r-(this.closed?0:1))*t;let a=Math.floor(o),c=o-a;this.closed?a+=a>0?0:(Math.floor(Math.abs(a)/r)+1)*r:c===0&&a===r-1&&(a=r-2,c=1);let l,h;this.closed||a>0?l=s[(a-1)%r]:(Ks.subVectors(s[0],s[1]).add(s[0]),l=Ks);const d=s[a%r],u=s[(a+1)%r];if(this.closed||a+2<r?h=s[(a+2)%r]:(Ks.subVectors(s[r-1],s[r-2]).add(s[r-1]),h=Ks),this.curveType==="centripetal"||this.curveType==="chordal"){const f=this.curveType==="chordal"?.5:.25;let g=Math.pow(l.distanceToSquared(d),f),_=Math.pow(d.distanceToSquared(u),f),p=Math.pow(u.distanceToSquared(h),f);_<1e-4&&(_=1),g<1e-4&&(g=_),p<1e-4&&(p=_),lo.initNonuniformCatmullRom(l.x,d.x,u.x,h.x,g,_,p),ho.initNonuniformCatmullRom(l.y,d.y,u.y,h.y,g,_,p),uo.initNonuniformCatmullRom(l.z,d.z,u.z,h.z,g,_,p)}else this.curveType==="catmullrom"&&(lo.initCatmullRom(l.x,d.x,u.x,h.x,this.tension),ho.initCatmullRom(l.y,d.y,u.y,h.y,this.tension),uo.initCatmullRom(l.z,d.z,u.z,h.z,this.tension));return n.set(lo.calc(c),ho.calc(c),uo.calc(c)),n}copy(t){super.copy(t),this.points=[];for(let e=0,n=t.points.length;e<n;e++){const s=t.points[e];this.points.push(s.clone())}return this.closed=t.closed,this.curveType=t.curveType,this.tension=t.tension,this}toJSON(){const t=super.toJSON();t.points=[];for(let e=0,n=this.points.length;e<n;e++){const s=this.points[e];t.points.push(s.toArray())}return t.closed=this.closed,t.curveType=this.curveType,t.tension=this.tension,t}fromJSON(t){super.fromJSON(t),this.points=[];for(let e=0,n=t.points.length;e<n;e++){const s=t.points[e];this.points.push(new C().fromArray(s))}return this.closed=t.closed,this.curveType=t.curveType,this.tension=t.tension,this}}function Yc(i,t,e,n,s){const r=(n-t)*.5,o=(s-e)*.5,a=i*i,c=i*a;return(2*e-2*n+r+o)*c+(-3*e+3*n-2*r-o)*a+r*i+e}function t0(i,t){const e=1-i;return e*e*t}function e0(i,t){return 2*(1-i)*i*t}function n0(i,t){return i*i*t}function hs(i,t,e,n){return t0(i,t)+e0(i,e)+n0(i,n)}function i0(i,t){const e=1-i;return e*e*e*t}function s0(i,t){const e=1-i;return 3*e*e*i*t}function r0(i,t){return 3*(1-i)*i*i*t}function o0(i,t){return i*i*i*t}function us(i,t,e,n,s){return i0(i,t)+s0(i,e)+r0(i,n)+o0(i,s)}class oh extends hn{constructor(t=new nt,e=new nt,n=new nt,s=new nt){super(),this.isCubicBezierCurve=!0,this.type="CubicBezierCurve",this.v0=t,this.v1=e,this.v2=n,this.v3=s}getPoint(t,e=new nt){const n=e,s=this.v0,r=this.v1,o=this.v2,a=this.v3;return n.set(us(t,s.x,r.x,o.x,a.x),us(t,s.y,r.y,o.y,a.y)),n}copy(t){return super.copy(t),this.v0.copy(t.v0),this.v1.copy(t.v1),this.v2.copy(t.v2),this.v3.copy(t.v3),this}toJSON(){const t=super.toJSON();return t.v0=this.v0.toArray(),t.v1=this.v1.toArray(),t.v2=this.v2.toArray(),t.v3=this.v3.toArray(),t}fromJSON(t){return super.fromJSON(t),this.v0.fromArray(t.v0),this.v1.fromArray(t.v1),this.v2.fromArray(t.v2),this.v3.fromArray(t.v3),this}}class a0 extends hn{constructor(t=new C,e=new C,n=new C,s=new C){super(),this.isCubicBezierCurve3=!0,this.type="CubicBezierCurve3",this.v0=t,this.v1=e,this.v2=n,this.v3=s}getPoint(t,e=new C){const n=e,s=this.v0,r=this.v1,o=this.v2,a=this.v3;return n.set(us(t,s.x,r.x,o.x,a.x),us(t,s.y,r.y,o.y,a.y),us(t,s.z,r.z,o.z,a.z)),n}copy(t){return super.copy(t),this.v0.copy(t.v0),this.v1.copy(t.v1),this.v2.copy(t.v2),this.v3.copy(t.v3),this}toJSON(){const t=super.toJSON();return t.v0=this.v0.toArray(),t.v1=this.v1.toArray(),t.v2=this.v2.toArray(),t.v3=this.v3.toArray(),t}fromJSON(t){return super.fromJSON(t),this.v0.fromArray(t.v0),this.v1.fromArray(t.v1),this.v2.fromArray(t.v2),this.v3.fromArray(t.v3),this}}class ah extends hn{constructor(t=new nt,e=new nt){super(),this.isLineCurve=!0,this.type="LineCurve",this.v1=t,this.v2=e}getPoint(t,e=new nt){const n=e;return t===1?n.copy(this.v2):(n.copy(this.v2).sub(this.v1),n.multiplyScalar(t).add(this.v1)),n}getPointAt(t,e){return this.getPoint(t,e)}getTangent(t,e=new nt){return e.subVectors(this.v2,this.v1).normalize()}getTangentAt(t,e){return this.getTangent(t,e)}copy(t){return super.copy(t),this.v1.copy(t.v1),this.v2.copy(t.v2),this}toJSON(){const t=super.toJSON();return t.v1=this.v1.toArray(),t.v2=this.v2.toArray(),t}fromJSON(t){return super.fromJSON(t),this.v1.fromArray(t.v1),this.v2.fromArray(t.v2),this}}class c0 extends hn{constructor(t=new C,e=new C){super(),this.isLineCurve3=!0,this.type="LineCurve3",this.v1=t,this.v2=e}getPoint(t,e=new C){const n=e;return t===1?n.copy(this.v2):(n.copy(this.v2).sub(this.v1),n.multiplyScalar(t).add(this.v1)),n}getPointAt(t,e){return this.getPoint(t,e)}getTangent(t,e=new C){return e.subVectors(this.v2,this.v1).normalize()}getTangentAt(t,e){return this.getTangent(t,e)}copy(t){return super.copy(t),this.v1.copy(t.v1),this.v2.copy(t.v2),this}toJSON(){const t=super.toJSON();return t.v1=this.v1.toArray(),t.v2=this.v2.toArray(),t}fromJSON(t){return super.fromJSON(t),this.v1.fromArray(t.v1),this.v2.fromArray(t.v2),this}}class ch extends hn{constructor(t=new nt,e=new nt,n=new nt){super(),this.isQuadraticBezierCurve=!0,this.type="QuadraticBezierCurve",this.v0=t,this.v1=e,this.v2=n}getPoint(t,e=new nt){const n=e,s=this.v0,r=this.v1,o=this.v2;return n.set(hs(t,s.x,r.x,o.x),hs(t,s.y,r.y,o.y)),n}copy(t){return super.copy(t),this.v0.copy(t.v0),this.v1.copy(t.v1),this.v2.copy(t.v2),this}toJSON(){const t=super.toJSON();return t.v0=this.v0.toArray(),t.v1=this.v1.toArray(),t.v2=this.v2.toArray(),t}fromJSON(t){return super.fromJSON(t),this.v0.fromArray(t.v0),this.v1.fromArray(t.v1),this.v2.fromArray(t.v2),this}}class l0 extends hn{constructor(t=new C,e=new C,n=new C){super(),this.isQuadraticBezierCurve3=!0,this.type="QuadraticBezierCurve3",this.v0=t,this.v1=e,this.v2=n}getPoint(t,e=new C){const n=e,s=this.v0,r=this.v1,o=this.v2;return n.set(hs(t,s.x,r.x,o.x),hs(t,s.y,r.y,o.y),hs(t,s.z,r.z,o.z)),n}copy(t){return super.copy(t),this.v0.copy(t.v0),this.v1.copy(t.v1),this.v2.copy(t.v2),this}toJSON(){const t=super.toJSON();return t.v0=this.v0.toArray(),t.v1=this.v1.toArray(),t.v2=this.v2.toArray(),t}fromJSON(t){return super.fromJSON(t),this.v0.fromArray(t.v0),this.v1.fromArray(t.v1),this.v2.fromArray(t.v2),this}}class lh extends hn{constructor(t=[]){super(),this.isSplineCurve=!0,this.type="SplineCurve",this.points=t}getPoint(t,e=new nt){const n=e,s=this.points,r=(s.length-1)*t,o=Math.floor(r),a=r-o,c=s[o===0?o:o-1],l=s[o],h=s[o>s.length-2?s.length-1:o+1],d=s[o>s.length-3?s.length-1:o+2];return n.set(Yc(a,c.x,l.x,h.x,d.x),Yc(a,c.y,l.y,h.y,d.y)),n}copy(t){super.copy(t),this.points=[];for(let e=0,n=t.points.length;e<n;e++){const s=t.points[e];this.points.push(s.clone())}return this}toJSON(){const t=super.toJSON();t.points=[];for(let e=0,n=this.points.length;e<n;e++){const s=this.points[e];t.points.push(s.toArray())}return t}fromJSON(t){super.fromJSON(t),this.points=[];for(let e=0,n=t.points.length;e<n;e++){const s=t.points[e];this.points.push(new nt().fromArray(s))}return this}}var la=Object.freeze({__proto__:null,ArcCurve:Qg,CatmullRomCurve3:rh,CubicBezierCurve:oh,CubicBezierCurve3:a0,EllipseCurve:Ia,LineCurve:ah,LineCurve3:c0,QuadraticBezierCurve:ch,QuadraticBezierCurve3:l0,SplineCurve:lh});class h0 extends hn{constructor(){super(),this.type="CurvePath",this.curves=[],this.autoClose=!1}add(t){this.curves.push(t)}closePath(){const t=this.curves[0].getPoint(0),e=this.curves[this.curves.length-1].getPoint(1);if(!t.equals(e)){const n=t.isVector2===!0?"LineCurve":"LineCurve3";this.curves.push(new la[n](e,t))}return this}getPoint(t,e){const n=t*this.getLength(),s=this.getCurveLengths();let r=0;for(;r<s.length;){if(s[r]>=n){const o=s[r]-n,a=this.curves[r],c=a.getLength(),l=c===0?0:1-o/c;return a.getPointAt(l,e)}r++}return null}getLength(){const t=this.getCurveLengths();return t[t.length-1]}updateArcLengths(){this.needsUpdate=!0,this.cacheLengths=null,this.getCurveLengths()}getCurveLengths(){if(this.cacheLengths&&this.cacheLengths.length===this.curves.length)return this.cacheLengths;const t=[];let e=0;for(let n=0,s=this.curves.length;n<s;n++)e+=this.curves[n].getLength(),t.push(e);return this.cacheLengths=t,t}getSpacedPoints(t=40){const e=[];for(let n=0;n<=t;n++)e.push(this.getPoint(n/t));return this.autoClose&&e.push(e[0]),e}getPoints(t=12){const e=[];let n;for(let s=0,r=this.curves;s<r.length;s++){const o=r[s],a=o.isEllipseCurve?t*2:o.isLineCurve||o.isLineCurve3?1:o.isSplineCurve?t*o.points.length:t,c=o.getPoints(a);for(let l=0;l<c.length;l++){const h=c[l];n&&n.equals(h)||(e.push(h),n=h)}}return this.autoClose&&e.length>1&&!e[e.length-1].equals(e[0])&&e.push(e[0]),e}copy(t){super.copy(t),this.curves=[];for(let e=0,n=t.curves.length;e<n;e++){const s=t.curves[e];this.curves.push(s.clone())}return this.autoClose=t.autoClose,this}toJSON(){const t=super.toJSON();t.autoClose=this.autoClose,t.curves=[];for(let e=0,n=this.curves.length;e<n;e++){const s=this.curves[e];t.curves.push(s.toJSON())}return t}fromJSON(t){super.fromJSON(t),this.autoClose=t.autoClose,this.curves=[];for(let e=0,n=t.curves.length;e<n;e++){const s=t.curves[e];this.curves.push(new la[s.type]().fromJSON(s))}return this}}class ha extends h0{constructor(t){super(),this.type="Path",this.currentPoint=new nt,t&&this.setFromPoints(t)}setFromPoints(t){this.moveTo(t[0].x,t[0].y);for(let e=1,n=t.length;e<n;e++)this.lineTo(t[e].x,t[e].y);return this}moveTo(t,e){return this.currentPoint.set(t,e),this}lineTo(t,e){const n=new ah(this.currentPoint.clone(),new nt(t,e));return this.curves.push(n),this.currentPoint.set(t,e),this}quadraticCurveTo(t,e,n,s){const r=new ch(this.currentPoint.clone(),new nt(t,e),new nt(n,s));return this.curves.push(r),this.currentPoint.set(n,s),this}bezierCurveTo(t,e,n,s,r,o){const a=new oh(this.currentPoint.clone(),new nt(t,e),new nt(n,s),new nt(r,o));return this.curves.push(a),this.currentPoint.set(r,o),this}splineThru(t){const e=[this.currentPoint.clone()].concat(t),n=new lh(e);return this.curves.push(n),this.currentPoint.copy(t[t.length-1]),this}arc(t,e,n,s,r,o){const a=this.currentPoint.x,c=this.currentPoint.y;return this.absarc(t+a,e+c,n,s,r,o),this}absarc(t,e,n,s,r,o){return this.absellipse(t,e,n,n,s,r,o),this}ellipse(t,e,n,s,r,o,a,c){const l=this.currentPoint.x,h=this.currentPoint.y;return this.absellipse(t+l,e+h,n,s,r,o,a,c),this}absellipse(t,e,n,s,r,o,a,c){const l=new Ia(t,e,n,s,r,o,a,c);if(this.curves.length>0){const d=l.getPoint(0);d.equals(this.currentPoint)||this.lineTo(d.x,d.y)}this.curves.push(l);const h=l.getPoint(1);return this.currentPoint.copy(h),this}copy(t){return super.copy(t),this.currentPoint.copy(t.currentPoint),this}toJSON(){const t=super.toJSON();return t.currentPoint=this.currentPoint.toArray(),t}fromJSON(t){return super.fromJSON(t),this.currentPoint.fromArray(t.currentPoint),this}}class Na extends Ne{constructor(t=1,e=1,n=1,s=32,r=1,o=!1,a=0,c=Math.PI*2){super(),this.type="CylinderGeometry",this.parameters={radiusTop:t,radiusBottom:e,height:n,radialSegments:s,heightSegments:r,openEnded:o,thetaStart:a,thetaLength:c};const l=this;s=Math.floor(s),r=Math.floor(r);const h=[],d=[],u=[],f=[];let g=0;const _=[],p=n/2;let m=0;w(),o===!1&&(t>0&&x(!0),e>0&&x(!1)),this.setIndex(h),this.setAttribute("position",new Se(d,3)),this.setAttribute("normal",new Se(u,3)),this.setAttribute("uv",new Se(f,2));function w(){const b=new C,I=new C;let R=0;const A=(e-t)/n;for(let P=0;P<=r;P++){const W=[],v=P/r,S=v*(e-t)+t;for(let F=0;F<=s;F++){const N=F/s,H=N*c+a,X=Math.sin(H),z=Math.cos(H);I.x=S*X,I.y=-v*n+p,I.z=S*z,d.push(I.x,I.y,I.z),b.set(X,A,z).normalize(),u.push(b.x,b.y,b.z),f.push(N,1-v),W.push(g++)}_.push(W)}for(let P=0;P<s;P++)for(let W=0;W<r;W++){const v=_[W][P],S=_[W+1][P],F=_[W+1][P+1],N=_[W][P+1];t>0&&(h.push(v,S,N),R+=3),e>0&&(h.push(S,F,N),R+=3)}l.addGroup(m,R,0),m+=R}function x(b){const I=g,R=new nt,A=new C;let P=0;const W=b===!0?t:e,v=b===!0?1:-1;for(let F=1;F<=s;F++)d.push(0,p*v,0),u.push(0,v,0),f.push(.5,.5),g++;const S=g;for(let F=0;F<=s;F++){const H=F/s*c+a,X=Math.cos(H),z=Math.sin(H);A.x=W*z,A.y=p*v,A.z=W*X,d.push(A.x,A.y,A.z),u.push(0,v,0),R.x=X*.5+.5,R.y=z*.5*v+.5,f.push(R.x,R.y),g++}for(let F=0;F<s;F++){const N=I+F,H=S+F;b===!0?h.push(H,H+1,N):h.push(H+1,H,N),P+=3}l.addGroup(m,P,b===!0?1:2),m+=P}}copy(t){return super.copy(t),this.parameters=Object.assign({},t.parameters),this}static fromJSON(t){return new Na(t.radiusTop,t.radiusBottom,t.height,t.radialSegments,t.heightSegments,t.openEnded,t.thetaStart,t.thetaLength)}}const Zs=new C,js=new C,fo=new C,Js=new Ye;class u0 extends Ne{constructor(t=null,e=1){if(super(),this.type="EdgesGeometry",this.parameters={geometry:t,thresholdAngle:e},t!==null){const s=Math.pow(10,4),r=Math.cos(Oi*e),o=t.getIndex(),a=t.getAttribute("position"),c=o?o.count:a.count,l=[0,0,0],h=["a","b","c"],d=new Array(3),u={},f=[];for(let g=0;g<c;g+=3){o?(l[0]=o.getX(g),l[1]=o.getX(g+1),l[2]=o.getX(g+2)):(l[0]=g,l[1]=g+1,l[2]=g+2);const{a:_,b:p,c:m}=Js;if(_.fromBufferAttribute(a,l[0]),p.fromBufferAttribute(a,l[1]),m.fromBufferAttribute(a,l[2]),Js.getNormal(fo),d[0]=`${Math.round(_.x*s)},${Math.round(_.y*s)},${Math.round(_.z*s)}`,d[1]=`${Math.round(p.x*s)},${Math.round(p.y*s)},${Math.round(p.z*s)}`,d[2]=`${Math.round(m.x*s)},${Math.round(m.y*s)},${Math.round(m.z*s)}`,!(d[0]===d[1]||d[1]===d[2]||d[2]===d[0]))for(let w=0;w<3;w++){const x=(w+1)%3,b=d[w],I=d[x],R=Js[h[w]],A=Js[h[x]],P=`${b}_${I}`,W=`${I}_${b}`;W in u&&u[W]?(fo.dot(u[W].normal)<=r&&(f.push(R.x,R.y,R.z),f.push(A.x,A.y,A.z)),u[W]=null):P in u||(u[P]={index0:l[w],index1:l[x],normal:fo.clone()})}}for(const g in u)if(u[g]){const{index0:_,index1:p}=u[g];Zs.fromBufferAttribute(a,_),js.fromBufferAttribute(a,p),f.push(Zs.x,Zs.y,Zs.z),f.push(js.x,js.y,js.z)}this.setAttribute("position",new Se(f,3))}}copy(t){return super.copy(t),this.parameters=Object.assign({},t.parameters),this}}class hh extends ha{constructor(t){super(t),this.uuid=ui(),this.type="Shape",this.holes=[]}getPointsHoles(t){const e=[];for(let n=0,s=this.holes.length;n<s;n++)e[n]=this.holes[n].getPoints(t);return e}extractPoints(t){return{shape:this.getPoints(t),holes:this.getPointsHoles(t)}}copy(t){super.copy(t),this.holes=[];for(let e=0,n=t.holes.length;e<n;e++){const s=t.holes[e];this.holes.push(s.clone())}return this}toJSON(){const t=super.toJSON();t.uuid=this.uuid,t.holes=[];for(let e=0,n=this.holes.length;e<n;e++){const s=this.holes[e];t.holes.push(s.toJSON())}return t}fromJSON(t){super.fromJSON(t),this.uuid=t.uuid,this.holes=[];for(let e=0,n=t.holes.length;e<n;e++){const s=t.holes[e];this.holes.push(new ha().fromJSON(s))}return this}}const d0={triangulate:function(i,t,e=2){const n=t&&t.length,s=n?t[0]*e:i.length;let r=uh(i,0,s,e,!0);const o=[];if(!r||r.next===r.prev)return o;let a,c,l,h,d,u,f;if(n&&(r=_0(i,t,r,e)),i.length>80*e){a=l=i[0],c=h=i[1];for(let g=e;g<s;g+=e)d=i[g],u=i[g+1],d<a&&(a=d),u<c&&(c=u),d>l&&(l=d),u>h&&(h=u);f=Math.max(l-a,h-c),f=f!==0?32767/f:0}return vs(r,o,e,a,c,f,0),o}};function uh(i,t,e,n,s){let r,o;if(s===C0(i,t,e,n)>0)for(r=t;r<e;r+=n)o=Kc(r,i[r],i[r+1],o);else for(r=e-n;r>=t;r-=n)o=Kc(r,i[r],i[r+1],o);return o&&wr(o,o.next)&&(ys(o),o=o.next),o}function ai(i,t){if(!i)return i;t||(t=i);let e=i,n;do if(n=!1,!e.steiner&&(wr(e,e.next)||he(e.prev,e,e.next)===0)){if(ys(e),e=t=e.prev,e===e.next)break;n=!0}else e=e.next;while(n||e!==t);return t}function vs(i,t,e,n,s,r,o){if(!i)return;!o&&r&&S0(i,n,s,r);let a=i,c,l;for(;i.prev!==i.next;){if(c=i.prev,l=i.next,r?p0(i,n,s,r):f0(i)){t.push(c.i/e|0),t.push(i.i/e|0),t.push(l.i/e|0),ys(i),i=l.next,a=l.next;continue}if(i=l,i===a){o?o===1?(i=m0(ai(i),t,e),vs(i,t,e,n,s,r,2)):o===2&&g0(i,t,e,n,s,r):vs(ai(i),t,e,n,s,r,1);break}}}function f0(i){const t=i.prev,e=i,n=i.next;if(he(t,e,n)>=0)return!1;const s=t.x,r=e.x,o=n.x,a=t.y,c=e.y,l=n.y,h=s<r?s<o?s:o:r<o?r:o,d=a<c?a<l?a:l:c<l?c:l,u=s>r?s>o?s:o:r>o?r:o,f=a>c?a>l?a:l:c>l?c:l;let g=n.next;for(;g!==t;){if(g.x>=h&&g.x<=u&&g.y>=d&&g.y<=f&&Ui(s,a,r,c,o,l,g.x,g.y)&&he(g.prev,g,g.next)>=0)return!1;g=g.next}return!0}function p0(i,t,e,n){const s=i.prev,r=i,o=i.next;if(he(s,r,o)>=0)return!1;const a=s.x,c=r.x,l=o.x,h=s.y,d=r.y,u=o.y,f=a<c?a<l?a:l:c<l?c:l,g=h<d?h<u?h:u:d<u?d:u,_=a>c?a>l?a:l:c>l?c:l,p=h>d?h>u?h:u:d>u?d:u,m=ua(f,g,t,e,n),w=ua(_,p,t,e,n);let x=i.prevZ,b=i.nextZ;for(;x&&x.z>=m&&b&&b.z<=w;){if(x.x>=f&&x.x<=_&&x.y>=g&&x.y<=p&&x!==s&&x!==o&&Ui(a,h,c,d,l,u,x.x,x.y)&&he(x.prev,x,x.next)>=0||(x=x.prevZ,b.x>=f&&b.x<=_&&b.y>=g&&b.y<=p&&b!==s&&b!==o&&Ui(a,h,c,d,l,u,b.x,b.y)&&he(b.prev,b,b.next)>=0))return!1;b=b.nextZ}for(;x&&x.z>=m;){if(x.x>=f&&x.x<=_&&x.y>=g&&x.y<=p&&x!==s&&x!==o&&Ui(a,h,c,d,l,u,x.x,x.y)&&he(x.prev,x,x.next)>=0)return!1;x=x.prevZ}for(;b&&b.z<=w;){if(b.x>=f&&b.x<=_&&b.y>=g&&b.y<=p&&b!==s&&b!==o&&Ui(a,h,c,d,l,u,b.x,b.y)&&he(b.prev,b,b.next)>=0)return!1;b=b.nextZ}return!0}function m0(i,t,e){let n=i;do{const s=n.prev,r=n.next.next;!wr(s,r)&&dh(s,n,n.next,r)&&xs(s,r)&&xs(r,s)&&(t.push(s.i/e|0),t.push(n.i/e|0),t.push(r.i/e|0),ys(n),ys(n.next),n=i=r),n=n.next}while(n!==i);return ai(n)}function g0(i,t,e,n,s,r){let o=i;do{let a=o.next.next;for(;a!==o.prev;){if(o.i!==a.i&&T0(o,a)){let c=fh(o,a);o=ai(o,o.next),c=ai(c,c.next),vs(o,t,e,n,s,r,0),vs(c,t,e,n,s,r,0);return}a=a.next}o=o.next}while(o!==i)}function _0(i,t,e,n){const s=[];let r,o,a,c,l;for(r=0,o=t.length;r<o;r++)a=t[r]*n,c=r<o-1?t[r+1]*n:i.length,l=uh(i,a,c,n,!1),l===l.next&&(l.steiner=!0),s.push(E0(l));for(s.sort(v0),r=0;r<s.length;r++)e=x0(s[r],e);return e}function v0(i,t){return i.x-t.x}function x0(i,t){const e=y0(i,t);if(!e)return t;const n=fh(e,i);return ai(n,n.next),ai(e,e.next)}function y0(i,t){let e=t,n=-1/0,s;const r=i.x,o=i.y;do{if(o<=e.y&&o>=e.next.y&&e.next.y!==e.y){const u=e.x+(o-e.y)*(e.next.x-e.x)/(e.next.y-e.y);if(u<=r&&u>n&&(n=u,s=e.x<e.next.x?e:e.next,u===r))return s}e=e.next}while(e!==t);if(!s)return null;const a=s,c=s.x,l=s.y;let h=1/0,d;e=s;do r>=e.x&&e.x>=c&&r!==e.x&&Ui(o<l?r:n,o,c,l,o<l?n:r,o,e.x,e.y)&&(d=Math.abs(o-e.y)/(r-e.x),xs(e,i)&&(d<h||d===h&&(e.x>s.x||e.x===s.x&&M0(s,e)))&&(s=e,h=d)),e=e.next;while(e!==a);return s}function M0(i,t){return he(i.prev,i,t.prev)<0&&he(t.next,i,i.next)<0}function S0(i,t,e,n){let s=i;do s.z===0&&(s.z=ua(s.x,s.y,t,e,n)),s.prevZ=s.prev,s.nextZ=s.next,s=s.next;while(s!==i);s.prevZ.nextZ=null,s.prevZ=null,b0(s)}function b0(i){let t,e,n,s,r,o,a,c,l=1;do{for(e=i,i=null,r=null,o=0;e;){for(o++,n=e,a=0,t=0;t<l&&(a++,n=n.nextZ,!!n);t++);for(c=l;a>0||c>0&&n;)a!==0&&(c===0||!n||e.z<=n.z)?(s=e,e=e.nextZ,a--):(s=n,n=n.nextZ,c--),r?r.nextZ=s:i=s,s.prevZ=r,r=s;e=n}r.nextZ=null,l*=2}while(o>1);return i}function ua(i,t,e,n,s){return i=(i-e)*s|0,t=(t-n)*s|0,i=(i|i<<8)&16711935,i=(i|i<<4)&252645135,i=(i|i<<2)&858993459,i=(i|i<<1)&1431655765,t=(t|t<<8)&16711935,t=(t|t<<4)&252645135,t=(t|t<<2)&858993459,t=(t|t<<1)&1431655765,i|t<<1}function E0(i){let t=i,e=i;do(t.x<e.x||t.x===e.x&&t.y<e.y)&&(e=t),t=t.next;while(t!==i);return e}function Ui(i,t,e,n,s,r,o,a){return(s-o)*(t-a)>=(i-o)*(r-a)&&(i-o)*(n-a)>=(e-o)*(t-a)&&(e-o)*(r-a)>=(s-o)*(n-a)}function T0(i,t){return i.next.i!==t.i&&i.prev.i!==t.i&&!w0(i,t)&&(xs(i,t)&&xs(t,i)&&A0(i,t)&&(he(i.prev,i,t.prev)||he(i,t.prev,t))||wr(i,t)&&he(i.prev,i,i.next)>0&&he(t.prev,t,t.next)>0)}function he(i,t,e){return(t.y-i.y)*(e.x-t.x)-(t.x-i.x)*(e.y-t.y)}function wr(i,t){return i.x===t.x&&i.y===t.y}function dh(i,t,e,n){const s=tr(he(i,t,e)),r=tr(he(i,t,n)),o=tr(he(e,n,i)),a=tr(he(e,n,t));return!!(s!==r&&o!==a||s===0&&Qs(i,e,t)||r===0&&Qs(i,n,t)||o===0&&Qs(e,i,n)||a===0&&Qs(e,t,n))}function Qs(i,t,e){return t.x<=Math.max(i.x,e.x)&&t.x>=Math.min(i.x,e.x)&&t.y<=Math.max(i.y,e.y)&&t.y>=Math.min(i.y,e.y)}function tr(i){return i>0?1:i<0?-1:0}function w0(i,t){let e=i;do{if(e.i!==i.i&&e.next.i!==i.i&&e.i!==t.i&&e.next.i!==t.i&&dh(e,e.next,i,t))return!0;e=e.next}while(e!==i);return!1}function xs(i,t){return he(i.prev,i,i.next)<0?he(i,t,i.next)>=0&&he(i,i.prev,t)>=0:he(i,t,i.prev)<0||he(i,i.next,t)<0}function A0(i,t){let e=i,n=!1;const s=(i.x+t.x)/2,r=(i.y+t.y)/2;do e.y>r!=e.next.y>r&&e.next.y!==e.y&&s<(e.next.x-e.x)*(r-e.y)/(e.next.y-e.y)+e.x&&(n=!n),e=e.next;while(e!==i);return n}function fh(i,t){const e=new da(i.i,i.x,i.y),n=new da(t.i,t.x,t.y),s=i.next,r=t.prev;return i.next=t,t.prev=i,e.next=s,s.prev=e,n.next=e,e.prev=n,r.next=n,n.prev=r,n}function Kc(i,t,e,n){const s=new da(i,t,e);return n?(s.next=n.next,s.prev=n,n.next.prev=s,n.next=s):(s.prev=s,s.next=s),s}function ys(i){i.next.prev=i.prev,i.prev.next=i.next,i.prevZ&&(i.prevZ.nextZ=i.nextZ),i.nextZ&&(i.nextZ.prevZ=i.prevZ)}function da(i,t,e){this.i=i,this.x=t,this.y=e,this.prev=null,this.next=null,this.z=0,this.prevZ=null,this.nextZ=null,this.steiner=!1}function C0(i,t,e,n){let s=0;for(let r=t,o=e-n;r<e;r+=n)s+=(i[o]-i[r])*(i[r+1]+i[o+1]),o=r;return s}class ds{static area(t){const e=t.length;let n=0;for(let s=e-1,r=0;r<e;s=r++)n+=t[s].x*t[r].y-t[r].x*t[s].y;return n*.5}static isClockWise(t){return ds.area(t)<0}static triangulateShape(t,e){const n=[],s=[],r=[];Zc(t),jc(n,t);let o=t.length;e.forEach(Zc);for(let c=0;c<e.length;c++)s.push(o),o+=e[c].length,jc(n,e[c]);const a=d0.triangulate(n,s);for(let c=0;c<a.length;c+=3)r.push(a.slice(c,c+3));return r}}function Zc(i){const t=i.length;t>2&&i[t-1].equals(i[0])&&i.pop()}function jc(i,t){for(let e=0;e<t.length;e++)i.push(t[e].x),i.push(t[e].y)}class ka extends Ne{constructor(t=new hh([new nt(.5,.5),new nt(-.5,.5),new nt(-.5,-.5),new nt(.5,-.5)]),e={}){super(),this.type="ExtrudeGeometry",this.parameters={shapes:t,options:e},t=Array.isArray(t)?t:[t];const n=this,s=[],r=[];for(let a=0,c=t.length;a<c;a++){const l=t[a];o(l)}this.setAttribute("position",new Se(s,3)),this.setAttribute("uv",new Se(r,2)),this.computeVertexNormals();function o(a){const c=[],l=e.curveSegments!==void 0?e.curveSegments:12,h=e.steps!==void 0?e.steps:1,d=e.depth!==void 0?e.depth:1;let u=e.bevelEnabled!==void 0?e.bevelEnabled:!0,f=e.bevelThickness!==void 0?e.bevelThickness:.2,g=e.bevelSize!==void 0?e.bevelSize:f-.1,_=e.bevelOffset!==void 0?e.bevelOffset:0,p=e.bevelSegments!==void 0?e.bevelSegments:3;const m=e.extrudePath,w=e.UVGenerator!==void 0?e.UVGenerator:R0;let x,b=!1,I,R,A,P;m&&(x=m.getSpacedPoints(h),b=!0,u=!1,I=m.computeFrenetFrames(h,!1),R=new C,A=new C,P=new C),u||(p=0,f=0,g=0,_=0);const W=a.extractPoints(l);let v=W.shape;const S=W.holes;if(!ds.isClockWise(v)){v=v.reverse();for(let K=0,T=S.length;K<T;K++){const rt=S[K];ds.isClockWise(rt)&&(S[K]=rt.reverse())}}const N=ds.triangulateShape(v,S),H=v;for(let K=0,T=S.length;K<T;K++){const rt=S[K];v=v.concat(rt)}function X(K,T,rt){return T||console.error("THREE.ExtrudeGeometry: vec does not exist"),K.clone().addScaledVector(T,rt)}const z=v.length,J=N.length;function G(K,T,rt){let st,Q,ot;const Ct=K.x-T.x,mt=K.y-T.y,E=rt.x-K.x,y=rt.y-K.y,k=Ct*Ct+mt*mt,q=Ct*y-mt*E;if(Math.abs(q)>Number.EPSILON){const Z=Math.sqrt(k),Y=Math.sqrt(E*E+y*y),bt=T.x-mt/Z,at=T.y+Ct/Z,vt=rt.x-y/Y,Yt=rt.y+E/Y,et=((vt-bt)*y-(Yt-at)*E)/(Ct*y-mt*E);st=bt+Ct*et-K.x,Q=at+mt*et-K.y;const xt=st*st+Q*Q;if(xt<=2)return new nt(st,Q);ot=Math.sqrt(xt/2)}else{let Z=!1;Ct>Number.EPSILON?E>Number.EPSILON&&(Z=!0):Ct<-Number.EPSILON?E<-Number.EPSILON&&(Z=!0):Math.sign(mt)===Math.sign(y)&&(Z=!0),Z?(st=-mt,Q=Ct,ot=Math.sqrt(k)):(st=Ct,Q=mt,ot=Math.sqrt(k/2))}return new nt(st/ot,Q/ot)}const ht=[];for(let K=0,T=H.length,rt=T-1,st=K+1;K<T;K++,rt++,st++)rt===T&&(rt=0),st===T&&(st=0),ht[K]=G(H[K],H[rt],H[st]);const ft=[];let pt,$t=ht.concat();for(let K=0,T=S.length;K<T;K++){const rt=S[K];pt=[];for(let st=0,Q=rt.length,ot=Q-1,Ct=st+1;st<Q;st++,ot++,Ct++)ot===Q&&(ot=0),Ct===Q&&(Ct=0),pt[st]=G(rt[st],rt[ot],rt[Ct]);ft.push(pt),$t=$t.concat(pt)}for(let K=0;K<p;K++){const T=K/p,rt=f*Math.cos(T*Math.PI/2),st=g*Math.sin(T*Math.PI/2)+_;for(let Q=0,ot=H.length;Q<ot;Q++){const Ct=X(H[Q],ht[Q],st);lt(Ct.x,Ct.y,-rt)}for(let Q=0,ot=S.length;Q<ot;Q++){const Ct=S[Q];pt=ft[Q];for(let mt=0,E=Ct.length;mt<E;mt++){const y=X(Ct[mt],pt[mt],st);lt(y.x,y.y,-rt)}}}const jt=g+_;for(let K=0;K<z;K++){const T=u?X(v[K],$t[K],jt):v[K];b?(A.copy(I.normals[0]).multiplyScalar(T.x),R.copy(I.binormals[0]).multiplyScalar(T.y),P.copy(x[0]).add(A).add(R),lt(P.x,P.y,P.z)):lt(T.x,T.y,0)}for(let K=1;K<=h;K++)for(let T=0;T<z;T++){const rt=u?X(v[T],$t[T],jt):v[T];b?(A.copy(I.normals[K]).multiplyScalar(rt.x),R.copy(I.binormals[K]).multiplyScalar(rt.y),P.copy(x[K]).add(A).add(R),lt(P.x,P.y,P.z)):lt(rt.x,rt.y,d/h*K)}for(let K=p-1;K>=0;K--){const T=K/p,rt=f*Math.cos(T*Math.PI/2),st=g*Math.sin(T*Math.PI/2)+_;for(let Q=0,ot=H.length;Q<ot;Q++){const Ct=X(H[Q],ht[Q],st);lt(Ct.x,Ct.y,d+rt)}for(let Q=0,ot=S.length;Q<ot;Q++){const Ct=S[Q];pt=ft[Q];for(let mt=0,E=Ct.length;mt<E;mt++){const y=X(Ct[mt],pt[mt],st);b?lt(y.x,y.y+x[h-1].y,x[h-1].x+rt):lt(y.x,y.y,d+rt)}}}$(),tt();function $(){const K=s.length/3;if(u){let T=0,rt=z*T;for(let st=0;st<J;st++){const Q=N[st];It(Q[2]+rt,Q[1]+rt,Q[0]+rt)}T=h+p*2,rt=z*T;for(let st=0;st<J;st++){const Q=N[st];It(Q[0]+rt,Q[1]+rt,Q[2]+rt)}}else{for(let T=0;T<J;T++){const rt=N[T];It(rt[2],rt[1],rt[0])}for(let T=0;T<J;T++){const rt=N[T];It(rt[0]+z*h,rt[1]+z*h,rt[2]+z*h)}}n.addGroup(K,s.length/3-K,0)}function tt(){const K=s.length/3;let T=0;yt(H,T),T+=H.length;for(let rt=0,st=S.length;rt<st;rt++){const Q=S[rt];yt(Q,T),T+=Q.length}n.addGroup(K,s.length/3-K,1)}function yt(K,T){let rt=K.length;for(;--rt>=0;){const st=rt;let Q=rt-1;Q<0&&(Q=K.length-1);for(let ot=0,Ct=h+p*2;ot<Ct;ot++){const mt=z*ot,E=z*(ot+1),y=T+st+mt,k=T+Q+mt,q=T+Q+E,Z=T+st+E;Dt(y,k,q,Z)}}}function lt(K,T,rt){c.push(K),c.push(T),c.push(rt)}function It(K,T,rt){Ot(K),Ot(T),Ot(rt);const st=s.length/3,Q=w.generateTopUV(n,s,st-3,st-2,st-1);Gt(Q[0]),Gt(Q[1]),Gt(Q[2])}function Dt(K,T,rt,st){Ot(K),Ot(T),Ot(st),Ot(T),Ot(rt),Ot(st);const Q=s.length/3,ot=w.generateSideWallUV(n,s,Q-6,Q-3,Q-2,Q-1);Gt(ot[0]),Gt(ot[1]),Gt(ot[3]),Gt(ot[1]),Gt(ot[2]),Gt(ot[3])}function Ot(K){s.push(c[K*3+0]),s.push(c[K*3+1]),s.push(c[K*3+2])}function Gt(K){r.push(K.x),r.push(K.y)}}}copy(t){return super.copy(t),this.parameters=Object.assign({},t.parameters),this}toJSON(){const t=super.toJSON(),e=this.parameters.shapes,n=this.parameters.options;return P0(e,n,t)}static fromJSON(t,e){const n=[];for(let r=0,o=t.shapes.length;r<o;r++){const a=e[t.shapes[r]];n.push(a)}const s=t.options.extrudePath;return s!==void 0&&(t.options.extrudePath=new la[s.type]().fromJSON(s)),new ka(n,t.options)}}const R0={generateTopUV:function(i,t,e,n,s){const r=t[e*3],o=t[e*3+1],a=t[n*3],c=t[n*3+1],l=t[s*3],h=t[s*3+1];return[new nt(r,o),new nt(a,c),new nt(l,h)]},generateSideWallUV:function(i,t,e,n,s,r){const o=t[e*3],a=t[e*3+1],c=t[e*3+2],l=t[n*3],h=t[n*3+1],d=t[n*3+2],u=t[s*3],f=t[s*3+1],g=t[s*3+2],_=t[r*3],p=t[r*3+1],m=t[r*3+2];return Math.abs(a-h)<Math.abs(o-l)?[new nt(o,1-c),new nt(l,1-d),new nt(u,1-g),new nt(_,1-m)]:[new nt(a,1-c),new nt(h,1-d),new nt(f,1-g),new nt(p,1-m)]}};function P0(i,t,e){if(e.shapes=[],Array.isArray(i))for(let n=0,s=i.length;n<s;n++){const r=i[n];e.shapes.push(r.uuid)}else e.shapes.push(i.uuid);return e.options=Object.assign({},t),t.extrudePath!==void 0&&(e.options.extrudePath=t.extrudePath.toJSON()),e}class si extends Ki{constructor(t){super(),this.isMeshStandardMaterial=!0,this.defines={STANDARD:""},this.type="MeshStandardMaterial",this.color=new Xt(16777215),this.roughness=1,this.metalness=0,this.map=null,this.lightMap=null,this.lightMapIntensity=1,this.aoMap=null,this.aoMapIntensity=1,this.emissive=new Xt(0),this.emissiveIntensity=1,this.emissiveMap=null,this.bumpMap=null,this.bumpScale=1,this.normalMap=null,this.normalMapType=Ol,this.normalScale=new nt(1,1),this.displacementMap=null,this.displacementScale=1,this.displacementBias=0,this.roughnessMap=null,this.metalnessMap=null,this.alphaMap=null,this.envMap=null,this.envMapRotation=new on,this.envMapIntensity=1,this.wireframe=!1,this.wireframeLinewidth=1,this.wireframeLinecap="round",this.wireframeLinejoin="round",this.flatShading=!1,this.fog=!0,this.setValues(t)}copy(t){return super.copy(t),this.defines={STANDARD:""},this.color.copy(t.color),this.roughness=t.roughness,this.metalness=t.metalness,this.map=t.map,this.lightMap=t.lightMap,this.lightMapIntensity=t.lightMapIntensity,this.aoMap=t.aoMap,this.aoMapIntensity=t.aoMapIntensity,this.emissive.copy(t.emissive),this.emissiveMap=t.emissiveMap,this.emissiveIntensity=t.emissiveIntensity,this.bumpMap=t.bumpMap,this.bumpScale=t.bumpScale,this.normalMap=t.normalMap,this.normalMapType=t.normalMapType,this.normalScale.copy(t.normalScale),this.displacementMap=t.displacementMap,this.displacementScale=t.displacementScale,this.displacementBias=t.displacementBias,this.roughnessMap=t.roughnessMap,this.metalnessMap=t.metalnessMap,this.alphaMap=t.alphaMap,this.envMap=t.envMap,this.envMapRotation.copy(t.envMapRotation),this.envMapIntensity=t.envMapIntensity,this.wireframe=t.wireframe,this.wireframeLinewidth=t.wireframeLinewidth,this.wireframeLinecap=t.wireframeLinecap,this.wireframeLinejoin=t.wireframeLinejoin,this.flatShading=t.flatShading,this.fog=t.fog,this}}class Fa extends Me{constructor(t,e=1){super(),this.isLight=!0,this.type="Light",this.color=new Xt(t),this.intensity=e}dispose(){}copy(t,e){return super.copy(t,e),this.color.copy(t.color),this.intensity=t.intensity,this}toJSON(t){const e=super.toJSON(t);return e.object.color=this.color.getHex(),e.object.intensity=this.intensity,this.groundColor!==void 0&&(e.object.groundColor=this.groundColor.getHex()),this.distance!==void 0&&(e.object.distance=this.distance),this.angle!==void 0&&(e.object.angle=this.angle),this.decay!==void 0&&(e.object.decay=this.decay),this.penumbra!==void 0&&(e.object.penumbra=this.penumbra),this.shadow!==void 0&&(e.object.shadow=this.shadow.toJSON()),this.target!==void 0&&(e.object.target=this.target.uuid),e}}class L0 extends Fa{constructor(t,e,n){super(t,n),this.isHemisphereLight=!0,this.type="HemisphereLight",this.position.copy(Me.DEFAULT_UP),this.updateMatrix(),this.groundColor=new Xt(e)}copy(t,e){return super.copy(t,e),this.groundColor.copy(t.groundColor),this}}const po=new re,Jc=new C,Qc=new C;class ph{constructor(t){this.camera=t,this.intensity=1,this.bias=0,this.normalBias=0,this.radius=1,this.blurSamples=8,this.mapSize=new nt(512,512),this.map=null,this.mapPass=null,this.matrix=new re,this.autoUpdate=!0,this.needsUpdate=!1,this._frustum=new Ra,this._frameExtents=new nt(1,1),this._viewportCount=1,this._viewports=[new se(0,0,1,1)]}getViewportCount(){return this._viewportCount}getFrustum(){return this._frustum}updateMatrices(t){const e=this.camera,n=this.matrix;Jc.setFromMatrixPosition(t.matrixWorld),e.position.copy(Jc),Qc.setFromMatrixPosition(t.target.matrixWorld),e.lookAt(Qc),e.updateMatrixWorld(),po.multiplyMatrices(e.projectionMatrix,e.matrixWorldInverse),this._frustum.setFromProjectionMatrix(po),n.set(.5,0,0,.5,0,.5,0,.5,0,0,.5,.5,0,0,0,1),n.multiply(po)}getViewport(t){return this._viewports[t]}getFrameExtents(){return this._frameExtents}dispose(){this.map&&this.map.dispose(),this.mapPass&&this.mapPass.dispose()}copy(t){return this.camera=t.camera.clone(),this.intensity=t.intensity,this.bias=t.bias,this.radius=t.radius,this.mapSize.copy(t.mapSize),this}clone(){return new this.constructor().copy(this)}toJSON(){const t={};return this.intensity!==1&&(t.intensity=this.intensity),this.bias!==0&&(t.bias=this.bias),this.normalBias!==0&&(t.normalBias=this.normalBias),this.radius!==1&&(t.radius=this.radius),(this.mapSize.x!==512||this.mapSize.y!==512)&&(t.mapSize=this.mapSize.toArray()),t.camera=this.camera.toJSON(!1).object,delete t.camera.matrix,t}}const tl=new re,rs=new C,mo=new C;class D0 extends ph{constructor(){super(new He(90,1,.5,500)),this.isPointLightShadow=!0,this._frameExtents=new nt(4,2),this._viewportCount=6,this._viewports=[new se(2,1,1,1),new se(0,1,1,1),new se(3,1,1,1),new se(1,1,1,1),new se(3,0,1,1),new se(1,0,1,1)],this._cubeDirections=[new C(1,0,0),new C(-1,0,0),new C(0,0,1),new C(0,0,-1),new C(0,1,0),new C(0,-1,0)],this._cubeUps=[new C(0,1,0),new C(0,1,0),new C(0,1,0),new C(0,1,0),new C(0,0,1),new C(0,0,-1)]}updateMatrices(t,e=0){const n=this.camera,s=this.matrix,r=t.distance||n.far;r!==n.far&&(n.far=r,n.updateProjectionMatrix()),rs.setFromMatrixPosition(t.matrixWorld),n.position.copy(rs),mo.copy(n.position),mo.add(this._cubeDirections[e]),n.up.copy(this._cubeUps[e]),n.lookAt(mo),n.updateMatrixWorld(),s.makeTranslation(-rs.x,-rs.y,-rs.z),tl.multiplyMatrices(n.projectionMatrix,n.matrixWorldInverse),this._frustum.setFromProjectionMatrix(tl)}}class mh extends Fa{constructor(t,e,n=0,s=2){super(t,e),this.isPointLight=!0,this.type="PointLight",this.distance=n,this.decay=s,this.shadow=new D0}get power(){return this.intensity*4*Math.PI}set power(t){this.intensity=t/(4*Math.PI)}dispose(){this.shadow.dispose()}copy(t,e){return super.copy(t,e),this.distance=t.distance,this.decay=t.decay,this.shadow=t.shadow.clone(),this}}class I0 extends ph{constructor(){super(new jl(-5,5,5,-5,.5,500)),this.isDirectionalLightShadow=!0}}class el extends Fa{constructor(t,e){super(t,e),this.isDirectionalLight=!0,this.type="DirectionalLight",this.position.copy(Me.DEFAULT_UP),this.updateMatrix(),this.target=new Me,this.shadow=new I0}dispose(){this.shadow.dispose()}copy(t){return super.copy(t),this.target=t.target.clone(),this.shadow=t.shadow.clone(),this}}class U0{constructor(t=!0){this.autoStart=t,this.startTime=0,this.oldTime=0,this.elapsedTime=0,this.running=!1}start(){this.startTime=nl(),this.oldTime=this.startTime,this.elapsedTime=0,this.running=!0}stop(){this.getElapsedTime(),this.running=!1,this.autoStart=!1}getElapsedTime(){return this.getDelta(),this.elapsedTime}getDelta(){let t=0;if(this.autoStart&&!this.running)return this.start(),0;if(this.running){const e=nl();t=(e-this.oldTime)/1e3,this.oldTime=e,this.elapsedTime+=t}return t}}function nl(){return performance.now()}const il=new re;class N0{constructor(t,e,n=0,s=1/0){this.ray=new br(t,e),this.near=n,this.far=s,this.camera=null,this.layers=new Ca,this.params={Mesh:{},Line:{threshold:1},LOD:{},Points:{threshold:1},Sprite:{}}}set(t,e){this.ray.set(t,e)}setFromCamera(t,e){e.isPerspectiveCamera?(this.ray.origin.setFromMatrixPosition(e.matrixWorld),this.ray.direction.set(t.x,t.y,.5).unproject(e).sub(this.ray.origin).normalize(),this.camera=e):e.isOrthographicCamera?(this.ray.origin.set(t.x,t.y,(e.near+e.far)/(e.near-e.far)).unproject(e),this.ray.direction.set(0,0,-1).transformDirection(e.matrixWorld),this.camera=e):console.error("THREE.Raycaster: Unsupported camera type: "+e.type)}setFromXRController(t){return il.identity().extractRotation(t.matrixWorld),this.ray.origin.setFromMatrixPosition(t.matrixWorld),this.ray.direction.set(0,0,-1).applyMatrix4(il),this}intersectObject(t,e=!0,n=[]){return fa(t,this,n,e),n.sort(sl),n}intersectObjects(t,e=!0,n=[]){for(let s=0,r=t.length;s<r;s++)fa(t[s],this,n,e);return n.sort(sl),n}}function sl(i,t){return i.distance-t.distance}function fa(i,t,e,n){let s=!0;if(i.layers.test(t.layers)&&i.raycast(t,e)===!1&&(s=!1),s===!0&&n===!0){const r=i.children;for(let o=0,a=r.length;o<a;o++)fa(r[o],t,e,!0)}}class rl{constructor(t=1,e=0,n=0){return this.radius=t,this.phi=e,this.theta=n,this}set(t,e,n){return this.radius=t,this.phi=e,this.theta=n,this}copy(t){return this.radius=t.radius,this.phi=t.phi,this.theta=t.theta,this}makeSafe(){return this.phi=Math.max(1e-6,Math.min(Math.PI-1e-6,this.phi)),this}setFromVector3(t){return this.setFromCartesianCoords(t.x,t.y,t.z)}setFromCartesianCoords(t,e,n){return this.radius=Math.sqrt(t*t+e*e+n*n),this.radius===0?(this.theta=0,this.phi=0):(this.theta=Math.atan2(t,n),this.phi=Math.acos(ye(e/this.radius,-1,1))),this}clone(){return new this.constructor().copy(this)}}class k0 extends sh{constructor(t=10,e=10,n=4473924,s=8947848){n=new Xt(n),s=new Xt(s);const r=e/2,o=t/e,a=t/2,c=[],l=[];for(let u=0,f=0,g=-a;u<=e;u++,g+=o){c.push(-a,0,g,a,0,g),c.push(g,0,-a,g,0,a);const _=u===r?n:s;_.toArray(l,f),f+=3,_.toArray(l,f),f+=3,_.toArray(l,f),f+=3,_.toArray(l,f),f+=3}const h=new Ne;h.setAttribute("position",new Se(c,3)),h.setAttribute("color",new Se(l,3));const d=new Da({vertexColors:!0,toneMapped:!1});super(h,d),this.type="GridHelper"}dispose(){this.geometry.dispose(),this.material.dispose()}}class gh extends hi{constructor(t,e=null){super(),this.object=t,this.domElement=e,this.enabled=!0,this.state=-1,this.keys={},this.mouseButtons={LEFT:null,MIDDLE:null,RIGHT:null},this.touches={ONE:null,TWO:null}}connect(){}disconnect(){}dispose(){}update(){}}typeof __THREE_DEVTOOLS__<"u"&&__THREE_DEVTOOLS__.dispatchEvent(new CustomEvent("register",{detail:{revision:xa}}));typeof window<"u"&&(window.__THREE__?console.warn("WARNING: Multiple instances of Three.js being imported."):window.__THREE__=xa);const At={name:"Tàu hàng khô 3.000 DWT (mô hình học tập)",L:70,B:12,D:6.5,T:4.4,hdb:1.2,spacing:.7,xAftPar:14,xForePar:50,dbX0:7,dbX1:63},Vn=(i,t,e)=>Math.min(e,Math.max(t,i)),ol=(i,t,e)=>{const n=Vn((e-i)/(t-i),0,1);return n*n*(3-2*n)},Ie=i=>i*At.spacing;function Tn(i){const{B:t,D:e,L:n,xAftPar:s,xForePar:r}=At,o=t/2;let a=o,c=10,l=1.6,h=0;if(i>r){const d=Vn((i-r)/(n-r),0,1);a=o*Math.max(.02,1-Math.pow(d,2.2)),c=10-7.5*Math.pow(d,.9),l=1.6+(e*.8-1.6)*Math.pow(d,1.3)}else if(i<s){const d=Vn((s-i)/s,0,1);a=o*(1-.3*d*d),c=10-7*Math.pow(d,.8),l=1.6+2.2*d,h=i<10?3*Math.pow(1-Math.max(0,i)/10,1.4):0}return l=Math.min(l,e-h-.3),{hb:a,n:c,zb:l,zk:h}}const er=44,al=new Map;function ji(i){const t=i.toFixed(4);let e=al.get(t);if(e)return e;const{hb:n,n:s,zb:r,zk:o}=Tn(i),a=[];for(let u=0;u<=er;u++){const f=Math.PI/2*(1-u/er),g=n*Math.pow(Math.cos(f),2/s),_=o+r*(1-Math.pow(Math.sin(f),2/s));a.push([u===er?n:g,u===er?o+r:_])}const c=o+r,l=Math.max(1,Math.ceil((At.D-c)/.4));for(let u=1;u<=l;u++)a.push([n,c+(At.D-c)*u/l]);const h=[0];for(let u=1;u<a.length;u++)h.push(h[u-1]+Math.hypot(a[u][0]-a[u-1][0],a[u][1]-a[u-1][1]));const d=h[h.length-1];return e={x:i,pts:a,u:h.map(u=>u/d),total:d,hb:n,zk:o},al.set(t,e),e}function _h(i,t){let e=1;for(;e<i.length-1&&i[e]<t;)e++;const n=i[e-1],s=i[e];return{i:e,f:s>n?Vn((t-n)/(s-n),0,1):0}}function Gn(i,t){const e=ji(i),{i:n,f:s}=_h(e.u,Vn(t,0,1)),r=e.pts[n-1],o=e.pts[n];return[r[0]+(o[0]-r[0])*s,r[1]+(o[1]-r[1])*s]}function vh(i,t){const e=ji(i),{i:n}=_h(e.u,Vn(t,0,1)),s=e.pts[n-1],r=e.pts[n],o=r[0]-s[0],a=r[1]-s[1],c=Math.hypot(o,a)||1;return[-a/c,o/c]}function Mn(i,t){const e=ji(i);if(t<=e.pts[0][1])return 0;for(let n=1;n<e.pts.length;n++){const s=e.pts[n-1],r=e.pts[n];if(r[1]>=t){const o=r[1]>s[1]?(t-s[1])/(r[1]-s[1]):0;return e.u[n-1]+(e.u[n]-e.u[n-1])*o}}return 1}function Wn(i,t){const e=ji(i);if(t<=e.pts[0][1])return 0;const[n]=Gn(i,Mn(i,t));return n}function fs(i,t){const e=ji(i);t=Math.abs(t);for(let n=1;n<e.pts.length;n++){const s=e.pts[n-1],r=e.pts[n];if(r[0]>=t){const o=r[0]>s[0]?(t-s[0])/(r[0]-s[0]):0;return s[1]+(r[1]-s[1])*o}}return At.D}function Ar(i,t,e=-1){const n=ji(i),s=[],r=e>0?Mn(i,e):0,o=Mn(i,t);s.push(Gn(i,r));for(let a=0;a<n.pts.length;a++)n.u[a]>r+1e-6&&n.u[a]<o-1e-6&&s.push(n.pts[a].slice());return s.push(Gn(i,o)),s}function ci(i,t,e,n=new C){let s=i;return s-=3.5*(1-Vn(e,0,At.D)/At.D)*ol(52,70,i),s-=1*(Vn(e,0,At.D)/At.D)*(1-ol(0,6,i)),n.set(s-At.L/2,e,t)}const qi={shell:{name:"Tôn vỏ bao",color:8229803},bottom:{name:"Kết cấu đáy",color:13208398},long:{name:"Kết cấu dọc (dầm dọc)",color:5219237},trans:{name:"Kết cấu ngang (sườn, đà)",color:13940570},deck:{name:"Boong & miệng hầm",color:8367723},bhd:{name:"Vách",color:11566278},bracket:{name:"Mã (bracket)",color:14708828},ends:{name:"Kết cấu mũi – đuôi",color:10260352},super:{name:"Thượng tầng",color:14278114},equip:{name:"Thiết bị",color:13214247}},pa={keel_plate:{name:"Tôn giữa đáy (tôn ky)",en:"Flat keel plate",cat:"shell",spec:"t = 14 mm",desc:"Dải tôn đáy nằm ở mặt phẳng dọc tâm, dày hơn các tấm tôn đáy khác vì chịu uốn chung lớn nhất và chịu lực khi tàu nằm trên đế kê ụ."},bottom_shell:{name:"Tôn đáy ngoài",en:"Bottom shell plating",cat:"shell",spec:"t = 12 mm",desc:"Các dải tôn tạo nên đáy ngoài; cùng với dầm dọc đáy tham gia sức bền dọc chung và chịu áp lực nước."},bilge_plate:{name:"Tôn hông (tôn lượn)",en:"Bilge strake",cat:"shell",spec:"t = 12 mm, uốn cong",desc:"Dải tôn cong nối đáy với mạn. Phải uốn cong hai chiều ở vùng mũi – đuôi nên gia công phức tạp nhất."},side_shell:{name:"Tôn mạn",en:"Side shell plating",cat:"shell",spec:"t = 11 mm",desc:"Dải tôn bao mạn tàu, chịu áp lực nước, va đập sóng và tham gia sức bền dọc."},sheer_strake:{name:"Tôn mép mạn",en:"Sheer strake",cat:"shell",spec:"t = 13 mm",desc:"Dải tôn mạn trên cùng nối với tôn mép boong; nằm xa trục trung hoà nên chịu ứng suất uốn chung lớn, thường dày hơn tôn mạn."},inner_bottom:{name:"Tôn đáy trên",en:"Inner bottom plating",cat:"bottom",spec:"t = 12 mm",desc:"Lớp tôn đáy thứ hai tạo thành đáy đôi; giữ kín nước khi đáy ngoài thủng, làm sàn hầm hàng và nóc két dằn/két dầu."},bottom_long:{name:"Dầm dọc đáy",en:"Bottom longitudinal",cat:"long",spec:"L 200×90×10",desc:"Thép hình chạy dọc tàu hàn lên tôn đáy ngoài, xuyên qua lỗ khoét của đà ngang. Đặc trưng của hệ thống kết cấu dọc ở đáy."},ib_long:{name:"Dầm dọc đáy trên",en:"Inner bottom longitudinal",cat:"long",spec:"L 180×90×9",desc:"Thép hình dọc gia cường tôn đáy trên, hàn phía dưới tôn đáy trên (bên trong đáy đôi)."},center_girder:{name:"Sống chính (sống đáy giữa)",en:"Centre girder",cat:"bottom",spec:"t = 14 mm, kín nước",desc:"Tấm đứng dọc tâm tàu nối tôn ky với tôn đáy trên, chạy liên tục suốt chiều dài đáy đôi. Là “xương sống” của thân tàu."},side_girder:{name:"Sống phụ (sống đáy bên)",en:"Side girder",cat:"bottom",spec:"t = 11 mm, có lỗ khoét",desc:"Tấm đứng dọc tàu đặt hai bên sống chính, đỡ đà ngang và tăng cứng đáy đôi. Có lỗ khoét giảm trọng lượng và lối đi lại."},floor:{name:"Đà ngang đáy đặc",en:"Solid (plate) floor",cat:"trans",spec:"t = 10 mm, lỗ khoét 800×500",desc:"Tấm đứng nằm ngang tàu trong đáy đôi, nối tôn đáy ngoài – tôn đáy trên – sống. Có lỗ khoét giảm trọng lượng, cho người chui kiểm tra và lỗ cho dầm dọc đi qua."},wt_floor:{name:"Đà ngang kín nước",en:"Watertight floor",cat:"trans",spec:"t = 12 mm, không khoét lỗ",desc:"Đà ngang không khoét lỗ, nằm dưới vách ngang kín nước, chia đáy đôi thành các két riêng biệt."},deep_floor:{name:"Đà ngang cao (khoang mũi/đuôi)",en:"Deep floor",cat:"trans",spec:"t = 10 mm",desc:"Đà ngang có chiều cao lớn ở vùng mũi, đuôi nơi thân tàu thon và không có đáy đôi; hệ thống kết cấu ngang."},frame:{name:"Sườn thường",en:"Ordinary frame",cat:"trans",spec:"L 180×90×9",desc:"Thép hình đặt ngang tàu theo từng khoảng sườn, gia cường tôn mạn — đặc trưng của hệ thống kết cấu ngang ở mạn."},web_frame:{name:"Sườn khỏe",en:"Web frame",cat:"trans",spec:"T 550×10 / 200×14",desc:"Sườn có tiết diện lớn đặt cách vài khoảng sườn, làm gối tựa cho sống dọc mạn và tăng độ cứng ngang thân tàu."},side_stringer:{name:"Sống dọc mạn",en:"Side stringer",cat:"long",spec:"T 500×10 / 150×12",desc:"Kết cấu dọc khỏe đặt trên mạn, tựa lên các sườn khỏe; giảm nhịp làm việc của sườn thường."},bilge_bracket:{name:"Mã hông",en:"Bilge bracket",cat:"bracket",spec:"t = 10 mm, 700×700",desc:"Tấm mã tam giác liên kết chân sườn với tôn đáy trên (tôn mép), truyền mô-men giữa kết cấu mạn và đáy."},beam_bracket:{name:"Mã xà (mã boong – mạn)",en:"Beam knee",cat:"bracket",spec:"t = 9 mm, 600×600",desc:"Mã nối đầu trên của sườn với kết cấu boong, tạo khung sườn kín."},deck_plate:{name:"Tôn boong",en:"Deck plating",cat:"deck",spec:"t = 11 mm",desc:"Lớp tôn phủ boong chính, cánh trên của dầm tương đương thân tàu, chịu uốn chung và tải trọng trên boong."},deck_stringer:{name:"Tôn mép boong",en:"Deck stringer plate",cat:"deck",spec:"t = 13 mm",desc:"Dải tôn boong sát mạn, nối với tôn mép mạn; thường dày hơn tôn boong vì ứng suất lớn."},deck_long:{name:"Dầm dọc boong",en:"Deck longitudinal",cat:"long",spec:"L 160×80×8",desc:"Thép hình dọc hàn dưới tôn boong (hệ thống kết cấu dọc ở boong vùng giữa tàu)."},deck_transverse:{name:"Xà ngang khỏe boong",en:"Deck transverse",cat:"trans",spec:"T 500×10 / 150×12",desc:"Xà ngang tiết diện lớn đặt tại vị trí sườn khỏe, làm gối tựa cho dầm dọc boong."},deck_beam:{name:"Xà ngang boong",en:"Deck beam",cat:"trans",spec:"L 160×80×8",desc:"Xà ngang đặt tại mỗi sườn ở vùng mũi/đuôi (hệ thống kết cấu ngang ở boong)."},deck_girder:{name:"Sống dọc boong",en:"Deck girder",cat:"long",spec:"T 450×10 / 150×12",desc:"Kết cấu dọc khỏe dưới boong, đỡ các xà ngang boong."},hatch_girder:{name:"Sống dọc miệng hầm",en:"Hatch side girder",cat:"long",spec:"T 600×12 / 200×16",desc:"Sống dọc dưới boong chạy dọc mép miệng hầm hàng, là phần kéo dài xuống dưới của thành miệng hầm dọc."},hatch_end_beam:{name:"Xà ngang đầu miệng hầm",en:"Hatch end beam",cat:"trans",spec:"T 600×12 / 200×16",desc:"Xà ngang khỏe tại hai đầu miệng hầm, đỡ thành miệng hầm ngang và đầu các sống dọc miệng hầm."},hatch_coaming:{name:"Thành miệng hầm",en:"Hatch coaming",cat:"deck",spec:"t = 12 mm, cao 1.200 mm",desc:"Tấm đứng bao quanh miệng hầm hàng, ngăn nước tràn vào hầm và là gối đỡ nắp hầm."},coaming_stay:{name:"Mã chống thành miệng hầm",en:"Coaming stay",cat:"bracket",spec:"t = 10 mm",desc:"Tấm mã đỡ thành miệng hầm, chống lật do áp lực sóng và tải trọng nắp hầm."},bhd_plate:{name:"Tôn vách ngang kín nước",en:"Transverse watertight bulkhead plating",cat:"bhd",spec:"t = 10 mm",desc:"Vách chia thân tàu thành các khoang kín nước, đảm bảo tính chống chìm, tăng cứng ngang và ngăn cháy lan."},bhd_stiffener:{name:"Nẹp vách",en:"Bulkhead stiffener",cat:"bhd",spec:"L 200×90×10",desc:"Thép hình đứng gia cường tôn vách chịu áp lực nước khi khoang bên cạnh bị ngập."},collision_bhd:{name:"Vách chống va",en:"Collision bulkhead",cat:"bhd",spec:"t = 11 mm",desc:"Vách kín nước đầu tiên tính từ mũi, cách đường vuông góc mũi 0,05–0,08L theo quy phạm; bảo vệ tàu khi va chạm ở mũi."},transom:{name:"Tôn vách đuôi (transom)",en:"Transom plating",cat:"ends",spec:"t = 11 mm",desc:"Tấm tôn phẳng khép kín đuôi tàu dạng đuôi transom."},stern_frame:{name:"Sống đuôi / ky lái",en:"Stern frame / skeg",cat:"ends",spec:"Thép tấm hàn t = 25 mm",desc:"Kết cấu khỏe ở đuôi đỡ ống bao trục chân vịt và gót bánh lái."},stem:{name:"Sống mũi",en:"Stem",cat:"ends",spec:"Thép tấm t = 20 mm",desc:"Kết cấu khép kín mũi tàu, nối tôn vỏ hai mạn tại mặt phẳng dọc tâm, chịu va đập."},breast_hook:{name:"Mã ngực mũi",en:"Breast hook",cat:"bracket",spec:"t = 10 mm",desc:"Tấm mã nằm ngang trong khoang mũi, giằng hai mạn với sống mũi."},super_wall:{name:"Vách thượng tầng",en:"Deckhouse wall",cat:"super",spec:"t = 7 mm",desc:"Vách bao thượng tầng/lầu lái có khoét cửa sổ, cửa ra vào."},super_deck:{name:"Boong thượng tầng",en:"Deckhouse deck",cat:"super",spec:"t = 7 mm",desc:"Các boong của khối thượng tầng: boong sinh hoạt, boong lầu lái, nóc lầu lái."},funnel:{name:"Ống khói",en:"Funnel",cat:"super",spec:"t = 6 mm",desc:"Bao che ống xả buồng máy."},rudder:{name:"Bánh lái",en:"Rudder",cat:"equip",spec:"Dạng cánh, A = 4,3 m²",desc:"Thiết bị điều khiển hướng đi, lắp sau khi đấu đà xong phần đuôi."},propeller:{name:"Chân vịt + trục",en:"Propeller & shaft",cat:"equip",spec:"D = 1.900 mm, 4 cánh",desc:"Thiết bị đẩy; trục chân vịt luồn qua ống bao trục trong sống đuôi."}};function Ji(i){return pa[i]||{name:i,en:"",cat:"shell",spec:"",desc:""}}const F0=["Tàu","Tổng đoạn","Phân đoạn","Panel / Cụm chi tiết","Chi tiết"],Lt={SHIP:0,GRAND:1,BLOCK:2,ASSY:3,PART:4},Ms={nodes:new Map,parts:[]},xh=i=>i?i.isVector3?i.clone():new C(...i):new C;function qt(i,t,e,n,s={}){const r=new Ii;return r.name=n,r.userData={level:t,id:e,name:n,code:s.code||"",desc:s.desc||"",type:s.type||"",explode:xh(s.explode),crane:!!s.crane,t:1},Ms.nodes.set(e,r),i&&i.add(r),r}function Tt(i,t,e,n={}){if(!e)return null;const s=Ji(t),r=i.children.length+1,o=new ae(e),a=`${i.userData.id}.${String(r).padStart(2,"0")}`;return o.name=n.name||s.name,o.userData={level:Lt.PART,id:a,kind:t,name:n.name||s.name,code:n.code||`${i.userData.code}-${String(r).padStart(2,"0")}`,spec:n.spec||s.spec,explode:xh(n.explode),t:1},Ms.parts.push(o),i.add(o),o}function O0(){Ms.nodes.clear(),Ms.parts.length=0}function B0(i){const t=[];let e=i;for(;e&&e.userData&&e.userData.level!==void 0;)t.unshift(e),e=e.parent;return t}function ma(i,t){let e=i;for(;e&&e.userData&&e.userData.level!==void 0;){if(e.userData.level===t)return e;e=e.parent}return null}function ga(i){const t=[];return i.traverse(e=>{e.isMesh&&e.userData.level===Lt.PART&&t.push(e)}),t}function Sn(i,t){const e=At.spacing,n=[];for(let s=Math.ceil(i/e-1e-6);s*e<t-1e-6;s++)n.push(s);return n}function ps(i,t,e,n=.1){let s=null,r=null;for(let o=i;o<=t+1e-9;o+=n){const a=Math.min(o,t);e(a)?(r||(r=[a,a]),r[1]=a):r&&((!s||r[1]-r[0]>s[1]-s[0])&&(s=r),r=null)}return r&&(!s||r[1]-r[0]>s[1]-s[0])&&(s=r),s&&s[1]-s[0]>.3?s:null}function Oa(i){const t=i.slice().reverse().map(([n,s])=>[-n,s]),e=[...i,...t];return Math.abs(e[0][0])<1e-6&&Math.abs(e[e.length-1][0])<1e-6&&e.pop(),e}function li(i,t,e=.35){const n=Math.max(1,Math.ceil((t-i)/e)),s=[];for(let r=0;r<=n;r++)s.push(i+(t-i)*r/n);return s}const yh=[{x:7,name:"Vách khoang đuôi (Fr10)",kind:"bhd_plate"},{x:14,name:"Vách mũi buồng máy (Fr20)",kind:"bhd_plate"},{x:28,name:"Vách ngang hầm hàng (Fr40)",kind:"bhd_plate"},{x:42,name:"Vách ngang hầm hàng (Fr60)",kind:"bhd_plate"},{x:56,name:"Vách ngang hầm hàng (Fr80)",kind:"bhd_plate"},{x:63,name:"Vách chống va (Fr90)",kind:"collision_bhd"}],z0=i=>yh.some(t=>Math.abs(t.x-i)<.001);function H0(i,t=!1){const e=i[0].index!==null,n=new Set(Object.keys(i[0].attributes)),s=new Set(Object.keys(i[0].morphAttributes)),r={},o={},a=i[0].morphTargetsRelative,c=new Ne;let l=0;for(let h=0;h<i.length;++h){const d=i[h];let u=0;if(e!==(d.index!==null))return console.error("THREE.BufferGeometryUtils: .mergeGeometries() failed with geometry at index "+h+". All geometries must have compatible attributes; make sure index attribute exists among all geometries, or in none of them."),null;for(const f in d.attributes){if(!n.has(f))return console.error("THREE.BufferGeometryUtils: .mergeGeometries() failed with geometry at index "+h+'. All geometries must have compatible attributes; make sure "'+f+'" attribute exists among all geometries, or in none of them.'),null;r[f]===void 0&&(r[f]=[]),r[f].push(d.attributes[f]),u++}if(u!==n.size)return console.error("THREE.BufferGeometryUtils: .mergeGeometries() failed with geometry at index "+h+". Make sure all geometries have the same number of attributes."),null;if(a!==d.morphTargetsRelative)return console.error("THREE.BufferGeometryUtils: .mergeGeometries() failed with geometry at index "+h+". .morphTargetsRelative must be consistent throughout all geometries."),null;for(const f in d.morphAttributes){if(!s.has(f))return console.error("THREE.BufferGeometryUtils: .mergeGeometries() failed with geometry at index "+h+".  .morphAttributes must be consistent throughout all geometries."),null;o[f]===void 0&&(o[f]=[]),o[f].push(d.morphAttributes[f])}if(t){let f;if(e)f=d.index.count;else if(d.attributes.position!==void 0)f=d.attributes.position.count;else return console.error("THREE.BufferGeometryUtils: .mergeGeometries() failed with geometry at index "+h+". The geometry must have either an index or a position attribute"),null;c.addGroup(l,f,h),l+=f}}if(e){let h=0;const d=[];for(let u=0;u<i.length;++u){const f=i[u].index;for(let g=0;g<f.count;++g)d.push(f.getX(g)+h);h+=i[u].attributes.position.count}c.setIndex(d)}for(const h in r){const d=cl(r[h]);if(!d)return console.error("THREE.BufferGeometryUtils: .mergeGeometries() failed while trying to merge the "+h+" attribute."),null;c.setAttribute(h,d)}for(const h in o){const d=o[h][0].length;if(d===0)break;c.morphAttributes=c.morphAttributes||{},c.morphAttributes[h]=[];for(let u=0;u<d;++u){const f=[];for(let _=0;_<o[h].length;++_)f.push(o[h][_][u]);const g=cl(f);if(!g)return console.error("THREE.BufferGeometryUtils: .mergeGeometries() failed while trying to merge the "+h+" morphAttribute."),null;c.morphAttributes[h].push(g)}}return c}function cl(i){let t,e,n,s=-1,r=0;for(let l=0;l<i.length;++l){const h=i[l];if(t===void 0&&(t=h.array.constructor),t!==h.array.constructor)return console.error("THREE.BufferGeometryUtils: .mergeAttributes() failed. BufferAttribute.array must be of consistent array types across matching attributes."),null;if(e===void 0&&(e=h.itemSize),e!==h.itemSize)return console.error("THREE.BufferGeometryUtils: .mergeAttributes() failed. BufferAttribute.itemSize must be consistent across matching attributes."),null;if(n===void 0&&(n=h.normalized),n!==h.normalized)return console.error("THREE.BufferGeometryUtils: .mergeAttributes() failed. BufferAttribute.normalized must be consistent across matching attributes."),null;if(s===-1&&(s=h.gpuType),s!==h.gpuType)return console.error("THREE.BufferGeometryUtils: .mergeAttributes() failed. BufferAttribute.gpuType must be consistent across matching attributes."),null;r+=h.count*e}const o=new t(r),a=new rn(o,e,n);let c=0;for(let l=0;l<i.length;++l){const h=i[l];if(h.isInterleavedBufferAttribute){const d=c/e;for(let u=0,f=h.count;u<f;u++)for(let g=0;g<e;g++){const _=h.getComponent(u,g);a.setComponent(u+d,g,_)}}else o.set(h.array,c);c+=h.count*e}return s!==void 0&&(a.gpuType=s),a}const kn=new C;class Mh{constructor(){this.pos=[],this.idx=[]}v(t,e,n){return ci(t,e,n,kn),this.pos.push(kn.x,kn.y,kn.z),this.pos.length/3-1}strip(t,e){for(let n=0;n<t.length-1;n++)this.idx.push(t[n],e[n],t[n+1],t[n+1],e[n],e[n+1])}build(){const t=new Ne;return t.setAttribute("position",new Se(this.pos,3)),t.setIndex(this.idx),t.computeVertexNormals(),t}}const cs=(i,t)=>typeof i=="function"?i(t):i;function Un(i,t,e,n,s=1){const r=new Mh,o=Math.max(2,Math.ceil((t-i)/.35)+1),a=(i+t)/2,c=Math.max(2,Math.ceil(Math.abs(cs(n,a)-cs(e,a))*60)+1),l=[];for(let h=0;h<o;h++){const d=i+(t-i)*h/(o-1),u=cs(e,d),f=cs(n,d),g=[];for(let _=0;_<c;_++){const[p,m]=Gn(d,u+(f-u)*_/(c-1));g.push(r.v(d,s*p,m))}l.push(g)}for(let h=0;h<o-1;h++)s>0?r.strip(l[h],l[h+1]):r.strip(l[h+1],l[h]);return r.build()}function Ba(i,t,e,n,s,r="L"){const o=new Mh,a=[],c=[],l=[],h=[];for(let d=0;d<i.length;d++){const u=i[d],f=t[d],g=e[d],_=[u[0]+f[0]*n,u[1]+f[1]*n,u[2]+f[2]*n];if(a.push(o.v(...u)),c.push(o.v(..._)),r==="FB")continue;const p=r==="T"?-s/2:0,m=r==="T"?s/2:s;l.push(o.v(_[0]+g[0]*p,_[1]+g[1]*p,_[2]+g[2]*p)),h.push(o.v(_[0]+g[0]*m,_[1]+g[1]*m,_[2]+g[2]*m))}return o.strip(a,c),r!=="FB"&&o.strip(l,h),o.build()}function Sh(i,t,e,n,s,r,o="L"){const a=[],c=[],l=[],h=Math.max(2,Math.ceil((t-i)/.5)+1);for(let d=0;d<h;d++){const u=i+(t-i)*d/(h-1),f=cs(e,u),[g,_]=Gn(u,f),[p,m]=vh(u,f);a.push([u,n*g,_]),c.push([0,n*p,m]),l.push([0,-n*m,p])}return Ba(a,c,l,s,r,o)}function ll(i,t,e,n,s,r,o="L"){const a=[],c=[],l=[],h=Math.max(3,Math.ceil((e-t)*50)+1);for(let d=0;d<h;d++){const u=t+(e-t)*d/(h-1),[f,g]=Gn(i,u),[_,p]=vh(i,u);a.push([i,n*f,g]),c.push([0,n*_,p]),l.push([1,0,0])}return Ba(a,c,l,s,r,o)}function tn(i,t,e,n,s,r,o="L",a=2){const c=[],l=[],h=[];for(let d=0;d<a;d++){const u=d/(a-1);c.push([i[0]+(t[0]-i[0])*u,i[1]+(t[1]-i[1])*u,i[2]+(t[2]-i[2])*u]),l.push(e),h.push(n)}return Ba(c,l,h,s,r,o)}function Wt(i,t,e,n){const s=new hh(i.map(([a,c])=>new nt(a,c)));for(const a of t||[])s.holes.push(new ha(a.map(([c,l])=>new nt(c,l))));const r=new ka(s,{depth:e,bevelEnabled:!1,curveSegments:6}),o=r.attributes.position;for(let a=0;a<o.count;a++){const[c,l,h]=n(o.getX(a),o.getY(a),o.getZ(a)-e/2);ci(c,l,h,kn),o.setXYZ(a,kn.x,kn.y,kn.z)}return r.computeVertexNormals(),r}const Ge=i=>(t,e,n)=>[i+n,t,e],Ve=i=>(t,e,n)=>[t,e,i+n],an=i=>(t,e,n)=>[t,i+n,e];function V0(i,t,e,n,s=20){const r=[];for(let o=0;o<s;o++){const a=o/s*Math.PI*2;r.push([i+e*Math.cos(a),t+n*Math.sin(a)])}return r}function _a(i,t,e,n,s=8){const r=Math.min(e,n)/2,o=[],a=e/2-r,c=n/2-r,l=(h,d,u)=>{for(let f=0;f<=s;f++){const g=u+f/s*(Math.PI/2);o.push([h+r*Math.cos(g),d+r*Math.sin(g)])}};return l(i+a,t+c,0),l(i-a,t+c,Math.PI/2),l(i-a,t-c,Math.PI),l(i+a,t-c,3*Math.PI/2),o}const we=(i,t,e,n)=>[[i,t],[e,t],[e,n],[i,n]];function Cr(i){const t=i.filter(Boolean).map(e=>e.index?e.toNonIndexed():e);for(const e of t)for(const n of Object.keys(e.attributes))n!=="position"&&n!=="normal"&&e.deleteAttribute(n);return H0(t,!1)}function ms(i,t,e,n=16){const s=ci(...i,new C),r=ci(...t,new C),o=new Na(e,e,s.distanceTo(r),n),a=new En().setFromUnitVectors(new C(0,1,0),r.clone().sub(s).normalize());return o.applyQuaternion(a),o.translate((s.x+r.x)/2,(s.y+r.y)/2,(s.z+r.z)/2),o}const _n=i=>Mn(i,At.hdb),vr=i=>Wn(i,At.hdb),bh=[2.2,4.2];function G0(i,t){const{dbX0:e,dbX1:n}=At,s=Math.max(t.x0,e),r=Math.min(t.x1,n),o=r-s>.5,a=qt(i,Lt.BLOCK,`${t.id}.db`,`Phân đoạn đáy ${t.label}`,{code:`${t.code}-ĐY`,type:"block",explode:[0,0,0],desc:o?"Phân đoạn đáy đôi: tôn đáy ngoài + dầm dọc đáy, sống chính, sống phụ, đà ngang đáy và tôn đáy trên. Đây là phân đoạn đặt đầu tiên của mỗi tổng đoạn (phân đoạn chuẩn).":"Phân đoạn đáy vùng mút: không có đáy đôi, gồm tôn đáy và hệ đà ngang cao (hệ thống kết cấu ngang)."}),c=qt(a,Lt.ASSY,`${a.userData.id}.shell`,"Panel tôn đáy ngoài",{code:`${a.userData.code}-P1`,type:"panel",explode:[0,0,0],desc:"Các tấm tôn đáy được hàn giáp mối thành tấm lớn trên bệ phẳng/bệ cong, sau đó hàn các dầm dọc đáy lên trên (dây chuyền panel)."}),l=[0,.12,.42,.72,1];Tt(c,"keel_plate",Cr([Un(t.x0,t.x1,0,h=>_n(h)*l[1],1),Un(t.x0,t.x1,0,h=>_n(h)*l[1],-1)]),{name:"Tôn ky",explode:[0,.8,0]});for(const h of[1,-1]){const d=h>0?"phải":"trái";Tt(c,"bottom_shell",Un(t.x0,t.x1,u=>_n(u)*l[1],u=>_n(u)*l[2],h),{name:`Tôn đáy dải A – mạn ${d}`,explode:[0,.3,h*1.6]}),Tt(c,"bottom_shell",Un(t.x0,t.x1,u=>_n(u)*l[2],u=>_n(u)*l[3],h),{name:`Tôn đáy dải B – mạn ${d}`,explode:[0,.3,h*3.2]}),Tt(c,"bilge_plate",Un(t.x0,t.x1,u=>_n(u)*l[3],_n,h),{name:`Tôn hông – mạn ${d}`,explode:[0,.6,h*4.8]})}if(o)for(const h of[1,-1])[.22,.38,.54,.7,.86].forEach((d,u)=>{Tt(c,"bottom_long",Sh(s,r,f=>_n(f)*d,h,.2,.09,"L"),{name:`Dầm dọc đáy ĐĐ${u+1} – mạn ${h>0?"phải":"trái"}`,explode:[0,2.2,0]})});return o&&(W0(a,s,r),$0(a,t,s,r),q0(a,s,r)),Y0(a,t),a}function W0(i,t,e){const{hdb:n}=At,s=qt(i,Lt.ASSY,`${i.userData.id}.cg`,"Cụm sống chính",{code:`${i.userData.code}-C1`,type:"cum",explode:[0,4.5,0],desc:"Tấm sống chính được lấy dấu, cắt, hàn nẹp gia cường thành cụm chi tiết trước khi lắp vào phân đoạn."}),o=[...li(t,e).map(c=>[c,Tn(c).zk]),[e,n],[t,n]];Tt(s,"center_girder",Wt(o,[],.014,an(0)),{name:"Tấm sống chính"});for(const c of Sn(t+.2,e-.2)){if(c%2===0)continue;const l=Ie(c);for(const h of[1,-1])Tt(s,"center_girder",tn([l,h*.007,Tn(l).zk+.05],[l,h*.007,n-.05],[0,h,0],[1,0,0],.12,0,"FB"),{name:`Nẹp đứng sống chính Fr${c}`,spec:"FB 120×10",explode:[0,0,h*.8]})}const a=qt(i,Lt.ASSY,`${i.userData.id}.sg`,"Cụm sống phụ",{code:`${i.userData.code}-C2`,type:"cum",explode:[0,4.5,0],desc:"Các sống phụ (sống đáy bên) có lỗ khoét giảm trọng lượng, được chế tạo thành cụm chi tiết."});for(const c of bh){const l=ps(t,e,u=>vr(u)>c+.45);if(!l)continue;const[h,d]=l;for(const u of[1,-1]){const g=[...li(h,d).map(p=>[p,fs(p,c)]),[d,n],[h,n]],_=[];for(const p of Sn(h+.45,d-.45)){if(p%2===0)continue;const m=Ie(p),w=Math.max(fs(m-.35,c),fs(m+.35,c)),x=Math.min(.5,n-w-.3);x>.2&&_.push(_a(m,(w+n)/2,.7,x))}Tt(a,"side_girder",Wt(g,_,.011,an(u*c)),{name:`Sống phụ y=${c} m – mạn ${u>0?"phải":"trái"}`,explode:[0,0,u*1.2]})}}}function X0(i){const{hdb:t}=At,e=[],n=vr(i),s=[0,...bh.filter(r=>r<n-.45),n];for(let r=0;r<s.length-1;r++){const o=s[r],a=s[r+1],c=Math.min(.8,a-o-.5);if(c<.3)continue;const l=(o+a)/2,h=Math.max(fs(i,l-c/2),fs(i,l+c/2)),d=Math.min(.5,t-h-.3);if(d<.2)continue;const u=h+(t-h)/2;e.push(_a(l,u,c,d),_a(-l,u,c,d))}return e}function $0(i,t,e,n){const s=qt(i,Lt.ASSY,`${i.userData.id}.fl`,"Cụm đà ngang đáy",{code:`${i.userData.code}-C3`,type:"cum",explode:[0,6,0],desc:"Đà ngang đặc được cắt bằng máy CNC (kể cả lỗ khoét), đặt cách nhau 2 khoảng sườn. Đà ngang kín nước đặt dưới vách ngang."});for(const r of Sn(e,n+.01)){if(r%2!==0)continue;const o=Ie(r);if(o<e-1e-6||o>n+1e-6)continue;const a=z0(o),c=Oa(Ar(o,At.hdb));Tt(s,a?"wt_floor":"floor",Wt(c,a?[]:X0(o),a?.012:.01,Ge(o)),{name:`${a?"Đà ngang kín nước":"Đà ngang đặc"} Fr${r}`,explode:[0,1.5,0]})}}function q0(i,t,e){const{hdb:n}=At,s=qt(i,Lt.ASSY,`${i.userData.id}.ib`,"Panel tôn đáy trên",{code:`${i.userData.code}-P2`,type:"panel",explode:[0,8.5,0],desc:"Panel phẳng: các tấm tôn đáy trên hàn giáp mối, sau đó hàn dầm dọc đáy trên. Thực tế phân đoạn đáy đôi thường được lắp úp (lấy panel tôn đáy trên làm bệ) rồi lật lại."}),r=li(t,e),o=2.4;Tt(s,"inner_bottom",Wt([[t,-o],[e,-o],[e,o],[t,o]],[],.012,Ve(n)),{name:"Tôn đáy trên dải giữa",explode:[0,1,0]});for(const a of[1,-1]){const c=[...r.map(l=>[l,a*o]),...r.slice().reverse().map(l=>[l,a*vr(l)])];Tt(s,"inner_bottom",Wt(c,[],.012,Ve(n)),{name:`Tôn đáy trên dải mép – mạn ${a>0?"phải":"trái"}`,explode:[0,1,a*.6]})}[.75,1.5,2.95,3.7,4.95].forEach((a,c)=>{const l=ps(t,e,h=>vr(h)>a+.3);if(l)for(const h of[1,-1])Tt(s,"ib_long",tn([l[0],h*a,n-.006],[l[1],h*a,n-.006],[0,0,-1],[0,h,0],.18,.09,"L"),{name:`Dầm dọc đáy trên DT${c+1} – mạn ${h>0?"phải":"trái"}`,explode:[0,-1.4,0]})})}function Y0(i,t){const{dbX0:e,dbX1:n}=At,s=Sn(t.x0,t.x1).filter(o=>{const a=Ie(o);return(a<e-1e-6||a>n+1e-6)&&a>.3&&Tn(a).hb>.5});if(!s.length)return;const r=qt(i,Lt.ASSY,`${i.userData.id}.df`,"Cụm đà ngang cao",{code:`${i.userData.code}-C4`,type:"cum",explode:[0,6,0],desc:"Vùng mút tàu thon, không bố trí đáy đôi; dùng đà ngang cao đặt ở mỗi sườn (hệ thống kết cấu ngang)."});for(const o of s){const a=Ie(o),c=Math.max(2.8,Tn(a).zk+1.6),l=Oa(Ar(a,c));Tt(r,"deep_floor",Wt(l,[],.01,Ge(a)),{name:`Đà ngang cao Fr${o}`,explode:[0,1.5,0]})}}const Eh=i=>Mn(i,At.hdb),Th=i=>i>=At.dbX0-1e-6&&i<=At.dbX1+1e-6,os=Eh,hl=i=>Th(i)?Eh(i)+.004:Mn(i,Math.max(2.8,Tn(i).zk+1.6));function ul(i,t,e){const n=e>0?"phải":"trái",s=qt(i,Lt.BLOCK,`${t.id}.${e>0?"ss":"ps"}`,`Phân đoạn mạn ${n} ${t.label}`,{code:`${t.code}-M${e>0?"P":"T"}`,type:"block",explode:[0,2.5,e*10],desc:`Phân đoạn mạn ${n}: tôn mạn cong, sườn thường, sườn khỏe, sống dọc mạn và các mã liên kết. Hệ thống kết cấu ngang ở mạn.`}),r=qt(s,Lt.ASSY,`${s.userData.id}.shell`,"Panel tôn mạn (cong)",{code:`${s.userData.code}-P1`,type:"panel",explode:[0,0,e*3.5],desc:"Panel cong lắp trên bệ khung (bệ chuyên dụng) theo đường hình: hàn các tấm tôn mạn, sau đó lắp và hàn sườn thường."}),o=g=>os(g)+(1-os(g))*.45,a=g=>os(g)+(1-os(g))*.8;Tt(r,"side_shell",Un(t.x0,t.x1,os,o,e),{name:`Tôn mạn dải dưới – mạn ${n}`,explode:[0,-.6,e*1.4]}),Tt(r,"side_shell",Un(t.x0,t.x1,o,a,e),{name:`Tôn mạn dải giữa – mạn ${n}`,explode:[0,0,e*1.4]}),Tt(r,"sheer_strake",Un(t.x0,t.x1,a,1,e),{name:`Tôn mép mạn – mạn ${n}`,explode:[0,.6,e*1.4]});const c=Sn(t.x0,t.x1).filter(g=>Ie(g)>.2&&Tn(Ie(g)).hb>.35);for(const g of c){if(g%4===0)continue;const _=Ie(g);Tt(r,"frame",ll(_,hl(_),.985,e,.18,.09,"L"),{name:`Sườn thường Fr${g} – mạn ${n}`,explode:[0,0,-e*1.6]})}const l=qt(s,Lt.ASSY,`${s.userData.id}.web`,"Cụm sườn khỏe & sống dọc mạn",{code:`${s.userData.code}-C1`,type:"cum",explode:[0,0,-e*4],desc:"Sườn khỏe (tiết diện chữ T) đặt mỗi 4 khoảng sườn cùng sống dọc mạn tạo thành khung khỏe đỡ các sườn thường."});for(const g of c){if(g%4!==0)continue;const _=Ie(g);Tt(l,"web_frame",ll(_,hl(_),.97,e,.55,.2,"T"),{name:`Sườn khỏe Fr${g} – mạn ${n}`,explode:[0,0,-e*1.2]})}const h=(At.hdb+At.D)/2;Tt(l,"side_stringer",Sh(t.x0+.05,t.x1-.05,g=>Mn(g,h),e,.5,.15,"T"),{name:`Sống dọc mạn – mạn ${n}`,explode:[0,.8,-e*1.2]});const d=qt(s,Lt.ASSY,`${s.userData.id}.br`,"Cụm mã hông & mã xà",{code:`${s.userData.code}-C2`,type:"cum",explode:[0,1.5,-e*3.5],desc:"Các mã (bracket) liên kết chân sườn với tôn đáy trên và đầu sườn với boong, đảm bảo tính liên tục của khung ngang."}),{hdb:u,D:f}=At;for(const g of c){const _=Ie(g);if(Th(_)){const m=Wn(_,u),w=Gn(_,Mn(_,u+.75)),x=[[m-.75,u],[m,u],w].map(([b,I])=>[e*b,I]);Tt(d,"bilge_bracket",Wt(x,[],.01,Ge(_)),{name:`Mã hông Fr${g} – mạn ${n}`,explode:[0,-.6,-e*.6]})}const p=Wn(_,f);if(p>.9){const m=Gn(_,Mn(_,f-.6)),w=[[p-.6,f],m,[p,f]].map(([x,b])=>[e*x,b]);Tt(d,"beam_bracket",Wt(w,[],.009,Ge(_)),{name:`Mã xà Fr${g} – mạn ${n}`,explode:[0,.6,-e*.6]})}}return s}const de=3.6,K0=1.2;function Z0(i,t){const{D:e}=At,n=h=>Wn(h,e),s=h=>Math.max(0,n(h)-1.2),r=.011,o=qt(i,Lt.BLOCK,`${t.id}.dk`,`Phân đoạn boong ${t.label}`,{code:`${t.code}-B`,type:"block",explode:[0,10,0],desc:t.hatch?"Phân đoạn boong vùng hầm hàng: hệ thống kết cấu dọc (dầm dọc boong, xà ngang khỏe), miệng hầm hàng với thành miệng hầm.":"Phân đoạn boong vùng mút: hệ thống kết cấu ngang (xà ngang boong mỗi sườn, sống dọc boong)."}),a=qt(o,Lt.ASSY,`${o.userData.id}.pl`,"Panel tôn boong",{code:`${o.userData.code}-P1`,type:"panel",explode:[0,3,0],desc:"Panel phẳng chế tạo trên dây chuyền panel: hàn giáp mối tôn boong (hàn tự động dưới lớp thuốc), lắp và hàn các kết cấu dọc/ngang thường. Thường chế tạo úp rồi lật."}),c=li(t.x0,t.x1);for(const h of[1,-1]){const d=[...c.map(u=>[u,h*n(u)]),...c.slice().reverse().map(u=>[u,h*s(u)])];Tt(a,"deck_stringer",Wt(d,[],.013,Ve(e-.0065)),{name:`Tôn mép boong – mạn ${h>0?"phải":"trái"}`,explode:[0,1.2,h*1]})}if(t.hatch){const h=t.x0+1.4,d=t.x1-1.4;for(const u of[1,-1]){const f=[...c.map(g=>[g,u*de]),...c.slice().reverse().map(g=>[g,u*s(g)])];Tt(a,"deck_plate",Wt(f,[],r,Ve(e-r/2)),{name:`Tôn boong dải mạn – ${u>0?"phải":"trái"}`,explode:[0,1.2,u*.5]})}Tt(a,"deck_plate",Wt(we(t.x0,-de,h,de),[],r,Ve(e-r/2)),{name:"Tôn boong ngang (sau miệng hầm)",explode:[-.8,1.2,0]}),Tt(a,"deck_plate",Wt(we(d,-de,t.x1,de),[],r,Ve(e-r/2)),{name:"Tôn boong ngang (trước miệng hầm)",explode:[.8,1.2,0]}),[4.3,5].forEach((u,f)=>{const g=ps(t.x0,t.x1,_=>n(_)>u+.35);if(g)for(const _ of[1,-1])Tt(a,"deck_long",tn([g[0],_*u,e-r],[g[1],_*u,e-r],[0,0,-1],[0,-_,0],.16,.08,"L"),{name:`Dầm dọc boong DB${f+1} – mạn ${_>0?"phải":"trái"}`,explode:[0,-1.2,0]})})}else{const h=ps(t.x0,t.x1,d=>s(d)>.05,.05);if(h){const d=li(h[0],h[1]),u=[...d.map(f=>[f,s(f)]),...d.slice().reverse().map(f=>[f,-s(f)])];Tt(a,"deck_plate",Wt(u,[],r,Ve(e-r/2)),{name:"Tôn boong dải giữa",explode:[0,1.2,0]})}for(const d of Sn(t.x0,t.x1)){const u=Ie(d);if(d%4===0||n(u)<.5||u<.2)continue;const f=n(u)-.12;Tt(a,"deck_beam",tn([u,-f,e-r],[u,f,e-r],[0,0,-1],[1,0,0],.16,.08,"L"),{name:`Xà ngang boong Fr${d}`,explode:[0,-1.2,0]})}}const l=qt(o,Lt.ASSY,`${o.userData.id}.st`,"Cụm kết cấu khỏe dưới boong",{code:`${o.userData.code}-C1`,type:"cum",explode:[0,-3,0],desc:t.hatch?"Sống dọc miệng hầm, xà ngang đầu miệng hầm và xà ngang khỏe boong – các kết cấu khỏe đỡ dầm dọc boong.":"Sống dọc boong và xà ngang khỏe – gối tựa cho các xà ngang boong."});if(t.hatch){const h=t.x0+1.4,d=t.x1-1.4;for(const u of[1,-1]){Tt(l,"hatch_girder",tn([t.x0+.02,u*de,e-r],[t.x1-.02,u*de,e-r],[0,0,-1],[0,1,0],.6,.2,"T"),{name:`Sống dọc miệng hầm – mạn ${u>0?"phải":"trái"}`,explode:[0,-1,u*.8]});for(const f of Sn(t.x0,t.x1)){if(f%4!==0)continue;const g=Ie(f);g<h||g>d||Tt(l,"deck_transverse",tn([g,u*de,e-r],[g,u*(n(g)-.1),e-r],[0,0,-1],[1,0,0],.5,.15,"T"),{name:`Xà ngang khỏe boong Fr${f} – mạn ${u>0?"phải":"trái"}`,explode:[0,-1,0]})}}for(const u of[h,d]){const f=n(u)-.1;Tt(l,"hatch_end_beam",tn([u,-f,e-r],[u,f,e-r],[0,0,-1],[1,0,0],.6,.2,"T"),{name:`Xà ngang đầu miệng hầm x=${u.toFixed(1)} m`,explode:[0,-1,0]})}}else{const h=ps(t.x0,t.x1,d=>n(d)>.6);h&&Tt(l,"deck_girder",tn([h[0],0,e-r],[h[1],0,e-r],[0,0,-1],[0,1,0],.45,.15,"T"),{name:"Sống dọc boong tâm",explode:[0,-1,0]});for(const d of Sn(t.x0,t.x1)){const u=Ie(d);if(d%4!==0||n(u)<.6||u<.2)continue;const f=n(u)-.1;Tt(l,"deck_transverse",tn([u,-f,e-r],[u,f,e-r],[0,0,-1],[1,0,0],.45,.15,"T"),{name:`Xà ngang khỏe boong Fr${d}`,explode:[0,-1,0]})}}return t.hatch&&j0(o,t),o}function j0(i,t){const{D:e}=At,n=t.x0+1.4,s=t.x1-1.4,r=e+K0,o=qt(i,Lt.ASSY,`${i.userData.id}.hc`,"Cụm thành miệng hầm hàng",{code:`${i.userData.code}-C2`,type:"cum",explode:[0,6,0],desc:"Thành miệng hầm dọc, ngang, bản mép và mã chống. Thường chế tạo thành cụm riêng rồi lắp lên panel boong."});for(const c of[1,-1])Tt(o,"hatch_coaming",Wt(we(n,e,s,r),[],.012,an(c*de)),{name:`Thành miệng hầm dọc – mạn ${c>0?"phải":"trái"}`,explode:[0,.8,c*1]});for(const[c,l]of[[n,-1],[s,1]])Tt(o,"hatch_coaming",Wt(we(-de,e,de,r),[],.012,Ge(c)),{name:`Thành miệng hầm ngang ${l<0?"sau":"trước"}`,explode:[l*1,.8,0]});const a=.15;Tt(o,"hatch_coaming",Cr([Wt(we(n-a,de,s+a,de+a),[],.014,Ve(r)),Wt(we(n-a,-de-a,s+a,-de),[],.014,Ve(r)),Wt(we(n-a,-de,n,de),[],.014,Ve(r)),Wt(we(s,-de,s+a,de),[],.014,Ve(r))]),{name:"Bản mép thành miệng hầm",spec:"FB 150×14",explode:[0,1.6,0]});for(const c of Sn(n+.3,s-.3)){if(c%2!==0)continue;const l=Ie(c);for(const h of[1,-1])Tt(o,"coaming_stay",Wt([[h*de,r-.1],[h*de,e],[h*(de+.8),e]],[],.01,Ge(l)),{name:`Mã chống thành miệng hầm Fr${c} – mạn ${h>0?"phải":"trái"}`,explode:[0,.4,h*.8]})}for(const c of[-2.8,-1.4,0,1.4,2.8])for(const[l,h]of[[n,-1],[s,1]])Tt(o,"coaming_stay",Wt([[l,r-.1],[l,e],[l+h*.8,e]],[],.01,an(c)),{name:`Mã chống thành miệng hầm ngang y=${c}`,explode:[h*.8,.4,0]})}function dl(i,t,e){const n=Ar(i,e,t);return[...n,...n.slice().reverse().map(([s,r])=>[-s,r])]}function wh(i,t,e,n=.15){for(let s=e;s<At.D;s+=.05)if(Wn(i,s)>Math.abs(t)+n)return s;return At.D}function J0(i,t,e,n){const{hdb:s,D:r}=At,o=e.x,a=qt(i,Lt.BLOCK,`${t.id}.bh${n}`,`Phân đoạn vách – ${e.name}`,{code:`${t.code}-V${n}`,type:"block",explode:[0,12,0],crane:!0,desc:e.kind==="collision_bhd"?"Vách chống va: vách kín nước đầu tiên tính từ mũi; bắt buộc theo quy phạm, kéo liên tục tới boong mạn khô.":"Vách ngang kín nước chia thân tàu thành các khoang, tăng độ cứng ngang và đảm bảo tính chống chìm."}),c=qt(a,Lt.ASSY,`${a.userData.id}.p`,"Panel vách phẳng",{code:`${a.userData.code}-P1`,type:"panel",explode:[0,2.5,0],desc:"Panel phẳng: hàn giáp mối các tấm tôn vách (tấm dưới dày hơn do áp lực thuỷ tĩnh lớn hơn), sau đó hàn nẹp đứng."}),l=3.8;Tt(c,e.kind,Wt(dl(o,s,l),[],.011,Ge(o)),{name:`Tôn vách dải dưới (t=11) – x=${o} m`,explode:[0,-.8,0]}),Tt(c,e.kind,Wt(dl(o,l,r),[],.009,Ge(o)),{name:`Tôn vách dải trên (t=9) – x=${o} m`,explode:[0,.8,0]});const h=Wn(o,r)-.25;for(let d=-Math.floor(h/.7);d<=Math.floor(h/.7);d++){const u=d*.7,f=wh(o,u,s);f>r-.8||Tt(c,"bhd_stiffener",tn([o-.006,u,f],[o-.006,u,r-.02],[-1,0,0],[0,1,0],.2,.09,"L"),{name:`Nẹp vách y=${u.toFixed(1)} m`,explode:[-1.4,0,0]})}return a}function Q0(i,t){const{D:e}=At,n=qt(i,Lt.BLOCK,`${t.id}.st`,"Phân đoạn đuôi (transom & sống đuôi)",{code:`${t.code}-ĐU`,type:"block",explode:[-8,6,0],crane:!0,desc:"Phân đoạn có hình dáng phức tạp nhất: vách đuôi transom, sống đuôi (ky lái) đỡ ống bao trục và gót bánh lái."}),s=qt(n,Lt.ASSY,`${n.userData.id}.tr`,"Panel vách đuôi (transom)",{code:`${n.userData.code}-P1`,type:"panel",explode:[-3,0,0],desc:"Tấm transom phẳng, nghiêng, gia cường bằng các nẹp đứng."});Tt(s,"transom",Wt(Oa(Ar(0,e)),[],.011,Ge(0)),{name:"Tôn vách đuôi transom",explode:[-1,0,0]});for(const c of[-2.8,-1.4,0,1.4,2.8]){const l=wh(0,c,Tn(0).zk);Tt(s,"bhd_stiffener",tn([.006,c,l],[.006,c,e-.02],[1,0,0],[0,1,0],.18,.09,"L"),{name:`Nẹp transom y=${c}`,explode:[1.2,0,0]})}const r=qt(n,Lt.ASSY,`${n.userData.id}.sf`,"Cụm sống đuôi (ky lái)",{code:`${n.userData.code}-C1`,type:"cum",explode:[0,-3,0],desc:"Sống đuôi hàn từ thép tấm dày, gồm thân ky lái, gót ky (sole piece) và bầu trục (ống bao trục chân vịt)."}),o=li(2.6,10.5,.3),a=[[2.6,0],[10.5,0],...o.slice().reverse().map(c=>[c,Tn(c).zk])];return Tt(r,"stern_frame",Wt(a,[],.03,an(0)),{name:"Thân ky lái (skeg)",explode:[0,-1,0]}),Tt(r,"stern_frame",Wt(we(.45,0,2.6,.25),[],.12,an(0)),{name:"Gót ky lái (sole piece)",explode:[-1,-.5,0]}),Tt(r,"stern_frame",ms([2.35,0,1.25],[5.2,0,1.25],.26),{name:"Bầu trục (ống bao trục)",explode:[-1.5,0,0]}),n}function t_(i,t){const{D:e}=At,n=qt(i,Lt.BLOCK,`${t.id}.stem`,"Phân đoạn sống mũi",{code:`${t.code}-SM`,type:"block",explode:[8,6,0],crane:!0,desc:"Sống mũi và các mã ngực khép kín mũi tàu, liên kết tôn vỏ hai mạn."}),s=qt(n,Lt.ASSY,`${n.userData.id}.c`,"Cụm sống mũi & mã ngực",{code:`${n.userData.code}-C1`,type:"cum",explode:[2.5,0,0],desc:"Sống mũi bằng thép tấm dày uốn theo đường sống mũi; mã ngực nằm ngang giằng hai mạn."});Tt(s,"stem",Wt(we(69.55,0,70.08,e),[],.03,an(0)),{name:"Sống mũi",explode:[1.5,0,0]});for(const r of[2.2,3.8,5.4]){const o=li(66.6,69.9,.2),a=[...o.map(c=>[c,Math.max(.01,Wn(c,r)-.01)]),...o.slice().reverse().map(c=>[c,-Math.max(.01,Wn(c,r)-.01)])];Tt(s,"breast_hook",Wt(a,[],.01,Ve(r)),{name:`Mã ngực z=${r} m`,explode:[-1.2,0,0]})}return n}function e_(i){const t=qt(i,Lt.GRAND,"eq","Thiết bị: chân vịt & bánh lái",{code:"TB",type:"grand",explode:[-12,0,0],desc:"Chân vịt, trục và bánh lái được lắp sau khi hoàn thành đấu đà phần đuôi và căn tâm trục."}),e=qt(t,Lt.BLOCK,"eq.prop","Hệ trục chân vịt",{code:"TB-CV",type:"block",explode:[-5,0,0]}),n=qt(e,Lt.ASSY,"eq.prop.a","Cụm chân vịt + trục",{code:"TB-CV-1",type:"cum",explode:[0,0,0]}),s=2,r=1.25,o=.6,a=[];for(let h=0;h<4;h++){const d=h*Math.PI/2+.3;a.push(Wt(V0(.53,0,.33,.22,24),[],.03,(u,f,g)=>[s+f*Math.sin(o)+g*Math.cos(o),u*Math.cos(d)-f*Math.cos(o)*Math.sin(d),r+u*Math.sin(d)+f*Math.cos(o)*Math.cos(d)]))}a.push(ms([s-.3,0,r],[s+.3,0,r],.2)),Tt(n,"propeller",Cr(a),{name:"Chân vịt 4 cánh",explode:[-1.5,0,0]}),Tt(n,"propeller",ms([s+.3,0,r],[8,0,r],.11),{name:"Trục chân vịt",explode:[-4,0,0]});const c=qt(t,Lt.BLOCK,"eq.rud","Bánh lái",{code:"TB-BL",type:"block",explode:[0,-4,0]}),l=qt(c,Lt.ASSY,"eq.rud.a","Cụm bánh lái",{code:"TB-BL-1",type:"cum",explode:[0,0,0]});return Tt(l,"rudder",Wt([[.2,.32],[1.3,.32],[1.35,2.35],[.2,2.45]],[],.24,an(0)),{name:"Lá bánh lái",explode:[0,-1,0]}),Tt(l,"rudder",ms([.6,0,2.4],[.6,0,3.8],.09),{name:"Trục lái (rudder stock)",explode:[0,1.5,0]}),t}function go(i,t,e,n,s,r){const o=[],a=Math.max(1,Math.floor((t-i-r)/(n+r))),c=(i+t)/2-(a*n+(a-1)*r)/2;for(let l=0;l<a;l++){const h=c+l*(n+r);o.push(we(h,e-s/2,h+n,e+s/2))}return o}function _o(i,t,e,n,s,r){const{xa:o,xb:a,w:c,z0:l,z1:h}=s,d=qt(i,Lt.BLOCK,t,e,{code:n,type:"block",explode:r.explode,crane:!0,desc:r.desc}),u=qt(d,Lt.ASSY,`${t}.w`,"Panel vách bao",{code:`${n}-P1`,type:"panel",explode:[0,0,0],desc:"Vách bao thượng tầng bằng tôn mỏng, khoét cửa sổ, gia cường nẹp; chế tạo dạng panel phẳng."}),f=.008,g=l+(h-l)*.55,_=r.bigWindows?{w:.9,h:1.1,g:.25}:{w:.7,h:.8,g:1};Tt(u,"super_wall",Wt(we(-c,l,c,h),go(-c+.4,c-.4,g,_.w,_.h,_.g),f,Ge(a)),{name:"Vách trước",explode:[1.5,0,0]}),Tt(u,"super_wall",Wt(we(-c,l,c,h),r.bigWindows?[]:go(-c+.6,c-.6,g,.7,.8,1.6),f,Ge(o)),{name:"Vách sau",explode:[-1.5,0,0]});for(const x of[1,-1]){const b=go(o+.5,a-.5,g,.7,.8,1.3);r.bigWindows||b.push(we(o+.6,l+.15,o+1.4,l+2.1)),Tt(u,"super_wall",Wt(we(o,l,a,h),b,f,an(x*c)),{name:`Vách mạn ${x>0?"phải":"trái"}`,explode:[0,0,x*1.5]})}const p=qt(d,Lt.ASSY,`${t}.d`,"Panel boong (nóc)",{code:`${n}-P2`,type:"panel",explode:[0,2.5,0],desc:"Tấm boong phía trên của tầng, có xà ngang gia cường bên dưới."}),m=r.overhang||.3,w=r.wings||c+m;return Tt(p,"super_deck",Wt(we(o-m,-w,a+m,w),[],f,Ve(h)),{name:"Tôn boong",explode:[0,.8,0]}),d}function n_(i){const t=At.D,e=qt(i,Lt.GRAND,"gb6","Tổng đoạn 6 – Thượng tầng",{code:"TĐ6",type:"grand",explode:[0,16,0],crane:!0,desc:"Khối thượng tầng (khu sinh hoạt, lầu lái, ống khói) được chế tạo và lắp đặt trang thiết bị trước (pre-outfitting) rồi cẩu nguyên khối lên tàu."});_o(e,"gb6.t1","Phân đoạn thượng tầng tầng 1","TĐ6-T1",{xa:1.2,xb:11.2,w:4.6,z0:t,z1:t+2.6},{explode:[0,0,0],desc:"Tầng sinh hoạt thứ nhất đặt trên boong chính phía đuôi."}),_o(e,"gb6.t2","Phân đoạn thượng tầng tầng 2","TĐ6-T2",{xa:2.2,xb:10.4,w:4.2,z0:t+2.6,z1:t+5.2},{explode:[0,4,0],wings:5.6,desc:"Tầng sinh hoạt thứ hai, boong nóc kéo rộng làm cánh gà lầu lái."});const n=_o(e,"gb6.wh","Phân đoạn lầu lái","TĐ6-LL",{xa:5,xb:10,w:3.6,z0:t+5.2,z1:t+7.6},{explode:[0,7,0],bigWindows:!0,desc:"Lầu lái với dãy cửa sổ phía trước để quan sát."});Tt(n.children[1],"super_deck",ms([7.5,0,t+7.6],[7.5,0,t+10.5],.08),{name:"Cột đèn hiệu",spec:"Ống Ø160",explode:[0,1.5,0]});const s=qt(e,Lt.BLOCK,"gb6.fn","Phân đoạn ống khói",{code:"TĐ6-OK",type:"block",explode:[0,10,0],crane:!0,desc:"Vỏ bao ống khói."}),r=qt(s,Lt.ASSY,"gb6.fn.a","Cụm vỏ ống khói",{code:"TĐ6-OK-1",type:"cum",explode:[0,0,0]}),o=t+5.2,a=t+9;return Tt(r,"funnel",Cr([Wt([[-1.1,o],[1.1,o],[.9,a],[-.9,a]],[],.006,Ge(2.6)),Wt([[-1.1,o],[1.1,o],[.9,a],[-.9,a]],[],.006,Ge(4.6)),Wt([[2.6,o],[4.6,o],[4.6,a],[2.6,a]],[],.006,an(1)),Wt([[2.6,o],[4.6,o],[4.6,a],[2.6,a]],[],.006,an(-1))]),{name:"Vỏ ống khói",explode:[0,1.5,0]}),e}const i_=[{id:"gb3",code:"TĐ3",no:3,label:"hầm hàng số 2",x0:28,x1:42,hatch:!0,explode:[0,15,0],desc:"Tổng đoạn chuẩn (base block) – đặt đầu tiên lên đà/ụ tại vùng giữa tàu, làm chuẩn để đấu nối các tổng đoạn tiếp theo về hai phía."},{id:"gb2",code:"TĐ2",no:2,label:"hầm hàng số 3",x0:14,x1:28,hatch:!0,explode:[-9,15,0],desc:"Tổng đoạn thân ống phía sau, đấu nối vào mặt sau tổng đoạn chuẩn."},{id:"gb4",code:"TĐ4",no:4,label:"hầm hàng số 1",x0:42,x1:56,hatch:!0,explode:[9,15,0],desc:"Tổng đoạn phía trước tổng đoạn chuẩn; bắt đầu vùng thon mũi."},{id:"gb1",code:"TĐ1",no:1,label:"đuôi",x0:0,x1:14,hatch:!1,explode:[-16,15,0],desc:"Tổng đoạn đuôi: buồng máy, khoang đuôi, vách transom, sống đuôi. Hình dáng phức tạp, nhiều tôn cong hai chiều."},{id:"gb5",code:"TĐ5",no:5,label:"mũi",x0:56,x1:70,hatch:!1,explode:[16,15,0],desc:"Tổng đoạn mũi: khoang mũi, vách chống va, sống mũi, mã ngực."}];function s_(){O0();const i=qt(null,Lt.SHIP,"ship",At.name,{code:"TAU",type:"ship",desc:`Lpp = ${At.L} m, B = ${At.B} m, D = ${At.D} m, d = ${At.T} m, khoảng sườn ${At.spacing*1e3} mm. Hệ thống kết cấu hỗn hợp: đáy và boong vùng giữa theo hệ dọc, mạn theo hệ ngang.`});for(const t of i_){const e=qt(i,Lt.GRAND,t.id,`Tổng đoạn ${t.no} – ${t.label[0].toUpperCase()}${t.label.slice(1)}`,{code:t.code,type:"grand",explode:t.explode,crane:!0,desc:t.desc});G0(e,t),yh.filter(n=>n.x>=t.x0-1e-6&&n.x<t.x1-1e-6).forEach((n,s)=>J0(e,t,n,s+1)),ul(e,t,-1),ul(e,t,1),Z0(e,t),t.id==="gb1"&&Q0(e,t),t.id==="gb5"&&t_(e,t)}return n_(i),e_(i),{ship:i,registry:Ms}}const fl={type:"change"},za={type:"start"},Ah={type:"end"},nr=new br,pl=new en,r_=Math.cos(70*zl.DEG2RAD),ge=new C,De=2*Math.PI,ie={NONE:-1,ROTATE:0,DOLLY:1,PAN:2,TOUCH_ROTATE:3,TOUCH_PAN:4,TOUCH_DOLLY_PAN:5,TOUCH_DOLLY_ROTATE:6},vo=1e-6;class o_ extends gh{constructor(t,e=null){super(t,e),this.state=ie.NONE,this.enabled=!0,this.target=new C,this.cursor=new C,this.minDistance=0,this.maxDistance=1/0,this.minZoom=0,this.maxZoom=1/0,this.minTargetRadius=0,this.maxTargetRadius=1/0,this.minPolarAngle=0,this.maxPolarAngle=Math.PI,this.minAzimuthAngle=-1/0,this.maxAzimuthAngle=1/0,this.enableDamping=!1,this.dampingFactor=.05,this.enableZoom=!0,this.zoomSpeed=1,this.enableRotate=!0,this.rotateSpeed=1,this.enablePan=!0,this.panSpeed=1,this.screenSpacePanning=!0,this.keyPanSpeed=7,this.zoomToCursor=!1,this.autoRotate=!1,this.autoRotateSpeed=2,this.keys={LEFT:"ArrowLeft",UP:"ArrowUp",RIGHT:"ArrowRight",BOTTOM:"ArrowDown"},this.mouseButtons={LEFT:Ni.ROTATE,MIDDLE:Ni.DOLLY,RIGHT:Ni.PAN},this.touches={ONE:Li.ROTATE,TWO:Li.DOLLY_PAN},this.target0=this.target.clone(),this.position0=this.object.position.clone(),this.zoom0=this.object.zoom,this._domElementKeyEvents=null,this._lastPosition=new C,this._lastQuaternion=new En,this._lastTargetPosition=new C,this._quat=new En().setFromUnitVectors(t.up,new C(0,1,0)),this._quatInverse=this._quat.clone().invert(),this._spherical=new rl,this._sphericalDelta=new rl,this._scale=1,this._panOffset=new C,this._rotateStart=new nt,this._rotateEnd=new nt,this._rotateDelta=new nt,this._panStart=new nt,this._panEnd=new nt,this._panDelta=new nt,this._dollyStart=new nt,this._dollyEnd=new nt,this._dollyDelta=new nt,this._dollyDirection=new C,this._mouse=new nt,this._performCursorZoom=!1,this._pointers=[],this._pointerPositions={},this._controlActive=!1,this._onPointerMove=c_.bind(this),this._onPointerDown=a_.bind(this),this._onPointerUp=l_.bind(this),this._onContextMenu=g_.bind(this),this._onMouseWheel=d_.bind(this),this._onKeyDown=f_.bind(this),this._onTouchStart=p_.bind(this),this._onTouchMove=m_.bind(this),this._onMouseDown=h_.bind(this),this._onMouseMove=u_.bind(this),this._interceptControlDown=__.bind(this),this._interceptControlUp=v_.bind(this),this.domElement!==null&&this.connect(),this.update()}connect(){this.domElement.addEventListener("pointerdown",this._onPointerDown),this.domElement.addEventListener("pointercancel",this._onPointerUp),this.domElement.addEventListener("contextmenu",this._onContextMenu),this.domElement.addEventListener("wheel",this._onMouseWheel,{passive:!1}),this.domElement.getRootNode().addEventListener("keydown",this._interceptControlDown,{passive:!0,capture:!0}),this.domElement.style.touchAction="none"}disconnect(){this.domElement.removeEventListener("pointerdown",this._onPointerDown),this.domElement.removeEventListener("pointermove",this._onPointerMove),this.domElement.removeEventListener("pointerup",this._onPointerUp),this.domElement.removeEventListener("pointercancel",this._onPointerUp),this.domElement.removeEventListener("wheel",this._onMouseWheel),this.domElement.removeEventListener("contextmenu",this._onContextMenu),this.stopListenToKeyEvents(),this.domElement.getRootNode().removeEventListener("keydown",this._interceptControlDown,{capture:!0}),this.domElement.style.touchAction="auto"}dispose(){this.disconnect()}getPolarAngle(){return this._spherical.phi}getAzimuthalAngle(){return this._spherical.theta}getDistance(){return this.object.position.distanceTo(this.target)}listenToKeyEvents(t){t.addEventListener("keydown",this._onKeyDown),this._domElementKeyEvents=t}stopListenToKeyEvents(){this._domElementKeyEvents!==null&&(this._domElementKeyEvents.removeEventListener("keydown",this._onKeyDown),this._domElementKeyEvents=null)}saveState(){this.target0.copy(this.target),this.position0.copy(this.object.position),this.zoom0=this.object.zoom}reset(){this.target.copy(this.target0),this.object.position.copy(this.position0),this.object.zoom=this.zoom0,this.object.updateProjectionMatrix(),this.dispatchEvent(fl),this.update(),this.state=ie.NONE}update(t=null){const e=this.object.position;ge.copy(e).sub(this.target),ge.applyQuaternion(this._quat),this._spherical.setFromVector3(ge),this.autoRotate&&this.state===ie.NONE&&this._rotateLeft(this._getAutoRotationAngle(t)),this.enableDamping?(this._spherical.theta+=this._sphericalDelta.theta*this.dampingFactor,this._spherical.phi+=this._sphericalDelta.phi*this.dampingFactor):(this._spherical.theta+=this._sphericalDelta.theta,this._spherical.phi+=this._sphericalDelta.phi);let n=this.minAzimuthAngle,s=this.maxAzimuthAngle;isFinite(n)&&isFinite(s)&&(n<-Math.PI?n+=De:n>Math.PI&&(n-=De),s<-Math.PI?s+=De:s>Math.PI&&(s-=De),n<=s?this._spherical.theta=Math.max(n,Math.min(s,this._spherical.theta)):this._spherical.theta=this._spherical.theta>(n+s)/2?Math.max(n,this._spherical.theta):Math.min(s,this._spherical.theta)),this._spherical.phi=Math.max(this.minPolarAngle,Math.min(this.maxPolarAngle,this._spherical.phi)),this._spherical.makeSafe(),this.enableDamping===!0?this.target.addScaledVector(this._panOffset,this.dampingFactor):this.target.add(this._panOffset),this.target.sub(this.cursor),this.target.clampLength(this.minTargetRadius,this.maxTargetRadius),this.target.add(this.cursor);let r=!1;if(this.zoomToCursor&&this._performCursorZoom||this.object.isOrthographicCamera)this._spherical.radius=this._clampDistance(this._spherical.radius);else{const o=this._spherical.radius;this._spherical.radius=this._clampDistance(this._spherical.radius*this._scale),r=o!=this._spherical.radius}if(ge.setFromSpherical(this._spherical),ge.applyQuaternion(this._quatInverse),e.copy(this.target).add(ge),this.object.lookAt(this.target),this.enableDamping===!0?(this._sphericalDelta.theta*=1-this.dampingFactor,this._sphericalDelta.phi*=1-this.dampingFactor,this._panOffset.multiplyScalar(1-this.dampingFactor)):(this._sphericalDelta.set(0,0,0),this._panOffset.set(0,0,0)),this.zoomToCursor&&this._performCursorZoom){let o=null;if(this.object.isPerspectiveCamera){const a=ge.length();o=this._clampDistance(a*this._scale);const c=a-o;this.object.position.addScaledVector(this._dollyDirection,c),this.object.updateMatrixWorld(),r=!!c}else if(this.object.isOrthographicCamera){const a=new C(this._mouse.x,this._mouse.y,0);a.unproject(this.object);const c=this.object.zoom;this.object.zoom=Math.max(this.minZoom,Math.min(this.maxZoom,this.object.zoom/this._scale)),this.object.updateProjectionMatrix(),r=c!==this.object.zoom;const l=new C(this._mouse.x,this._mouse.y,0);l.unproject(this.object),this.object.position.sub(l).add(a),this.object.updateMatrixWorld(),o=ge.length()}else console.warn("WARNING: OrbitControls.js encountered an unknown camera type - zoom to cursor disabled."),this.zoomToCursor=!1;o!==null&&(this.screenSpacePanning?this.target.set(0,0,-1).transformDirection(this.object.matrix).multiplyScalar(o).add(this.object.position):(nr.origin.copy(this.object.position),nr.direction.set(0,0,-1).transformDirection(this.object.matrix),Math.abs(this.object.up.dot(nr.direction))<r_?this.object.lookAt(this.target):(pl.setFromNormalAndCoplanarPoint(this.object.up,this.target),nr.intersectPlane(pl,this.target))))}else if(this.object.isOrthographicCamera){const o=this.object.zoom;this.object.zoom=Math.max(this.minZoom,Math.min(this.maxZoom,this.object.zoom/this._scale)),o!==this.object.zoom&&(this.object.updateProjectionMatrix(),r=!0)}return this._scale=1,this._performCursorZoom=!1,r||this._lastPosition.distanceToSquared(this.object.position)>vo||8*(1-this._lastQuaternion.dot(this.object.quaternion))>vo||this._lastTargetPosition.distanceToSquared(this.target)>vo?(this.dispatchEvent(fl),this._lastPosition.copy(this.object.position),this._lastQuaternion.copy(this.object.quaternion),this._lastTargetPosition.copy(this.target),!0):!1}_getAutoRotationAngle(t){return t!==null?De/60*this.autoRotateSpeed*t:De/60/60*this.autoRotateSpeed}_getZoomScale(t){const e=Math.abs(t*.01);return Math.pow(.95,this.zoomSpeed*e)}_rotateLeft(t){this._sphericalDelta.theta-=t}_rotateUp(t){this._sphericalDelta.phi-=t}_panLeft(t,e){ge.setFromMatrixColumn(e,0),ge.multiplyScalar(-t),this._panOffset.add(ge)}_panUp(t,e){this.screenSpacePanning===!0?ge.setFromMatrixColumn(e,1):(ge.setFromMatrixColumn(e,0),ge.crossVectors(this.object.up,ge)),ge.multiplyScalar(t),this._panOffset.add(ge)}_pan(t,e){const n=this.domElement;if(this.object.isPerspectiveCamera){const s=this.object.position;ge.copy(s).sub(this.target);let r=ge.length();r*=Math.tan(this.object.fov/2*Math.PI/180),this._panLeft(2*t*r/n.clientHeight,this.object.matrix),this._panUp(2*e*r/n.clientHeight,this.object.matrix)}else this.object.isOrthographicCamera?(this._panLeft(t*(this.object.right-this.object.left)/this.object.zoom/n.clientWidth,this.object.matrix),this._panUp(e*(this.object.top-this.object.bottom)/this.object.zoom/n.clientHeight,this.object.matrix)):(console.warn("WARNING: OrbitControls.js encountered an unknown camera type - pan disabled."),this.enablePan=!1)}_dollyOut(t){this.object.isPerspectiveCamera||this.object.isOrthographicCamera?this._scale/=t:(console.warn("WARNING: OrbitControls.js encountered an unknown camera type - dolly/zoom disabled."),this.enableZoom=!1)}_dollyIn(t){this.object.isPerspectiveCamera||this.object.isOrthographicCamera?this._scale*=t:(console.warn("WARNING: OrbitControls.js encountered an unknown camera type - dolly/zoom disabled."),this.enableZoom=!1)}_updateZoomParameters(t,e){if(!this.zoomToCursor)return;this._performCursorZoom=!0;const n=this.domElement.getBoundingClientRect(),s=t-n.left,r=e-n.top,o=n.width,a=n.height;this._mouse.x=s/o*2-1,this._mouse.y=-(r/a)*2+1,this._dollyDirection.set(this._mouse.x,this._mouse.y,1).unproject(this.object).sub(this.object.position).normalize()}_clampDistance(t){return Math.max(this.minDistance,Math.min(this.maxDistance,t))}_handleMouseDownRotate(t){this._rotateStart.set(t.clientX,t.clientY)}_handleMouseDownDolly(t){this._updateZoomParameters(t.clientX,t.clientX),this._dollyStart.set(t.clientX,t.clientY)}_handleMouseDownPan(t){this._panStart.set(t.clientX,t.clientY)}_handleMouseMoveRotate(t){this._rotateEnd.set(t.clientX,t.clientY),this._rotateDelta.subVectors(this._rotateEnd,this._rotateStart).multiplyScalar(this.rotateSpeed);const e=this.domElement;this._rotateLeft(De*this._rotateDelta.x/e.clientHeight),this._rotateUp(De*this._rotateDelta.y/e.clientHeight),this._rotateStart.copy(this._rotateEnd),this.update()}_handleMouseMoveDolly(t){this._dollyEnd.set(t.clientX,t.clientY),this._dollyDelta.subVectors(this._dollyEnd,this._dollyStart),this._dollyDelta.y>0?this._dollyOut(this._getZoomScale(this._dollyDelta.y)):this._dollyDelta.y<0&&this._dollyIn(this._getZoomScale(this._dollyDelta.y)),this._dollyStart.copy(this._dollyEnd),this.update()}_handleMouseMovePan(t){this._panEnd.set(t.clientX,t.clientY),this._panDelta.subVectors(this._panEnd,this._panStart).multiplyScalar(this.panSpeed),this._pan(this._panDelta.x,this._panDelta.y),this._panStart.copy(this._panEnd),this.update()}_handleMouseWheel(t){this._updateZoomParameters(t.clientX,t.clientY),t.deltaY<0?this._dollyIn(this._getZoomScale(t.deltaY)):t.deltaY>0&&this._dollyOut(this._getZoomScale(t.deltaY)),this.update()}_handleKeyDown(t){let e=!1;switch(t.code){case this.keys.UP:t.ctrlKey||t.metaKey||t.shiftKey?this._rotateUp(De*this.rotateSpeed/this.domElement.clientHeight):this._pan(0,this.keyPanSpeed),e=!0;break;case this.keys.BOTTOM:t.ctrlKey||t.metaKey||t.shiftKey?this._rotateUp(-De*this.rotateSpeed/this.domElement.clientHeight):this._pan(0,-this.keyPanSpeed),e=!0;break;case this.keys.LEFT:t.ctrlKey||t.metaKey||t.shiftKey?this._rotateLeft(De*this.rotateSpeed/this.domElement.clientHeight):this._pan(this.keyPanSpeed,0),e=!0;break;case this.keys.RIGHT:t.ctrlKey||t.metaKey||t.shiftKey?this._rotateLeft(-De*this.rotateSpeed/this.domElement.clientHeight):this._pan(-this.keyPanSpeed,0),e=!0;break}e&&(t.preventDefault(),this.update())}_handleTouchStartRotate(t){if(this._pointers.length===1)this._rotateStart.set(t.pageX,t.pageY);else{const e=this._getSecondPointerPosition(t),n=.5*(t.pageX+e.x),s=.5*(t.pageY+e.y);this._rotateStart.set(n,s)}}_handleTouchStartPan(t){if(this._pointers.length===1)this._panStart.set(t.pageX,t.pageY);else{const e=this._getSecondPointerPosition(t),n=.5*(t.pageX+e.x),s=.5*(t.pageY+e.y);this._panStart.set(n,s)}}_handleTouchStartDolly(t){const e=this._getSecondPointerPosition(t),n=t.pageX-e.x,s=t.pageY-e.y,r=Math.sqrt(n*n+s*s);this._dollyStart.set(0,r)}_handleTouchStartDollyPan(t){this.enableZoom&&this._handleTouchStartDolly(t),this.enablePan&&this._handleTouchStartPan(t)}_handleTouchStartDollyRotate(t){this.enableZoom&&this._handleTouchStartDolly(t),this.enableRotate&&this._handleTouchStartRotate(t)}_handleTouchMoveRotate(t){if(this._pointers.length==1)this._rotateEnd.set(t.pageX,t.pageY);else{const n=this._getSecondPointerPosition(t),s=.5*(t.pageX+n.x),r=.5*(t.pageY+n.y);this._rotateEnd.set(s,r)}this._rotateDelta.subVectors(this._rotateEnd,this._rotateStart).multiplyScalar(this.rotateSpeed);const e=this.domElement;this._rotateLeft(De*this._rotateDelta.x/e.clientHeight),this._rotateUp(De*this._rotateDelta.y/e.clientHeight),this._rotateStart.copy(this._rotateEnd)}_handleTouchMovePan(t){if(this._pointers.length===1)this._panEnd.set(t.pageX,t.pageY);else{const e=this._getSecondPointerPosition(t),n=.5*(t.pageX+e.x),s=.5*(t.pageY+e.y);this._panEnd.set(n,s)}this._panDelta.subVectors(this._panEnd,this._panStart).multiplyScalar(this.panSpeed),this._pan(this._panDelta.x,this._panDelta.y),this._panStart.copy(this._panEnd)}_handleTouchMoveDolly(t){const e=this._getSecondPointerPosition(t),n=t.pageX-e.x,s=t.pageY-e.y,r=Math.sqrt(n*n+s*s);this._dollyEnd.set(0,r),this._dollyDelta.set(0,Math.pow(this._dollyEnd.y/this._dollyStart.y,this.zoomSpeed)),this._dollyOut(this._dollyDelta.y),this._dollyStart.copy(this._dollyEnd);const o=(t.pageX+e.x)*.5,a=(t.pageY+e.y)*.5;this._updateZoomParameters(o,a)}_handleTouchMoveDollyPan(t){this.enableZoom&&this._handleTouchMoveDolly(t),this.enablePan&&this._handleTouchMovePan(t)}_handleTouchMoveDollyRotate(t){this.enableZoom&&this._handleTouchMoveDolly(t),this.enableRotate&&this._handleTouchMoveRotate(t)}_addPointer(t){this._pointers.push(t.pointerId)}_removePointer(t){delete this._pointerPositions[t.pointerId];for(let e=0;e<this._pointers.length;e++)if(this._pointers[e]==t.pointerId){this._pointers.splice(e,1);return}}_isTrackingPointer(t){for(let e=0;e<this._pointers.length;e++)if(this._pointers[e]==t.pointerId)return!0;return!1}_trackPointer(t){let e=this._pointerPositions[t.pointerId];e===void 0&&(e=new nt,this._pointerPositions[t.pointerId]=e),e.set(t.pageX,t.pageY)}_getSecondPointerPosition(t){const e=t.pointerId===this._pointers[0]?this._pointers[1]:this._pointers[0];return this._pointerPositions[e]}_customWheelEvent(t){const e=t.deltaMode,n={clientX:t.clientX,clientY:t.clientY,deltaY:t.deltaY};switch(e){case 1:n.deltaY*=16;break;case 2:n.deltaY*=100;break}return t.ctrlKey&&!this._controlActive&&(n.deltaY*=10),n}}function a_(i){this.enabled!==!1&&(this._pointers.length===0&&(this.domElement.setPointerCapture(i.pointerId),this.domElement.addEventListener("pointermove",this._onPointerMove),this.domElement.addEventListener("pointerup",this._onPointerUp)),!this._isTrackingPointer(i)&&(this._addPointer(i),i.pointerType==="touch"?this._onTouchStart(i):this._onMouseDown(i)))}function c_(i){this.enabled!==!1&&(i.pointerType==="touch"?this._onTouchMove(i):this._onMouseMove(i))}function l_(i){switch(this._removePointer(i),this._pointers.length){case 0:this.domElement.releasePointerCapture(i.pointerId),this.domElement.removeEventListener("pointermove",this._onPointerMove),this.domElement.removeEventListener("pointerup",this._onPointerUp),this.dispatchEvent(Ah),this.state=ie.NONE;break;case 1:const t=this._pointers[0],e=this._pointerPositions[t];this._onTouchStart({pointerId:t,pageX:e.x,pageY:e.y});break}}function h_(i){let t;switch(i.button){case 0:t=this.mouseButtons.LEFT;break;case 1:t=this.mouseButtons.MIDDLE;break;case 2:t=this.mouseButtons.RIGHT;break;default:t=-1}switch(t){case Ni.DOLLY:if(this.enableZoom===!1)return;this._handleMouseDownDolly(i),this.state=ie.DOLLY;break;case Ni.ROTATE:if(i.ctrlKey||i.metaKey||i.shiftKey){if(this.enablePan===!1)return;this._handleMouseDownPan(i),this.state=ie.PAN}else{if(this.enableRotate===!1)return;this._handleMouseDownRotate(i),this.state=ie.ROTATE}break;case Ni.PAN:if(i.ctrlKey||i.metaKey||i.shiftKey){if(this.enableRotate===!1)return;this._handleMouseDownRotate(i),this.state=ie.ROTATE}else{if(this.enablePan===!1)return;this._handleMouseDownPan(i),this.state=ie.PAN}break;default:this.state=ie.NONE}this.state!==ie.NONE&&this.dispatchEvent(za)}function u_(i){switch(this.state){case ie.ROTATE:if(this.enableRotate===!1)return;this._handleMouseMoveRotate(i);break;case ie.DOLLY:if(this.enableZoom===!1)return;this._handleMouseMoveDolly(i);break;case ie.PAN:if(this.enablePan===!1)return;this._handleMouseMovePan(i);break}}function d_(i){this.enabled===!1||this.enableZoom===!1||this.state!==ie.NONE||(i.preventDefault(),this.dispatchEvent(za),this._handleMouseWheel(this._customWheelEvent(i)),this.dispatchEvent(Ah))}function f_(i){this.enabled===!1||this.enablePan===!1||this._handleKeyDown(i)}function p_(i){switch(this._trackPointer(i),this._pointers.length){case 1:switch(this.touches.ONE){case Li.ROTATE:if(this.enableRotate===!1)return;this._handleTouchStartRotate(i),this.state=ie.TOUCH_ROTATE;break;case Li.PAN:if(this.enablePan===!1)return;this._handleTouchStartPan(i),this.state=ie.TOUCH_PAN;break;default:this.state=ie.NONE}break;case 2:switch(this.touches.TWO){case Li.DOLLY_PAN:if(this.enableZoom===!1&&this.enablePan===!1)return;this._handleTouchStartDollyPan(i),this.state=ie.TOUCH_DOLLY_PAN;break;case Li.DOLLY_ROTATE:if(this.enableZoom===!1&&this.enableRotate===!1)return;this._handleTouchStartDollyRotate(i),this.state=ie.TOUCH_DOLLY_ROTATE;break;default:this.state=ie.NONE}break;default:this.state=ie.NONE}this.state!==ie.NONE&&this.dispatchEvent(za)}function m_(i){switch(this._trackPointer(i),this.state){case ie.TOUCH_ROTATE:if(this.enableRotate===!1)return;this._handleTouchMoveRotate(i),this.update();break;case ie.TOUCH_PAN:if(this.enablePan===!1)return;this._handleTouchMovePan(i),this.update();break;case ie.TOUCH_DOLLY_PAN:if(this.enableZoom===!1&&this.enablePan===!1)return;this._handleTouchMoveDollyPan(i),this.update();break;case ie.TOUCH_DOLLY_ROTATE:if(this.enableZoom===!1&&this.enableRotate===!1)return;this._handleTouchMoveDollyRotate(i),this.update();break;default:this.state=ie.NONE}}function g_(i){this.enabled!==!1&&i.preventDefault()}function __(i){i.key==="Control"&&(this._controlActive=!0,this.domElement.getRootNode().addEventListener("keyup",this._interceptControlUp,{passive:!0,capture:!0}))}function v_(i){i.key==="Control"&&(this._controlActive=!1,this.domElement.getRootNode().removeEventListener("keyup",this._interceptControlUp,{passive:!0,capture:!0}))}const Ai=new on(0,0,0,"YXZ"),Ci=new C,x_={type:"change"},y_={type:"lock"},M_={type:"unlock"},ml=Math.PI/2;class S_ extends gh{constructor(t,e=null){super(t,e),this.isLocked=!1,this.minPolarAngle=0,this.maxPolarAngle=Math.PI,this.pointerSpeed=1,this._onMouseMove=b_.bind(this),this._onPointerlockChange=E_.bind(this),this._onPointerlockError=T_.bind(this),this.domElement!==null&&this.connect()}connect(){this.domElement.ownerDocument.addEventListener("mousemove",this._onMouseMove),this.domElement.ownerDocument.addEventListener("pointerlockchange",this._onPointerlockChange),this.domElement.ownerDocument.addEventListener("pointerlockerror",this._onPointerlockError)}disconnect(){this.domElement.ownerDocument.removeEventListener("mousemove",this._onMouseMove),this.domElement.ownerDocument.removeEventListener("pointerlockchange",this._onPointerlockChange),this.domElement.ownerDocument.removeEventListener("pointerlockerror",this._onPointerlockError)}dispose(){this.disconnect()}getObject(){return console.warn("THREE.PointerLockControls: getObject() has been deprecated. Use controls.object instead."),this.object}getDirection(t){return t.set(0,0,-1).applyQuaternion(this.object.quaternion)}moveForward(t){if(this.enabled===!1)return;const e=this.object;Ci.setFromMatrixColumn(e.matrix,0),Ci.crossVectors(e.up,Ci),e.position.addScaledVector(Ci,t)}moveRight(t){if(this.enabled===!1)return;const e=this.object;Ci.setFromMatrixColumn(e.matrix,0),e.position.addScaledVector(Ci,t)}lock(){this.domElement.requestPointerLock()}unlock(){this.domElement.ownerDocument.exitPointerLock()}}function b_(i){if(this.enabled===!1||this.isLocked===!1)return;const t=i.movementX||i.mozMovementX||i.webkitMovementX||0,e=i.movementY||i.mozMovementY||i.webkitMovementY||0,n=this.object;Ai.setFromQuaternion(n.quaternion),Ai.y-=t*.002*this.pointerSpeed,Ai.x-=e*.002*this.pointerSpeed,Ai.x=Math.max(ml-this.maxPolarAngle,Math.min(ml-this.minPolarAngle,Ai.x)),n.quaternion.setFromEuler(Ai),this.dispatchEvent(x_)}function E_(){this.domElement.ownerDocument.pointerLockElement===this.domElement?(this.dispatchEvent(y_),this.isLocked=!0):(this.dispatchEvent(M_),this.isLocked=!1)}function T_(){console.error("THREE.PointerLockControls: Unable to use Pointer Lock API")}class w_ extends ih{constructor(){super();const t=new zn;t.deleteAttribute("uv");const e=new si({side:Re}),n=new si,s=new mh(16777215,900,28,2);s.position.set(.418,16.199,.3),this.add(s);const r=new ae(t,e);r.position.set(-.757,13.219,.717),r.scale.set(31.713,28.305,28.591),this.add(r);const o=new ae(t,n);o.position.set(-10.906,2.009,1.846),o.rotation.set(0,-.195,0),o.scale.set(2.328,7.905,4.651),this.add(o);const a=new ae(t,n);a.position.set(-5.607,-.754,-.758),a.rotation.set(0,.994,0),a.scale.set(1.97,1.534,3.955),this.add(a);const c=new ae(t,n);c.position.set(6.167,.857,7.803),c.rotation.set(0,.561,0),c.scale.set(3.927,6.285,3.687),this.add(c);const l=new ae(t,n);l.position.set(-2.017,.018,6.124),l.rotation.set(0,.333,0),l.scale.set(2.002,4.566,2.064),this.add(l);const h=new ae(t,n);h.position.set(2.291,-.756,-2.621),h.rotation.set(0,-.286,0),h.scale.set(1.546,1.552,1.496),this.add(h);const d=new ae(t,n);d.position.set(-2.193,-.369,-5.547),d.rotation.set(0,.516,0),d.scale.set(3.875,3.487,2.986),this.add(d);const u=new ae(t,Ri(50));u.position.set(-16.116,14.37,8.208),u.scale.set(.1,2.428,2.739),this.add(u);const f=new ae(t,Ri(50));f.position.set(-16.109,18.021,-8.207),f.scale.set(.1,2.425,2.751),this.add(f);const g=new ae(t,Ri(17));g.position.set(14.904,12.198,-1.832),g.scale.set(.15,4.265,6.331),this.add(g);const _=new ae(t,Ri(43));_.position.set(-.462,8.89,14.52),_.scale.set(4.38,5.441,.088),this.add(_);const p=new ae(t,Ri(20));p.position.set(3.235,11.486,-12.541),p.scale.set(2.5,2,.1),this.add(p);const m=new ae(t,Ri(100));m.position.set(0,20,0),m.scale.set(1,.1,1),this.add(m)}dispose(){const t=new Set;this.traverse(e=>{e.isMesh&&(t.add(e.geometry),t.add(e.material))});for(const e of t)e.dispose()}}function Ri(i){const t=new Er;return t.color.setScalar(i),t}const Pt=(i,t,e)=>ci(i,t,e,new C),xr=[{id:"outside",name:"Vòng quanh bên ngoài tàu",speed:7,look:"center",desc:"Camera bay vòng quanh thân tàu để quan sát hình dáng vỏ, các tổng đoạn và đường nước.",pts:()=>{const i=[];for(let t=0;t<=24;t++){const e=t/24*Math.PI*2;i.push(new C(Math.cos(e)*52,6+5*Math.sin(e*2)**2,Math.sin(e)*24))}return i}},{id:"hold",name:"Bên trong hầm hàng số 2",speed:2.2,look:"path",desc:"Đi từ miệng hầm xuống hầm hàng: quan sát sườn thường, sườn khỏe, sống dọc mạn, mã hông, tôn đáy trên và vách ngang.",pts:()=>[Pt(35,-9,14),Pt(34,-1,10),Pt(33,0,6.6),Pt(32,-1,4.2),Pt(30,-3.6,3),Pt(33,-4.6,2.6),Pt(38,-4.6,2.6),Pt(40.6,-2.5,3.2),Pt(40.6,2.5,3.2),Pt(38,4.6,2.6),Pt(32,4.6,2.6),Pt(29.6,1.5,3.4),Pt(31,0,5.4),Pt(34,0,8.5),Pt(38,7,12)]},{id:"db",name:"Chui vào trong đáy đôi",speed:1.4,look:"path",desc:"Camera chui qua các lỗ khoét trên đà ngang và sống phụ – đúng như người thợ đi kiểm tra trong két đáy đôi.",pts:()=>[Pt(41.3,1.1,3.2),Pt(41.3,1.1,1.6),Pt(41.3,1.1,.6),Pt(39.6,1.1,.6),Pt(36,1.1,.6),Pt(32,1.1,.6),Pt(30.5,1.1,.6),Pt(30.1,1.6,.6),Pt(30.1,2.7,.6),Pt(30.5,3.2,.6),Pt(33,3.2,.6),Pt(35.3,3.2,.6),Pt(35.7,3.2,1),Pt(35.7,3.2,3.2),Pt(36.5,2,5)]},{id:"deck",name:"Dọc boong từ mũi về đuôi",speed:4.5,look:"path",desc:"Đi dọc boong chính: thành miệng hầm, mã chống, tôn mép boong và khối thượng tầng.",pts:()=>[Pt(76,0,10),Pt(68,0,8.4),Pt(60,1.5,8.2),Pt(54,5,8.4),Pt(46,5.2,8.3),Pt(35,5.2,8.3),Pt(24,5.2,8.3),Pt(16,4,8.6),Pt(13.5,0,9.6),Pt(12.5,-3,12.5),Pt(16,-8,15)]}],va={overview:{name:"Toàn cảnh",pos:[-58,30,62],target:[0,3,0]},side:{name:"Nhìn mạn",pos:[0,4,80],target:[0,3,0]},front:{name:"Nhìn từ mũi",pos:[80,10,0],target:[0,3,0]},stern:{name:"Nhìn từ đuôi",pos:[-70,9,-22],target:[-30,3,0]},top:{name:"Nhìn từ trên",pos:[0,90,.1],target:[0,0,0]},below:{name:"Nhìn từ dưới đáy",pos:[-30,-14,30],target:[0,2,0]},midship:{name:"Mặt cắt giữa tàu",pos:[24,7,16],target:[0,3,0],cutX:35}},ze=[{name:"Trong hầm hàng số 2",pos:Pt(30,0,2.8),look:Pt(40,0,2.5)},{name:"Trong đáy đôi",pos:Pt(39.6,1.1,.6),look:Pt(30,1.1,.6)},{name:"Trên boong chính",pos:Pt(46,5,8.2),look:Pt(30,4,7.5)},{name:"Khoang mũi",pos:Pt(60,0,4.2),look:Pt(66,0,3.5)},{name:"Buồng máy (đuôi)",pos:Pt(12.5,0,3.2),look:Pt(6,0,3)}],A_=i=>{for(;i;i=i.parent)if(!i.visible)return!1;return!0};class C_{constructor(t){this.el=t;const e=this.renderer=new jg({antialias:!0});e.setPixelRatio(Math.min(window.devicePixelRatio,2)),e.toneMapping=wl,e.toneMappingExposure=1.05,t.appendChild(e.domElement);const n=this.scene=new ih;n.background=new Xt(13227747),n.fog=new La(13227747,160,420);const s=new aa(e);n.environment=s.fromScene(new w_,.04).texture,this.camera=new He(50,1,.05,2e3),this.camera.position.set(-46,22,48),this.orbit=new o_(this.camera,e.domElement),this.orbit.enableDamping=!0,this.orbit.dampingFactor=.08,this.orbit.target.set(0,3,0),this.orbit.maxDistance=400,this.walk=new S_(this.camera,e.domElement),this.keys={},this.walkSpeed=3,this.mode="orbit",this.tour=null,this.fly=null,this.listeners={},this.updaters=[],n.add(new L0(15266047,4869973,1.2));const r=new el(16777215,2);r.position.set(-40,70,35),n.add(r);const o=new el(14673663,.7);o.position.set(50,20,-40),n.add(o),this.headlight=new mh(16777215,0,30,1.2),this.camera.add(this.headlight),n.add(this.camera),this.buildDock(),this.planes={x:new en(new C(-1,0,0),0),z:new en(new C(0,0,-1),0),y:new en(new C(0,-1,0),0)},this.clip={x:null,z:!1,y:null},this.raycaster=new N0,this.pointer=new nt,this.bindEvents(),this.clock=new U0,new ResizeObserver(()=>this.resize()).observe(t),this.resize(),e.setAnimationLoop(()=>this.frame())}on(t,e){var n;((n=this.listeners)[t]||(n[t]=[])).push(e)}emit(t,...e){(this.listeners[t]||[]).forEach(n=>n(...e))}buildDock(){const t=new Ii,e=-1.4,n=new si({color:9145994,roughness:.95}),s=new ae(new bs(260,70),n);s.rotation.x=-Math.PI/2,s.position.y=e,t.add(s);const r=new k0(260,130,7106668,8159356);r.position.y=e+.01,t.add(r);const o=new si({color:10132888,roughness:.9});for(const c of[1,-1]){const l=new ae(new zn(260,9,2),o);l.position.set(0,e+4.5,c*35),t.add(l)}const a=new si({color:7035461,roughness:.9});for(let c=4;c<=64;c+=2.8)for(const l of[0,-3.2,3.2]){if(l!==0&&(c<14||c>54))continue;const h=new ae(new zn(.9,-e,1.4),a);h.position.set(c-At.L/2,e/2-.01,l),t.add(h)}this.dock=t,this.scene.add(t)}setShip(t,e){this.ship=t,this.parts=e,this.scene.add(t)}resize(){const t=this.el.clientWidth,e=this.el.clientHeight;this.renderer.setSize(t,e),this.camera.aspect=t/e,this.camera.updateProjectionMatrix()}setClip(t){Object.assign(this.clip,t);const e=[];this.clip.x!==null&&(this.planes.x.constant=this.clip.x,e.push(this.planes.x)),this.clip.z&&e.push(this.planes.z),this.clip.y!==null&&(this.planes.y.constant=this.clip.y,e.push(this.planes.y)),this.renderer.clippingPlanes=e}clipped(t){return this.renderer.clippingPlanes.some(e=>e.distanceToPoint(t)<0)}pickAt(t,e){this.raycaster.setFromCamera(new nt(t,e),this.camera);const n=this.raycaster.intersectObjects(this.parts,!1);for(const s of n)if(A_(s.object)&&!s.object.userData.ghost&&!this.clipped(s.point))return s.object;return null}bindEvents(){const t=this.renderer.domElement;let e=null;t.addEventListener("pointerdown",s=>{e=[s.clientX,s.clientY]}),t.addEventListener("pointerup",s=>{if(!e||Math.hypot(s.clientX-e[0],s.clientY-e[1])>5)return;if(this.mode==="walk"){if(!this.walk.isLocked){this.walk.lock();return}this.emit("pick",this.pickAt(0,0));return}const r=t.getBoundingClientRect();this.emit("pick",this.pickAt((s.clientX-r.left)/r.width*2-1,-((s.clientY-r.top)/r.height)*2+1))});let n=0;t.addEventListener("pointermove",s=>{if(this.mode==="walk"||performance.now()-n<90)return;n=performance.now();const r=t.getBoundingClientRect(),o=this.pickAt((s.clientX-r.left)/r.width*2-1,-((s.clientY-r.top)/r.height)*2+1);this.emit("hover",o,s.clientX-r.left,s.clientY-r.top)}),t.addEventListener("pointerleave",()=>this.emit("hover",null)),window.addEventListener("keydown",s=>{s.target.tagName==="INPUT"||s.target.tagName==="TEXTAREA"||(this.keys[s.code]=!0)}),window.addEventListener("keyup",s=>{this.keys[s.code]=!1}),this.walk.addEventListener("lock",()=>this.emit("walklock",!0)),this.walk.addEventListener("unlock",()=>this.emit("walklock",!1))}setMode(t){if(this.walk.isLocked&&this.walk.unlock(),this.tour=null,this.mode=t,this.orbit.enabled=t==="orbit",this.headlight.intensity=t==="orbit"?0:25,t==="orbit"){const e=new C;this.camera.getWorldDirection(e),this.orbit.target.copy(this.camera.position).addScaledVector(e,12),this.camera.up.set(0,1,0)}this.emit("mode",t)}walkTo(t,e){this.setMode("walk"),this.camera.position.copy(t),this.camera.up.set(0,1,0),this.camera.lookAt(e)}startTour(t){const e=xr.find(s=>s.id===t);if(!e)return;this.setMode("tour");const n=new rh(e.pts(),e.id==="outside","centripetal");this.tour={def:e,curve:n,len:n.getLength(),u:0,paused:!1,speedMul:1},this.emit("tour",this.tour)}stopTour(){this.setMode("orbit")}flyTo(t,e,n=1.1){this.mode!=="orbit"&&this.setMode("orbit"),this.fly={p0:this.camera.position.clone(),t0:this.orbit.target.clone(),p1:t.clone(),t1:e.clone(),el:0,dur:n}}focusObjects(t,{keepDir:e=!0,dur:n=1.1}={}){const s=new Yi;if(t.forEach(l=>l&&s.expandByObject(l)),s.isEmpty())return;const r=s.getCenter(new C),a=Math.max(2,s.getSize(new C).length()/2)/Math.sin(zl.degToRad(this.camera.fov/2))*.85,c=e?this.camera.position.clone().sub(this.orbit.target).normalize():new C(-.6,.45,.65).normalize();c.y<.15&&(c.y=.15),c.normalize(),this.flyTo(r.clone().addScaledVector(c,a),r,n)}frame(){const t=Math.min(.05,this.clock.getDelta());if(this.updaters.forEach(e=>e(t)),this.fly){const e=this.fly;e.el+=t;const n=Math.min(1,e.el/e.dur),s=n<.5?2*n*n:1-Math.pow(-2*n+2,2)/2;this.camera.position.lerpVectors(e.p0,e.p1,s),this.orbit.target.lerpVectors(e.t0,e.t1,s),n>=1&&(this.fly=null)}this.mode==="orbit"?this.orbit.update():this.mode==="walk"&&this.walk.isLocked?this.walkStep(t):this.mode==="tour"&&this.tour&&this.tourStep(t),this.renderer.render(this.scene,this.camera)}walkStep(t){const e=this.keys,n=this.walkSpeed*(e.ShiftLeft||e.ShiftRight?3:1)*t;(e.KeyW||e.ArrowUp)&&this.walk.moveForward(n),(e.KeyS||e.ArrowDown)&&this.walk.moveForward(-n),(e.KeyD||e.ArrowRight)&&this.walk.moveRight(n),(e.KeyA||e.ArrowLeft)&&this.walk.moveRight(-n),(e.KeyE||e.Space)&&(this.camera.position.y+=n),(e.KeyQ||e.KeyC)&&(this.camera.position.y-=n),this.emit("walkmove",this.camera.position)}tourStep(t){const e=this.tour;e.paused||(e.u+=e.def.speed*e.speedMul*t/e.len,e.u>=1&&(e.def.id==="outside"?e.u-=1:(e.u=1,e.paused=!0)));const n=e.curve.getPointAt(Math.min(1,e.u));if(this.camera.position.copy(n),e.def.look==="center")this.camera.lookAt(0,2.5,0);else{const s=e.curve.getPointAt(Math.min(1,e.u+Math.max(.01,3/e.len)));if(s.distanceTo(n)>.01){const r=new re().lookAt(n,s,new C(0,1,0)),o=new En().setFromRotationMatrix(r);this.camera.quaternion.slerp(o,Math.min(1,t*3))}}this.emit("tourprogress",e)}}const R_={type:"Theo loại kết cấu",block:"Theo phân đoạn",level:"Theo dạng Panel / Cụm chi tiết",paint:"Sơn hoàn thiện (thực tế)"},xo=new Map;function ir(i,t={}){const e=`${i}|${JSON.stringify(t)}`;return xo.has(e)||xo.set(e,new si({color:i,metalness:.35,roughness:.6,side:qe,polygonOffset:!0,polygonOffsetFactor:1,polygonOffsetUnits:1,...t})),xo.get(e)}let yo=null;function P_(){if(yo)return yo;const i=new si({color:16777215,metalness:.25,roughness:.55,side:qe,polygonOffset:!0,polygonOffsetFactor:1,polygonOffsetUnits:1});return i.onBeforeCompile=t=>{t.uniforms.uT={value:At.T},t.vertexShader=t.vertexShader.replace("#include <common>",`#include <common>
varying float vWY;`).replace("#include <begin_vertex>",`#include <begin_vertex>
vWY = (modelMatrix * vec4(transformed, 1.0)).y;`),t.fragmentShader=t.fragmentShader.replace("#include <common>",`#include <common>
varying float vWY;
uniform float uT;`).replace("#include <color_fragment>",`#include <color_fragment>
        vec3 c = vWY < uT - 0.15 ? vec3(0.50, 0.10, 0.07) : (vWY < uT + 0.2 ? vec3(0.85, 0.85, 0.82) : vec3(0.07, 0.11, 0.17));
        diffuseColor.rgb = c;`)},i.customProgramCacheKey=()=>"hullpaint",yo=i,i}const gl=[6000111,15246141,5223046,14246991,10190801,4175817,13217855,13856679,8231754,9408399];function L_(i,t){let e=0;for(const n of i)e=e*31+n.charCodeAt(0)>>>0;return e%t}function D_(i,t){return t==="shell"||i==="transom"||i==="stem"?"hull":i==="deck_plate"||i==="deck_stringer"?5664847:i==="hatch_coaming"||i==="coaming_stay"?11027500:t==="super"?i==="funnel"?13224393:15526886:i==="propeller"?12092974:i==="rudder"||i==="stern_frame"?8004632:11119783}function I_(i,t){const e=i.userData,n=Ji(e.kind);switch(t){case"block":{const s=ma(i,Lt.BLOCK);return ir(gl[L_(s?s.userData.id:e.id,gl.length)])}case"level":{const s=ma(i,Lt.ASSY);return ir(s&&s.userData.type==="panel"?5219237:13940570)}case"paint":{const s=D_(e.kind,n.cat);return s==="hull"?P_():ir(s)}default:return ir(qi[n.cat].color)}}function _l(i,t){for(const e of i)e.userData.baseMat=I_(e,t),e.userData.hl||(e.material=e.userData.baseMat)}const Mo=new Map,U_={select:16742938,step:2282478,task:8702998,kind:16020150};function vl(i,t){if(!t){i.userData.hl=null,i.material=i.userData.baseMat;return}const e=i.userData.baseMat,n=`${e.uuid}|${t}`;if(!Mo.has(n)){const s=e.clone();s.onBeforeCompile=e.onBeforeCompile,s.customProgramCacheKey=e.customProgramCacheKey,s.emissive=new Xt(U_[t]),s.emissiveIntensity=t==="select"?.65:.45,Mo.set(n,s)}i.userData.hl=t,i.material=Mo.get(n)}const N_=new Er({color:9413560,transparent:!0,opacity:.07,depthWrite:!1,side:qe}),k_=new Da({color:1778219,transparent:!0,opacity:.45});function F_(i){for(const t of i){const e=new sh(new u0(t.geometry,28),k_);e.raycast=()=>{},e.userData.isEdge=!0,t.add(e)}}const $e=[{n:1,name:"Chi tiết",color:"#9aa7b4",desc:"Tôn tấm, thép hình được làm sạch, sơn lót, lấy dấu và cắt (CNC plasma/oxy-gas), uốn, vát mép thành các chi tiết riêng lẻ."},{n:2,name:"Panel",color:"#4fa3a5",desc:"Hàn giáp mối các tấm tôn thành tấm lớn (phẳng hoặc cong), sau đó lắp và hàn các nẹp, dầm dọc, sườn thường lên tấm."},{n:3,name:"Cụm chi tiết",color:"#d4b75a",desc:"Ghép một số chi tiết thành cụm nhỏ: sống đáy + nẹp, sườn khỏe, thành miệng hầm, mã… trước khi lắp vào phân đoạn."},{n:4,name:"Phân đoạn",color:"#c98b4e",desc:"Lắp panel và cụm chi tiết trên bệ lắp ráp thành phân đoạn (đáy, mạn, boong, vách…), hàn hoàn chỉnh, kiểm tra kích thước."},{n:5,name:"Tổng đoạn",color:"#b07cc6",desc:"Ghép các phân đoạn thành tổng đoạn vòng (ring block) ở bãi lắp ráp trước khi đưa lên đà – giảm khối lượng công việc trên đà."},{n:6,name:"Đấu nối thành tàu",color:"#e0705c",desc:"Cẩu các tổng đoạn lên đà/ụ, căn chỉnh theo đường tâm và đường chuẩn, hàn đấu đà – bắt đầu từ tổng đoạn chuẩn ở giữa tàu rồi phát triển về mũi và đuôi."}],O_=i=>i<.5?4*i*i*i:1-Math.pow(-2*i+2,3)/2,xl=(i,t,e)=>{const n=Math.min(1,Math.max(0,(e-i)/(t-i)));return n*n*(3-2*n)};function B_(i){const t=i.userData,e=t.t,n=t.explode;if(t.crane){const s=1-xl(0,.55,e),r=1-xl(.45,1,e);i.position.set(n.x*s,n.y*r,n.z*s)}else{const s=1-O_(e);i.position.set(n.x*s,n.y*s,n.z*s)}}function Nn(i,t){i.userData.t=t,B_(i)}function zi(i){const t=[];return i.traverse(e=>{e!==i&&e.userData&&e.userData.level!==void 0&&t.push(e)}),t}function z_(i,t){return zi(i).filter(e=>e.userData.level===t)}function Ch(i,t){for(;i&&i.userData.level>t;)i=i.parent;return i}function H_(i){const t=i.userData.level,e=[{stage:1,title:"Gia công chi tiết",desc:`${$e[0].desc} Toàn bộ chi tiết của “${i.userData.name}” đang được bày ra ở trạng thái tách rời.`,nodes:[],focus:[i]}];for(let n=Lt.PART;n>t;n--){const s=z_(i,n);if(!s.length)continue;const r=n-t,o=new Map;for(const a of s){let c;r===1?c=n===Lt.PART?`k:${a.userData.kind}`:`n:${a.userData.id}`:r===2?c=`p:${a.parent.userData.id}`:c=`a:${Ch(a,t+1).userData.id}`,o.has(c)||o.set(c,[]),o.get(c).push(a)}for(const[a,c]of o)e.push(V_(n,r,a,c,i))}return e}function V_(i,t,e,n,s){const r=n[0],o=r.parent,a=t>=3?Ch(r,s.userData.level+1):o,c=n.length;if(i===Lt.PART){if(t===1){const l=Ji(r.userData.kind);return{stage:o.userData.type==="panel"?2:3,title:`Lắp ${l.name.toLowerCase()}${c>1?` (${c} chi tiết)`:""}`,desc:`${l.desc} Quy cách: ${r.userData.spec||l.spec}.`,nodes:n,focus:[o]}}if(t===2){const l=o.userData.type==="panel";return{stage:l?2:3,title:`${l?"Chế tạo panel":"Chế tạo cụm chi tiết"}: ${o.userData.name}`,desc:`${o.userData.desc||""} (${c} chi tiết)`,nodes:n,focus:[o]}}return{stage:2,title:`Chế tạo panel & cụm chi tiết – ${a.userData.name}`,desc:`${$e[1].desc} ${$e[2].desc} (${c} chi tiết)`,nodes:n,focus:[a]}}return i===Lt.ASSY?t===1?{stage:4,title:`Lắp ${r.userData.name.toLowerCase()} vào phân đoạn`,desc:r.userData.desc||$e[3].desc,nodes:n,focus:[o]}:{stage:4,title:`Lắp ráp ${t===2?o.userData.name:"các phân đoạn – "+a.userData.name}`,desc:`${t===2?o.userData.desc+" ":""}${$e[3].desc}`,nodes:n,focus:[t===2?o:a]}:i===Lt.BLOCK?t===1?{stage:5,title:`Lắp ${r.userData.name}`,desc:r.userData.desc||$e[4].desc,nodes:n,focus:[o]}:{stage:5,title:`Hình thành ${a.userData.name}`,desc:`${$e[4].desc} ${a.userData.desc||""}`,nodes:n,focus:[a]}:{stage:6,title:`Đấu nối: ${r.userData.name}`,desc:r.userData.desc||$e[5].desc,nodes:n,focus:[r]}}class G_{constructor(){this.tracks=[]}run(t,e,{duration:n=1.6,stagger:s=null}={}){const r=s??Math.min(.08,2.4/Math.max(1,t.length));return new Promise(o=>{if(!t.length){o();return}t.forEach((a,c)=>{this.tracks=this.tracks.filter(l=>l.obj!==a),this.tracks.push({obj:a,from:a.userData.t,to:e,delay:c*r,dur:n,el:0,done:c===t.length-1?o:null})})})}stop(){this.tracks.forEach(t=>t.done&&t.done()),this.tracks=[]}get busy(){return this.tracks.length>0}update(t){if(this.tracks.length){for(const e of this.tracks){e.el+=t;const n=Math.min(1,Math.max(0,(e.el-e.delay)/e.dur));Nn(e.obj,e.from+(e.to-e.from)*n),n>=1&&(e.fin=!0)}for(const e of this.tracks)e.fin&&e.done&&e.done();this.tracks=this.tracks.filter(e=>!e.fin)}}}class W_{constructor(t,e){this.anim=t,this.onChange=e||(()=>{}),this.scope=null,this.steps=[],this.index=-1,this.playing=!1,this.speed=1}load(t){this.pause(),this.anim.stop(),this.scope&&zi(this.scope).forEach(e=>Nn(e,1)),this.scope=t,this.steps=H_(t),this.index=0,zi(t).forEach(e=>Nn(e,0)),this.onChange(this.steps[0],0)}snap(t){this.anim.stop(),this.steps.forEach((e,n)=>e.nodes.forEach(s=>Nn(s,n<t?1:0)))}async go(t,e=!0){if(!this.steps.length)return;t=Math.max(0,Math.min(this.steps.length-1,t)),this.snap(t),this.index=t;const n=this.steps[t];this.onChange(n,t),e?await this.anim.run(n.nodes,1,{duration:1.6/this.speed,stagger:Math.min(.08,2.4/Math.max(1,n.nodes.length))/this.speed}):n.nodes.forEach(s=>Nn(s,1))}next(){return this.index<this.steps.length-1?this.go(this.index+1):(this.pause(),Promise.resolve())}prev(){return this.go(this.index-1,!1)}async play(){if(!this.playing){for(this.playing=!0,this.onChange(this.steps[this.index],this.index);this.playing&&this.index<this.steps.length-1;)await this.next(),await new Promise(t=>setTimeout(t,700/this.speed));this.playing=!1,this.onChange(this.steps[this.index],this.index)}}pause(){this.playing=!1}finish(){this.pause(),this.snap(this.steps.length),this.index=this.steps.length-1,this.onChange(this.steps[this.index],this.index)}unload(){this.pause(),this.anim.stop(),this.scope&&zi(this.scope).forEach(t=>Nn(t,1)),this.scope=null,this.steps=[],this.index=-1,this.onChange(null,-1)}}function X_(i,t,e){zi(i).forEach(n=>Nn(n,n.userData.level<=t?1-e:1))}const zt=i=>String(i??"").replace(/[&<>"']/g,t=>({"&":"&amp;","<":"&lt;",">":"&gt;",'"':"&quot;","'":"&#39;"})[t]);function $_(i){const t=document.getElementById("modal");t.innerHTML=`<div class="modal"><button class="close" data-close>×</button>${i}</div>`,t.classList.remove("hidden"),t.onclick=e=>{(e.target===t||e.target.dataset.close!==void 0)&&t.classList.add("hidden")}}const q_=[["ship","Toàn tàu: tổng đoạn → đấu đà"],["gb3","Tổng đoạn 3 (tổng đoạn chuẩn)"],["gb3.db","Phân đoạn đáy đôi TĐ3"],["gb3.ss","Phân đoạn mạn phải TĐ3"],["gb3.dk","Phân đoạn boong & miệng hầm TĐ3"],["gb3.db.shell","Panel tôn đáy ngoài"],["gb3.db.ib","Panel tôn đáy trên"],["gb1","Tổng đoạn đuôi"]];function yl(i){return`<div class="stages">${$e.map(t=>`<div class="${t.n===i?"on":t.n<i?"done":""}"
    style="${t.n===i?`background:${t.color}`:""}">${t.n}. ${t.name}</div>`).join("")}</div>`}function Y_(i){const t=document.getElementById("tab-asm"),e=document.getElementById("stageBar"),n=i.player,s=[];i.ship.traverse(l=>{const h=l.userData;h.level!==void 0&&h.level<=Lt.ASSY&&s.push(`<option value="${h.id}">${"— ".repeat(h.level)}${zt(h.name)}</option>`)}),t.innerHTML=`
    <h3>Quy trình đóng tàu theo phân đoạn</h3>
    <div class="group" style="font-size:12.5px;line-height:1.45">
      ${$e.map(l=>`<div style="margin-bottom:6px"><span class="swatch" style="background:${l.color}"></span> <b>${l.n}. ${l.name}</b> – ${l.desc}</div>`).join("")}
    </div>
    <div class="group">
      <h3>Chọn phạm vi mô phỏng</h3>
      <div class="row">${q_.map(([l,h])=>`<button class="btn" data-q="${l}" style="font-size:12px">${h}</button>`).join("")}</div>
      <div class="row"><select id="asmScope" style="width:100%">${s.join("")}</select></div>
      <div class="row"><button class="btn primary" id="asmLoad">Bắt đầu mô phỏng</button>
        <label class="chk" style="margin-left:auto">Tốc độ
          <select id="asmSpeed"><option value="0.5">0.5×</option><option value="1" selected>1×</option><option value="2">2×</option><option value="4">4×</option></select></label></div>
    </div>
    <div id="asmState"><p class="note">Chọn một phạm vi rồi bấm “Bắt đầu mô phỏng”. Mọi chi tiết thuộc phạm vi sẽ được tách rời, sau đó lắp lại theo đúng trình tự: chi tiết → panel / cụm chi tiết → phân đoạn → tổng đoạn → đấu nối.</p></div>`;const r=l=>t.querySelector(l);t.querySelectorAll("[data-q]").forEach(l=>l.onclick=()=>i.playAssembly(i.node(l.dataset.q))),r("#asmLoad").onclick=()=>i.playAssembly(i.node(r("#asmScope").value)),r("#asmSpeed").onchange=l=>n.speed=+l.target.value;const o=()=>`
    <button class="btn" data-a="prev" ${n.index<=0?"disabled":""}>◀ Trước</button>
    <button class="btn primary" data-a="${n.playing?"pause":"play"}">${n.playing?"❚❚ Tạm dừng":"▶ Tự động"}</button>
    <button class="btn" data-a="next" ${n.index>=n.steps.length-1?"disabled":""}>Tiếp ▶</button>
    <button class="btn" data-a="finish">⏭ Lắp xong</button>
    <button class="btn" data-a="close">✕ Thoát</button>`,a=l=>{l==="prev"?n.prev():l==="next"?(n.pause(),n.next()):l==="play"?(n.index>=n.steps.length-1&&n.go(0,!1),n.play()):l==="pause"?n.pause():l==="finish"?n.finish():l==="close"&&(n.unload(),i.viewer.focusObjects([i.scope])),c(n.steps[n.index],n.index)};t.addEventListener("click",l=>{const h=l.target.closest("[data-a]");h&&a(h.dataset.a);const d=l.target.closest("[data-step]");d&&(n.pause(),n.go(+d.dataset.step))}),e.addEventListener("click",l=>{const h=l.target.closest("[data-a]");h&&a(h.dataset.a)});const c=(l,h)=>{if(!l){e.classList.add("hidden"),r("#asmState").innerHTML='<p class="note">Chưa có mô phỏng nào đang chạy.</p>';return}const d=$e[l.stage-1];e.classList.remove("hidden"),e.innerHTML=`${yl(l.stage)}
      <div class="title"><span class="chip" style="background:${d.color};color:#111">Giai đoạn ${d.n}: ${d.name}</span> ${zt(l.title)}</div>
      <div class="desc">${zt(l.desc)}</div>
      <div class="ctl">${o()}<span class="pos">Bước ${h+1}/${n.steps.length} · ${zt(n.scope.userData.name)}</span></div>`,r("#asmState").innerHTML=`
      <div class="group"><b>${zt(n.scope.userData.name)}</b>
        ${yl(l.stage)}
        <div class="row">${o()}</div></div>
      <div class="steps">${n.steps.map((f,g)=>`<div data-step="${g}" class="${g===h?"cur":g<h?"done":""}">
        <b>${g+1}</b><span class="swatch" style="background:${$e[f.stage-1].color};margin-top:3px"></span><span>${zt(f.title)}</span></div>`).join("")}</div>`;const u=t.querySelector(".steps .cur");u&&u.scrollIntoView({block:"nearest"}),r("#asmScope").value=n.scope.userData.id};i.on("step",c)}function Ha(i){document.querySelectorAll("#tabs button").forEach(t=>t.classList.toggle("on",t.dataset.tab===i)),document.querySelectorAll(".tab").forEach(t=>t.classList.toggle("on",t.id===`tab-${i}`))}function K_(i){document.getElementById("tabs").addEventListener("click",t=>{t.target.dataset.tab&&Ha(t.target.dataset.tab)}),j_(i),Y_(i),J_(i),Q_(i)}function Z_(i){const t=i.userData;if(t.level===Lt.ASSY)return t.type==="panel"?'<span class="lvl l3p">Panel</span>':'<span class="lvl l3c">Cụm</span>';const e=["Tàu","TĐ","PĐ"][t.level];return`<span class="lvl l${t.level}">${e}</span>`}function j_(i){const t=document.getElementById("tab-tree"),e=new Set(["ship"]),n=()=>{const s=r=>{const o=r.userData,a=o.level<Lt.ASSY?r.children.filter(u=>u.userData.level!==void 0):[],c=ga(r).length,l=e.has(o.id);let d=`<div class="node${i.scope===r?" sel":""}" data-id="${o.id}">
        <span class="tw" data-tw="${o.id}">${a.length?l?"▾":"▸":"·"}</span>
        ${Z_(r)}<span class="nm" title="${zt(o.name)}">${zt(o.name)}</span>
        <span class="cnt">${c}</span>
        <button class="btn" data-play="${o.id}" title="Mô phỏng lắp ráp phạm vi này" style="padding:1px 6px">▶</button>
      </div>`;return a.length&&l&&(d+=`<div class="kids">${a.map(s).join("")}</div>`),d};t.innerHTML=`
      <h3>Cây kết cấu thân tàu</h3>
      <p class="note">${zt(At.name)}. Nhấp một mục để <b>cô lập</b> và quan sát; nút ▶ để xem mô phỏng lắp ráp của mục đó. Số bên phải là số chi tiết.</p>
      <div class="row" style="margin-bottom:8px">
        <span class="lvl l1">TĐ</span><small>Tổng đoạn</small>
        <span class="lvl l2">PĐ</span><small>Phân đoạn</small>
        <span class="lvl l3p">Panel</span><span class="lvl l3c">Cụm</span><small>cụm chi tiết</small>
      </div>
      <div class="tree">${s(i.ship)}</div>
      <div class="group" style="margin-top:10px">
        <div class="kv">
          <span>Lpp × B × D</span><span>${At.L} × ${At.B} × ${At.D} m</span>
          <span>Chiều chìm</span><span>${At.T} m</span>
          <span>Đáy đôi</span><span>cao ${At.hdb*1e3} mm (Fr10 – Fr90)</span>
          <span>Khoảng sườn</span><span>${At.spacing*1e3} mm (Fr0 – Fr100)</span>
          <span>Hệ kết cấu</span><span>Hỗn hợp: đáy, boong giữa tàu hệ dọc; mạn hệ ngang; mũi – đuôi hệ ngang</span>
        </div>
      </div>`};t.addEventListener("click",s=>{const r=s.target.closest("[data-tw]"),o=s.target.closest("[data-play]");if(o){i.playAssembly(i.node(o.dataset.play)),Ha("asm");return}if(r&&r.textContent.trim()!=="·"){const c=r.dataset.tw;e.has(c)?e.delete(c):e.add(c),n();return}const a=s.target.closest(".node");if(a){const c=i.node(a.dataset.id);e.add(a.dataset.id),i.setScope(c)}}),i.on("scope",n),n()}function J_(i){const t=document.getElementById("tab-view"),e=i.viewer;t.innerHTML=`
    <div class="group">
      <h3>Tô màu</h3>
      <select id="colorMode" style="width:100%">${Object.entries(R_).map(([a,c])=>`<option value="${a}">${c}</option>`).join("")}</select>
    </div>
    <div class="group">
      <h3>Nhóm kết cấu hiển thị</h3>
      ${Object.entries(qi).map(([a,c])=>`<label class="chk"><input type="checkbox" data-cat="${a}" checked>
        <span class="swatch" style="background:#${c.color.toString(16).padStart(6,"0")}"></span>${c.name}</label>`).join("")}
      <div class="row" style="margin-top:6px">
        <button class="btn" id="hideShell">Ẩn tôn vỏ (xem khung xương)</button>
        <button class="btn" id="showAll">Hiện tất cả</button>
      </div>
    </div>
    <div class="group">
      <h3>Mặt cắt</h3>
      <label class="chk"><input type="checkbox" id="cutX"> Cắt ngang tàu tại sườn <b id="cutXv" style="margin-left:auto">Fr50</b></label>
      <input type="range" id="cutXs" min="0" max="${At.L}" step="${At.spacing}" value="35">
      <label class="chk"><input type="checkbox" id="cutZ"> Cắt dọc tại mặt phẳng dọc tâm (bỏ mạn phải)</label>
      <label class="chk"><input type="checkbox" id="cutY"> Cắt bằng ở độ cao <b id="cutYv" style="margin-left:auto">z = 3.0 m</b></label>
      <input type="range" id="cutYs" min="0" max="15" step="0.1" value="3">
    </div>
    <div class="group">
      <h3>Tách rời (exploded view)</h3>
      <p class="note">Áp dụng cho phạm vi đang chọn trong cây kết cấu.</p>
      <select id="exLevel" style="width:100%">
        <option value="1">Tách các tổng đoạn</option><option value="2">Tách đến phân đoạn</option>
        <option value="3">Tách đến panel / cụm chi tiết</option><option value="4" selected>Tách đến từng chi tiết</option>
      </select>
      <input type="range" id="exAmt" min="0" max="1" step="0.01" value="0">
    </div>
    <div class="group">
      <h3>Tuỳ chọn</h3>
      <label class="chk"><input type="checkbox" id="optEdges" checked> Hiện đường mép tôn / đường hàn</label>
      <label class="chk"><input type="checkbox" id="optGhost" checked> Hiện mờ phần ngoài phạm vi chọn</label>
      <label class="chk"><input type="checkbox" id="optFollow" checked> Camera bám theo bước lắp ráp</label>
      <label class="chk"><input type="checkbox" id="optDock" checked> Hiện ụ/đà và đế kê</label>
      <label class="chk">Tốc độ di chuyển khi đi trong tàu <b id="wsv" style="margin-left:auto">3 m/s</b></label>
      <input type="range" id="walkSpeed" min="0.5" max="10" step="0.5" value="3">
    </div>`;const n=a=>t.querySelector("#"+a);n("colorMode").onchange=a=>i.setColorMode(a.target.value),t.querySelectorAll("[data-cat]").forEach(a=>a.onchange=()=>i.setCategory(a.dataset.cat,a.checked));const s=(a,c)=>{const l=t.querySelector(`[data-cat=${a}]`);l.checked=c,i.setCategory(a,c)};i.showCats=a=>{t.querySelectorAll("[data-cat]").forEach(c=>c.checked=!a.includes(c.dataset.cat)),i.hiddenCats=new Set(a),i.refreshVisibility()},n("hideShell").onclick=()=>{s("shell",!1),s("deck",!1)},n("showAll").onclick=()=>Object.keys(qi).forEach(a=>s(a,!0));const r=()=>{const a=+n("cutXs").value;n("cutXv").textContent=`Fr${Math.round(a/At.spacing)}`,n("cutYv").textContent=`z = ${(+n("cutYs").value).toFixed(1)} m`,e.setClip({x:n("cutX").checked?a-At.L/2:null,z:n("cutZ").checked,y:n("cutY").checked?+n("cutYs").value:null})};["cutX","cutZ","cutY"].forEach(a=>n(a).onchange=r),["cutXs","cutYs"].forEach(a=>n(a).oninput=()=>{a==="cutXs"?n("cutX").checked=!0:n("cutY").checked=!0,r()}),i.setCut=a=>{"x"in a&&(n("cutX").checked=a.x!==null,a.x!==null&&(n("cutXs").value=a.x)),"z"in a&&(n("cutZ").checked=a.z),"y"in a&&(n("cutY").checked=a.y!==null,a.y!==null&&(n("cutYs").value=a.y)),r()};const o=()=>{i.player.unload(),X_(i.scope,+n("exLevel").value,+n("exAmt").value)};n("exLevel").onchange=o,n("exAmt").oninput=o,i.on("scope",()=>{n("exAmt").value=0}),n("optEdges").onchange=a=>i.setEdges(a.target.checked),n("optGhost").onchange=a=>i.setGhost(a.target.checked),n("optFollow").onchange=a=>i.follow=a.target.checked,n("optDock").onchange=a=>e.dock.visible=a.target.checked,n("walkSpeed").oninput=a=>{e.walkSpeed=+a.target.value,n("wsv").textContent=`${a.target.value} m/s`}}function Q_(i){const t=document.getElementById("tab-glo");t.innerHTML=`<h3>Thuật ngữ kết cấu thân tàu</h3>
    <p class="note">Nhấp vào thuật ngữ để tô sáng tất cả chi tiết cùng loại trên mô hình 3D.</p>
    <input class="search" id="gloQ" placeholder="Tìm: sườn, frame, đà ngang…">
    <div id="gloList"></div>
    <div class="group" style="margin-top:10px"><h3>Cấp lắp ráp</h3>
    ${F0.map((s,r)=>`<div style="font-size:12.5px;padding:2px 0"><b>${r}.</b> ${s}</div>`).join("")}</div>`;const e=t.querySelector("#gloList"),n=(s="")=>{s=s.toLowerCase(),e.innerHTML=Object.entries(pa).filter(([,r])=>!s||`${r.name} ${r.en} ${r.desc}`.toLowerCase().includes(s)).map(([r,o])=>`<div class="glo-item" data-kind="${r}">
        <div class="t"><span class="swatch" style="background:#${qi[o.cat].color.toString(16).padStart(6,"0")}"></span> ${zt(o.name)}</div>
        <div class="e">${zt(o.en)} · ${zt(o.spec)}</div><div class="d">${zt(o.desc)}</div></div>`).join("")};t.querySelector("#gloQ").oninput=s=>n(s.target.value),e.addEventListener("click",s=>{const r=s.target.closest("[data-kind]");if(!r)return;const o=i.highlightKind(r.dataset.kind).filter(a=>a.visible);i.scope!==i.ship&&i.setScope(i.ship,{focus:!1}),i.toast(o.length?`Đã tô sáng ${o.length} chi tiết “${pa[r.dataset.kind].name}”`:"Loại chi tiết này đang bị ẩn hoặc không có trong mô hình"),o.length&&i.viewer.focusObjects(o.slice(0,400))}),n()}const tv=["Tàu","Tổng đoạn","Phân đoạn","","Chi tiết"];function ev(i){const t=i.viewer,e=h=>document.getElementById(h),n=e("camModes");n.addEventListener("click",h=>{const d=h.target.dataset.mode;d&&(d==="tour"?t.startTour("hold"):d==="walk"?t.walkTo(ze[0].pos,ze[0].look):t.setMode("orbit"))}),t.on("mode",h=>{n.querySelectorAll("button").forEach(d=>d.classList.toggle("on",d.dataset.mode===h)),e("crosshair").classList.toggle("hidden",h!=="walk"),e("tourBar").classList.toggle("hidden",h!=="tour"),r(!1)});const s=e("viewPreset");s.innerHTML=`<option value="">Góc nhìn…</option>
    <optgroup label="Quan sát ngoài">${Object.entries(va).map(([h,d])=>`<option value="v:${h}">${d.name}</option>`).join("")}</optgroup>
    <optgroup label="Đi trong tàu – vị trí xuất phát">${ze.map((h,d)=>`<option value="w:${d}">${h.name}</option>`).join("")}</optgroup>
    <optgroup label="Tham quan tự động">${xr.map(h=>`<option value="t:${h.id}">${h.name}</option>`).join("")}</optgroup>`,s.onchange=()=>{const[h,d]=s.value.split(":");if(s.value="",h==="v"){const u=va[d];u.cutX!==void 0&&i.setCut&&i.setCut({x:u.cutX}),t.flyTo(new C(...u.pos),new C(...u.target))}else h==="w"?t.walkTo(ze[d].pos,ze[d].look):h==="t"&&t.startTour(d)};const r=h=>{const d=e("walkHint");if(t.mode!=="walk"){d.classList.add("hidden");return}d.classList.remove("hidden"),d.innerHTML=h?"<kbd>W</kbd><kbd>A</kbd><kbd>S</kbd><kbd>D</kbd> di chuyển · <kbd>E</kbd>/<kbd>Q</kbd> lên/xuống · <kbd>Shift</kbd> nhanh · nhấp chuột: nhận diện chi tiết tại tâm · <kbd>Esc</kbd> nhả chuột":`<b>Nhấp vào khung nhìn</b> để điều khiển camera bằng chuột (xoay đầu nhìn quanh).<br>
         <select id="walkStart">${ze.map((f,g)=>`<option value="${g}">${f.name}</option>`).join("")}</select>`;const u=d.querySelector("#walkStart");u&&(u.value=i._walkIdx||0,u.onchange=()=>{i._walkIdx=+u.value,t.walkTo(ze[u.value].pos,ze[u.value].look)})};t.on("walklock",r);const o=e("tourBar");t.on("tour",h=>{o.innerHTML=`<div class="row"><b>${zt(h.def.name)}</b>
      <select id="tourSel" style="margin-left:auto">${xr.map(d=>`<option value="${d.id}" ${d.id===h.def.id?"selected":""}>${d.name}</option>`).join("")}</select></div>
      <div class="desc">${zt(h.def.desc)}</div>
      <input type="range" id="tourU" min="0" max="1" step="0.001" value="0">
      <div class="row"><button class="btn primary" id="tourPP">❚❚ Tạm dừng</button>
        <select id="tourSp"><option value="0.5">0.5×</option><option value="1" selected>1×</option><option value="2">2×</option></select>
        <button class="btn" id="tourStop" style="margin-left:auto">✕ Kết thúc tham quan</button></div>`,o.querySelector("#tourSel").onchange=d=>t.startTour(d.target.value),o.querySelector("#tourPP").onclick=()=>{h.paused=!h.paused,h.u>=1&&(h.u=0,h.paused=!1)},o.querySelector("#tourSp").onchange=d=>h.speedMul=+d.target.value,o.querySelector("#tourU").oninput=d=>{h.u=+d.target.value},o.querySelector("#tourStop").onclick=()=>t.stopTour()}),t.on("tourprogress",h=>{const d=o.querySelector("#tourU"),u=o.querySelector("#tourPP");d&&document.activeElement!==d&&(d.value=h.u),u&&(u.textContent=h.paused?"▶ Tiếp tục":"❚❚ Tạm dừng")});const a=e("hoverTip");t.on("hover",(h,d,u)=>{if(!h){a.classList.add("hidden");return}a.classList.remove("hidden"),a.textContent=h.userData.name,a.style.left=`${d+14}px`,a.style.top=`${u+10}px`});const c=e("scopeBadge");i.on("scope",h=>{if(h===i.ship){c.classList.add("hidden");return}c.classList.remove("hidden"),c.innerHTML=`<span>Đang cô lập: <b>${zt(h.userData.name)}</b></span><button class="btn" id="scopeAll">Toàn tàu</button>`,c.querySelector("#scopeAll").onclick=()=>i.setScope(i.ship)});const l=e("infoPanel");i.on("select",h=>{if(!h||!e("scenarioPanel").classList.contains("hidden")){l.classList.add("hidden");return}const d=h.userData,u=Ji(d.kind),f=B0(h).slice(0,-1);l.classList.remove("hidden"),l.innerHTML=`<button class="close" id="infoX">×</button>
      <h4>${zt(d.name)}</h4>
      <div class="en">${zt(u.name)} · ${zt(u.en)}</div>
      <div class="kv">
        <span>Mã chi tiết</span><span>${zt(d.code)}</span>
        <span>Quy cách</span><span>${zt(d.spec||u.spec)}</span>
        <span>Nhóm</span><span><span class="swatch" style="background:#${qi[u.cat].color.toString(16).padStart(6,"0")}"></span> ${qi[u.cat].name}</span>
      </div>
      <p>${zt(u.desc)}</p>
      <div class="crumb"><b>Thuộc:</b><br>${f.map(g=>{const _=g.userData.level===Lt.ASSY?g.userData.type==="panel"?"Panel":"Cụm chi tiết":tv[g.userData.level];return`${"&nbsp;&nbsp;".repeat(g.userData.level)}↳ ${_}: <a data-id="${g.userData.id}">${zt(g.userData.name)}</a>`}).join("<br>")}</div>
      <div class="row">
        <button class="btn" id="infoKind">Tô sáng cùng loại</button>
        <button class="btn" id="infoIso">Cô lập ${f.at(-1).userData.type==="panel"?"panel":"cụm"}</button>
        <button class="btn primary" id="infoAsm">Xem lắp ráp phân đoạn</button>
      </div>`,l.querySelector("#infoX").onclick=()=>i.select(null),l.querySelectorAll("[data-id]").forEach(g=>g.onclick=()=>i.setScope(i.node(g.dataset.id))),l.querySelector("#infoKind").onclick=()=>{const g=i.highlightKind(d.kind);i.toast(`${g.length} chi tiết “${u.name}” trên toàn tàu`)},l.querySelector("#infoIso").onclick=()=>i.setScope(f.at(-1)),l.querySelector("#infoAsm").onclick=()=>{i.playAssembly(i.blockOf(h)),Ha("asm")}}),e("helpBtn").onclick=()=>Ml(i);try{localStorage.getItem("ktt_help_seen")||(Ml(i),localStorage.setItem("ktt_help_seen","1"))}catch{}}function Ml(i){const t=i.parts.length;$_(`<h2>Hướng dẫn sử dụng</h2>
    <p>Ứng dụng mô phỏng <b>kết cấu thân tàu vỏ thép</b> của một tàu hàng khô (Lpp ${At.L} m, B ${At.B} m, D ${At.D} m) gồm <b>${t} chi tiết</b> được dựng theo kết cấu thực:
    tôn vỏ, dầm dọc, đà ngang có lỗ khoét, sống chính, sống phụ, sườn thường, sườn khỏe, mã, vách, miệng hầm…</p>
    <table>
      <tr><td><b>Quan sát ngoài</b></td><td>Chuột trái: xoay · Chuột phải: dời · Cuộn: thu phóng · Nhấp vào chi tiết để xem tên, quy cách, chức năng và thuộc panel/phân đoạn/tổng đoạn nào.</td></tr>
      <tr><td><b>Đi trong tàu</b></td><td>Nhấp khung nhìn để khoá chuột, <kbd>W A S D</kbd> di chuyển, <kbd>E</kbd>/<kbd>Q</kbd> lên/xuống, <kbd>Shift</kbd> chạy nhanh, nhấp để nhận diện chi tiết ở tâm, <kbd>Esc</kbd> để thoát. Chọn vị trí xuất phát: hầm hàng, đáy đôi, boong, khoang mũi, buồng máy.</td></tr>
      <tr><td><b>Tham quan tự động</b></td><td>Camera di chuyển theo tuyến: vòng quanh tàu, trong hầm hàng, chui trong đáy đôi qua lỗ khoét, dọc boong.</td></tr>
      <tr><td><b>Cấu trúc</b></td><td>Cây phân cấp Tàu → Tổng đoạn → Phân đoạn → Panel/Cụm chi tiết → Chi tiết. Nhấp để cô lập; ▶ để mô phỏng lắp ráp.</td></tr>
      <tr><td><b>Lắp ráp</b></td><td>Mô phỏng từng bước 6 giai đoạn: Chi tiết → Panel → Cụm chi tiết → Phân đoạn → Tổng đoạn → Đấu nối thành tàu.</td></tr>
      <tr><td><b>Hiển thị</b></td><td>Ẩn/hiện nhóm kết cấu (ví dụ ẩn tôn vỏ để thấy khung xương), mặt cắt ngang/dọc/bằng, tách rời (exploded), chế độ tô màu.</td></tr>
      <tr><td><b>Thực hành</b></td><td>Các bài thực hành có nhiệm vụ trên mô hình 3D, câu hỏi trắc nghiệm, sắp xếp trình tự – có chấm điểm và đáp án giải thích.</td></tr>
    </table>
    <p style="color:var(--muted);font-size:12.5px">Mô hình mang tính học tập: kích thước, quy cách được đơn giản hoá nhưng tuân theo nguyên tắc bố trí kết cấu thực tế của tàu hàng.</p>
    <button class="btn primary" data-close>Bắt đầu</button>`)}const Sl=[{id:"s1",title:"Bài 1. Tổng quan: tàu được chia thành tổng đoạn, phân đoạn",level:"Cơ bản",time:"10 phút",goals:["Nắm được các cấp lắp ráp thân tàu","Nhận biết tổng đoạn, phân đoạn trên mô hình","Hiểu ý nghĩa của phương pháp đóng tàu theo phân đoạn"],steps:[{type:"info",title:"Con tàu được tạo thành như thế nào?",setup:{scope:"ship",view:"overview"},text:`Thân tàu thép không được đóng từ một khối duy nhất. Nó được chia thành nhiều cấp:<br>
        <b>Chi tiết</b> (tấm tôn, thép hình đã cắt) → <b>Panel</b> và <b>Cụm chi tiết</b> → <b>Phân đoạn</b> (đáy, mạn, boong, vách…) → <b>Tổng đoạn</b> (ghép nhiều phân đoạn) → <b>Đấu nối</b> các tổng đoạn trên đà/ụ thành con tàu.<br><br>
        Hãy xoay mô hình, mở tab <i>Cấu trúc</i> để xem cây phân cấp, sau đó bấm <b>Tiếp</b>.`},{type:"mcq",q:"Thân tàu mô phỏng (không kể thượng tầng và thiết bị) được chia thành bao nhiêu tổng đoạn vòng?",options:["3 tổng đoạn","4 tổng đoạn","5 tổng đoạn","6 tổng đoạn"],answer:2,explain:"Gồm 5 tổng đoạn: TĐ1 (đuôi), TĐ2, TĐ3, TĐ4 (vùng hầm hàng – thân ống) và TĐ5 (mũi). Thượng tầng là tổng đoạn TĐ6 lắp trên boong."},{type:"mcq",q:"Định nghĩa nào đúng nhất về “phân đoạn” (block)?",options:["Một chi tiết riêng lẻ được cắt từ tôn tấm","Một phần thân tàu gồm nhiều panel, cụm chi tiết được lắp ráp và hàn hoàn chỉnh trên bệ, có kích thước – khối lượng phù hợp sức nâng của cẩu","Toàn bộ thân tàu sau khi hạ thuỷ","Một tấm tôn đã được hàn nẹp gia cường"],answer:1,explain:"Phân đoạn là đơn vị lắp ráp trung gian. Tấm tôn có hàn nẹp chỉ là panel; chi tiết là cấp nhỏ nhất."},{type:"order",q:"Sắp xếp các cấp lắp ráp thân tàu từ nhỏ đến lớn:",items:["Chi tiết","Panel / Cụm chi tiết","Phân đoạn","Tổng đoạn","Con tàu (đấu nối trên đà)"],explain:"Đi từ chi tiết → panel/cụm chi tiết → phân đoạn → tổng đoạn → đấu nối thành tàu."},{type:"info",title:"Quan sát tổng đoạn TĐ3",setup:{scope:"gb3"},text:"Tổng đoạn TĐ3 (hầm hàng số 2) đang được cô lập. Mở tab <i>Hiển thị → Tách rời</i>, chọn “Tách các phân đoạn” và kéo thanh trượt để thấy các phân đoạn tạo thành tổng đoạn này."},{type:"multi",q:"Tổng đoạn vòng TĐ3 gồm những phân đoạn nào? (chọn tất cả đáp án đúng)",options:["Phân đoạn đáy đôi","Phân đoạn mạn trái","Phân đoạn mạn phải","Phân đoạn boong","Phân đoạn thượng tầng","Phân đoạn vách ngang","Phân đoạn sống mũi"],answer:[0,1,2,3,5],explain:"Một tổng đoạn vòng (ring block) gồm đáy đôi, hai mạn, boong và vách ngang. Thượng tầng và sống mũi thuộc tổng đoạn khác."},{type:"mcq",q:"Lợi ích chính của phương pháp đóng tàu theo phân đoạn – tổng đoạn là gì?",options:["Không cần bản vẽ thiết kế kết cấu","Chuyển phần lớn khối lượng công việc vào xưởng: hàn ở tư thế thuận lợi, tự động hoá, làm song song nhiều phân đoạn, rút ngắn thời gian chiếm đà","Giảm chiều dày tôn vỏ","Không phải thử kín các mối hàn"],answer:1,explain:"Đóng tàu theo phân đoạn giúp thi công song song, cơ giới hoá, nâng cao chất lượng mối hàn và giảm mạnh thời gian tàu nằm trên đà."}]},{id:"s2",title:"Bài 2. Kết cấu đáy đôi",level:"Cơ bản",time:"15 phút",goals:["Nhận biết các chi tiết của đáy đôi","Phân biệt hệ thống kết cấu dọc ở đáy","Hiểu công dụng lỗ khoét, đà ngang kín nước"],steps:[{type:"info",title:"Phân đoạn đáy đôi",setup:{scope:"gb3.db",cut:{x:35},cam:{pos:[24,9,6],target:[35,0,.6]}},text:`Đáy đôi gồm hai lớp tôn: <b>tôn đáy ngoài</b> và <b>tôn đáy trên</b>, liên kết bởi <b>sống chính</b> (dọc tâm), <b>sống phụ</b> và <b>đà ngang</b>. Khoang giữa hai lớp tôn dùng làm két dằn, két nhiên liệu.<br><br>
        Mặt cắt ngang đang đặt tại Fr50 để bạn quan sát bên trong.`},{type:"pick",prompt:"Nhấp chọn <b>sống chính</b> trên mô hình.",kinds:["center_girder"],explain:"Sống chính nằm ở mặt phẳng dọc tâm, chạy liên tục suốt chiều dài đáy đôi, nối tôn ky với tôn đáy trên."},{type:"pick",prompt:"Nhấp chọn một <b>đà ngang đáy đặc</b> (tấm ngang có lỗ khoét).",kinds:["floor"],explain:"Đà ngang đặc là tấm đứng đặt ngang tàu, cách nhau 2 khoảng sườn trong mô hình này, có lỗ khoét giảm trọng lượng."},{type:"pick",prompt:"Mặt cắt bằng đã bỏ đi tôn đáy trên. Hãy chọn một <b>dầm dọc đáy</b>.",kinds:["bottom_long"],setup:{scope:"gb3.db",cut:{x:null,y:.95},cam:{pos:[26,-6,9],target:[33,0,0]}},explain:"Dầm dọc đáy là thép hình chữ L hàn lên tôn đáy ngoài, chạy dọc tàu xuyên qua các đà ngang."},{type:"pick",prompt:"Nhìn từ dưới đáy lên, hãy chọn <b>tôn giữa đáy (tôn ky)</b>.",kinds:["keel_plate"],setup:{scope:"gb3.db",cut:{y:null},cam:{pos:[26,-10,-4],target:[35,0,0]}},explain:"Tôn ky là dải tôn đáy ở giữa, dày hơn các tấm đáy khác (14 mm so với 12 mm)."},{type:"mcq",q:"Đáy đôi vùng giữa tàu trong mô hình được kết cấu theo hệ thống nào?",options:["Hệ thống ngang","Hệ thống dọc","Không theo hệ thống nào","Hệ thống ngang có sườn khỏe"],answer:1,explain:"Có dầm dọc đáy và dầm dọc đáy trên chạy liên tục, đà ngang đặt thưa (2 khoảng sườn) → hệ thống kết cấu dọc. Hệ dọc phù hợp vùng giữa tàu chịu uốn chung lớn."},{type:"multi",q:"Lỗ khoét trên đà ngang và sống phụ dùng để làm gì? (chọn tất cả đáp án đúng)",options:["Giảm trọng lượng kết cấu","Cho người chui qua kiểm tra, bảo dưỡng két","Lưu thông chất lỏng và không khí giữa các ô két","Làm tăng độ bền của đà ngang","Cho dầm dọc đi xuyên qua (lỗ khoét nhỏ ở mép)"],answer:[0,1,2,4],explain:"Lỗ khoét làm giảm (không tăng) độ bền, vì vậy được đặt ở vùng ứng suất nhỏ, có kích thước giới hạn theo quy phạm và mép lỗ được làm trơn."},{type:"mcq",q:"Vì sao ngay dưới vách ngang kín nước phải bố trí đà ngang kín nước (không khoét lỗ)?",options:["Để tiết kiệm vật liệu","Để chia đáy đôi thành các két riêng và đảm bảo tính kín nước liên tục từ vách xuống đáy","Để làm lối đi lại trong đáy đôi","Vì vách ngang không chịu lực"],answer:1,explain:"Đà ngang kín nước kết hợp với vách ngang chia thân tàu thành các khoang kín nước từ đáy đến boong."},{type:"tour",tour:"db",text:"Bấm nút bên dưới để camera <b>chui vào trong đáy đôi</b>, đi qua các lỗ khoét trên đà ngang và sống phụ như người thợ kiểm tra két."}]},{id:"s3",title:"Bài 3. Kết cấu mạn và mã liên kết",level:"Cơ bản",time:"12 phút",goals:["Nhận biết sườn thường, sườn khỏe, sống dọc mạn, mã","Xác định hệ thống kết cấu mạn"],steps:[{type:"info",title:"Phân đoạn mạn phải TĐ3",setup:{scope:"gb3.ss",cam:{pos:[30,-2,4],target:[35,6,3.5]}},text:"Camera đang nhìn từ phía trong ra mạn phải. Tôn mạn được gia cường bởi <b>sườn thường</b> (mỗi khoảng sườn) và <b>sườn khỏe</b> (mỗi 4 khoảng sườn), cùng <b>sống dọc mạn</b> ở giữa chiều cao mạn."},{type:"pick",prompt:"Chọn một <b>sườn thường</b>.",kinds:["frame"],explain:"Sườn thường là thép hình L 180×90×9 đặt tại mỗi sườn."},{type:"pick",prompt:"Chọn một <b>sườn khỏe</b>.",kinds:["web_frame"],explain:"Sườn khỏe có tiết diện chữ T cao 550 mm, làm gối tựa cho sống dọc mạn."},{type:"pick",prompt:"Chọn <b>sống dọc mạn</b>.",kinds:["side_stringer"],explain:"Sống dọc mạn chạy dọc tàu, tựa lên các sườn khỏe, giảm nhịp của sườn thường."},{type:"pick",prompt:"Chọn một <b>mã hông</b> (tấm tam giác ở chân sườn).",kinds:["bilge_bracket"],explain:"Mã hông nối chân sườn với tôn đáy trên."},{type:"mcq",q:"Trong mô hình, khoảng cách giữa hai sườn khỏe liên tiếp là bao nhiêu?",options:["1 khoảng sườn (0,7 m)","2 khoảng sườn (1,4 m)","4 khoảng sườn (2,8 m)","10 khoảng sườn (7 m)"],answer:2,explain:"Sườn khỏe đặt tại các sườn số chia hết cho 4: Fr40, Fr44, Fr48… → 4 × 0,7 = 2,8 m."},{type:"mcq",q:"Mạn tàu trong mô hình được kết cấu theo hệ thống nào?",options:["Hệ thống dọc, vì có sống dọc mạn","Hệ thống ngang, vì kết cấu chính chịu áp lực nước là sườn thường đặt tại mỗi khoảng sườn","Hệ thống hỗn hợp ngay trong cùng mạn","Không xác định được"],answer:1,explain:"Hệ thống kết cấu được xác định bởi kết cấu thường (đặt dày) trực tiếp gia cường tôn: ở mạn là các sườn ngang → hệ ngang. Sống dọc mạn chỉ là kết cấu khỏe."},{type:"mcq",q:"Chức năng chính của mã hông là gì?",options:["Trang trí","Liên kết chân sườn với đáy đôi, truyền mô-men uốn, giảm tập trung ứng suất tại góc","Làm lối thoát nước","Đỡ nắp hầm hàng"],answer:1,explain:"Mã tạo liên kết cứng giữa các kết cấu giao nhau, đảm bảo khung ngang (đà ngang – sườn – xà) làm việc liên tục."}]},{id:"s4",title:"Bài 4. Kết cấu boong và miệng hầm hàng",level:"Trung bình",time:"12 phút",goals:["Nhận biết kết cấu boong vùng hầm hàng","So sánh hệ thống kết cấu boong giữa tàu và vùng mũi"],steps:[{type:"info",title:"Phân đoạn boong TĐ3",setup:{scope:"gb3.dk",view:"overview"},text:"Miệng hầm hàng là lỗ khoét lớn trên boong, phá vỡ tính liên tục của kết cấu boong. Vì vậy xung quanh miệng hầm có <b>thành miệng hầm</b>, <b>sống dọc miệng hầm</b> và <b>xà ngang đầu miệng hầm</b> để bù đắp độ bền."},{type:"pick",prompt:"Chọn <b>thành miệng hầm</b>.",kinds:["hatch_coaming"],explain:"Thành miệng hầm cao 1,2 m, ngăn nước tràn vào hầm và là gối đỡ nắp hầm."},{type:"pick",prompt:"Chọn một <b>mã chống thành miệng hầm</b>.",kinds:["coaming_stay"],explain:"Mã chống giữ ổn định cho thành miệng hầm."},{type:"pick",prompt:"Camera đã chuyển xuống dưới boong. Chọn một <b>dầm dọc boong</b>.",kinds:["deck_long"],setup:{scope:"gb3.dk",cam:{pos:[30,2,3.5],target:[36,4.6,6.5]}},explain:"Dầm dọc boong L 160×80×8 nằm dưới tôn boong, ở hai bên miệng hầm."},{type:"pick",prompt:"Chọn <b>sống dọc miệng hầm</b>.",kinds:["hatch_girder"],explain:"Là phần kéo dài xuống dưới boong của thành miệng hầm dọc."},{type:"pick",prompt:"Chọn <b>xà ngang đầu miệng hầm</b>.",kinds:["hatch_end_beam"],explain:"Xà ngang khỏe tại hai đầu miệng hầm."},{type:"mcq",q:"Vì sao tôn mép boong và tôn mép mạn thường dày hơn các tấm lân cận?",options:["Để dễ hàn","Vì nằm xa trục trung hoà nhất của mặt cắt ngang nên chịu ứng suất pháp do uốn chung lớn nhất","Vì chịu áp lực nước lớn nhất","Để chống ăn mòn do nước mưa"],answer:1,explain:"Ứng suất uốn chung tỷ lệ với khoảng cách tới trục trung hoà; góc boong – mạn còn có tập trung ứng suất."},{type:"mcq",q:"Quan sát boong tổng đoạn mũi. Boong vùng mũi kết cấu theo hệ thống nào?",setup:{scope:"gb5.dk",cam:{pos:[54,-3,3.8],target:[62,1,6.4]}},options:["Hệ thống dọc: dầm dọc boong + xà ngang khỏe","Hệ thống ngang: xà ngang boong ở mỗi sườn + sống dọc boong","Không có kết cấu gia cường","Chỉ có thành miệng hầm"],answer:1,explain:"Ở vùng mút, mô-men uốn chung nhỏ, tải cục bộ lớn → dùng hệ ngang. Cả tàu dùng hệ thống kết cấu hỗn hợp."}]},{id:"s5",title:"Bài 5. Vách ngang kín nước và vách chống va",level:"Trung bình",time:"12 phút",goals:["Nhận biết vách ngang, nẹp vách, vách chống va","Hiểu yêu cầu bố trí vách theo quy phạm"],steps:[{type:"info",title:"Tổng đoạn mũi TĐ5",setup:{scope:"gb5",hide:["shell","deck"],view:"front"},text:"Tôn vỏ và boong đã được ẩn để thấy các vách bên trong tổng đoạn mũi: vách ngang Fr80 và <b>vách chống va</b> Fr90."},{type:"pick",prompt:"Chọn <b>vách chống va</b>.",kinds:["collision_bhd"],explain:"Vách chống va là vách kín nước đầu tiên tính từ mũi (Fr90, cách mũi khoảng 7 m ≈ 0,1L trong mô hình)."},{type:"pick",prompt:"Chọn một <b>nẹp vách</b>.",kinds:["bhd_stiffener"],explain:"Nẹp vách là thép hình đặt đứng, cách nhau 700 mm."},{type:"mcq",q:"Mô hình có bao nhiêu vách ngang kín nước (kể cả vách khoang đuôi và vách chống va)?",setup:{scope:"ship",hide:["shell","deck"],view:"side"},options:["4","5","6","8"],answer:2,explain:"Fr10 (vách khoang đuôi), Fr20 (vách mũi buồng máy), Fr40, Fr60, Fr80 (vách hầm hàng), Fr90 (vách chống va) → 6 vách."},{type:"mcq",q:"Vì sao dải tôn dưới của vách ngang dày hơn dải tôn trên?",options:["Để vách nặng hơn, tàu ổn định hơn","Vì áp lực thuỷ tĩnh khi khoang bên cạnh bị ngập tăng theo chiều sâu","Vì dải dưới phải chịu nắp hầm","Không có lý do kỹ thuật"],answer:1,explain:"Áp lực p = ρgh tăng tuyến tính theo chiều sâu, nên tôn vách phía dưới chịu tải lớn hơn."},{type:"multi",q:"Vách ngang kín nước có những chức năng nào?",options:["Chia tàu thành các khoang kín nước, đảm bảo tính chống chìm","Tăng độ cứng ngang của thân tàu","Ngăn cháy lan giữa các khoang","Thay thế hoàn toàn cho sườn","Làm gối tựa cho kết cấu dọc boong, đáy"],answer:[0,1,2,4],explain:"Vách không thay thế sườn; nó là kết cấu ngang khỏe, kín nước, làm gối tựa cho kết cấu dọc."},{type:"walk",prompt:"Chuyển sang chế độ <b>đi trong tàu</b> và di chuyển vào <b>khoang mũi</b> (phía trước vách chống va).",setup:{scope:"ship",walk:3},region:{x:[63.3,70],y:[-5,5],z:[.3,6.4]},explain:"Bạn đang ở trong khoang mũi (fore peak) – thường dùng làm két dằn mũi."}]},{id:"s6",title:"Bài 6. Chế tạo panel và lắp ráp phân đoạn đáy đôi",level:"Trung bình",time:"15 phút",goals:["Hiểu quy trình chế tạo panel phẳng","Hiểu trình tự lắp ráp phân đoạn đáy đôi (phương pháp lắp úp)"],steps:[{type:"info",title:"Từ chi tiết đến panel",setup:{scope:"gb3.db.shell"},text:"Panel là tấm tôn lớn được ghép từ nhiều tấm tôn và gia cường bằng thép hình. Panel phẳng thường được chế tạo trên <b>dây chuyền panel</b>: hàn giáp mối tự động một phía, sau đó lắp và hàn nẹp bằng máy hàn góc tự động."},{type:"watch",scope:"gb3.db.shell",text:"Xem mô phỏng chế tạo <b>panel tôn đáy ngoài</b>: các tấm tôn được ghép lại rồi hàn các dầm dọc đáy."},{type:"order",q:"Sắp xếp trình tự chế tạo một panel phẳng:",items:["Lấy dấu, cắt tôn và thép hình (CNC)","Ghép và hàn giáp mối các tấm tôn thành tấm lớn","Lấy dấu vị trí các dầm dọc/nẹp trên tấm","Lắp và hàn các dầm dọc (nẹp) lên tấm","Nắn sửa biến dạng, kiểm tra kích thước"],explain:"Phải hàn giáp mối các tấm trước để có tấm lớn phẳng, sau đó mới lắp nẹp; cuối cùng nắn biến dạng hàn."},{type:"watch",scope:"gb3.db",text:"Xem mô phỏng lắp ráp <b>phân đoạn đáy đôi</b> từ các panel và cụm chi tiết."},{type:"mcq",q:"Trong thực tế, phân đoạn đáy đôi thường được lắp úp trên panel tôn đáy trên rồi lật lại. Lợi ích chính là gì?",options:["Không cần cẩu","Panel tôn đáy trên phẳng làm bệ lắp ráp, phần lớn mối hàn ở tư thế hàn sấp, dễ cơ giới hoá","Giảm số lượng đà ngang","Không phải hàn sống chính"],answer:1,explain:"Tôn đáy ngoài có vùng cong (hông) nên khó làm bệ; dùng tôn đáy trên phẳng làm bệ thuận lợi hơn, hàn sấp năng suất và chất lượng cao."},{type:"order",q:"Sắp xếp trình tự lắp phân đoạn đáy đôi theo phương pháp lắp úp:",items:["Đặt panel tôn đáy trên lên bệ (mặt có dầm dọc quay lên)","Lắp sống chính và các sống phụ","Lắp các đà ngang đáy, hàn liên kết sống – đà","Lắp panel tôn đáy ngoài và hàn","Lật phân đoạn, hàn hoàn thiện và thử kín"],explain:"Khung sống – đà được dựng trên panel tôn đáy trên, đậy panel đáy ngoài, rồi lật để hàn phía còn lại."},{type:"mcq",q:"Phân đoạn đáy đôi thuộc loại phân đoạn nào?",options:["Phân đoạn phẳng","Phân đoạn khối (không gian)","Panel","Cụm chi tiết"],answer:1,explain:"Đáy đôi có hai lớp tôn và kết cấu đứng ở giữa tạo thành khối không gian kín → phân đoạn khối."}]},{id:"s7",title:"Bài 7. Hình thành tổng đoạn và đấu nối thành tàu",level:"Nâng cao",time:"15 phút",goals:["Hiểu trình tự ghép phân đoạn thành tổng đoạn","Hiểu nguyên tắc chọn tổng đoạn chuẩn và trình tự đấu đà"],steps:[{type:"watch",scope:"gb3",text:"Xem mô phỏng hình thành <b>tổng đoạn TĐ3</b> từ các phân đoạn (chọn tốc độ 2× nếu muốn nhanh)."},{type:"order",q:"Sắp xếp trình tự ghép các phân đoạn thành tổng đoạn vòng TĐ3:",items:["Đặt phân đoạn đáy đôi lên bệ","Lắp phân đoạn vách ngang","Lắp hai phân đoạn mạn","Lắp phân đoạn boong (đậy nắp)"],explain:"Đáy đôi là phân đoạn chuẩn; vách được dựng trước khi đóng mạn; boong được lắp cuối cùng."},{type:"watch",scope:"ship",text:"Xem mô phỏng toàn bộ quá trình: chế tạo panel/cụm → phân đoạn → tổng đoạn → <b>đấu nối thành tàu</b> trên ụ."},{type:"mcq",q:"Tổng đoạn đặt đầu tiên lên đà (tổng đoạn chuẩn) thường được chọn ở đâu? Vì sao?",options:["Ở mũi, vì mũi quan trọng nhất","Ở vùng giữa tàu (thân ống): hình dáng đơn giản, dễ căn chỉnh, đấu nối dần về hai đầu giúp phân tán sai số tích luỹ","Ở đuôi, vì có chân vịt","Thượng tầng, vì cao nhất"],answer:1,explain:"Trong mô hình, TĐ3 (hầm hàng số 2) là tổng đoạn chuẩn."},{type:"order",q:"Sắp xếp trình tự đấu nối trên ụ trong mô hình:",items:["TĐ3 – tổng đoạn chuẩn (hầm hàng số 2)","TĐ2 – hầm hàng số 3","TĐ4 – hầm hàng số 1","TĐ1 – đuôi","TĐ5 – mũi","TĐ6 – thượng tầng","Chân vịt & bánh lái"],explain:"Từ tổng đoạn chuẩn phát triển về hai phía, sau đó lắp thượng tầng và các thiết bị."},{type:"multi",q:"Những công việc nào thực hiện khi đấu nối tổng đoạn trên đà?",options:["Căn chỉnh đường tâm, đường nước chuẩn, độ thẳng ky","Cắt lượng dư tại mép đấu nối","Hàn đấu đà tôn vỏ và các kết cấu dọc","Kiểm tra, thử kín các mối hàn đấu đà","Cắt tôn từ tấm nguyên tại xưởng gia công"],answer:[0,1,2,3],explain:"Cắt tôn thuộc giai đoạn gia công chi tiết, không phải công việc trên đà."},{type:"mcq",q:"Vì sao thượng tầng thường được chế tạo thành tổng đoạn và lắp sẵn trang thiết bị (pre-outfitting) trước khi cẩu lên tàu?",options:["Vì thượng tầng không cần hàn","Lắp đặt ống, điện, nội thất ở bãi dễ hơn nhiều so với trên tàu, rút ngắn thời gian đóng mới","Để thượng tầng nhẹ hơn","Vì quy phạm cấm hàn trên boong"],answer:1,explain:"Lắp đặt trước (pre-outfitting) là xu hướng của công nghệ đóng tàu hiện đại."}]},{id:"s8",title:"Bài 8. Khám phá bên trong tàu (đi trong tàu)",level:"Nâng cao",time:"15 phút",goals:["Định hướng không gian bên trong thân tàu","Nhận diện kết cấu từ góc nhìn bên trong"],steps:[{type:"info",title:"Chế độ đi trong tàu",setup:{scope:"ship",walk:2},text:"Bạn đang đứng trên boong chính. Nhấp vào khung nhìn để điều khiển: <b>W A S D</b> di chuyển, <b>E/Q</b> lên/xuống, <b>Shift</b> chạy nhanh. Khi cần chọn chi tiết, đưa <b>tâm ngắm</b> vào chi tiết và nhấp chuột."},{type:"walk",prompt:"Đi xuống <b>hầm hàng số 2</b> qua miệng hầm và đứng giữa hầm.",region:{x:[29,41],y:[-3.5,3.5],z:[1.3,6]},explain:"Bạn đang ở trong hầm hàng số 2, giới hạn bởi vách Fr40 và Fr60."},{type:"pick",prompt:"Từ trong hầm, đưa tâm ngắm vào một <b>sườn khỏe</b> và nhấp chuột.",kinds:["web_frame"],explain:"Sườn khỏe dễ nhận ra vì có bản thành cao và bản mép rộng."},{type:"walk",prompt:"Chui xuống <b>bên trong đáy đôi</b> (dưới tôn đáy trên).",region:{x:[28.3,41.7],y:[-5.6,5.6],z:[.05,1.15]},explain:"Không gian trong đáy đôi chỉ cao 1,2 m – người thợ phải bò qua các lỗ khoét."},{type:"pick",prompt:"Trong đáy đôi, chỉ vào một <b>sống phụ</b>.",kinds:["side_girder"],explain:"Sống phụ chạy dọc tàu tại y = ±2,2 m và ±4,2 m."},{type:"walk",prompt:"Di chuyển tới <b>khoang mũi</b> (phía trước vách chống va Fr90).",region:{x:[63.3,70],y:[-5,5],z:[.3,6.4]},setup:{walk:3},explain:"Bạn đang ở khoang mũi."},{type:"pick",prompt:"Chỉ vào một <b>mã ngực mũi</b>.",kinds:["breast_hook"],explain:"Mã ngực là tấm nằm ngang giằng hai mạn với sống mũi."},{type:"mcq",q:"Vùng mũi tàu (khoang mũi) được gia cường bằng những kết cấu nào trong mô hình?",options:["Dầm dọc đáy và đà ngang đặt thưa","Đà ngang cao ở mỗi sườn, sườn thường, mã ngực, sống mũi","Chỉ có tôn vỏ dày","Thành miệng hầm"],answer:1,explain:"Vùng mũi chịu va đập sóng (slamming) nên được gia cường dày bằng hệ thống ngang và các mã ngực."}]}],bl=new Set(["pick","mcq","multi","order","walk"]),Rh="ktt_scores";function Ph(){try{return JSON.parse(localStorage.getItem(Rh))||{}}catch{return{}}}function nv(i,t){try{const e=Ph();e[i]=Math.max(e[i]||0,t),localStorage.setItem(Rh,JSON.stringify(e))}catch{}}function iv(i,t){const e=[...Array(i).keys()];let n=t;for(let s=i-1;s>0;s--){n=(n*9301+49297)%233280;const r=Math.floor(n/233280*(s+1));[e[s],e[r]]=[e[r],e[s]]}return e.every((s,r)=>s===r)&&e.reverse(),e}function sv(i){const t=document.getElementById("tab-lab"),e=document.getElementById("scenarioPanel"),n=i.viewer;let s=null;const r=()=>{const _=Ph();t.innerHTML=`<h3>Bài thực hành</h3>
      <p class="note">Mỗi bài gồm phần quan sát, nhiệm vụ thao tác trên mô hình 3D (chọn chi tiết, di chuyển camera, xem mô phỏng lắp ráp), câu hỏi trắc nghiệm và sắp xếp trình tự. Sau mỗi câu có đáp án và giải thích. Điểm cao nhất được lưu trên máy này.</p>
      ${Sl.map(p=>`<div class="lab-card" data-sc="${p.id}">
        <div class="t">${zt(p.title)}</div>
        <div class="d"><span class="chip">${p.level}</span><span class="chip">${p.time}</span><span class="chip">${p.steps.length} bước</span></div>
        <div class="d">${p.goals.map(zt).join(" · ")}</div>
        ${_[p.id]!==void 0?`<div class="score">Điểm cao nhất: ${_[p.id]}%</div>`:""}
      </div>`).join("")}`};t.addEventListener("click",_=>{const p=_.target.closest("[data-sc]");p&&a(Sl.find(m=>m.id===p.dataset.sc))}),r();function o(_){if(!_)return;const p=_.cam||_.view||_.walk!==void 0;if(_.scope&&i.setScope(i.node(_.scope),{focus:!p}),_.cut&&i.setCut(_.cut),_.hide&&i.showCats(_.hide),_.view){const m=va[_.view];n.flyTo(new C(...m.pos),new C(...m.target))}_.cam&&n.flyTo(ci(..._.cam.pos,new C),ci(..._.cam.target,new C)),_.walk!==void 0&&n.walkTo(ze[_.walk].pos,ze[_.walk].look)}function a(_){c(),i.select(null),i.resetAssembly(),i.showCats([]),i.setCut({x:null,z:!1,y:null}),n.setMode("orbit"),s={sc:_,i:0,res:_.steps.map(()=>null),state:_.steps.map(()=>({}))},e.classList.remove("hidden"),document.getElementById("infoPanel").classList.add("hidden"),h(0)}function c(){s&&(i.pickHandler=null,i.setHL("task",[]),n.updaters=n.updaters.filter(_=>_!==l),s=null,e.classList.add("hidden"))}function l(){if(!s)return;const _=s.sc.steps[s.i];if(_.type!=="walk"||s.res[s.i]!==null)return;const p=n.camera.position,m=_.region,w=p.x+At.L/2,x=p.z,b=p.y;w>=m.x[0]&&w<=m.x[1]&&x>=m.y[0]&&x<=m.y[1]&&b>=m.z[0]&&b<=m.z[1]&&(s.res[s.i]=!0,i.toast("✓ Đã đến vị trí yêu cầu!"),h(s.i))}function h(_){var w;s.i=_;const p=s.sc.steps[_],m=s.state[_];i.pickHandler=null,i.setHL("task",[]),n.updaters=n.updaters.filter(x=>x!==l),m.setupDone||(o(p.setup),m.setupDone=!0),p.type==="pick"&&(i.pickHandler=x=>d(x),s.res[_]!==null&&m.reveal&&i.setHL("task",i.parts.filter(x=>p.kinds.includes(x.userData.kind)))),p.type==="walk"&&(n.mode!=="walk"&&((w=p.setup)==null?void 0:w.walk)===void 0&&n.walkTo(ze[0].pos,ze[0].look),n.updaters.push(l)),f()}function d(_){const p=s.sc.steps[s.i],m=s.state[s.i];return _?s.res[s.i]!==null?!1:(p.kinds.includes(_.userData.kind)?(s.res[s.i]=!m.wrong,m.picked=_.userData.name,i.setHL("task",[_])):(m.wrong=(m.wrong||0)+1,m.last=`${_.userData.name} (${Ji(_.userData.kind).name})`,m.wrong>=3&&u()),f(),!0):!0}function u(){const _=s.sc.steps[s.i],p=s.state[s.i];p.reveal=!0,s.res[s.i]=!1;const m=i.parts.filter(w=>_.kinds.includes(w.userData.kind)&&w.visible&&!w.userData.ghost);i.setHL("task",m),m.length&&n.focusObjects(m.slice(0,60))}function f(){const{sc:_,i:p,res:m,state:w}=s,x=_.steps[p],b=w[p],I=m[p]!==null,R="ABCDEFGH";let A="";const P=(F,N)=>`<div class="feedback ${F===null?"info":F?"ok":"no"}">${F===null?"":F?"<b>✓ Chính xác.</b> ":"<b>✗ Chưa đúng.</b> "}${N}</div>`;if(x.type==="info")A=`<div class="q">${zt(x.title)}</div><div>${x.text}</div>`;else if(x.type==="pick")A=`<div class="task">🎯 ${x.prompt}</div>`,!I&&b.wrong&&(A+=P(!1,`Bạn chọn: ${zt(b.last)}. Thử lại (${3-b.wrong} lần).`)),I&&(A+=b.reveal?P(!1,`Đáp án đang được tô sáng màu xanh lá. ${zt(x.explain)}`):P(!0,`Bạn đã chọn: ${zt(b.picked)}. ${zt(x.explain)}`)),I||(A+='<div class="row" style="margin-top:10px"><button class="btn" data-x="reveal">Xem đáp án</button></div>');else if(x.type==="mcq"||x.type==="multi"){const F=b.sel||[],N=x.type==="mcq"?[x.answer]:x.answer;A=`<div class="q">${zt(x.q)}</div>${x.type==="multi"?'<p class="note">Có thể có nhiều đáp án đúng.</p>':""}
        ${x.options.map((H,X)=>{let z=F.includes(X)?"picked":"";return I&&(z=N.includes(X)?"right":F.includes(X)?"wrong":""),`<div class="opt ${z}" data-o="${X}"><span class="k">${R[X]}.</span><span>${zt(H)}</span></div>`}).join("")}`,I?A+=P(m[p],zt(x.explain)):A+=`<button class="btn primary" data-x="check" ${F.length?"":"disabled"}>Kiểm tra</button>`}else if(x.type==="order")b.ord||(b.ord=iv(x.items.length,p*7+_.id.length*13+3)),A=`<div class="q">${zt(x.q)}</div><p class="note">Dùng nút ▲ ▼ để sắp xếp.</p>
        ${b.ord.map((F,N)=>`<div class="order-item ${I?F===N?"right":"wrong":""}">
          <span class="n">${N+1}</span><span class="tx">${zt(x.items[F])}</span>
          ${I?"":`<button data-up="${N}">▲</button><button data-dn="${N}">▼</button>`}</div>`).join("")}`,I?A+=P(m[p],`<b>Trình tự đúng:</b><br>${x.items.map((F,N)=>`${N+1}. ${zt(F)}`).join("<br>")}<br><br>${zt(x.explain)}`):A+='<button class="btn primary" data-x="check">Kiểm tra</button>';else if(x.type==="watch")A=`<div>${x.text}</div><div class="row" style="margin-top:10px"><button class="btn primary" data-x="watch">▶ Xem mô phỏng</button></div>
        <p class="note">Mô phỏng chạy ở thanh điều khiển phía dưới khung nhìn. Có thể tạm dừng, lùi/tiến từng bước. Bấm <b>Tiếp</b> khi đã xem xong.</p>`;else if(x.type==="tour"){const F=xr.find(N=>N.id===x.tour);A=`<div>${x.text}</div><div class="row" style="margin-top:10px"><button class="btn primary" data-x="tour">▶ ${zt(F.name)}</button></div>`}else x.type==="walk"&&(A=`<div class="task">🚶 ${x.prompt}</div>
        <p class="note">Nhấp vào khung nhìn để điều khiển: W A S D di chuyển, E/Q lên/xuống, Shift chạy nhanh, Esc nhả chuột.</p>`,I?A+=P(m[p],m[p]?zt(x.explain):"Đã bỏ qua nhiệm vụ này."):A+='<div class="row"><button class="btn" data-x="walkstart">Về vị trí xuất phát</button><button class="btn" data-x="skip">Bỏ qua</button></div>');const W=p===_.steps.length-1,v=!bl.has(x.type)||I,S=Math.round((p+(v?1:0))/_.steps.length*100);e.innerHTML=`<header><button class="close" data-x="close" title="Thoát bài">×</button>
        <div class="t">${zt(_.title)}</div>
        <div style="color:var(--muted);font-size:12px">Bước ${p+1}/${_.steps.length}</div>
        <div class="prog"><i style="width:${S}%"></i></div></header>
      <div class="body">${A}</div>
      <footer><button class="btn" data-x="prev" ${p===0?"disabled":""}>◀ Trước</button>
        <button class="btn primary sp" data-x="next" ${v?"":"disabled"}>${W?"Hoàn thành ✓":"Tiếp ▶"}</button></footer>`}function g(){const{sc:_,res:p}=s,m=_.steps.map((I,R)=>[I,p[R]]).filter(([I])=>bl.has(I.type)),w=m.filter(([,I])=>I).length,x=m.length?Math.round(w/m.length*100):100;nv(_.id,x),i.pickHandler=null,i.setHL("task",[]);const b=I=>{var R;return zt(I.q||((R=I.prompt)==null?void 0:R.replace(/<[^>]+>/g,""))||I.title||"")};e.querySelector(".body").innerHTML=`<div class="q" style="font-size:16px">Kết quả: ${w}/${m.length} (${x}%)</div>
      <div class="feedback ${x>=80?"ok":x>=50?"info":"no"}">${x>=80?"Rất tốt! Bạn đã nắm vững nội dung bài.":x>=50?"Khá. Hãy xem lại các câu sai và giải thích.":"Cần ôn lại. Hãy làm lại bài và đọc kỹ phần giải thích."}</div>
      <div style="margin-top:10px">${m.map(([I,R])=>`<div style="padding:4px 0;border-bottom:1px solid var(--line)">${R?"✅":"❌"} ${b(I)}</div>`).join("")}</div>`,e.querySelector("footer").innerHTML='<button class="btn" data-x="again">↻ Làm lại</button><button class="btn primary sp" data-x="close">Đóng</button>',r()}e.addEventListener("click",_=>{var R,A;if(!s)return;const p=s.sc.steps[s.i],m=s.state[s.i],w=(R=_.target.closest("[data-x]"))==null?void 0:R.dataset.x,x=_.target.closest("[data-o]"),b=_.target.closest("[data-up]"),I=_.target.closest("[data-dn]");if(x&&s.res[s.i]===null){const P=+x.dataset.o;p.type==="mcq"?m.sel=[P]:(m.sel||(m.sel=[]),m.sel=m.sel.includes(P)?m.sel.filter(W=>W!==P):[...m.sel,P]),f();return}if(b||I){const P=+(b||I).dataset[b?"up":"dn"],W=b?P-1:P+1;W>=0&&W<m.ord.length&&([m.ord[P],m.ord[W]]=[m.ord[W],m.ord[P]]),f();return}switch(w){case"close":c(),i.setScope(i.ship);break;case"again":a(s.sc);break;case"prev":h(s.i-1);break;case"next":s.i===s.sc.steps.length-1?g():h(s.i+1);break;case"reveal":u(),f();break;case"skip":s.res[s.i]=!1,f();break;case"walkstart":{const P=ze[((A=p.setup)==null?void 0:A.walk)??0];n.walkTo(P.pos,P.look);break}case"watch":i.playAssembly(i.node(p.scope)),i.player.play();break;case"tour":n.startTour(p.tour);break;case"check":if(p.type==="order")s.res[s.i]=m.ord.every((P,W)=>P===W);else{const P=p.type==="mcq"?[p.answer]:p.answer,W=m.sel||[];s.res[s.i]=W.length===P.length&&P.every(v=>W.includes(v))}f();break}})}const rv=["select","task","step","kind"];class ov{constructor(){this.listeners={},this.viewer=new C_(document.getElementById("viewport"));const{ship:t,registry:e}=s_();this.ship=t,this.registry=e,this.parts=e.parts,this.colorMode="type",this.hiddenCats=new Set,this.ghostOthers=!0,this.edgesOn=!0,this.follow=!0,this.scope=t,this.selected=null,this.hl={select:new Set,task:new Set,step:new Set,kind:new Set};for(const n of this.parts)n.userData.hls=new Set,n.userData.cat=Ji(n.userData.kind).cat;_l(this.parts,this.colorMode),F_(this.parts),this.viewer.setShip(t,this.parts),this.animator=new G_,this.viewer.updaters.push(n=>this.animator.update(n)),this.player=new W_(this.animator,(n,s)=>this.onStep(n,s)),this.viewer.on("pick",n=>{this.emit("pick",n),(!this.pickHandler||!this.pickHandler(n))&&this.select(n)})}on(t,e){var n;((n=this.listeners)[t]||(n[t]=[])).push(e)}emit(t,...e){(this.listeners[t]||[]).forEach(n=>n(...e))}node(t){return this.registry.nodes.get(t)}paint(t){const e=t.userData.hls,n=rv.find(s=>e.has(s));n?vl(t,n):t.userData.ghost?(t.userData.hl=null,t.material=N_):vl(t,null);for(const s of t.children)s.userData.isEdge&&(s.visible=this.edgesOn&&!t.userData.ghost)}setHL(t,e){const n=this.hl[t],s=new Set(e);for(const r of n)s.has(r)||(r.userData.hls.delete(t),this.paint(r));for(const r of s)n.has(r)||(r.userData.hls.add(t),this.paint(r));this.hl[t]=s}select(t){this.selected=t||null,this.setHL("select",t?[t]:[]),this.emit("select",this.selected)}highlightKind(t){const e=t?this.parts.filter(n=>n.userData.kind===t):[];return this.setHL("kind",e),e}setScope(t,{focus:e=!0}={}){this.player.scope&&this.player.scope!==t&&this.player.unload(),this.scope=t||this.ship,this.refreshVisibility(),e&&this.viewer.focusObjects([this.scope]),this.emit("scope",this.scope)}refreshVisibility(){const t=new Set(ga(this.scope));for(const e of this.parts){const n=t.has(e);e.userData.ghost=!n&&this.ghostOthers,e.visible=!this.hiddenCats.has(e.userData.cat)&&(n||this.ghostOthers),this.paint(e)}}setCategory(t,e){e?this.hiddenCats.delete(t):this.hiddenCats.add(t),this.refreshVisibility()}setColorMode(t){this.colorMode=t,_l(this.parts,t),this.parts.forEach(e=>this.paint(e))}setEdges(t){this.edgesOn=t,this.parts.forEach(e=>this.paint(e))}setGhost(t){this.ghostOthers=t,this.refreshVisibility()}resetAssembly(){this.player.unload(),zi(this.ship).forEach(t=>Nn(t,1))}playAssembly(t){this.scope!==t&&this.setScope(t,{focus:!1}),this.player.load(t),this.viewer.focusObjects([t])}onStep(t,e){if(!t)this.setHL("step",[]);else{const n=[];t.nodes.forEach(s=>s.isMesh?n.push(s):n.push(...ga(s))),this.setHL("step",n),this.follow&&e>0&&this.player.lastFocus!==t.focus[0]&&(this.player.lastFocus=t.focus[0],setTimeout(()=>this.viewer.focusObjects(t.focus,{dur:1.2}),50))}this.emit("step",t,e)}toast(t,e=2600){const n=document.getElementById("toast");n.textContent=t,n.classList.remove("hidden"),clearTimeout(this._toast),this._toast=setTimeout(()=>n.classList.add("hidden"),e)}blockOf(t){return ma(t,Lt.BLOCK)}}function av(){const i=new ov;window.app=i,K_(i),ev(i),sv(i),document.getElementById("loading").remove(),i.setScope(i.ship,{focus:!1})}requestAnimationFrame(()=>setTimeout(av,30));
