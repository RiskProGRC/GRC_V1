const {chromium}=require('playwright');const BASE='http://127.0.0.1:8020';
(async()=>{const b=await chromium.launch({headless:true});const p=await(await b.newContext()).newPage();
const errs={};let cur='';p.on('console',m=>{if(m.type()==='error'){(errs[cur]=errs[cur]||[]).push(m.text());}});p.on('pageerror',e=>{(errs[cur]=errs[cur]||[]).push('PE:'+e.message);});
await p.goto(`${BASE}/login.php`,{waitUntil:'networkidle'});await p.fill('#email','hillary@gmail.com');await p.fill('#password','hillary');await p.click('.login-btn');await p.waitForTimeout(2500);
const st={};
for(const u of ['../systemover.php','Project/entity.php','Project/permissionedit.php?id=2','Project/companylist.php','Project/actions.php','Project/kpi.php','Project/bussinf.php']){cur=u;const r=await p.goto(`${BASE}/${u}`,{waitUntil:'networkidle'}).catch(()=>null);await p.waitForTimeout(500);st[u]=r?r.status():'ERR';}
console.log(JSON.stringify({status:st,consoleErrors:errs},null,2));await b.close();})();
