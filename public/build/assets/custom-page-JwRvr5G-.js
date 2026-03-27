import{R as m,j as t}from"./ui-Ps9nvBG1.js";import{K as d,z as T,y as A,L as H}from"./app-BTfiyyPE.js";import O from"./Header-BA_gd-56.js";import $ from"./Footer-cAFcURxa.js";import{u as q}from"./use-favicon-WzxqB2zU.js";import"./vendor-B1hewrmX.js";/* empty css            *//* empty css                  */import"./utils-DBYZG17H.js";import"./menu-BCT8qgIu.js";import"./mail-BqNAeYhs.js";import"./phone-gwdek-Iq.js";import"./map-pin-Cx7Uq6kF.js";import"./instagram-DwIqw1IB.js";import"./twitter-Ob4juxZn.js";function se(){var f,x,y,g,j,b,k,L,_,v,C,D,w;const R=`
    .prose h1, .prose h2, .prose h3, .prose h4, .prose h5, .prose h6 {
      color: #1f2937;
      font-weight: 600;
      margin-top: 2rem;
      margin-bottom: 1rem;
    }
    
    .prose h1 { font-size: 2.25rem; }
    .prose h2 { font-size: 1.875rem; }
    .prose h3 { font-size: 1.5rem; }
    
    .prose p {
      margin-bottom: 1.5rem;
      line-height: 1.75;
    }
    
    .prose ul, .prose ol {
      margin: 1.5rem 0;
      padding-left: 1.5rem;
    }
    
    .prose li {
      margin-bottom: 0.5rem;
    }
    
    .prose a {
      color: var(--primary-color);
      text-decoration: underline;
    }
    
    .prose blockquote {
      border-left: 4px solid var(--primary-color);
      padding-left: 1rem;
      margin: 1.5rem 0;
      font-style: italic;
      background-color: #f9fafb;
      padding: 1rem;
    }
    
    .prose img {
      max-width: 100%;
      height: auto;
      border-radius: 0.5rem;
      margin: 1.5rem 0;
    }
  `,{page:c,customPages:F=[],settings:r}=d().props,a=((x=(f=r==null?void 0:r.config_sections)==null?void 0:f.theme)==null?void 0:x.primary_color)||"#3b82f6",l=((g=(y=r==null?void 0:r.config_sections)==null?void 0:y.theme)==null?void 0:g.secondary_color)||"#8b5cf6",p=((b=(j=r==null?void 0:r.config_sections)==null?void 0:j.theme)==null?void 0:b.accent_color)||"#10B77F",e=d().props.globalSettings,u=d().props.userLanguage;q();const h=m.useCallback(()=>{const o=(e==null?void 0:e.is_demo)||!1,s=u||(e==null?void 0:e.defaultLanguage)||"en",i=["ar","he"].includes(s);let n="ltr";const z=(o?(P=>{var N;if(typeof document>"u")return null;const E=`; ${document.cookie}`.split(`; ${P}=`);if(E.length===2){const M=(N=E.pop())==null?void 0:N.split(";").shift();return M?decodeURIComponent(M):null}return null})("layoutDirection"):e==null?void 0:e.layoutDirection)==="right";return(i||z)&&(n="rtl"),document.documentElement.dir=n,document.documentElement.setAttribute("dir",n),document.body.dir=n,n},[u,e==null?void 0:e.defaultLanguage,e==null?void 0:e.is_demo,e==null?void 0:e.layoutDirection]);return m.useLayoutEffect(()=>{const o=h(),s=new MutationObserver(()=>{document.documentElement.dir!==o&&(document.documentElement.dir=o,document.documentElement.setAttribute("dir",o))});return s.observe(document.documentElement,{attributes:!0,attributeFilter:["dir"]}),()=>s.disconnect()},[h]),m.useEffect(()=>{let o="light";if(T())try{const n=A("themeSettings");n&&(o=JSON.parse(n).appearance||"light")}catch{}else o=(e==null?void 0:e.themeMode)||"light";const s=window.matchMedia("(prefers-color-scheme: dark)").matches,i=o==="dark"||o==="system"&&s;document.documentElement.classList.toggle("dark",i),document.body.classList.toggle("dark",i)},[e==null?void 0:e.themeMode]),t.jsxs(t.Fragment,{children:[t.jsxs(H,{children:[t.jsx("title",{children:c.meta_title||c.title}),c.meta_description&&t.jsx("meta",{name:"description",content:c.meta_description}),t.jsx("style",{children:R})]}),t.jsxs("div",{className:"min-h-screen bg-white",style:{"--primary-color":a,"--secondary-color":l,"--accent-color":p,"--primary-color-rgb":((k=a.replace("#","").match(/.{2}/g))==null?void 0:k.map(o=>parseInt(o,16)).join(", "))||"59, 130, 246","--secondary-color-rgb":((L=l.replace("#","").match(/.{2}/g))==null?void 0:L.map(o=>parseInt(o,16)).join(", "))||"139, 92, 246","--accent-color-rgb":((_=p.replace("#","").match(/.{2}/g))==null?void 0:_.map(o=>parseInt(o,16)).join(", "))||"16, 185, 129"},children:[t.jsx(O,{"max-w-7xl":!0,"mx-auto":!0,settings:r,customPages:F,sectionData:((C=(v=r==null?void 0:r.config_sections)==null?void 0:v.sections)==null?void 0:C.find(o=>o.key==="header"))||{},brandColor:a}),t.jsx("main",{className:"pt-16",children:t.jsx("div",{className:"max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12",children:t.jsxs("div",{className:"max-w-4xl mx-auto",children:[t.jsxs("header",{className:"text-center mb-12",children:[t.jsx("h1",{className:"text-4xl font-bold text-gray-900 mb-4",children:c.title}),t.jsx("div",{className:"w-24 h-1 bg-gradient-to-r from-blue-500 to-purple-600 mx-auto rounded-full"})]}),t.jsx("article",{className:"max-w-none",children:t.jsx("div",{className:"text-gray-700 leading-relaxed text-lg",dangerouslySetInnerHTML:{__html:c.content}})})]})})}),t.jsx($,{settings:r,sectionData:((w=(D=r==null?void 0:r.config_sections)==null?void 0:D.sections)==null?void 0:w.find(o=>o.key==="footer"))||{},brandColor:a})]})]})}export{se as default};
