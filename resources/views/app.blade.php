<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="csrf-token" content="{{ csrf_token() }}">
<title>DMS CRM</title>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
<style>

*{box-sizing:border-box;margin:0;padding:0}
:root{
  --navy:#08111f;--navy2:#0f1d33;--navy3:#1a2e4a;--navy4:#1e3a5f;
  --amber:#f59e0b;--amber2:#fbbf24;--al:#fef3c7;--ad:#92400e;
  --green:#10b981;--gb:#d1fae5;--gd:#065f46;
  --red:#ef4444;--rb:#fee2e2;--rd:#991b1b;
  --blue:#3b82f6;--bb:#dbeafe;--bd:#1e40af;
  --purple:#8b5cf6;--pb:#ede9fe;--pd:#5b21b6;
  --teal:#14b8a6;--tb:#ccfbf1;--td:#0f766e;
  --pink:#ec4899;--pkb:#fce7f3;--pkd:#9d174d;
  --orange:#f97316;--ob:#ffedd5;--od:#9a3412;
  --t1:#0f172a;--t2:#475569;--t3:#94a3b8;--t4:#cbd5e1;
  --border:#e2e8f0;--bg:#f8fafc;--card:#fff;
  --r:8px;--rlg:12px;--rxl:16px;
  --sh:0 1px 3px rgba(0,0,0,.06),0 1px 2px rgba(0,0,0,.04);
  --shmd:0 4px 20px rgba(0,0,0,.1);--shlg:0 16px 48px rgba(0,0,0,.18);
}
html,body{height:100%;font-family:'Plus Jakarta Sans',sans-serif;background:var(--bg);color:var(--t1);overflow:hidden}
/* LOGIN */
#lw{display:flex;height:100vh}
.ll{flex:1;background:var(--orange);display:flex;align-items:center;justify-content:center;padding:48px;position:relative;overflow:hidden}
.ll::before{content:'';position:absolute;inset:0;background:radial-gradient(ellipse 80% 60% at 30% 40%,rgba(245,158,11,.12),transparent),radial-gradient(ellipse 60% 80% at 80% 70%,rgba(59,130,246,.08),transparent)}
.ll-i{position:relative;z-index:1;max-width:380px}
.ll-logo{font-size:44px;font-weight:800;color:#fff;letter-spacing:-1.5px;margin-bottom:12px}
.ll-logo em{color:var(--amber);font-style:normal}
.ll-desc{color:rgba(255,255,255,.45);font-size:14px;line-height:1.8;margin-bottom:28px}
.ll-feat{display:flex;flex-direction:column;gap:10px}
.ll-fi{display:flex;align-items:center;gap:11px}
.ll-fic{width:30px;height:30px;border-radius:7px;background:rgba(255,255,255,.07);border:1px solid rgba(255,255,255,.1);display:flex;align-items:center;justify-content:center;font-size:12px;flex-shrink:0}
.ll-ft{color:rgba(255,255,255,.55);font-size:13px}
.lr{width:480px;background:#fff;display:flex;flex-direction:column;justify-content:center;padding:52px 44px}
.lr-logo{font-size:18px;font-weight:800;margin-bottom:26px}.lr-logo em{color:var(--amber);font-style:normal}
.lr-title{font-size:26px;font-weight:800;margin-bottom:5px}
.lr-sub{font-size:13px;color:var(--t3);margin-bottom:22px}
.flbl{font-size:11px;font-weight:700;color:var(--t2);text-transform:uppercase;letter-spacing:.5px;margin-bottom:5px;display:block}
.finp,.fsel,.fta{width:100%;padding:10px 14px;border:1.5px solid var(--border);border-radius:var(--r);font-size:13px;font-family:'Plus Jakarta Sans',sans-serif;color:var(--t1);outline:none;background:#fff;transition:border-color .12s}
.finp:focus,.fsel:focus,.fta:focus{border-color:var(--amber);box-shadow:0 0 0 3px rgba(245,158,11,.1)}
.finp-icon{position:relative;margin-bottom:11px}.finp-icon .finp{padding-left:40px}
.finp-icon i{position:absolute;left:14px;top:50%;transform:translateY(-50%);color:var(--t3);font-size:13px}
.lbtn{width:100%;padding:12px;background:var(--amber);color:#fff;border:none;border-radius:var(--r);font-size:15px;font-weight:700;cursor:pointer;font-family:'Plus Jakarta Sans',sans-serif;margin-top:5px;transition:all .15s}
.lbtn:hover{background:var(--amber2);transform:translateY(-1px);box-shadow:0 6px 20px rgba(245,158,11,.35)}
.lerr{color:var(--red);font-size:12px;margin-top:6px;display:none;align-items:center;gap:6px}
.ldemo{margin-top:16px;padding:11px;background:var(--bg);border-radius:var(--r);border:1px solid var(--border)}
.ldemo-t{font-size:10px;font-weight:700;color:var(--t3);text-transform:uppercase;letter-spacing:.6px;margin-bottom:7px}
.ldemo-row{display:flex;align-items:center;justify-content:space-between;margin-bottom:5px}
.ldemo-role{font-size:12px;color:var(--t2)}
.ldemo-cred{font-family:'JetBrains Mono',monospace;font-size:11px;cursor:pointer;background:#fff;border:1px solid var(--border);padding:2px 8px;border-radius:5px;transition:all .12s;color:var(--t2)}
.ldemo-cred:hover{border-color:var(--amber);color:var(--amber)}
/* APP */
#app{display:none;height:100vh;flex-direction:row}
#app.on{display:flex}
.sb{width:228px;background:var(--navy);display:flex;flex-direction:column;flex-shrink:0;overflow-y:auto}
.sb-logo{padding:16px 15px 12px;border-bottom:1px solid rgba(255,255,255,.06);display:flex;align-items:center;gap:9px}
.sb-li{width:29px;height:29px;border-radius:7px;background:var(--amber);display:flex;align-items:center;justify-content:center;font-size:13px;font-weight:800;color:#fff;flex-shrink:0}
.sb-lt{font-size:13px;font-weight:800;color:#fff;letter-spacing:-.3px}
.sb-ls{font-size:9px;color:rgba(255,255,255,.25);text-transform:uppercase;letter-spacing:.7px}
.sb-user{padding:9px 13px;border-bottom:1px solid rgba(255,255,255,.06);display:flex;align-items:center;gap:8px}
.sb-av{width:26px;height:26px;border-radius:50%;display:flex;align-items:center;justify-content:center;font-size:10px;font-weight:700;color:#fff;flex-shrink:0}
.sb-un{font-size:12px;font-weight:600;color:#fff}
.sb-ur{font-size:10px;color:rgba(255,255,255,.33);margin-top:1px}
.sb-sec{font-size:9px;color:rgba(255,255,255,.17);letter-spacing:.9px;text-transform:uppercase;padding:10px 14px 3px}
.sb-item{display:flex;align-items:center;gap:8px;padding:7px 14px;cursor:pointer;color:rgba(255,255,255,.38);font-size:12px;font-weight:500;border:none;background:none;width:100%;text-align:left;font-family:'Plus Jakarta Sans',sans-serif;transition:all .1s;position:relative}
.sb-item:hover{background:rgba(255,255,255,.05);color:rgba(255,255,255,.75)}
.sb-item.act{background:linear-gradient(90deg,var(--amber),#f97316);color:#fff;font-weight:700}
.sb-item i{width:14px;text-align:center;font-size:11px}
.sb-badge{background:var(--red);color:#fff;font-size:9px;font-weight:700;padding:1px 5px;border-radius:20px;margin-left:auto;min-width:16px;text-align:center}
.main{flex:1;display:flex;flex-direction:column;overflow:hidden}
.topbar{height:50px;background:var(--card);border-bottom:1px solid var(--border);padding:0 20px;display:flex;align-items:center;justify-content:space-between;flex-shrink:0}
.topbar-t{font-size:14px;font-weight:700}
.tbr{display:flex;align-items:center;gap:6px}
.ib{width:31px;height:31px;border-radius:7px;border:1px solid var(--border);background:var(--card);cursor:pointer;display:flex;align-items:center;justify-content:center;color:var(--t2);font-size:12px;position:relative;transition:all .12s}
.ib:hover{background:var(--bg);border-color:var(--amber);color:var(--amber)}
.nbc{position:absolute;top:-4px;right:-4px;background:var(--red);color:#fff;font-size:8px;min-width:14px;height:14px;border-radius:20px;display:flex;align-items:center;justify-content:center;border:2px solid #fff;font-weight:700}
.pc{flex:1;overflow-y:auto;padding:18px 20px}
/* LAYOUT */
.g2{display:grid;grid-template-columns:1fr 1fr;gap:12px}
.g3{display:grid;grid-template-columns:repeat(3,1fr);gap:11px}
.g4{display:grid;grid-template-columns:repeat(4,1fr);gap:11px}
.g5{display:grid;grid-template-columns:repeat(5,1fr);gap:10px}
.card{background:var(--card);border:1px solid var(--border);border-radius:var(--rlg);padding:16px;box-shadow:var(--sh)}
.mc{background:var(--card);border:1px solid var(--border);border-radius:var(--rlg);padding:14px 16px;box-shadow:var(--sh)}
.mc-icon{width:36px;height:36px;border-radius:9px;display:flex;align-items:center;justify-content:center;font-size:14px;margin-bottom:9px}
.mc-lbl{font-size:10px;color:var(--t3);text-transform:uppercase;letter-spacing:.5px;margin-bottom:3px;font-weight:600}
.mc-val{font-size:22px;font-weight:800;color:var(--t1);line-height:1;letter-spacing:-.5px}
.mc-sub{font-size:11px;color:var(--t3);margin-top:4px}
.ph{display:flex;align-items:flex-start;justify-content:space-between;margin-bottom:14px;flex-wrap:wrap;gap:9px}
.ph-t{font-size:18px;font-weight:800;letter-spacing:-.3px}
.ph-s{font-size:12px;color:var(--t3);margin-top:2px}
/* BUTTONS */
.btn{display:inline-flex;align-items:center;gap:5px;padding:7px 13px;border-radius:var(--r);font-size:12px;font-weight:600;cursor:pointer;border:none;font-family:'Plus Jakarta Sans',sans-serif;transition:all .12s;line-height:1;white-space:nowrap}
.btn-p{background:var(--amber);color:#fff}.btn-p:hover{background:var(--amber2)}
.btn-o{background:var(--card);border:1px solid var(--border);color:var(--t2)}.btn-o:hover{background:var(--bg)}
.btn-sm{padding:5px 10px;font-size:11px}
.btn-xs{padding:2px 7px;font-size:10px}
.btn-red{background:var(--rb);color:var(--rd);border:1px solid #fca5a5}
.btn-grn{background:var(--gb);color:var(--gd);border:1px solid #86efac}
.btn-blu{background:var(--bb);color:var(--bd);border:1px solid #93c5fd}
.btn-pur{background:var(--pb);color:var(--pd);border:1px solid #c4b5fd}
.btn-tel{background:var(--tb);color:var(--td);border:1px solid #5eead4}
.btn-amb{background:var(--al);color:var(--ad);border:1px solid #fcd34d}
.btn-navy{background:var(--navy);color:#fff}
/* FORMS */
.fg{display:flex;flex-direction:column;gap:4px;margin-bottom:10px}
.fta{resize:vertical;min-height:64px}
.fr2{display:grid;grid-template-columns:1fr 1fr;gap:11px}
.fr3{display:grid;grid-template-columns:1fr 1fr 1fr;gap:9px}
/* TABLE */
.tw{background:var(--card);border:1px solid var(--border);border-radius:var(--rlg);overflow:hidden;box-shadow:var(--sh)}
table{width:100%;border-collapse:collapse}
th{font-size:10px;font-weight:700;color:var(--t3);text-transform:uppercase;letter-spacing:.5px;padding:8px 12px;border-bottom:1px solid var(--border);text-align:left;white-space:nowrap;background:var(--bg)}
td{padding:9px 12px;font-size:12px;border-bottom:1px solid var(--border);vertical-align:middle}
tr:last-child td{border-bottom:none}
tbody tr:hover td{background:#fafbfc}
/* BADGE / AVATAR */
.badge{display:inline-flex;align-items:center;gap:3px;padding:2px 7px;border-radius:20px;font-size:10px;font-weight:700;white-space:nowrap}
.av{display:flex;align-items:center;justify-content:center;border-radius:50%;font-weight:700;color:#fff;flex-shrink:0}
/* MODAL */
.mo{position:fixed;inset:0;background:rgba(8,17,31,.55);z-index:400;display:flex;align-items:center;justify-content:center;padding:14px;backdrop-filter:blur(3px)}
.mb{background:#fff;border-radius:var(--rxl);padding:24px;width:100%;max-width:560px;max-height:93vh;overflow-y:auto;box-shadow:var(--shlg)}
.mb-lg{max-width:820px}.mb-xl{max-width:1060px}
.mt2{font-size:15px;font-weight:800;margin-bottom:16px;display:flex;align-items:center;justify-content:space-between;letter-spacing:-.3px}
.mc2{background:none;border:none;color:var(--t3);font-size:16px;cursor:pointer;padding:3px}.mc2:hover{color:var(--t1)}
.mact{display:flex;gap:7px;justify-content:flex-end;margin-top:16px;padding-top:12px;border-top:1px solid var(--border)}
/* TABS */
.tabs{display:flex;border-bottom:2px solid var(--border);margin-bottom:14px;overflow-x:auto;flex-shrink:0}
.tab{padding:7px 14px;font-size:12px;font-weight:600;color:var(--t3);cursor:pointer;border-bottom:2px solid transparent;margin-bottom:-2px;white-space:nowrap;transition:all .12s}
.tab.act{color:var(--amber);border-bottom-color:var(--amber)}
/* PIPELINE */
.pipeline{display:flex;gap:8px;overflow-x:auto;padding-bottom:8px}
.pcol{background:var(--bg);border-radius:var(--r);padding:9px;min-width:170px;flex-shrink:0;border:1px solid var(--border)}
.phd2{font-size:10px;font-weight:800;text-transform:uppercase;letter-spacing:.5px;margin-bottom:8px;display:flex;align-items:center;justify-content:space-between}
.pcnt{font-size:10px;background:var(--border);color:var(--t2);padding:2px 6px;border-radius:20px;font-weight:700}
.pcard{background:#fff;border:1px solid var(--border);border-radius:var(--r);padding:9px;margin-bottom:6px;cursor:pointer;transition:all .12s}
.pcard:hover{border-color:var(--amber);box-shadow:0 2px 10px rgba(245,158,11,.15);transform:translateY(-1px)}
/* NOTIF PANEL */
.np{position:fixed;top:54px;right:10px;width:315px;background:#fff;border:1px solid var(--border);border-radius:var(--rlg);box-shadow:var(--shlg);z-index:200;overflow:hidden;display:none;animation:slideD .15s ease}
.np.on{display:block}
@keyframes slideD{from{opacity:0;transform:translateY(-8px)}to{opacity:1;transform:translateY(0)}}
.np-hd{padding:10px 14px;border-bottom:1px solid var(--border);font-size:13px;font-weight:700;display:flex;align-items:center;justify-content:space-between}
.ni{display:flex;align-items:flex-start;gap:9px;padding:9px 14px;border-bottom:1px solid var(--border);cursor:pointer;transition:background .1s}
.ni:hover{background:var(--bg)}.ni.unread{background:#fffcf0}
/* PROGRESS */
.pb2{background:var(--bg);border-radius:20px;overflow:hidden}
.pf{border-radius:20px;transition:width .5s cubic-bezier(.4,0,.2,1)}
/* TASK KANBAN */
.kb{display:flex;gap:9px;overflow-x:auto;padding-bottom:8px;min-height:380px}
.kcol{background:var(--bg);border-radius:var(--rlg);padding:11px;min-width:235px;flex-shrink:0;border:1px solid var(--border)}
.kcol-hd{font-size:10px;font-weight:800;text-transform:uppercase;letter-spacing:.5px;margin-bottom:9px;display:flex;align-items:center;justify-content:space-between}
.tcard{background:#fff;border:1px solid var(--border);border-radius:var(--r);padding:11px;margin-bottom:7px;border-left:3px solid var(--amber);transition:all .12s}
.tcard:hover{transform:translateY(-1px);box-shadow:var(--shmd)}
.tcard.p-high{border-left-color:var(--red)}.tcard.p-low{border-left-color:var(--green)}
.tcard.overdue-t{background:#fff5f5;border-left-color:var(--red)}
/* CHAT */
.chat-wrap{display:flex;flex-direction:column;border:1px solid var(--border);border-radius:var(--rlg);overflow:hidden;background:var(--bg)}
.chat-msgs{flex:1;overflow-y:auto;padding:12px;display:flex;flex-direction:column;gap:9px}
.cmsg{display:flex;align-items:flex-end;gap:7px}
.cmsg.mine{flex-direction:row-reverse}
.cbub{padding:7px 11px;border-radius:11px;font-size:12px;line-height:1.5;max-width:72%;word-break:break-word}
.cmsg.mine .cbub{background:var(--amber);color:#fff;border-radius:11px 11px 2px 11px}
.cmsg:not(.mine) .cbub{background:#fff;border:1px solid var(--border);border-radius:11px 11px 11px 2px}
.chat-bar{padding:9px;border-top:1px solid var(--border);display:flex;gap:7px;background:#fff}
.chat-inp{flex:1;padding:7px 11px;border:1.5px solid var(--border);border-radius:var(--r);font-size:12px;font-family:'Plus Jakarta Sans',sans-serif;outline:none;resize:none}
.chat-inp:focus{border-color:var(--amber)}
.chat-send{width:32px;height:32px;border-radius:var(--r);background:var(--amber);border:none;color:#fff;cursor:pointer;display:flex;align-items:center;justify-content:center;font-size:12px;flex-shrink:0}
/* CAL */
.cal-grid{display:grid;grid-template-columns:repeat(7,1fr);gap:3px}
.cal-hd2{font-size:10px;font-weight:700;color:var(--t3);text-transform:uppercase;text-align:center;padding:5px 0;letter-spacing:.4px}
.cal-day{min-height:82px;background:#fff;border:1px solid var(--border);border-radius:var(--r);padding:5px;overflow:hidden;transition:border-color .12s;cursor:pointer}
.cal-day:hover{border-color:var(--amber)}
.cal-day.today{border-color:var(--amber);background:var(--al)}
.cal-day.other-m{background:var(--bg);opacity:.5}
.cal-dn{font-size:11px;font-weight:700;color:var(--t2);margin-bottom:3px}
.cal-chip{font-size:9px;font-weight:600;padding:2px 5px;border-radius:3px;margin-bottom:2px;cursor:pointer;display:block;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;line-height:1.4}
/* FILTER BAR */
.fbar{display:flex;gap:7px;margin-bottom:14px;flex-wrap:wrap;align-items:center;background:var(--card);padding:10px 14px;border-radius:var(--rlg);border:1px solid var(--border)}
.fbar .fsel,.fbar .finp{padding:6px 10px;font-size:12px;width:auto;border-radius:6px}
.fbar label{font-size:11px;font-weight:600;color:var(--t3);white-space:nowrap}
/* STAR */
.star-wrap{display:flex;gap:3px}
.star{font-size:19px;cursor:pointer;transition:transform .1s;color:#d1d5db}
.star:hover,.star.lit{color:#f59e0b}.star:hover{transform:scale(1.2)}
/* PERM */
.perm-grid{display:grid;grid-template-columns:1fr 1fr 1fr;gap:5px;max-height:280px;overflow-y:auto;border:1px solid var(--border);border-radius:var(--r);padding:10px;background:var(--bg)}
.perm-item{display:flex;align-items:center;gap:6px;padding:5px 7px;background:#fff;border-radius:5px;font-size:11px;font-weight:500;border:1px solid var(--border);cursor:pointer}
.perm-item input{accent-color:var(--amber)}
/* MISC */
.mono{font-family:'JetBrains Mono',monospace}
.dots span{width:5px;height:5px;border-radius:50%;background:var(--t3);display:inline-block;animation:dot 1.2s infinite;margin:0 2px}
.dots span:nth-child(2){animation-delay:.2s}.dots span:nth-child(3){animation-delay:.4s}
@keyframes dot{0%,80%,100%{transform:scale(.5);opacity:.4}40%{transform:scale(1);opacity:1}}
.tg{color:var(--green)}.tr{color:var(--red)}.ta{color:var(--amber)}.tb2{color:var(--blue)}.tp{color:var(--purple)}
.fw7{font-weight:700}.fw6{font-weight:600}.fw8{font-weight:800}
.fs10{font-size:10px}.fs11{font-size:11px}.fs12{font-size:12px}.fs13{font-size:13px}
.mb4{margin-bottom:4px}.mb8{margin-bottom:8px}.mb12{margin-bottom:12px}.mb14{margin-bottom:14px}.mb16{margin-bottom:16px}.mb20{margin-bottom:20px}
.mt8{margin-top:8px}.mt12{margin-top:12px}.mt14{margin-top:14px}
.flex{display:flex}.ic{align-items:center}.sbj{justify-content:space-between}.gap6{gap:6px}.gap8{gap:8px}.gap10{gap:10px}.f1{flex:1}
.sect-t{font-size:13px;font-weight:700;margin-bottom:8px}
.sep{border:none;border-top:1px solid var(--border);margin:12px 0}
.cp-hero{background:linear-gradient(135deg,var(--navy),var(--navy4));border-radius:var(--rlg);padding:18px;margin-bottom:11px;color:#fff}
.abox{border-radius:var(--r);padding:10px 12px;margin-bottom:12px;display:flex;align-items:flex-start;gap:9px;font-size:12px}
.a-red{background:var(--rb);border:1px solid #fca5a5;color:var(--rd)}
.a-amb{background:var(--al);border:1px solid #fcd34d;color:var(--ad)}
.a-grn{background:var(--gb);border:1px solid #86efac;color:var(--gd)}
.a-blu{background:var(--bb);border:1px solid #93c5fd;color:var(--bd)}
.a-pur{background:var(--pb);border:1px solid #c4b5fd;color:var(--pd)}
.empty{text-align:center;padding:36px 20px;color:var(--t3)}
.empty i{font-size:30px;margin-bottom:9px;display:block;opacity:.4}
.srvc-row{display:flex;align-items:center;gap:7px;padding:7px;border:1px solid var(--border);border-radius:var(--r);background:#fff;margin-bottom:5px}
.pulse{animation:pulse 2s infinite}
@keyframes pulse{0%,100%{opacity:1}50%{opacity:.6}}
.role-chip{display:inline-flex;align-items:center;padding:2px 8px;border-radius:20px;font-size:10px;font-weight:700}
.pb-wrap{background:var(--bg);border-radius:var(--r);padding:12px;margin-bottom:9px;border:1px solid var(--border)}
.brief-box{background:var(--bg);border:1px solid var(--border);border-radius:var(--r);padding:12px;font-size:12px;line-height:1.7;white-space:pre-wrap;max-height:280px;overflow-y:auto}
.exp-cat{display:inline-flex;align-items:center;gap:4px;padding:2px 8px;border-radius:20px;font-size:10px;font-weight:700}
/* REMINDER CARD */
.rem-card{border:1px solid var(--border);border-radius:var(--rlg);padding:14px;background:#fff;margin-bottom:10px;transition:border-color .12s}
.rem-card.overdue{border-color:var(--red);background:#fffafa}
.rem-card.urgent{border-color:var(--amber);background:#fffcf0}
.rem-card.ok{border-color:var(--green)}
.esc-step{text-align:center;padding:6px;border-radius:var(--r);font-size:10px;font-weight:700;flex:1}
/* WORK ITEM */
.witem{border:1px solid var(--border);border-radius:var(--r);padding:11px;background:#fff;margin-bottom:7px;display:flex;align-items:flex-start;gap:10px;transition:all .12s}
.witem:hover{border-color:var(--amber);box-shadow:var(--sh)}
.witem.done-item{opacity:.65;border-left:3px solid var(--green)}
.witem.overdue-item{border-left:3px solid var(--red);background:#fffafa}
/* MEETING CARD */
.meetcard{border:1px solid var(--border);border-radius:var(--r);padding:11px;background:#fff;margin-bottom:7px;display:flex;gap:12px;align-items:flex-start}
.meetcard-date{min-width:48px;text-align:center;background:var(--navy);color:#fff;border-radius:var(--r);padding:7px 5px}
.fcard{display:flex;align-items:center;gap:10px;padding:8px 11px;border:1px solid var(--border);border-radius:var(--r);background:#fff;margin-bottom:6px;transition:all .12s;cursor:pointer}
.fcard:hover{border-color:var(--amber);background:var(--al)}

.rec-badge{background:#ccfbf1;color:#0f766e;border-radius:4px;padding:1px 6px;font-size:9px;font-weight:700;margin-left:4px}
.dp-col{background:var(--card);border:1px solid var(--border);border-radius:var(--rlg);padding:10px;min-height:160px;flex:1;min-width:130px;transition:border-color .15s}
.dp-col.today{border-color:var(--amber);background:var(--al)}
.dp-col.drag-over{border-color:var(--blue);background:var(--bb)}
.dp-chip{background:var(--bg);border:1px solid var(--border);border-left:3px solid var(--amber);border-radius:5px;padding:5px 7px;font-size:11px;font-weight:600;margin-bottom:4px;cursor:grab;transition:all .12s;display:block}
.dp-chip:hover{border-color:var(--amber);transform:translateY(-1px)}
.dp-chip.high{border-left-color:var(--red)}
.dp-chip.low{border-left-color:var(--green)}
.wl-row{display:grid;grid-template-columns:160px repeat(5,1fr) 70px 70px;gap:4px;align-items:start;border-bottom:1px solid var(--border);padding:8px 0}
.wl-cell{background:var(--bg);border-radius:5px;padding:5px 7px;min-height:32px;font-size:10px;text-align:center}
.wl-cell.over{background:var(--rb)}
.wl-cell.full{background:var(--al)}
.wl-cell.free{background:var(--gb)}
.cs-pill{display:inline-flex;align-items:center;gap:4px;padding:3px 9px;border-radius:20px;font-size:11px;font-weight:700;cursor:pointer;border:2px solid transparent;font-family:inherit;transition:all .12s}
.gcal-connect-btn{display:flex;align-items:center;gap:10px;padding:14px 18px;border:1.5px solid var(--border);border-radius:var(--rlg);background:var(--card);cursor:pointer;transition:all .15s;width:100%;font-family:inherit;font-size:14px;font-weight:600}
.gcal-connect-btn:hover{border-color:var(--blue);background:var(--bb)}
.gcal-connect-btn.connected{border-color:var(--green);background:var(--gb)}
.step-num{width:26px;height:26px;border-radius:50%;background:var(--amber);color:#fff;font-size:12px;font-weight:700;display:flex;align-items:center;justify-content:center;flex-shrink:0}

</style>
</head>
<body>
<!-- LOADING SCREEN -->
<div id="loading-screen" style="position:fixed;inset:0;background:var(--navy);display:flex;flex-direction:column;align-items:center;justify-content:center;z-index:9999;color:#fff;">
  <div style="font-size:36px;font-weight:800;margin-bottom:12px;letter-spacing:-1px;font-family:'Plus Jakarta Sans',sans-serif;">DMS <span style="color:var(--amber);">CRM</span></div>
  <div style="font-size:13px;color:rgba(255,255,255,0.45);margin-bottom:24px;font-family:'Plus Jakarta Sans',sans-serif;">Loading your workspace...</div>
  <div style="width:36px;height:36px;border:3px solid rgba(255,255,255,0.08);border-top:3px solid var(--amber);border-radius:50%;animation:loading-spin 1s linear infinite;"></div>
</div>
<style>
@keyframes loading-spin {
  0% { transform: rotate(0deg); }
  100% { transform: rotate(360deg); }
}
</style>
<!-- APP -->
<div id="app">
  <div class="sb" id="sb">
    <div class="sb-logo"><div class="sb-li">D</div><div><div class="sb-lt">DMS CRM</div><div class="sb-ls">v5.0 Pro</div></div></div>
    <div class="sb-user"><div class="sb-av" id="sb-av"></div><div><div class="sb-un" id="sb-name">—</div><div class="sb-ur" id="sb-role">—</div></div></div>
    <nav id="sb-nav"></nav>
  </div>
  <div class="main">
    <div class="topbar">
      <div class="topbar-t" id="pg-t">Dashboard</div>
      <div class="tbr">
        <button class="ib" onclick="openBriefGen()" title="AI Brief"><i class="fa fa-magic"></i></button>
        <button class="ib" onclick="go('agent')" title="AI Agent"><i class="fa fa-robot"></i></button>
        <button class="ib" id="nb-btn" onclick="toggleNP()"><i class="fa fa-bell"></i><span class="nbc" id="nb-cnt" style="display:none">0</span></button>
        <button class="btn btn-sm btn-o" onclick="logout()"><i class="fa fa-sign-out-alt"></i> Logout</button>
      </div>
    </div>
    <div class="pc" id="pc"></div>
  </div>
</div>
<!-- NOTIF PANEL -->
<div class="np" id="np">
  <div class="np-hd">Notifications <button class="btn btn-xs btn-o" onclick="markAllRead()">All read</button></div>
  <div id="np-list"></div>
</div>
<!-- MODAL -->
<div class="mo" id="mo" style="display:none" onclick="if(event.target===this)closeMo()">
  <div class="mb" id="mb"></div>
</div>
@php
  $currentUser = Auth::user();
  $userPermissions = [];
  if ($currentUser) {
      $modules = [
          'dashboard','clients','invoices','reminders','expenses','crm','meetings',
          'followups','targets','my_target','my_work','tasks','my_tasks','calendar',
          'worklogs','reports','team','services','requisitions','workload','dayplan',
          'gcal','agent','settings'
      ];
      foreach ($modules as $m) {
          if ($currentUser->canAccess($m)) {
              $userPermissions[] = $m;
          }
      }
  }
@endphp
<script>
window.APP_API_BASE = @json(url('/api'));
window.APP_LOGIN_URL = @json(route('login.post'));
window.APP_LOGOUT_URL = @json(route('logout'));
window.APP_DASHBOARD_URL = @json(route('dashboard'));
window.CURRENT_USER = @json($currentUser);
window.USER_PERMISSIONS = @json($userPermissions);
@verbatim

// ══════ LARAVEL API LAYER ══════
// Replaces localStorage with real database calls

let CSRF = document.querySelector('meta[name="csrf-token"]')?.content || '';

function updateCsrfToken(token) {
    if (!token) return;
    CSRF = token;
    const meta = document.querySelector('meta[name="csrf-token"]');
    if (meta) meta.setAttribute('content', token);
}

function toCamelKey(key) {
    return key.replace(/_([a-z])/g, (_, c) => c.toUpperCase());
}

function toSnakeKey(key) {
    return key.replace(/SMM/g, 'Smm').replace(/[A-Z]/g, c => '_' + c.toLowerCase());
}

function mapKeys(value, mapper) {
    if (Array.isArray(value)) return value.map(v => mapKeys(v, mapper));
    if (!value || typeof value !== 'object') return value;
    return Object.fromEntries(Object.entries(value).map(([k, v]) => [mapper(k), mapKeys(v, mapper)]));
}

function apiOut(value) {
    return mapKeys(value, toSnakeKey);
}

function apiIn(value) {
    return mapKeys(value, toCamelKey);
}

function normalizeService(s) {
    return {...s, basePrice: Number(s.basePrice ?? 0), active: !!s.active};
}

function normalizeClient(c) {
    return {
        ...c,
        assignedSMM: c.assignedSMM ?? c.assignedSmm ?? null,
        assignedSales: c.assignedSales ?? null,
        onboarded: c.onboarded ?? c.onboardedAt ?? '',
        satisfactionScore: c.satisfactionScore ?? null,
        services: (c.services || []).map(cs => ({
            ...cs,
            serviceId: cs.serviceId ?? cs.service?.id,
            price: Number(cs.price ?? 0),
            qty: Number(cs.qty ?? 1),
        })),
    };
}

function normalizeLeadStage(s) {
    return {...s, label: s.label ?? s.name, order: s.order ?? s.id};
}

function normalizeLead(l) {
    return {
        ...l,
        stageId: l.stageId ?? l.stage?.id,
        assignedTo: l.assignedTo?.id ?? l.assignedTo,
        createdBy: l.createdBy ?? null,
        nextFollowup: l.nextFollowup ?? '',
        deleted: false,
    };
}

function normalizeTask(t) {
    return {
        ...t,
        clientId: t.clientId ?? null,
        assignedTo: t.assignedTo?.id ?? t.assignedTo,
        assignedBy: t.assignedBy?.id ?? t.assignedBy,
        scheduledDate: t.scheduledDate ?? null,
        estimatedHours: t.estimatedHours ?? null,
        serviceId: t.serviceId ?? null,
        parentTaskId: t.parentTaskId ?? null,
        approvalComments: t.approvalComments || [],
        progress: t.progress || [],
    };
}

function normalizeMeeting(m) {
    return {
        ...m,
        clientId: m.clientId ?? null,
        leadId: m.leadId ?? null,
        clientName: m.clientName ?? m.client?.name ?? '',
        nextAction: m.nextAction ?? '',
        type: m.clientId ? 'client' : (m.leadId ? 'prospect' : 'internal'),
        with: (m.attendees || []).map(u => u.id),
        createdBy: m.createdBy?.id ?? m.createdBy,
    };
}

function normalizeInvoice(i) {
    return {...i, clientId: i.clientId, number: i.invoiceNumber, issuedDate: i.issuedDate, dueDate: i.dueDate};
}

function normalizeNotification(n) {
    return {
        ...n,
        bg: n.bg ?? n.bgColor,
        msg: n.msg ?? n.message,
        read: n.read ?? n.isRead,
        adminOnly: n.adminOnly ?? n.isAdminOnly,
    };
}

function normalizeExpense(e) {
    const date = (e.date || '').slice(0, 10);
    return {
        ...e,
        categoryId: e.categoryId ?? null,
        reason: e.reason ?? e.title ?? '',
        title: e.title ?? e.reason ?? '',
        month: e.month ?? date.slice(0, 7),
        paidTo: e.paidTo ?? e.paymentMethod ?? '',
        amount: Number(e.amount ?? 0),
        date,
    };
}

function normalizeWorklog(w) {
    const status = w.status === 'pending' ? 'pending_smm_review' : w.status;
    const desc = w.description || w.notes || '';
    let unit = '';
    let notes = desc;
    const unitMatch = desc.match(/Unit:\s*([^\n]+)/i);
    if (unitMatch) {
        unit = unitMatch[1].trim();
        notes = desc.replace(/Unit:\s*[^\n]+/i, '').trim();
    }
    return {
        ...w,
        status,
        userId: w.userId,
        clientId: w.clientId,
        taskId: w.taskId,
        qtyDelivered: Number(w.qtyDelivered ?? w.qtyDone ?? 0),
        qtyTotal: w.qtyTotal ?? null,
        deliveredDate: (w.deliveredDate ?? w.date ?? '').slice(0, 10),
        quality: w.quality ?? w.qualityRating ?? null,
        reviewNote: w.reviewNote ?? w.smmFeedback ?? '',
        notes: notes,
        unit: w.unit ?? unit,
        serviceId: w.task?.serviceId ?? w.serviceId ?? null,
    };
}

function normalizeWorkItem(w) {
    return {
        ...w,
        userId: w.userId,
        dueDate: (w.dueDate || '').slice(0, 10),
        completedAt: w.completedAt ? w.completedAt.slice(0, 10) : '',
        createdAt: (w.createdAt || '').slice(0, 10),
    };
}

function normalizeExpenseCategory(c) {
    const icons = {rent:'🏢',utilities:'💡',software:'💻',marketing:'📣',salaries:'👥',equipment:'🖥️',miscellaneous:'📦'};
    const key = (c.name || '').toLowerCase();
    return {...c, icon: c.icon || Object.entries(icons).find(([k]) => key.includes(k))?.[1] || '📦'};
}

async function apiCall(method, url, data = null) {
    const opts = {
        method,
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': CSRF,
            'Accept': 'application/json',
        },
    };
    if (data && method !== 'GET') opts.body = JSON.stringify(apiOut(data));
    const res = await fetch((window.APP_API_BASE || '/api') + url, opts);
    if (!res.ok) {
        const err = await res.json().catch(() => ({message: res.statusText}));
        throw new Error(err.message || 'API error');
    }
    return apiIn(await res.json());
}

async function webCall(method, url, data = null) {
    const opts = {
        method,
        credentials: 'same-origin',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': CSRF,
            'Accept': 'application/json',
        },
    };
    if (data && method !== 'GET') opts.body = JSON.stringify(data);
    const res = await fetch(url, opts);
    const payload = await res.json().catch(() => ({}));
    updateCsrfToken(payload.csrf_token);
    if (!res.ok) throw new Error(payload.message || 'Request failed');
    return payload;
}

const API = {
    get:    (url)       => apiCall('GET', url),
    post:   (url, data) => apiCall('POST', url, data),
    put:    (url, data) => apiCall('PUT', url, data),
    patch:  (url, data) => apiCall('PATCH', url, data),
    delete: (url)       => apiCall('DELETE', url),
};

// ── DB is still used as local cache, but real data comes from API ──
// Override save() and load() to use API

async function loadFromAPI(onlyModules = null) {
    try {
        if (window.CURRENT_USER) {
            DB.currentUser = window.CURRENT_USER;
            DB.currentUser.canAccess = Array.isArray(window.USER_PERMISSIONS) ? window.USER_PERMISSIONS : Object.values(window.USER_PERMISSIONS || {});
        } else {
            const me = await API.get('/me');
            DB.currentUser = me.user;
            DB.currentUser.canAccess = Array.isArray(me.canAccess) ? me.canAccess : Object.values(me.canAccess || {});
        }
        const canLoad = (module) => isOwner() || DB.currentUser.canAccess.includes(module);

        const promises = {};
        const addPromise = (key, apiCall) => {
            if (!onlyModules || onlyModules.includes(key)) {
                promises[key] = apiCall;
            }
        };

        addPromise('users', API.get('/users'));
        addPromise('clients', API.get('/clients'));
        addPromise('services', API.get('/services'));
        addPromise('leads', API.get('/leads'));
        addPromise('tasks', API.get('/tasks'));
        addPromise('meetings', API.get('/meetings'));
        addPromise('invoices', canLoad('invoices') ? API.get('/invoices') : Promise.resolve([]));
        addPromise('contentPosts', API.get('/content-posts'));
        addPromise('expenses', canLoad('expenses') ? API.get('/expenses') : Promise.resolve([]));
        addPromise('expenseCategories', canLoad('expenses') ? API.get('/expenses/categories') : Promise.resolve(DB.expenseCategories));
        addPromise('worklogs', API.get('/worklogs'));
        addPromise('myWorkItems', API.get('/my-work-items').catch(() => []));
        addPromise('targets', API.get('/targets'));
        addPromise('requisitions', API.get('/requisitions'));
        addPromise('notifications', API.get('/notifications'));
        addPromise('leadStages', API.get('/lead-stages'));

        const keys = Object.keys(promises);
        const results = await Promise.all(Object.values(promises));

        keys.forEach((key, index) => {
            const val = results[index];
            if (key === 'clients') DB.clients = val.map(normalizeClient);
            else if (key === 'services') DB.services = val.map(normalizeService);
            else if (key === 'leads') DB.leads = val.map(normalizeLead);
            else if (key === 'tasks') DB.tasks = val.map(normalizeTask);
            else if (key === 'meetings') DB.meetings = val.map(normalizeMeeting);
            else if (key === 'invoices') DB.invoices = val.map(normalizeInvoice);
            else if (key === 'expenses') DB.expenses = val.map(normalizeExpense);
            else if (key === 'expenseCategories') DB.expenseCategories = val.map(normalizeExpenseCategory);
            else if (key === 'worklogs') DB.worklogs = val.map(normalizeWorklog);
            else if (key === 'myWorkItems') DB.myWorkItems = val.map(normalizeWorkItem);
            else if (key === 'notifications') DB.notifications = val.map(normalizeNotification);
            else if (key === 'leadStages') DB.leadStages = val.map(normalizeLeadStage);
            else DB[key] = val;
        });

    } catch (e) {
        console.error('Failed to load data:', e);
        if (!onlyModules) DB.currentUser = null;
        throw e;
    }
}

// Async save - syncs specific entity to API
async function saveEntity(type, id, data) {
    try {
        if (id) {
            return await API.put(`/${type}/${id}`, data);
        } else {
            return await API.post(`/${type}`, data);
        }
    } catch (e) {
        console.error('Save failed:', e);
        throw e;
    }
}

// Keep original save() working but also push to API
const _origSave = typeof save === 'function' ? save : () => {};
function save() {
    // localStorage backup (for offline resilience)
    try { _origSave(); } catch(e) {}
}



// ══════ ANTHROPIC API KEY — Set your key here ══════
// Get your key from: https://console.anthropic.com
// For security: only share this file with your own team, not publicly
window.ANTHROPIC_KEY = 'YOUR_API_KEY_HERE';
// ════════════════════════════════════════════════════

// ══════ ALL MODULES (each has its own permission key) ══════
const MODULES={
  dashboard:{icon:'fa-chart-pie',label:'Dashboard',section:'Overview'},
  clients:{icon:'fa-users',label:'Clients'},
  invoices:{icon:'fa-file-invoice',label:'Invoices'},
  reminders:{icon:'fa-bell',label:'Payment Reminders'},
  expenses:{icon:'fa-receipt',label:'Expenses',section:'Finance'},
  crm:{icon:'fa-filter',label:'CRM Pipeline',section:'Sales'},
  meetings:{icon:'fa-handshake',label:'Meetings'},
  followups:{icon:'fa-calendar-check',label:'Follow-ups'},
  targets:{icon:'fa-bullseye',label:'Sales Targets'},
  my_target:{icon:'fa-bullseye',label:'My Target',section:'My Work'},
  my_work:{icon:'fa-list-check',label:'My Work'},
  tasks:{icon:'fa-tasks',label:'Task Board',section:'Creative'},
  my_tasks:{icon:'fa-clipboard-list',label:'My Tasks'},
  calendar:{icon:'fa-calendar-alt',label:'Content Calendar'},
  worklogs:{icon:'fa-chart-bar',label:'Work Reports'},
  reports:{icon:'fa-chart-line',label:'Reports',section:'Analytics'},
  team:{icon:'fa-user-cog',label:'Team & Access',section:'Admin'},
  services:{icon:'fa-tags',label:'Services'},
  requisitions:{icon:'fa-clipboard-check',label:'Requisitions',section:'Sales'},
  agent:{icon:'fa-robot',label:'AI Agent',section:'Tools'},
  workload:{icon:'fa-chart-gantt',label:'Team Workload',section:'Analytics'},
  dayplan:{icon:'fa-calendar-day',label:'Day Planner'},
  gcal:{icon:'fa-google',label:'Google Calendar',section:'Tools'},
  settings:{icon:'fa-cog',label:'Settings'},
};
const PAGE_TITLES=Object.fromEntries(Object.entries(MODULES).map(([k,v])=>[k,v.label]));

// ══════ DATA STORE ══════
const DB={
  currentUser:null,currentPage:'dashboard',
  users:[
    {id:1,name:'Mehedi Hasan',username:'admin',password:'admin123',role:'owner',designation:'CEO & Owner',color:'#f59e0b',active:true,email:'admin@agency.com'},
    {id:2,name:'Rahim Uddin',username:'rahim',password:'rahim123',role:'sales',designation:'Sales Executive',color:'#3b82f6',active:true,email:'rahim@agency.com'},
    {id:3,name:'Karim Sheikh',username:'karim',password:'karim123',role:'sales',designation:'Sr. Sales Executive',color:'#8b5cf6',active:true,email:'karim@agency.com'},
    {id:4,name:'Rafi Ahmed',username:'rafi',password:'rafi123',role:'designer',designation:'Senior Designer',color:'#10b981',active:true,email:'rafi@agency.com'},
    {id:5,name:'Nafi Islam',username:'nafi',password:'nafi123',role:'motion',designation:'Motion Designer',color:'#14b8a6',active:true,email:'nafi@agency.com'},
    {id:6,name:'Sara Begum',username:'sara',password:'sara123',role:'smm',designation:'Social Media Manager',color:'#ec4899',active:true,email:'sara@agency.com'},
    {id:7,name:'Tariq Hassan',username:'tariq',password:'tariq123',role:'seo',designation:'Web Developer',color:'#0f766e',active:true,email:'tariq@agency.com'},
  ],
  roles:[
    {id:'owner',label:'Owner/Admin',color:'#f59e0b',pages:Object.keys(MODULES),editable:false},
    {id:'sales',label:'Sales Team',color:'#3b82f6',pages:['dashboard','crm','meetings','followups','my_target','my_work','requisitions','dayplan','agent'],editable:true},
    {id:'smm',label:'Social Media Manager',color:'#ec4899',pages:['dashboard','my_tasks','my_work','calendar','worklogs','dayplan','agent'],editable:true},
    {id:'designer',label:'Designer',color:'#10b981',pages:['dashboard','my_tasks','my_work','worklogs','agent'],editable:true},
    {id:'motion',label:'Motion Designer',color:'#14b8a6',pages:['dashboard','my_tasks','my_work','worklogs','agent'],editable:true},
    {id:'video',label:'Video Editor',color:'#ef4444',pages:['dashboard','my_tasks','my_work','worklogs','agent'],editable:true},
    {id:'seo',label:'SEO & Web Dev',color:'#0f766e',pages:['dashboard','my_tasks','my_work','worklogs','agent'],editable:true},
    {id:'mediabuyer',label:'Media Buyer',color:'#f97316',pages:['dashboard','my_tasks','my_work','worklogs','agent'],editable:true},
  ],
  services:[
    {id:1,name:'Social Media Design',basePrice:500,unit:'per post',recurring:false,trackable:true,active:true},
    {id:2,name:'Video / Motion Editing',basePrice:800,unit:'per video',recurring:false,trackable:true,active:true},
    {id:3,name:'Logo Design',basePrice:5000,unit:'one-time',recurring:false,trackable:true,active:true},
    {id:4,name:'Website Design & Dev',basePrice:15000,unit:'one-time',recurring:false,trackable:true,active:true},
    {id:5,name:'Content Writing',basePrice:300,unit:'per article',recurring:false,trackable:true,active:true},
    {id:6,name:'SEO Package',basePrice:3000,unit:'per month',recurring:true,trackable:false,active:true},
    {id:7,name:'Ad Campaign Mgmt',basePrice:5000,unit:'per month',recurring:true,trackable:false,active:true},
    {id:8,name:'Website Maintenance',basePrice:2000,unit:'per month',recurring:true,trackable:false,active:true},
    {id:9,name:'Software / SaaS',basePrice:8000,unit:'one-time',recurring:false,trackable:true,active:true},
  ],
  leadStages:[
    {id:1,label:'New Lead',color:'#64748b'},{id:2,label:'Interested',color:'#3b82f6'},
    {id:3,label:'Follow Up',color:'#f97316'},{id:4,label:'Meeting Set',color:'#8b5cf6'},
    {id:5,label:'Proposal Sent',color:'#14b8a6'},{id:6,label:'Negotiation',color:'#ec4899'},
    {id:7,label:'Won',color:'#10b981'},{id:8,label:'Lost',color:'#ef4444'},
  ],
  clients:[
    {id:1,name:'Ahmed Rahman',phone:'+880-171-1234567',email:'ahmed@co.com',company:'Ahmed Co Ltd',location:'Dhaka',onboarded:'2025-05-20',status:'active',assignedSMM:6,assignedSales:2,billingCycle:'monthly',notes:'VIP. Prefers WhatsApp.',services:[{serviceId:1,price:600,qty:10},{serviceId:2,price:900,qty:3},{serviceId:8,price:2000,qty:1}],advance:5000,satisfactionScore:4,satisfactionHistory:[{stars:4,comment:'Good quality.',date:'2025-05-15'}]},
    {id:2,name:'Nadia Hossain',phone:'+880-181-9876543',email:'nadia@si.io',company:'StartupIO',location:'Chittagong',onboarded:'2025-05-10',status:'active',assignedSMM:6,assignedSales:3,billingCycle:'monthly',notes:'',services:[{serviceId:4,price:15000,qty:1},{serviceId:6,price:3000,qty:1}],advance:10000,satisfactionScore:5,satisfactionHistory:[{stars:5,comment:'Excellent!',date:'2025-05-20'}]},
    {id:3,name:'Rafiq Islam',phone:'+880-191-5555555',email:'rafiq@rv.com',company:'Rafiq Ventures',location:'Sylhet',onboarded:'2025-05-28',status:'onboarding',assignedSMM:null,assignedSales:2,billingCycle:'monthly',notes:'New client.',services:[{serviceId:1,price:500,qty:20},{serviceId:5,price:300,qty:5}],advance:3000,satisfactionScore:null,satisfactionHistory:[]},
  ],
  invoices:[
    {id:1,clientId:1,number:'INV-2025-001',period:'May 2025',month:'2025-05',issueDate:'2025-05-01',dueDate:'2025-06-20',status:'sent',items:[{name:'Social Media Design',qty:10,price:600},{name:'Video/Motion',qty:3,price:900},{name:'Website Maintenance',qty:1,price:2000}],advance:5000,reminders:[]},
    {id:2,clientId:2,number:'INV-2025-002',period:'May 2025',month:'2025-05',issueDate:'2025-05-10',dueDate:'2025-05-30',status:'paid',items:[{name:'Website Design & Dev',qty:1,price:15000},{name:'SEO Package',qty:1,price:3000}],advance:10000,paidDate:'2025-05-28',reminders:[]},
    {id:3,clientId:3,number:'INV-2025-003',period:'May 2025',month:'2025-05',issueDate:'2025-05-29',dueDate:'2025-06-28',status:'draft',items:[{name:'Social Media Design',qty:20,price:500},{name:'Content Writing',qty:5,price:300}],advance:3000,reminders:[]},
  ],
  leads:[
    {id:1,name:'Sadia Akter',phone:'+880-171-9999999',email:'sadia@biz.com',company:'Sadia Biz',location:'Dhaka',source:'Facebook',stageId:2,services:[1,2],budget:8000,assignedTo:2,createdBy:2,nextFollowup:'2025-06-03',notes:'Interested in SM package.',deleted:false,requirements:[{id:'r1a',service:'Social Media Design',qty:20,unitPrice:500,notes:'Blue/gold brand theme'},{id:'r1b',service:'Content Writing',qty:8,unitPrice:300,notes:'Product descriptions'}],timeline:[{type:'created',by:2,text:'Lead created',date:'2025-05-20'}]},
    {id:2,name:'Tanvir Ahmed',phone:'+880-181-8888888',email:'tanvir@corp.com',company:'Tanvir Corp',location:'Chittagong',source:'Referral',stageId:4,services:[4],budget:18000,assignedTo:3,createdBy:1,nextFollowup:'2025-06-05',notes:'Meeting June 5.',deleted:false,requirements:[{id:'r2a',service:'Website Design & Dev',qty:1,unitPrice:15000,notes:'E-commerce, WooCommerce'},{id:'r2b',service:'SEO Package',qty:1,unitPrice:3000,notes:'Monthly SEO management'}],timeline:[{type:'created',by:1,text:'Lead created',date:'2025-05-18'}]},
    {id:3,name:'Rubel Islam',phone:'+880-191-7777777',email:'rubel@shop.com',company:'Rubel Shop',location:'Dhaka',source:'Walk-in',stageId:5,services:[1,5],budget:6000,assignedTo:2,createdBy:2,nextFollowup:'2025-06-07',notes:'Proposal sent.',deleted:false,requirements:[{id:'r3a',service:'Social Media Design',qty:15,unitPrice:400,notes:'Agreed 15% discount'}],timeline:[{type:'created',by:2,text:'Walk-in lead',date:'2025-05-15'}]},
    {id:4,name:'Mitu Begum',phone:'+880-171-6666666',email:'mitu@org.com',company:'Mitu Org',location:'Sylhet',source:'Website',stageId:1,services:[3],budget:5000,assignedTo:3,createdBy:1,nextFollowup:'2025-06-02',notes:'',deleted:false,requirements:[],timeline:[{type:'created',by:1,text:'Website form',date:'2025-05-23'}]},
  ],
  // MEETINGS — proper meeting tracker
  meetings:[
    {id:1,clientName:'Ahmed Rahman',clientId:1,leadId:null,type:'client',with:[2,6],location:'Office',date:'2025-05-22',time:'10:00',duration:60,agenda:'Monthly review & next quarter plan',outcome:'Approved June content plan',status:'completed',nextAction:'Send proposal by May 30',createdBy:1},
    {id:2,clientName:'Tanvir Corp',clientId:null,leadId:2,type:'prospect',with:[3],location:'Client Office',date:'2025-06-05',time:'11:00',duration:90,agenda:'Website project discussion',outcome:'',status:'scheduled',nextAction:'',createdBy:3},
    {id:3,clientName:'Sadia Akter',clientId:null,leadId:1,type:'prospect',with:[2],location:'Zoom',date:'2025-05-20',time:'14:00',duration:30,agenda:'Initial call',outcome:'Interested, asked for proposal',status:'completed',nextAction:'Send proposal by June 3',createdBy:2},
  ],
  // TARGETS — fully admin-defined, any service, any qty
  targets:[
    {id:1,userId:2,month:'2025-05',label:'May 2025 Target',items:[
      {id:'t1a',serviceName:'Social Media Design',qty:50,unitPrice:500,achieved:28},
      {id:'t1b',serviceName:'Video/Motion Editing',qty:10,unitPrice:800,achieved:5},
      {id:'t1c',serviceName:'Website Design & Dev',qty:2,unitPrice:15000,achieved:0},
    ],deals:[
      {client:'Ahmed Rahman',service:'Social Media Design',qty:10,amount:5000,date:'2025-05-20'},
      {client:'Rafiq Islam',service:'Social Media Design',qty:18,amount:9000,date:'2025-05-28'},
      {client:'Ahmed Rahman',service:'Video/Motion Editing',qty:3,amount:2400,date:'2025-05-22'},
    ]},
    {id:2,userId:3,month:'2025-05',label:'May 2025 Target',items:[
      {id:'t2a',serviceName:'Website Design & Dev',qty:3,unitPrice:15000,achieved:1},
      {id:'t2b',serviceName:'SEO Package',qty:5,unitPrice:3000,achieved:2},
    ],deals:[
      {client:'Nadia Hossain',service:'Website Design & Dev',qty:1,amount:15000,date:'2025-05-10'},
    ]},
  ],
  tasks:[
    {id:1,title:'Monthly SM Package — Ahmed Rahman (June)',clientId:1,assignedTo:6,assignedBy:1,priority:'high',status:'in_progress',deadline:'2025-06-30',notes:'20 posts + 5 reels.',createdAt:'2025-05-28',serviceId:1,approvalStatus:null,approvalComments:[],parentTaskId:null,progress:[]},
    {id:2,title:'10 static posts — Ahmed Rahman',clientId:1,assignedTo:4,assignedBy:6,priority:'high',status:'in_progress',deadline:'2025-06-10',notes:'Blue & gold. Helvetica.',createdAt:'2025-05-28',serviceId:1,approvalStatus:null,approvalComments:[],parentTaskId:1,progress:[{by:4,note:'7 posts done',done:7,total:10,date:'2025-05-30'}]},
    {id:3,title:'5 reels — Ahmed Rahman',clientId:1,assignedTo:5,assignedBy:6,priority:'medium',status:'pending',deadline:'2025-06-20',notes:'15-30 sec.',createdAt:'2025-05-28',serviceId:2,approvalStatus:null,approvalComments:[],parentTaskId:1,progress:[]},
    {id:4,title:'Website Development — Nadia Hossain',clientId:2,assignedTo:7,assignedBy:1,priority:'high',status:'in_progress',deadline:'2025-06-30',notes:'WordPress + WooCommerce.',createdAt:'2025-05-10',serviceId:4,approvalStatus:null,approvalComments:[],parentTaskId:null,progress:[{by:7,note:'Homepage + About done',done:2,total:5,date:'2025-05-25'}]},
  ],
  // MY WORK — personal task list for any staff member
  myWorkItems:[
    {id:1,userId:2,title:'Call Sadia Akter re: proposal',category:'call',priority:'high',dueDate:'2025-06-03',status:'pending',notes:'Discuss SM package pricing',createdAt:'2025-05-30'},
    {id:2,userId:2,title:'Send revised proposal to Rubel',category:'proposal',priority:'high',dueDate:'2025-06-01',status:'done',notes:'Include 15% discount',createdAt:'2025-05-29',completedAt:'2025-05-31'},
    {id:3,userId:4,title:'Finish Ahmed Rahman June batch',category:'design',priority:'high',dueDate:'2025-06-10',status:'in_progress',notes:'3 posts remaining',createdAt:'2025-05-30'},
    {id:4,userId:6,title:'Plan Nadia content calendar',category:'planning',priority:'medium',dueDate:'2025-06-05',status:'pending',notes:'June-July posts',createdAt:'2025-05-31'},
  ],
  worklogs:[
    {id:1,userId:4,clientId:1,taskId:2,serviceId:1,qtyDelivered:7,qtyTotal:10,unit:'posts',deliveredDate:'2025-05-30',status:'pending_smm_review',notes:'7 of 10 posts ready.',quality:null,reviewNote:''},
    {id:2,userId:5,clientId:1,taskId:3,serviceId:2,qtyDelivered:2,qtyTotal:5,unit:'reels',deliveredDate:'2025-05-31',status:'approved',notes:'First 2 reels.',quality:4,reviewNote:'Good energy.'},
    {id:3,userId:7,clientId:2,taskId:4,serviceId:4,qtyDelivered:2,qtyTotal:5,unit:'pages',deliveredDate:'2025-05-28',status:'approved',notes:'Homepage + About.',quality:5,reviewNote:''},
  ],
  contentPosts:[
    {id:1,clientId:1,title:'Product Launch Post',platform:'instagram',type:'design',date:'2025-06-03',status:'scheduled',assignedTo:4,notes:'Blue CTA'},
    {id:2,clientId:1,title:'Brand Story Reel',platform:'instagram',type:'motion',date:'2025-06-05',status:'in_progress',assignedTo:5,notes:'15 sec'},
    {id:3,clientId:1,title:'Weekly Tips Story',platform:'facebook',type:'design',date:'2025-06-07',status:'pending',assignedTo:4,notes:'5 tips'},
    {id:4,clientId:1,title:'Friday Q&A Reel',platform:'instagram',type:'motion',date:'2025-06-13',status:'pending',assignedTo:5,notes:'30 sec'},
    {id:5,clientId:2,title:'Website Launch Post',platform:'facebook',type:'design',date:'2025-06-15',status:'pending',assignedTo:4,notes:'Launch'},
    {id:6,clientId:2,title:'SEO Tips Video',platform:'youtube',type:'video',date:'2025-06-20',status:'pending',assignedTo:5,notes:'5 min video'},
  ],
  expenseCategories:[
    {id:1,name:'Office Rent',color:'#ef4444',icon:'🏢'},
    {id:2,name:'Salaries',color:'#8b5cf6',icon:'👥'},
    {id:3,name:'Software & Tools',color:'#3b82f6',icon:'💻'},
    {id:4,name:'Marketing & Ads',color:'#f97316',icon:'📣'},
    {id:5,name:'Utilities',color:'#14b8a6',icon:'⚡'},
    {id:6,name:'Transport',color:'#10b981',icon:'🚗'},
    {id:7,name:'Miscellaneous',color:'#94a3b8',icon:'📦'},
  ],
  expenses:[
    {id:1,categoryId:1,amount:25000,date:'2025-05-01',reason:'May office rent',paidTo:'Landlord',month:'2025-05',notes:''},
    {id:2,categoryId:2,amount:85000,date:'2025-05-05',reason:'Staff salary — May',paidTo:'Team',month:'2025-05',notes:'5 staff'},
    {id:3,categoryId:3,amount:3500,date:'2025-05-10',reason:'Adobe CC subscription',paidTo:'Adobe',month:'2025-05',notes:''},
    {id:4,categoryId:3,amount:2800,date:'2025-05-10',reason:'Canva Pro + tools',paidTo:'Various',month:'2025-05',notes:''},
    {id:5,categoryId:5,amount:3200,date:'2025-05-15',reason:'Electricity + Internet',paidTo:'Utility',month:'2025-05',notes:''},
    {id:6,categoryId:4,amount:15000,date:'2025-05-20',reason:'Facebook Ads — client campaigns',paidTo:'Meta',month:'2025-05',notes:''},
  ],
  // PAYMENT REMINDERS — rich system
  reminderTemplates:[
    {id:1,name:'Friendly Reminder (7 days)',trigger:'7_before',channel:'email',subject:'Upcoming Invoice Due — {CLIENT}',body:'Dear {CLIENT},\n\nThis is a friendly reminder that Invoice {INVOICE} for {AMOUNT} is due on {DATE}.\n\nPlease arrange payment at your earliest convenience.\n\nThank you for your business!\n\nBest regards,\nDMS Creative Agency'},
    {id:2,name:'Due Date Reminder',trigger:'due_date',channel:'whatsapp',body:'Hi {CLIENT}! 👋 Your invoice {INVOICE} for {AMOUNT} is due today. Please make the payment to avoid any service disruption. Thank you! 🙏'},
    {id:3,name:'Overdue Notice (3 days)',trigger:'3_after',channel:'email',subject:'⚠️ Overdue Payment — Invoice {INVOICE}',body:'Dear {CLIENT},\n\nYour payment of {AMOUNT} for Invoice {INVOICE} is now 3 days overdue.\n\nPlease settle this immediately to avoid service interruption.\n\nIf you have already paid, please ignore this notice.\n\nBest regards,\nDMS Creative Agency'},
    {id:4,name:'Final Notice (7 days)',trigger:'7_after',channel:'email',subject:'🔴 FINAL NOTICE — Invoice {INVOICE} Severely Overdue',body:'Dear {CLIENT},\n\nDespite our previous reminders, Invoice {INVOICE} for {AMOUNT} remains unpaid — now 7 days overdue.\n\nThis is a final notice before we escalate this matter.\n\nPlease contact us immediately.\n\nDMS Creative Agency'},
    {id:5,name:'WhatsApp Quick (3 days after)',trigger:'3_after',channel:'whatsapp',body:'Hi {CLIENT} — your invoice {INVOICE} for {AMOUNT} is overdue by 3 days. Please make the payment ASAP! 🙏'},
  ],
  clientChats:{1:[{id:1,userId:6,text:'Ahmed brand kit uploaded.',ts:'2025-05-28 10:15'},{id:2,userId:4,text:'Got it! Starting posts.',ts:'2025-05-28 10:42'}],2:[{id:1,userId:7,text:'Wireframes done. Need feedback.',ts:'2025-05-25 09:00'}],3:[]},
  clientFiles:{1:[{id:1,name:'Ahmed_BrandKit.pdf',category:'brand',size:'2.4 MB',uploadedBy:6,date:'2025-05-28',icon:'📋',bg:'#fee2e2'},{id:2,name:'Logo_Primary.ai',category:'brand',size:'890 KB',uploadedBy:6,date:'2025-05-28',icon:'🎨',bg:'#ede9fe'}],2:[{id:1,name:'Wireframes_v2.fig',category:'creative',size:'4.1 MB',uploadedBy:7,date:'2025-05-25',icon:'📐',bg:'#dbeafe'}],3:[]},
  notifications:[
    {id:1,icon:'💳',bg:'#fef3c7',msg:'Ahmed Rahman — INV-2025-001 (৳8,200) due in 28 days',time:'Just now',read:false},
    {id:2,icon:'🔴',bg:'#fee2e2',msg:'Overdue: INV-2025-002 payment follow-up required',time:'1h ago',read:false},
    {id:3,icon:'👀',bg:'#ede9fe',msg:'Rafi submitted 7 posts for SMM review',time:'2h ago',read:false},
    {id:4,icon:'✅',bg:'#d1fae5',msg:'Nadia Hossain paid ৳45,000',time:'1d ago',read:true},
  ],
  requisitions:[
    {id:1,leadId:3,clientName:'Rubel Islam',company:'Rubel Shop',phone:'+880-191-7777777',email:'rubel@shop.com',location:'Dhaka',submittedBy:2,submittedAt:'2025-05-20',status:'pending',
     items:[{id:'req1a',service:'Social Media Design',qty:15,unitPrice:400,total:6000,notes:'Agreed 15% discount — brand colors blue/white'}],
     totalValue:6000,advancePaid:2000,billingCycle:'monthly',specialNotes:'Client wants content calendar shared each week.',
     assignedSMM:null,assignedTeam:[],adminNotes:'',reviewedAt:null,reviewedBy:null,convertedClientId:null},
  ],
  customStatuses:[
    {id:'cs1',clientId:null,name:'Pending',color:'#94a3b8',order:1,core:'pending'},
    {id:'cs2',clientId:null,name:'In Progress',color:'#3b82f6',order:2,core:'in_progress'},
    {id:'cs3',clientId:null,name:'Review',color:'#8b5cf6',order:3,core:'done_pending_review'},
    {id:'cs4',clientId:null,name:'Done',color:'#10b981',order:4,core:'done'},
    {id:'cs5',clientId:1,name:'Brief Ready',color:'#f59e0b',order:1,core:'pending'},
    {id:'cs6',clientId:1,name:'Designing',color:'#ec4899',order:2,core:'in_progress'},
    {id:'cs7',clientId:1,name:'SMM Check',color:'#8b5cf6',order:3,core:'done_pending_review'},
    {id:'cs8',clientId:1,name:'Published',color:'#10b981',order:4,core:'done'},
  ],
  gcalConfig:{clientId:'',connected:false},
  aiMsgs:[],_nid:900,
};

// ══════ PERSIST ══════
function load(){const s=localStorage.getItem('dmscrm_v5');if(s)try{const d=JSON.parse(s);['roles','services','clients','invoices','leads','meetings','targets','tasks','myWorkItems','worklogs','contentPosts','expenseCategories','expenses','reminderTemplates','clientChats','clientFiles','notifications','leadStages','requisitions','customStatuses','gcalConfig','_nid','currentPage'].forEach(k=>{if(d[k]!==undefined)DB[k]=d[k];});DB.currentUser=null;}catch(e){}
}
function save(){const d={};['roles','services','clients','invoices','leads','meetings','targets','tasks','myWorkItems','worklogs','contentPosts','expenseCategories','expenses','reminderTemplates','clientChats','clientFiles','notifications','leadStages','requisitions','customStatuses','gcalConfig','_nid','currentPage'].forEach(k=>d[k]=DB[k]);localStorage.setItem('dmscrm_v5',JSON.stringify(d));}
function uid(){return ++DB._nid;}
function removeParentRow(el){var r=el.closest('.srvc-row');if(r)r.remove();}

// ══════ HELPERS ══════
const fmt=n=>'৳'+Number(n||0).toLocaleString();
const fmtD=d=>{if(!d)return'—';try{return new Date(d).toLocaleDateString('en-GB',{day:'numeric',month:'short',year:'numeric'});}catch(e){return d;}};
function daysFrom(d){return Math.ceil((new Date(d)-new Date('2025-05-23'))/864e5);}
function cTotal(c){return(c.services||[]).reduce((s,cs)=>s+cs.price*cs.qty,0);}
function iTotal(inv){return(inv.items||[]).reduce((s,i)=>s+i.qty*i.price,0);}
function iBal(inv){return iTotal(inv)-(inv.advance||0);}
function pSt(inv){if(inv.status==='paid')return{l:'Paid',c:'var(--green)',b:'var(--gb)'};const d=daysFrom(inv.dueDate);if(d<0)return{l:`${Math.abs(d)}d Overdue`,c:'var(--red)',b:'var(--rb)'};if(d<=7)return{l:`Due ${d}d`,c:'var(--amber)',b:'var(--al)'};return{l:`Due ${d}d`,c:'var(--blue)',b:'var(--bb)'};}
function bh(l,c,b){return`<span class="badge" style="background:${b};color:${c}">${l}</span>`;}
function avH(name,col,sz,fs){const i=(name||'?').split(' ').map(w=>w[0]).join('').toUpperCase().slice(0,2);return`<div class="av" style="width:${sz||28}px;height:${sz||28}px;font-size:${fs||10}px;background:${col||'#1e3a5f'}">${i}</div>`;}
const CLRS=['#10b981','#3b82f6','#f97316','#8b5cf6','#14b8a6','#ec4899','#16a34a','#ef4444'];
const cclr=id=>CLRS[(id||0)%CLRS.length];
function uname(id){const u=DB.users.find(x=>x.id===id);return u?u.name:'?';}
function ucolor(id){const u=DB.users.find(x=>x.id===id);return u?.color||'#64748b';}
function svcName(id){const s=DB.services.find(x=>x.id===id);return s?s.name:'?';}
function stgLabel(id){const s=DB.leadStages.find(x=>x.id===id);return s?s.label:'?';}
function stgColor(id){const s=DB.leadStages.find(x=>x.id===id);return s?s.color:'#64748b';}
function isOwner(){return DB.currentUser?.role==='owner';}
function isSMM(){return DB.currentUser?.role==='smm';}
function isSales(){return DB.currentUser?.role==='sales';}
function userRole(){return DB.roles.find(r=>r.id===DB.currentUser?.role)||DB.roles[0];}
function canDo(page){return isOwner()||userRole().pages.includes(page);}
function pct(a,b){return b>0?Math.min(100,Math.round(a/b*100)):0;}
function isOverdue(t){return t.status!=='done'&&t.deadline&&daysFrom(t.deadline)<0;}
function getSubTasks(pid){return DB.tasks.filter(t=>t.parentTaskId===pid);}
function addNotif(icon,bg,msg,adminOnly=false){
  const finKeys=['paid','payment','Invoice','INV-','৳','overdue','invoice','revenue','expense','Requisition','requisition','collected'];
  const isFin=adminOnly||finKeys.some(k=>msg.includes(k));
  if(isFin&&!isOwner())return;
  DB.notifications.unshift({id:uid(),icon,bg,msg,time:'Just now',read:false,adminOnly:isFin});
  updNB();
}
function updNB(){const u=DB.notifications.filter(n=>!n.read&&(!n.adminOnly||isOwner())).length;const el=document.getElementById('nb-cnt');if(el){el.textContent=u;el.style.display=u?'flex':'none';}}
function expCat(id){return DB.expenseCategories.find(x=>x.id===id)||{name:'?',color:'#94a3b8',icon:'📦'};}
function expTotal(month){return DB.expenses.filter(e=>!month||e.month===month).reduce((s,e)=>s+e.amount,0);}

// CLIENT VISIBILITY — staff only see their assigned clients or task-related clients
function myVisibleClients(){
  if(isOwner())return DB.clients;
  const me=DB.currentUser;
  const taskCids=new Set(DB.tasks.filter(t=>t.assignedTo===me.id||t.assignedBy===me.id).map(t=>t.clientId));
  return DB.clients.filter(c=>c.assignedSMM===me.id||c.assignedSales===me.id||taskCids.has(c.id));
}

// TARGET HELPERS
function tgtTotal(t){return(t.items||[]).reduce((s,item)=>s+item.qty*item.unitPrice,0);}
function tgtAch(t){return(t.deals||[]).reduce((s,d)=>s+(d.amount||0),0);}
function tgtItemAch(t,itemId){return(t.deals||[]).filter(d=>d.itemId===itemId).reduce((s,d)=>s+(d.qty||0),0);}
function myTgt(){
  const mine=DB.targets.filter(t=>t.userId===DB.currentUser.id);
  if(!mine.length)return null;
  return mine.sort((a,b)=>b.month.localeCompare(a.month))[0];
}

function taskStatusBadge(t){
  if(t.status==='done')return bh('Done','var(--gd)','var(--gb)');
  if(t.status==='done_pending_review')return bh('⏳ Review','var(--pd)','var(--pb)');
  if(t.approvalStatus==='revision')return bh('↩ Revision','var(--ad)','var(--al)');
  if(t.status==='in_progress')return bh('In Progress','var(--bd)','var(--bb)');
  if(isOverdue(t))return bh('OVERDUE','var(--rd)','var(--rb)');
  return bh('Pending','var(--t2)','var(--bg)');
}

// REMINDER HELPERS
function getReminderStatus(inv){
  if(inv.status==='paid')return'paid';
  const d=daysFrom(inv.dueDate);
  if(d>7)return'upcoming';
  if(d>=0&&d<=7)return'due_soon';
  if(d>=-3&&d<0)return'overdue_mild';
  if(d>=-7&&d<-3)return'overdue_moderate';
  return'overdue_severe';
}
function fillTemplate(tpl,inv){const c=DB.clients.find(x=>x.id===inv.clientId);return tpl.replace(/{CLIENT}/g,c?.name||'Client').replace(/{INVOICE}/g,inv.number).replace(/{AMOUNT}/g,fmt(iBal(inv))).replace(/{DATE}/g,fmtD(inv.dueDate));}

// ══════ AUTH + NAVIGATION ══════
function showLoginScreen(){
  window.location.assign('/login');
}
function initApp(){
  if(!DB.currentUser)return showLoginScreen();
  const loading = document.getElementById('loading-screen');
  if(loading) loading.style.display = 'none';
  document.getElementById('app').classList.add('on');
  const ini=DB.currentUser.name.split(' ').map(w=>w[0]).join('').toUpperCase().slice(0,2);
  document.getElementById('sb-av').textContent=ini;
  document.getElementById('sb-av').style.background=DB.currentUser.color;
  document.getElementById('sb-name').textContent=DB.currentUser.name;
  document.getElementById('sb-role').textContent=userRole().label;
  buildSB();
  checkOverdue();
  updNB();
  go(DB.currentPage||'dashboard');
}
async function logout(){try{await webCall('POST', window.APP_LOGOUT_URL || '/logout');}catch(e){console.warn('Logout failed',e);}DB.currentUser=null;DB.aiMsgs=[];DB.currentPage='dashboard';save();window.location.assign('/login');}
function buildSB(){
  const pages=userRole().pages||[];let html='',last='';
  pages.forEach(p=>{const m=MODULES[p];if(!m)return;if(m.section&&m.section!==last){html+=`<div class="sb-sec">${m.section}</div>`;last=m.section;}
  html+=`<button class="sb-item" id="sbi-${p}" onclick="go('${p}')"><i class="fa ${m.icon}"></i><span>${m.label}</span></button>`;});
  document.getElementById('sb-nav').innerHTML=html;
}
function checkOverdue(){DB.tasks.forEach(t=>{if(isOverdue(t)&&!DB.notifications.find(n=>n.msg.includes(t.title)&&n.msg.includes('OVERDUE')))addNotif('⏰','#fee2e2',`OVERDUE: "${t.title.slice(0,28)}" — ${Math.abs(daysFrom(t.deadline))}d late`);});}
function go(page){
  if(!canDo(page)&&page!=='agent')page='dashboard';
  DB.currentPage=page;
  document.querySelectorAll('.sb-item').forEach(b=>b.classList.remove('act'));
  const sbi=document.getElementById('sbi-'+page);if(sbi)sbi.classList.add('act');
  document.getElementById('pg-t').textContent=PAGE_TITLES[page]||page;closeNP();
  const FNS={dashboard:pgDash,clients:pgClients,services:pgServices,invoices:pgInvoices,reminders:pgReminders,expenses:pgExpenses,crm:pgCRM,meetings:pgMeetings,followups:pgFollowups,targets:pgTargets,my_target:pgMyTarget,my_work:pgMyWork,tasks:pgTasks,my_tasks:pgMyTasks,calendar:pgCal,worklogs:pgWorklogs,reports:pgReports,team:pgTeam,requisitions:pgRequisitions,workload:pgWorkload,dayplan:pgDayPlan,gcal:pgGcal,agent:pgAgent,settings:pgSettings};
  document.getElementById('pc').innerHTML=FNS[page]?FNS[page]():'<div class="empty"><i class="fa fa-hard-hat"></i>Coming soon</div>';
  setTimeout(()=>{
    if(page==='clients')renderCT();
    else if(page==='invoices')renderIT();
    else if(page==='crm')renderPipe();
    else if(page==='tasks')renderTasks();
    else if(page==='calendar'){const mc=myVisibleClients();if(mc.length)switchCalClient(mc[0].id);}
    else if(page==='agent')initAgent();
    else if(page==='reports')renderReports();
    else if(page==='meetings')renderMeetings();
    else if(page==='reminders')renderReminders();
    else if(page==='expenses')renderExpenses();
    else if(page==='my_work')renderMyWork();
    else if(page==='requisitions')renderRequisitions();
    else if(page==='workload')renderWorkload();
    else if(page==='dayplan')renderDayPlan();
  },30);
}

// ══════ DASHBOARDS ══════
function pgDash(){const r=DB.currentUser.role;if(r==='owner')return ownerDash();if(r==='sales')return salesDash();return creativeDash();}

function ownerDash(){
  const tR=DB.clients.reduce((s,c)=>s+cTotal(c),0);const tP=DB.invoices.filter(i=>i.status==='paid').reduce((s,i)=>s+iTotal(i),0);const tExp=expTotal('2025-05');const tDue=DB.invoices.filter(i=>i.status!=='paid').reduce((s,i)=>s+iBal(i),0);const odT=DB.tasks.filter(isOverdue);const pr=DB.tasks.filter(t=>t.status==='done_pending_review').length;const overduePay=DB.invoices.filter(i=>i.status!=='paid'&&daysFrom(i.dueDate)<0).length;
  return`<div class="g5 mb14">
<div class="mc"><div class="mc-icon" style="background:var(--al)"><i class="fa fa-dollar-sign" style="color:var(--amber)"></i></div><div class="mc-lbl">Monthly Revenue</div><div class="mc-val">${fmt(tR)}</div><div class="mc-sub">${DB.clients.length} clients</div></div>
<div class="mc"><div class="mc-icon" style="background:var(--gb)"><i class="fa fa-arrow-down" style="color:var(--green)"></i></div><div class="mc-lbl">Collected</div><div class="mc-val tg">${fmt(tP)}</div></div>
<div class="mc" style="cursor:pointer;border-color:${overduePay?'var(--red)':'var(--border)'}" onclick="go('reminders')"><div class="mc-icon" style="background:var(--rb)"><i class="fa fa-clock" style="color:var(--red)"></i></div><div class="mc-lbl">Overdue Payments</div><div class="mc-val tr">${overduePay}</div><div class="mc-sub">${fmt(tDue)} total due</div></div>
<div class="mc"><div class="mc-icon" style="background:var(--pb)"><i class="fa fa-receipt" style="color:var(--purple)"></i></div><div class="mc-lbl">May Expenses</div><div class="mc-val tp">${fmt(tExp)}</div><div class="mc-sub">Net: <strong class="${tP-tExp>0?'tg':'tr'}">${fmt(tP-tExp)}</strong></div></div>
<div class="mc" style="cursor:pointer;border-color:${pr>0?'var(--purple)':'var(--border)'}" onclick="go('tasks')"><div class="mc-icon" style="background:var(--pb)"><i class="fa fa-eye" style="color:var(--purple)"></i></div><div class="mc-lbl">Awaiting Review</div><div class="mc-val tp">${pr}</div></div>
</div>
${odT.length?`<div class="abox a-red mb12"><i class="fa fa-exclamation-triangle fa-lg"></i><div><div class="fw7 mb4">${odT.length} Overdue Tasks</div>${odT.map(t=>`<div class="fs11 mt2">• ${t.title.slice(0,40)} → ${uname(t.assignedTo)} (${Math.abs(daysFrom(t.deadline))}d late) <button class="btn btn-xs btn-red" onclick="go('tasks')">View</button></div>`).join('')}</div></div>`:''}
<div class="g2 mb12">
<div class="card"><div class="flex ic sbj mb10"><div class="sect-t" style="margin-bottom:0">Client Overview</div><button class="btn btn-sm btn-o" onclick="go('clients')">All</button></div>
${DB.clients.map(c=>{const t=cTotal(c);const p=pct(c.advance,t);return`<div class="flex ic gap8 py2" style="padding:8px 0;border-bottom:1px solid var(--border);cursor:pointer" onclick="openCP(${c.id})">${avH(c.name,cclr(c.id),28,10)}<div class="f1"><div class="fw6 fs12">${c.name}</div><div class="fs11" style="color:var(--t3)">${c.company}</div></div><div style="text-align:right;min-width:90px"><div class="fw6 mono fs11">${fmt(t)}</div><div class="pb2 mt2" style="height:3px"><div class="pf" style="width:${p}%;height:3px;background:${p>=100?'var(--green)':'var(--amber)'}"></div></div></div></div>`;}).join('')}
</div>
<div class="card"><div class="flex ic sbj mb10"><div class="sect-t" style="margin-bottom:0">Payment Alerts</div><button class="btn btn-sm btn-o" onclick="go('reminders')">All</button></div>
${DB.invoices.filter(i=>i.status!=='paid').slice(0,4).map(inv=>{const c=DB.clients.find(x=>x.id===inv.clientId);const d=daysFrom(inv.dueDate);return`<div class="flex ic gap8" style="padding:8px 0;border-bottom:1px solid var(--border)"><div class="f1"><div class="fw6 fs12">${c?.name||'?'}</div><div class="fs11" style="color:var(--t3)">${inv.number}</div></div><div class="mono fs11 fw7 ${d<0?'tr':d<=7?'ta':''}">${fmt(iBal(inv))}</div>${bh(d<0?`${Math.abs(d)}d Late`:d===0?'Due Today':`${d}d`,d<0?'var(--rd)':d<=7?'var(--ad)':'var(--bd)',d<0?'var(--rb)':d<=7?'var(--al)':'var(--bb)')}</div>`;}).join('')||'<div class="empty" style="padding:12px"><i class="fa fa-check-circle"></i>All paid!</div>'}
</div>
</div>
${(()=>{const pR=DB.requisitions.filter(r=>r.status==='pending');return pR.length?`<div class="abox a-amb mb12" style="cursor:pointer;border-left:4px solid var(--amber)" onclick="go('requisitions')"><i class="fa fa-clipboard-check fa-lg"></i><div><div class="fw7">${pR.length} Client Requisition${pR.length>1?'s':''} Need Your Approval</div><div class="fs11 mt3">${pR.map(r=>r.clientName+' — '+fmt(r.totalValue)+' — by '+uname(r.submittedBy)).join(' · ')}</div><button class="btn btn-xs btn-amb mt5">Review Now →</button></div></div>`:''})()}
<div class="card"><div class="sect-t mb8">Quick Actions</div>
<div class="flex gap7" style="flex-wrap:wrap">
<button class="btn btn-p" onclick="openAddClient()"><i class="fa fa-user-plus"></i> Add Client</button>
<button class="btn btn-o" onclick="openAddLead()"><i class="fa fa-plus"></i> Add Lead</button>
<button class="btn btn-o" onclick="go('invoices');setTimeout(openAddInvoice,200)"><i class="fa fa-file-invoice"></i> Invoice</button>
<button class="btn btn-o" onclick="go('meetings');setTimeout(openAddMeeting,200)"><i class="fa fa-handshake"></i> Log Meeting</button>
<button class="btn btn-o" onclick="go('tasks');setTimeout(openAddTask,200)"><i class="fa fa-tasks"></i> Assign Task</button>
<button class="btn btn-o" onclick="go('expenses');setTimeout(openAddExpense,200)"><i class="fa fa-receipt"></i> Log Expense</button>
<button class="btn btn-o" onclick="go('workload')"><i class="fa fa-chart-gantt"></i> Workload</button>
<button class="btn btn-o" onclick="go('dayplan')"><i class="fa fa-calendar-day"></i> Day Planner</button>
<button class="btn btn-pur" onclick="openBriefGen()"><i class="fa fa-magic"></i> AI Brief</button>
</div></div>`;
}

function salesDash(){
  const t=myTgt();const a=t?tgtAch(t):0;const tot=t?tgtTotal(t):0;const p=pct(a,tot);
  const ml=DB.leads.filter(l=>!l.deleted&&l.assignedTo===DB.currentUser.id);
  const myMeetings=DB.meetings.filter(m=>m.with.includes(DB.currentUser.id));
  const myReqs=DB.requisitions.filter(r=>r.submittedBy===DB.currentUser.id);
  return`${myReqs.filter(r=>r.status==='approved').length?`<div class="abox a-grn mb10"><i class="fa fa-check-circle"></i><div class="fw7">${myReqs.filter(r=>r.status==='approved').length} requisition${myReqs.filter(r=>r.status==='approved').length>1?'s':''} approved by admin — clients are being set up!</div></div>`:''} ${myReqs.filter(r=>r.status==='rejected').length?`<div class="abox a-red mb10"><i class="fa fa-times-circle"></i><div class="fw7">${myReqs.filter(r=>r.status==='rejected').length} requisition${myReqs.filter(r=>r.status==='rejected').length>1?'s':''} rejected — check admin notes</div></div>`:''}
<div class="g4 mb14">
<div class="mc"><div class="mc-icon" style="background:var(--bb)"><i class="fa fa-filter" style="color:var(--blue)"></i></div><div class="mc-lbl">Open Leads</div><div class="mc-val">${ml.filter(l=>l.stageId<7).length}</div></div>
<div class="mc"><div class="mc-icon" style="background:var(--gb)"><i class="fa fa-trophy" style="color:var(--green)"></i></div><div class="mc-lbl">Won</div><div class="mc-val tg">${ml.filter(l=>l.stageId===7).length}</div></div>
<div class="mc"><div class="mc-icon" style="background:var(--al)"><i class="fa fa-bullseye" style="color:var(--amber)"></i></div><div class="mc-lbl">Target</div><div class="mc-val">${p}%</div><div class="mc-sub">${fmt(a)} / ${fmt(tot)}</div></div>
<div class="mc" style="cursor:pointer" onclick="go('meetings')"><div class="mc-icon" style="background:var(--pb)"><i class="fa fa-handshake" style="color:var(--purple)"></i></div><div class="mc-lbl">Meetings This Month</div><div class="mc-val tp">${myMeetings.filter(m=>m.date&&m.date.startsWith('2025-05')).length}</div></div>
</div>
${t?`<div class="card mb12"><div class="sect-t mb10">My Service Targets — May 2025</div>
${(t.items||[]).map(item=>{const ach=tgtItemAch(t,item.id);const p2=pct(ach,item.qty);return`<div style="padding:8px 0;border-bottom:1px solid var(--border)"><div class="flex ic sbj mb5"><div class="fw6 fs12">${item.serviceName}</div><div class="flex ic gap8"><span class="fs11 mono">৳${item.unitPrice}/unit</span><span class="fw7 fs12" style="color:${p2>=100?'var(--green)':p2>=70?'var(--amber)':'var(--red)'}">${ach}/${item.qty}</span></div></div><div class="pb2 mb4" style="height:7px"><div class="pf" style="width:${p2}%;height:7px;background:${p2>=100?'var(--green)':p2>=70?'var(--amber)':'var(--red)'}"></div></div><div class="flex sbj fs11" style="color:var(--t3)"><span>Earned: ${fmt(ach*item.unitPrice)}</span><span>Target: ${fmt(item.qty*item.unitPrice)}</span></div></div>`;}).join('')}
<div class="flex sbj mt10 pt8" style="border-top:1px solid var(--border)"><span class="fw7">Total</span><span class="mono fw8 tg">${fmt(a)} / ${fmt(tot)}</span></div>
</div>`:''}
<div class="card"><div class="sect-t mb8">My Leads</div>
${ml.slice(0,5).map(l=>`<div class="flex ic gap8" style="padding:8px 0;border-bottom:1px solid var(--border);cursor:pointer" onclick="viewLead(${l.id})">${avH(l.name,'#1e3a5f',26,9)}<div class="f1"><div class="fw6 fs12">${l.name}</div><div class="fs11" style="color:var(--t3)">${l.company||'—'}</div></div>${bh(stgLabel(l.stageId),stgColor(l.stageId),'#f8fafc')}<div class="mono fs11 fw7 tg">${fmt(l.budget)}</div></div>`).join('')||'<div class="empty" style="padding:12px">No leads yet</div>'}
<button class="btn btn-p mt10" onclick="go('crm')">Full Pipeline →</button></div>`;
}

function creativeDash(){
  if(isSMM()) return smmDash();
  return designerDash();
}

function smmDash(){
  var me=DB.currentUser;
  var myClients=myVisibleClients();
  var pendingReview=DB.tasks.filter(function(t){return t.status==='done_pending_review'&&t.assignedBy===me.id;});
  var overdue=DB.tasks.filter(function(t){return (t.assignedTo===me.id||t.assignedBy===me.id)&&isOverdue(t);});
  var out=[];
  if(overdue.length) out.push('<div class="abox a-red mb10"><i class="fa fa-exclamation-triangle"></i><div class="fw7">'+overdue.length+' overdue task'+(overdue.length>1?'s':'')+' - action needed</div></div>');
  if(pendingReview.length) out.push('<div class="abox a-pur mb10"><i class="fa fa-eye"></i><div class="fw7">'+pendingReview.length+' designer submission'+(pendingReview.length>1?'s':'')+' waiting for your review</div></div>');
  var monthStr='2025-06';
  var monthPosts=DB.contentPosts.filter(function(p){return myClients.some(function(c){return c.id===p.clientId;})&&p.date&&p.date.startsWith(monthStr);});
  out.push('<div class="g4 mb14">');
  out.push('<div class="mc"><div class="mc-icon" style="background:var(--bb)"><i class="fa fa-users" style="color:var(--blue)"></i></div><div class="mc-lbl">My Clients</div><div class="mc-val">'+myClients.length+'</div></div>');
  out.push('<div class="mc" style="cursor:pointer" onclick="go(\'tasks\')"><div class="mc-icon" style="background:var(--pb)"><i class="fa fa-eye" style="color:var(--purple)"></i></div><div class="mc-lbl">Awaiting Review</div><div class="mc-val tp">'+pendingReview.length+'</div></div>');
  out.push('<div class="mc"><div class="mc-icon" style="background:var(--al)"><i class="fa fa-calendar-alt" style="color:var(--amber)"></i></div><div class="mc-lbl">Posts This Month</div><div class="mc-val ta">'+monthPosts.length+'</div></div>');
  out.push('<div class="mc"><div class="mc-icon" style="background:var(--gb)"><i class="fa fa-check" style="color:var(--green)"></i></div><div class="mc-lbl">Posts Done</div><div class="mc-val tg">'+monthPosts.filter(function(p){return p.status==='done';}).length+'</div></div>');
  out.push('</div>');
  out.push('<div class="sect-t mb10">Client Work Timeline</div>');
  myClients.forEach(function(c){
    var clientPosts=DB.contentPosts.filter(function(p){return p.clientId===c.id&&p.date&&p.date.startsWith(monthStr);});
    var clientTasks=DB.tasks.filter(function(t){return t.clientId===c.id&&t.status!=='done';});
    var done=clientPosts.filter(function(p){return p.status==='done';}).length;
    var inP=clientPosts.filter(function(p){return p.status==='in_progress';}).length;
    var pend=clientPosts.filter(function(p){return p.status==='pending'||p.status==='scheduled';}).length;
    var tot=clientPosts.length;
    var pp=tot?Math.round(done/tot*100):0;
    var late=clientPosts.filter(function(p){return p.status!=='done'&&p.date<'2025-06-05';}).length;
    var assignees={};
    clientTasks.forEach(function(t){
      var uid=t.assignedTo;
      if(!assignees[uid]){var u=DB.users.find(function(x){return x.id===uid;});assignees[uid]={name:u?u.name:'?',color:u?u.color:'#64748b',done:0,total:0,review:0};}
      assignees[uid].total++;
      if(t.status==='done')assignees[uid].done++;
      if(t.status==='done_pending_review')assignees[uid].review++;
    });
    out.push('<div class="card mb10">');
    out.push('<div class="flex ic gap10 mb10">'+avH(c.name,cclr(c.id),32,11)+'<div class="f1"><div class="fw7 fs13">'+c.name+(c.company?' <span class="fs11" style="color:var(--t3)">'+c.company+'</span>':'')+(late?' <span class="badge" style="background:var(--rb);color:var(--rd)">'+late+' late</span>':'')+'</div><div class="fs11" style="color:var(--t3)">'+tot+' posts - '+pp+'% done</div></div><div class="flex gap5"><button class="btn btn-xs btn-o" onclick="go(\'calendar\')"><i class="fa fa-calendar-alt"></i> Calendar</button><button class="btn btn-xs btn-p" onclick="go(\'tasks\')"><i class="fa fa-tasks"></i> Tasks</button></div></div>');
    out.push('<div class="pb2 mb8" style="height:8px"><div class="pf" style="width:'+pp+'%;height:8px;background:'+(pp>=80?'var(--green)':pp>=50?'var(--amber)':'var(--red)')+'></div></div>');
    out.push('<div class="flex gap12 mb10 fs11" style="color:var(--t3)"><span>Done: <strong class="tg">'+done+'</strong></span><span>In Progress: <strong class="ta">'+inP+'</strong></span><span>Pending: <strong>'+pend+'</strong></span><span>Total: <strong>'+tot+'</strong></span></div>');
    var al=Object.values(assignees);
    if(al.length){
      out.push('<div class="sect-t mb7" style="font-size:12px">Designer Breakdown</div><div class="flex gap7" style="flex-wrap:wrap">');
      al.forEach(function(a){
        var ap=a.total?Math.round(a.done/a.total*100):0;
        out.push('<div style="flex:1;min-width:110px;background:var(--bg);border-radius:var(--r);padding:8px;border:1px solid var(--border)">'+avH(a.name,a.color,22,8)+'<div class="fw6 fs11 mt5">'+a.name+'</div><div class="flex sbj fs11 mt4 mb3"><span class="tg">'+a.done+'/'+a.total+'</span>'+(a.review?'<span class="badge" style="background:var(--pb);color:var(--pd)">'+a.review+' review</span>':'')+'</div><div class="pb2" style="height:4px"><div class="pf" style="width:'+ap+'%;height:4px;background:'+(ap>=100?'var(--green)':ap>=60?'var(--amber)':'var(--red)')+'></div></div></div>');
      });
      out.push('</div>');
    }
    if(!tot&&!clientTasks.length) out.push('<div class="abox a-amb mt8"><i class="fa fa-exclamation-circle"></i><div><div class="fw6">No content scheduled</div></div></div>');
    out.push('</div>');
  });
  if(!myClients.length) out.push('<div class="empty"><i class="fa fa-users"></i>No clients assigned yet.</div>');
  return out.join('');
}

function designerDash(){
  var me=DB.currentUser;
  var mt=DB.tasks.filter(function(t){return t.assignedTo===me.id;});
  var od=mt.filter(isOverdue);
  var rev=mt.filter(function(t){return t.approvalStatus==='revision';});
  var pr=mt.filter(function(t){return t.status==='done_pending_review';});
  var out=[];
  if(od.length) out.push('<div class="abox a-red mb10"><i class="fa fa-exclamation-triangle"></i><div class="fw7">'+od.length+' overdue - update your SMM now</div></div>');
  if(rev.length) out.push('<div class="abox a-amb mb10"><i class="fa fa-undo"></i><div class="fw7">'+rev.length+' revision'+(rev.length>1?'s':'')+' needed</div></div>');
  if(pr.length) out.push('<div class="abox a-blu mb10"><i class="fa fa-clock"></i><div class="fw6">'+pr.length+' submitted - waiting SMM approval</div></div>');
  var statDone=mt.filter(function(t){return t.status==='done';}).length;
  var statIP=mt.filter(function(t){return t.status==='in_progress';}).length;
  var statPend=mt.filter(function(t){return t.status==='pending';}).length;
  var todayStr='2025-05-23';
  var todayCt=mt.filter(function(t){return t.scheduledDate===todayStr&&t.status!=='done';}).length;
  out.push('<div class="g4 mb12">');
  out.push('<div class="mc"><div class="mc-icon" style="background:var(--rb)"><i class="fa fa-hourglass-half" style="color:var(--red)"></i></div><div class="mc-lbl">Pending</div><div class="mc-val tr">'+statPend+'</div></div>');
  out.push('<div class="mc"><div class="mc-icon" style="background:var(--al)"><i class="fa fa-spinner" style="color:var(--amber)"></i></div><div class="mc-lbl">In Progress</div><div class="mc-val ta">'+statIP+'</div></div>');
  out.push('<div class="mc"><div class="mc-icon" style="background:var(--gb)"><i class="fa fa-check" style="color:var(--green)"></i></div><div class="mc-lbl">Done</div><div class="mc-val tg">'+statDone+'</div></div>');
  out.push('<div class="mc" style="cursor:pointer" onclick="go(\'dayplan\')"><div class="mc-icon" style="background:var(--al)"><i class="fa fa-calendar-day" style="color:var(--amber)"></i></div><div class="mc-lbl">Scheduled Today</div><div class="mc-val ta">'+todayCt+'</div></div>');
  out.push('</div>');
  var myClientIds=[...new Set(mt.map(function(t){return t.clientId;}))].filter(Boolean);
  if(myClientIds.length){
    out.push('<div class="sect-t mb10">Work by Client</div>');
    myClientIds.forEach(function(cid){
      var c=DB.clients.find(function(x){return x.id===cid;});
      var ctasks=mt.filter(function(t){return t.clientId===cid&&t.status!=='done';});
      if(!ctasks.length)return;
      var doneCt=mt.filter(function(t){return t.clientId===cid&&t.status==='done';}).length;
      var totalCt=mt.filter(function(t){return t.clientId===cid;}).length;
      var assignerIds=[...new Set(ctasks.map(function(t){return t.assignedBy;}))];
      var smm=assignerIds.map(function(id){return DB.users.find(function(u){return u.id===id;});}).filter(Boolean)[0];
      out.push('<div class="card mb10">');
      out.push('<div class="flex ic gap9 mb10">'+avH(c?c.name:'?',cclr(cid),30,10)+'<div class="f1"><div class="fw7 fs13">'+(c?c.name:'Unknown')+'</div><div class="fs11" style="color:var(--t3)">SMM: <strong>'+(smm?smm.name:'Admin')+'</strong></div></div><div class="fs11 mono" style="color:var(--t3)">'+doneCt+'/'+totalCt+' done</div></div>');
      ctasks.slice(0,4).forEach(function(t){
        var lp=t.progress&&t.progress.length?t.progress[t.progress.length-1]:null;
        var od2=isOverdue(t);
        out.push('<div class="flex ic gap8" style="padding:8px 0;border-bottom:1px solid var(--border)">');
        out.push('<div class="f1"><div class="fw6 fs12">'+t.title+(t.recurrence&&t.recurrence.enabled?' <span class="rec-badge">Rec</span>':'')+(t.qty?' <span class="badge" style="background:var(--bb);color:var(--bd)">'+t.qty+' items</span>':'')+'</div>');
        if(t.notes) out.push('<div class="fs11" style="color:var(--t2)">'+t.notes.slice(0,60)+'</div>');
        if(lp) out.push('<div class="fs11" style="color:var(--t3)">Progress: '+lp.note+(lp.done?' - <strong class="tg">'+lp.done+'/'+lp.total+'</strong>':'')+'</div>');
        out.push('</div>');
        out.push('<span class="fs11" style="color:'+(od2?'var(--red)':'var(--t3)')+'">'+fmtD(t.deadline)+'</span>');
        out.push(taskStatusBadge(t));
        out.push('<div class="flex gap3">');
        if(t.status==='pending') out.push('<button class="btn btn-xs btn-blu" onclick="updateTS('+t.id+',\"in_progress\")"><i class="fa fa-play"></i></button>');
        if(t.status==='in_progress'){
          out.push('<button class="btn btn-xs btn-grn" onclick="submitForReview('+t.id+')"><i class="fa fa-paper-plane"></i></button>');
          out.push('<button class="btn btn-xs btn-o" onclick="addProgress('+t.id+')"><i class="fa fa-edit"></i></button>');
        }
        out.push('</div></div>');
      });
      if(ctasks.length>4) out.push('<div class="fs11 mt6" style="color:var(--t3)">+'+( ctasks.length-4)+' more</div>');
      out.push('</div>');
    });
  } else {
    out.push('<div class="empty mb12"><i class="fa fa-inbox"></i>No tasks assigned yet.</div>');
  }
  return out.join('');
}

function pgReminders(){
  return`<div class="ph"><div><div class="ph-t">Payment Reminders</div><div class="ph-s">Auto-escalating reminder system</div></div><button class="btn btn-p" onclick="openReminderTemplates()"><i class="fa fa-cog"></i> Templates</button></div>
<div id="rem-body"></div>`;
}
function renderReminders(){
  const unpaid=DB.invoices.filter(i=>i.status!=='paid');
  const overdueSevere=unpaid.filter(i=>daysFrom(i.dueDate)<-7);const overdueModerate=unpaid.filter(i=>daysFrom(i.dueDate)>=-7&&daysFrom(i.dueDate)<-3);const overdueMild=unpaid.filter(i=>daysFrom(i.dueDate)>=-3&&daysFrom(i.dueDate)<0);const dueSoon=unpaid.filter(i=>daysFrom(i.dueDate)>=0&&daysFrom(i.dueDate)<=7);const upcoming=unpaid.filter(i=>daysFrom(i.dueDate)>7);
  const card=(inv,urgency)=>{const c=DB.clients.find(x=>x.id===inv.clientId);const d=daysFrom(inv.dueDate);const bal=iBal(inv);const colorMap={severe:'var(--red)',moderate:'var(--orange)',mild:'var(--amber)',soon:'var(--blue)',upcoming:'var(--green)'};const sentCount=(inv.reminders||[]).length;
  return`<div class="rem-card ${urgency==='severe'||urgency==='moderate'?'overdue':urgency==='mild'||urgency==='soon'?'urgent':'ok'}">
<div class="flex ic gap12 mb10">${avH(c?.name,cclr(inv.clientId),38,12)}<div class="f1"><div class="fw8 fs13">${c?.name||'?'}</div><div class="fs11" style="color:var(--t3)">${inv.number} · ${inv.period} · ${sentCount} reminder${sentCount!==1?'s':''} sent</div></div>
<div class="mono fw8" style="font-size:18px;color:${colorMap[urgency]||'var(--t1)'}">${fmt(bal)}</div>
${bh(d<0?`${Math.abs(d)}d Overdue`:d===0?'Due Today':`Due in ${d}d`,d<0?'var(--rd)':d<=3?'var(--ad)':d<=7?'var(--bd)':'var(--gd)',d<0?'var(--rb)':d<=3?'var(--al)':d<=7?'var(--bb)':'var(--gb)')}
</div>
<div class="flex gap7 mb10" style="overflow-x:auto">
${['7 days before','3 days before','Due date','3 days after','7 days after'].map((s,i)=>{const states=[d<=7,d<=3,d<=0,d<=-3,d<=-7];const done=states[i];const urg=i>=3;return`<div class="esc-step" style="background:${done?(urg?'var(--rb)':'var(--gb)'):'var(--bg)'};border:1px solid ${done?(urg?'#fca5a5':'#86efac'):'var(--border)'};color:${done?(urg?'var(--rd)':'var(--gd)'):'var(--t3)'};min-width:80px"><div class="fs10 fw7" style="margin-bottom:2px">${s}</div><div class="fs11">${done?'✓':'Pending'}</div></div>`;}).join('')}
</div>
<div class="flex gap7" style="flex-wrap:wrap">
${DB.reminderTemplates.filter(t=>t.channel==='email').map(tpl=>`<button class="btn btn-sm btn-o" onclick="openSendReminder(${inv.id},${tpl.id})"><i class="fa fa-envelope"></i> ${tpl.name}</button>`).join('')}
${DB.reminderTemplates.filter(t=>t.channel==='whatsapp').map(tpl=>`<button class="btn btn-sm btn-grn" onclick="openSendReminder(${inv.id},${tpl.id})"><i class="fab fa-whatsapp"></i> ${tpl.name}</button>`).join('')}
<button class="btn btn-sm btn-o" onclick="openSendReminder(${inv.id},0)"><i class="fa fa-plus"></i> Custom</button>
<button class="btn btn-sm btn-grn" onclick="markPaid(${inv.id})"><i class="fa fa-check"></i> Mark Paid</button>
<button class="btn btn-sm btn-o" onclick="dlInvoice(${inv.id})"><i class="fa fa-download"></i> PDF</button>
<button class="btn btn-sm btn-pur" onclick="openPaymentHistory(${inv.id})"><i class="fa fa-history"></i> History (${sentCount})</button>
</div>
</div>`;};
  const el=document.getElementById('rem-body');if(!el)return;
  const total=unpaid.reduce((s,i)=>s+iBal(i),0);const overdueAmt=unpaid.filter(i=>daysFrom(i.dueDate)<0).reduce((s,i)=>s+iBal(i),0);
  el.innerHTML=`<div class="g4 mb14">
<div class="mc"><div class="mc-icon" style="background:var(--rb)"><i class="fa fa-file-invoice" style="color:var(--red)"></i></div><div class="mc-lbl">Total Outstanding</div><div class="mc-val tr">${fmt(total)}</div><div class="mc-sub">${unpaid.length} invoices</div></div>
<div class="mc"><div class="mc-icon" style="background:var(--rb)"><i class="fa fa-exclamation-triangle" style="color:var(--red)"></i></div><div class="mc-lbl">Overdue Amount</div><div class="mc-val tr">${fmt(overdueAmt)}</div><div class="mc-sub">${unpaid.filter(i=>daysFrom(i.dueDate)<0).length} overdue</div></div>
<div class="mc"><div class="mc-icon" style="background:var(--al)"><i class="fa fa-clock" style="color:var(--amber)"></i></div><div class="mc-lbl">Due This Week</div><div class="mc-val ta">${dueSoon.length}</div></div>
<div class="mc"><div class="mc-icon" style="background:var(--gb)"><i class="fa fa-check-circle" style="color:var(--green)"></i></div><div class="mc-lbl">Upcoming (Safe)</div><div class="mc-val tg">${upcoming.length}</div></div>
</div>
${overdueSevere.length?`<div class="abox a-red mb10"><i class="fa fa-skull fa-lg"></i><div class="fw7">🔴 Critical — ${overdueSevere.length} invoice${overdueSevere.length>1?'s':''} severely overdue (7+ days)</div></div>${overdueSevere.map(i=>card(i,'severe')).join('')}`:''}
${overdueModerate.length?`<div class="sect-t mb8" style="color:var(--orange)">⚠ Overdue 3–7 days (${overdueModerate.length})</div>${overdueModerate.map(i=>card(i,'moderate')).join('')}`:''}
${overdueMild.length?`<div class="sect-t mb8" style="color:var(--amber)">⏰ Overdue 1–3 days (${overdueMild.length})</div>${overdueMild.map(i=>card(i,'mild')).join('')}`:''}
${dueSoon.length?`<div class="sect-t mb8" style="color:var(--blue)">📅 Due within 7 days (${dueSoon.length})</div>${dueSoon.map(i=>card(i,'soon')).join('')}`:''}
${upcoming.length?`<div class="sect-t mb8" style="color:var(--green)">✅ Upcoming — more than 7 days (${upcoming.length})</div>${upcoming.map(i=>card(i,'upcoming')).join('')}`:''}
${!unpaid.length?'<div class="empty"><i class="fa fa-party-horn"></i>All invoices paid! Excellent! 🎉</div>':''}`;
}
function openSendReminder(invId,tplId){
  const inv=DB.invoices.find(x=>x.id===invId);const c=DB.clients.find(x=>x.id===inv?.clientId);const tpl=DB.reminderTemplates.find(x=>x.id===tplId);
  const body=tpl?fillTemplate(tpl.body,inv):`Dear ${c?.name},\n\nYour invoice ${inv?.number} for ${fmt(iBal(inv||{}))} is due on ${fmtD(inv?.dueDate)}.\n\nPlease make the payment at your earliest convenience.\n\nBest regards,\nDMS Creative Agency`;
  showMo(`<div class="mt2">${tpl?tpl.name:'Custom Reminder'} — ${c?.name||'?'} <button class="mc2" onclick="closeMo()"><i class="fa fa-times"></i></button></div>
<div class="fr2"><div class="fg"><label class="flbl">Channel</label><select class="fsel" id="rm-ch"><option value="email" ${!tpl||tpl.channel==='email'?'selected':''}>📧 Email</option><option value="whatsapp" ${tpl?.channel==='whatsapp'?'selected':''}>💬 WhatsApp</option><option value="phone">📞 Phone Call</option><option value="sms">📱 SMS</option></select></div><div class="fg"><label class="flbl">Date Sent</label><input class="finp" type="date" id="rm-date" value="2025-05-23"></div></div>
${tpl?.channel==='email'?`<div class="fg"><label class="flbl">Subject</label><input class="finp" id="rm-subj" value="${tpl?fillTemplate(tpl.subject||'',inv):'Payment Reminder — '+inv?.number}"></div>`:''}
<div class="fg"><label class="flbl">Message</label><textarea class="fta" id="rm-body" style="min-height:140px">${body}</textarea></div>
<div class="fg"><label class="flbl">Notes (internal)</label><input class="finp" id="rm-notes" placeholder="e.g. Client said will pay by Monday"></div>
<div class="mact"><button class="btn btn-o" onclick="closeMo()">Cancel</button><button class="btn btn-p" onclick="logReminder(${invId})"><i class="fa fa-paper-plane"></i> Log as Sent</button>${tpl?.channel==='whatsapp'||!tpl?`<button class="btn btn-grn" onclick="openWhatsApp('${c?.phone||''}',document.getElementById('rm-body').value)"><i class="fab fa-whatsapp"></i> Open WhatsApp</button>`:''}</div>`);}
function logReminder(invId){const inv=DB.invoices.find(x=>x.id===invId);if(!inv)return;if(!inv.reminders)inv.reminders=[];inv.reminders.push({id:uid(),channel:document.getElementById('rm-ch').value,date:document.getElementById('rm-date').value,subject:document.getElementById('rm-subj')?.value||'',message:document.getElementById('rm-body').value,notes:document.getElementById('rm-notes').value,sentBy:DB.currentUser.id});addNotif('📧','#dbeafe',`Reminder sent for ${inv.number}`);save();closeMo();renderReminders();}
function openWhatsApp(phone,msg){window.open(`https://wa.me/${phone.replace(/[^0-9]/g,'')}?text=${encodeURIComponent(msg)}`);}
function openPaymentHistory(invId){const inv=DB.invoices.find(x=>x.id===invId);const c=DB.clients.find(x=>x.id===inv?.clientId);const rems=inv?.reminders||[];
showMo(`<div class="mt2">Reminder History — ${c?.name||'?'} <button class="mc2" onclick="closeMo()"><i class="fa fa-times"></i></button></div>
${rems.length===0?'<div class="empty"><i class="fa fa-inbox"></i>No reminders sent yet</div>':rems.map(r=>`<div style="border:1px solid var(--border);border-radius:var(--r);padding:10px;margin-bottom:8px"><div class="flex ic sbj mb5"><div class="flex ic gap7"><span class="badge" style="background:var(--bb);color:var(--bd)">${r.channel==='email'?'📧 Email':r.channel==='whatsapp'?'💬 WhatsApp':'📞 '+r.channel}</span><span class="fw6 fs12">${fmtD(r.date)}</span></div><span class="fs11" style="color:var(--t3)">By ${uname(r.sentBy)}</span></div>${r.subject?`<div class="fs12 fw6 mb3">${r.subject}</div>`:''}<div class="fs11" style="color:var(--t2);line-height:1.5;max-height:60px;overflow:hidden">${r.message?.slice(0,200)||'—'}</div>${r.notes?`<div class="fs11 mt5" style="color:var(--t3)"><i class="fa fa-sticky-note"></i> ${r.notes}</div>`:''}</div>`).join('')}
<div class="mact"><button class="btn btn-o" onclick="closeMo()">Close</button></div>`);}
function openReminderTemplates(){showMo(`<div class="mt2">Reminder Templates <button class="mc2" onclick="closeMo()"><i class="fa fa-times"></i></button></div>
${DB.reminderTemplates.map(t=>`<div style="border:1px solid var(--border);border-radius:var(--r);padding:10px;margin-bottom:8px"><div class="flex ic sbj mb5"><div class="fw6 fs12">${t.name}</div><div class="flex gap5">${bh(t.channel,'var(--bd)','var(--bb)')}<button class="btn btn-xs btn-red" onclick="DB.reminderTemplates=DB.reminderTemplates.filter(x=>x.id!==${t.id});save();closeMo();openReminderTemplates()"><i class="fa fa-trash"></i></button></div></div><div class="fs11" style="color:var(--t3);line-height:1.4;max-height:50px;overflow:hidden">${t.body?.slice(0,120)}…</div></div>`).join('')}
<div class="sep"></div><div class="sect-t mb8">New Template</div>
<div class="fr2"><div class="fg"><label class="flbl">Name</label><input class="finp" id="nt-name"></div><div class="fg"><label class="flbl">Channel</label><select class="fsel" id="nt-ch"><option value="email">📧 Email</option><option value="whatsapp">💬 WhatsApp</option></select></div></div>
<div class="fg"><label class="flbl">Subject (email only)</label><input class="finp" id="nt-subj" placeholder="Use {CLIENT}, {INVOICE}, {AMOUNT}, {DATE}"></div>
<div class="fg"><label class="flbl">Message Body</label><textarea class="fta" id="nt-body" style="min-height:100px" placeholder="Use {CLIENT}, {INVOICE}, {AMOUNT}, {DATE}"></textarea></div>
<div class="mact"><button class="btn btn-o" onclick="closeMo()">Cancel</button><button class="btn btn-p" onclick="saveReminderTemplate()">Save Template</button></div>`);}
function saveReminderTemplate(){const name=document.getElementById('nt-name')?.value?.trim();if(!name)return;DB.reminderTemplates.push({id:uid(),name,channel:document.getElementById('nt-ch').value,subject:document.getElementById('nt-subj').value,body:document.getElementById('nt-body').value,trigger:'manual'});save();closeMo();openReminderTemplates();}
function markPaid(id){const i=DB.invoices.find(x=>x.id===id);if(i){i.status='paid';i.paidDate=new Date().toISOString().split('T')[0];save();const c=DB.clients.find(x=>x.id===i.clientId);addNotif('💰','#d1fae5',`Payment received — ${c?.name} (${i.number} · ${fmt(iBal(i))})`);if(DB.currentPage==='reminders')renderReminders();if(DB.currentPage==='invoices')renderIT();}}

// ══════ MEETINGS — Full tracking with filters ══════
function pgMeetings(){
  const members=DB.users.filter(u=>u.active);const clients=[...DB.clients.map(c=>({id:'c'+c.id,name:c.name,type:'client'})),...DB.leads.filter(l=>!l.deleted).map(l=>({id:'l'+l.id,name:l.name,type:'lead'}))];
  return`<div class="ph"><div><div class="ph-t">Meetings</div><div class="ph-s">${DB.meetings.length} total</div></div><button class="btn btn-p" onclick="openAddMeeting()"><i class="fa fa-plus"></i> Log Meeting</button></div>
<div class="fbar mb14">
<label>Member:</label><select class="fsel" id="mf-user" onchange="renderMeetings()"><option value="">All Members</option>${members.map(u=>`<option value="${u.id}">${u.name}</option>`).join('')}</select>
<label>Type:</label><select class="fsel" id="mf-type" onchange="renderMeetings()"><option value="">All Types</option><option value="client">Client</option><option value="prospect">Prospect/Lead</option><option value="internal">Internal</option></select>
<label>Status:</label><select class="fsel" id="mf-status" onchange="renderMeetings()"><option value="">All</option><option value="scheduled">Scheduled</option><option value="completed">Completed</option><option value="cancelled">Cancelled</option></select>
<label>From:</label><input class="finp" type="date" id="mf-from" onchange="renderMeetings()">
<label>To:</label><input class="finp" type="date" id="mf-to" onchange="renderMeetings()">
<button class="btn btn-sm btn-o" onclick="clearMeetFilters()"><i class="fa fa-times"></i> Clear</button>
</div>
<div id="meet-summary" class="g4 mb14"></div>
<div id="meet-list"></div>`;
}
function clearMeetFilters(){['mf-user','mf-type','mf-status','mf-from','mf-to'].forEach(id=>{const el=document.getElementById(id);if(el)el.value='';});renderMeetings();}
function renderMeetings(){
  const fu=parseInt(document.getElementById('mf-user')?.value)||0;const ft=document.getElementById('mf-type')?.value||'';const fs=document.getElementById('mf-status')?.value||'';const frm=document.getElementById('mf-from')?.value||'';const fto=document.getElementById('mf-to')?.value||'';
  let meets=DB.meetings;
  if(!isOwner())meets=meets.filter(m=>m.with.includes(DB.currentUser.id)||m.createdBy===DB.currentUser.id);
  if(fu)meets=meets.filter(m=>m.with.includes(fu));
  if(ft)meets=meets.filter(m=>m.type===ft);
  if(fs)meets=meets.filter(m=>m.status===fs);
  if(frm)meets=meets.filter(m=>m.date>=frm);
  if(fto)meets=meets.filter(m=>m.date<=fto);
  // Sort by date desc
  meets=meets.sort((a,b)=>b.date.localeCompare(a.date));
  const totalMin=meets.filter(m=>m.status==='completed').reduce((s,m)=>s+(m.duration||0),0);
  const sumEl=document.getElementById('meet-summary');if(sumEl)sumEl.innerHTML=`<div class="mc"><div class="mc-icon" style="background:var(--bb)"><i class="fa fa-calendar-check" style="color:var(--blue)"></i></div><div class="mc-lbl">Total Meetings</div><div class="mc-val">${meets.length}</div></div><div class="mc"><div class="mc-icon" style="background:var(--gb)"><i class="fa fa-check" style="color:var(--green)"></i></div><div class="mc-lbl">Completed</div><div class="mc-val tg">${meets.filter(m=>m.status==='completed').length}</div></div><div class="mc"><div class="mc-icon" style="background:var(--pb)"><i class="fa fa-clock" style="color:var(--purple)"></i></div><div class="mc-lbl">Scheduled</div><div class="mc-val tp">${meets.filter(m=>m.status==='scheduled').length}</div></div><div class="mc"><div class="mc-icon" style="background:var(--al)"><i class="fa fa-hourglass" style="color:var(--amber)"></i></div><div class="mc-lbl">Total Time</div><div class="mc-val">${Math.round(totalMin/60)}h</div><div class="mc-sub">${totalMin} min</div></div>`;
  const listEl=document.getElementById('meet-list');if(!listEl)return;
  listEl.innerHTML=`<div class="tw"><table><thead><tr><th>Date & Time</th><th>With (Client/Lead)</th><th>Attendees</th><th>Type</th><th>Agenda</th><th>Duration</th><th>Status</th><th>Outcome</th><th>Actions</th></tr></thead><tbody>
${meets.map(m=>{const dd=m.date.split('-');const parts=m.with.map(uid=>DB.users.find(x=>x.id===uid)).filter(Boolean);return`<tr>
<td><div class="fw7 fs12">${fmtD(m.date)}</div><div class="fs11" style="color:var(--t3)">${m.time||'—'}</div></td>
<td><div class="fw6 fs12">${m.clientName||'—'}</div><div class="fs11" style="color:var(--t3)">${m.location||'—'}</div></td>
<td><div class="flex gap4">${parts.map(u=>avH(u.name,u.color,22,8)).join('')}</div></td>
<td>${bh(m.type==='client'?'Client':m.type==='prospect'?'Prospect':'Internal',m.type==='client'?'var(--gd)':m.type==='prospect'?'var(--pd)':'var(--td)',m.type==='client'?'var(--gb)':m.type==='prospect'?'var(--pb)':'var(--tb)')}</td>
<td class="fs12" style="max-width:140px;white-space:normal">${m.agenda||'—'}</td>
<td class="fs12">${m.duration?m.duration+'min':'—'}</td>
<td>${bh(m.status,m.status==='completed'?'var(--gd)':m.status==='scheduled'?'var(--bd)':'var(--rd)',m.status==='completed'?'var(--gb)':m.status==='scheduled'?'var(--bb)':'var(--rb)')}</td>
<td class="fs12" style="max-width:120px;white-space:normal;color:var(--t2)">${m.outcome||'—'}</td>
<td><div class="flex gap4"><button class="btn btn-xs btn-o" onclick="viewMeeting(${m.id})"><i class="fa fa-eye"></i></button>${isOwner()||m.createdBy===DB.currentUser.id?`<button class="btn btn-xs btn-red" onclick="if(confirm('Delete?')){DB.meetings=DB.meetings.filter(x=>x.id!==${m.id});save();renderMeetings()}"><i class="fa fa-trash"></i></button>`:''}</div></td></tr>`;}).join('')||'<tr><td colspan="9" style="text-align:center;color:var(--t3);padding:20px">No meetings found</td></tr>'}
</tbody></table></div>`;
}
function openAddMeeting(pre={}){
  const creative=DB.users.filter(u=>u.active);const allContacts=[...DB.clients.map(c=>({id:'c'+c.id,name:c.name+' (Client)',clientId:c.id,leadId:null})),...DB.leads.filter(l=>!l.deleted).map(l=>({id:'l'+l.id,name:l.name+' (Lead - '+stgLabel(l.stageId)+')',clientId:null,leadId:l.id}))];
  showMo(`<div class="mt2">${pre.id?'Edit':'Log'} Meeting <button class="mc2" onclick="closeMo()"><i class="fa fa-times"></i></button></div>
<div class="fr2"><div class="fg"><label class="flbl">Meeting With *</label><select class="fsel" id="mt-with"><option value="">Select client/lead…</option>${allContacts.map(x=>`<option value="${x.id}" data-cid="${x.clientId||''}" data-lid="${x.leadId||''}">${x.name}</option>`).join('')}</select></div><div class="fg"><label class="flbl">Meeting Type</label><select class="fsel" id="mt-type"><option value="prospect">Prospect Meeting</option><option value="client">Client Meeting</option><option value="internal">Internal</option></select></div></div>
<div class="fr3"><div class="fg"><label class="flbl">Date *</label><input class="finp" type="date" id="mt-date" value="${pre.date||'2025-05-23'}"></div><div class="fg"><label class="flbl">Time</label><input class="finp" type="time" id="mt-time" value="${pre.time||''}"></div><div class="fg"><label class="flbl">Duration (min)</label><input class="finp" type="number" id="mt-dur" value="${pre.duration||60}"></div></div>
<div class="fr2"><div class="fg"><label class="flbl">Location / Channel</label><select class="fsel" id="mt-loc"><option>Office</option><option>Client Office</option><option>Zoom</option><option>Google Meet</option><option>Phone Call</option><option>Restaurant</option><option>Other</option></select></div><div class="fg"><label class="flbl">Status</label><select class="fsel" id="mt-status"><option value="scheduled">Scheduled</option><option value="completed" ${!pre.id?'selected':''}>Completed</option></select></div></div>
<div class="fg"><label class="flbl">Attendees (who from our team)</label><div class="flex gap5" style="flex-wrap:wrap">${creative.map(u=>`<label style="display:flex;align-items:center;gap:5px;font-size:11px;cursor:pointer;padding:3px 8px;border:1px solid var(--border);border-radius:20px;background:#fff"><input type="checkbox" id="mt-att-${u.id}" ${(pre.with||[DB.currentUser.id]).includes(u.id)?'checked':''} style="accent-color:var(--amber)">${u.name}</label>`).join('')}</div></div>
<div class="fg"><label class="flbl">Agenda / Purpose *</label><input class="finp" id="mt-agenda" value="${pre.agenda||''}"></div>
<div class="fg"><label class="flbl">Outcome / Notes (if completed)</label><textarea class="fta" id="mt-outcome" style="min-height:50px">${pre.outcome||''}</textarea></div>
<div class="fg"><label class="flbl">Next Action</label><input class="finp" id="mt-next" value="${pre.nextAction||''}" placeholder="e.g. Send proposal by June 5"></div>
<div class="mact"><button class="btn btn-o" onclick="closeMo()">Cancel</button><button class="btn btn-p" onclick="saveMeeting(${pre.id||0})">Save Meeting</button></div>`,true);}
async function saveMeeting(id){
  const selEl=document.getElementById('mt-with');const selOpt=selEl?.options[selEl.selectedIndex];const selVal=selEl?.value||'';const clientId=selOpt?.dataset?.cid?parseInt(selOpt.dataset.cid)||null:null;const leadId=selOpt?.dataset?.lid?parseInt(selOpt.dataset.lid)||null:null;const clientName=selOpt?.text?.replace(/ \(.*?\)/,'').trim()||'';
  const attendees=DB.users.filter(u=>document.getElementById('mt-att-'+u.id)?.checked).map(u=>u.id);
  const d={clientName,clientId,leadId,date:document.getElementById('mt-date').value,time:document.getElementById('mt-time').value,duration:parseInt(document.getElementById('mt-dur').value)||60,location:document.getElementById('mt-loc').value,status:document.getElementById('mt-status').value,agenda:document.getElementById('mt-agenda').value,outcome:document.getElementById('mt-outcome').value,nextAction:document.getElementById('mt-next').value,attendees};
  try{await saveEntity('meetings',id,d);await loadFromAPI();closeMo();renderMeetings();}catch(e){alert(e.message||'Meeting save failed');}
}
function viewMeeting(id){const m=DB.meetings.find(x=>x.id===id);if(!m)return;const parts=m.with.map(uid=>DB.users.find(x=>x.id===uid)).filter(Boolean);
showMo(`<div class="mt2">Meeting — ${m.clientName||'Internal'} <button class="mc2" onclick="closeMo()"><i class="fa fa-times"></i></button></div>
<div class="g2 mb12"><div><div class="fs10 mb2" style="color:var(--t3)">Date & Time</div><div class="fw7">${fmtD(m.date)} ${m.time?'at '+m.time:''}</div></div><div><div class="fs10 mb2" style="color:var(--t3)">Location</div><div class="fw6">${m.location||'—'}</div></div><div><div class="fs10 mb2" style="color:var(--t3)">Duration</div><div>${m.duration||'—'} min</div></div><div><div class="fs10 mb2" style="color:var(--t3)">Status</div>${bh(m.status,m.status==='completed'?'var(--gd)':'var(--bd)',m.status==='completed'?'var(--gb)':'var(--bb)')}</div></div>
<div class="mb10"><div class="fs10 mb4" style="color:var(--t3)">Attendees</div><div class="flex gap5">${parts.map(u=>`<div class="flex ic gap5">${avH(u.name,u.color,24,9)}<span class="fs11 fw6">${u.name}</span></div>`).join('')}</div></div>
${m.agenda?`<div class="mb8"><div class="fs10 mb2" style="color:var(--t3)">Agenda</div><div class="fs12">${m.agenda}</div></div>`:''}
${m.outcome?`<div class="mb8"><div class="fs10 mb2" style="color:var(--t3)">Outcome</div><div class="fs12" style="background:var(--gb);border-radius:var(--r);padding:8px">${m.outcome}</div></div>`:''}
${m.nextAction?`<div class="mb8"><div class="fs10 mb2" style="color:var(--t3)">Next Action</div><div class="fs12 fw6">${m.nextAction}</div></div>`:''}
<div class="mact"><button class="btn btn-o" onclick="closeMo()">Close</button><button class="btn btn-o" onclick="closeMo();openAddMeeting(DB.meetings.find(x=>x.id===${id}))"><i class="fa fa-edit"></i> Edit</button></div>`);}

// ══════ MY WORK — Personal Work Tracker ══════
function pgMyWork(){
  const me=DB.currentUser;const items=DB.myWorkItems.filter(w=>w.userId===me.id);const CATS=['call','email','proposal','design','planning','meeting','review','research','other'];const PRIS=['high','medium','low'];
  return`<div class="ph"><div><div class="ph-t">My Work</div><div class="ph-s">Personal task & work item tracker</div></div><button class="btn btn-p" onclick="openAddWorkItem()"><i class="fa fa-plus"></i> Add Work Item</button></div>
<div class="g4 mb12">
<div class="mc"><div class="mc-icon" style="background:var(--rb)"><i class="fa fa-circle-dot" style="color:var(--red)"></i></div><div class="mc-lbl">Pending</div><div class="mc-val tr">${items.filter(w=>w.status==='pending').length}</div></div>
<div class="mc"><div class="mc-icon" style="background:var(--al)"><i class="fa fa-spinner" style="color:var(--amber)"></i></div><div class="mc-lbl">In Progress</div><div class="mc-val ta">${items.filter(w=>w.status==='in_progress').length}</div></div>
<div class="mc"><div class="mc-icon" style="background:var(--gb)"><i class="fa fa-check" style="color:var(--green)"></i></div><div class="mc-lbl">Done</div><div class="mc-val tg">${items.filter(w=>w.status==='done').length}</div></div>
<div class="mc"><div class="mc-icon" style="background:var(--rb)"><i class="fa fa-fire" style="color:var(--red)"></i></div><div class="mc-lbl">Overdue</div><div class="mc-val tr">${items.filter(w=>w.status!=='done'&&w.dueDate&&daysFrom(w.dueDate)<0).length}</div></div>
</div>
<div class="fbar mb12">
<label>Status:</label><select class="fsel" id="wf-status" onchange="renderMyWork()"><option value="">All</option><option value="pending">Pending</option><option value="in_progress">In Progress</option><option value="done">Done</option></select>
<label>Category:</label><select class="fsel" id="wf-cat" onchange="renderMyWork()"><option value="">All Categories</option>${CATS.map(c=>`<option>${c}</option>`).join('')}</select>
<label>Priority:</label><select class="fsel" id="wf-pri" onchange="renderMyWork()"><option value="">All</option>${PRIS.map(p=>`<option>${p}</option>`).join('')}</select>
</div>
<div id="mywork-list"></div>`;
}
function renderMyWork(){
  const me=DB.currentUser;let items=DB.myWorkItems.filter(w=>w.userId===me.id);const fs=document.getElementById('wf-status')?.value||'';const fc=document.getElementById('wf-cat')?.value||'';const fp=document.getElementById('wf-pri')?.value||'';
  if(fs)items=items.filter(w=>w.status===fs);if(fc)items=items.filter(w=>w.category===fc);if(fp)items=items.filter(w=>w.priority===fp);
  items=items.sort((a,b)=>{const po={high:0,medium:1,low:2};const oda=a.status!=='done'&&a.dueDate&&daysFrom(a.dueDate)<0;const odb=b.status!=='done'&&b.dueDate&&daysFrom(b.dueDate)<0;if(oda&&!odb)return -1;if(!oda&&odb)return 1;return (po[a.priority]||1)-(po[b.priority]||1);});
  const CAT_ICONS={call:'📞',email:'📧',proposal:'📋',design:'🎨',planning:'📅',meeting:'🤝',review:'👁️',research:'🔍',other:'📌'};
  const el=document.getElementById('mywork-list');if(!el)return;
  el.innerHTML=items.map(w=>{const od=w.status!=='done'&&w.dueDate&&daysFrom(w.dueDate)<0;const due=w.status!=='done'&&w.dueDate&&daysFrom(w.dueDate)>=0&&daysFrom(w.dueDate)<=2;return`<div class="witem ${w.status==='done'?'done-item':''} ${od?'overdue-item':''}">
<div style="margin-top:3px;font-size:18px">${CAT_ICONS[w.category]||'📌'}</div>
<div class="f1">
<div class="flex ic gap7 mb4">
<div class="fw6 fs13 f1" style="${w.status==='done'?'text-decoration:line-through;color:var(--t3)':''}">${w.title}</div>
${bh(w.priority,w.priority==='high'?'var(--rd)':w.priority==='low'?'var(--gd)':'var(--ad)',w.priority==='high'?'var(--rb)':w.priority==='low'?'var(--gb)':'var(--al)')}
${bh(w.category,'var(--td)','var(--tb)')}
${w.status==='done'?bh('Done','var(--gd)','var(--gb)'):bh(w.status.replace('_',' '),'var(--t2)','var(--bg)')}
</div>
${w.notes?`<div class="fs12 mb4" style="color:var(--t2)">${w.notes}</div>`:''}
<div class="flex ic gap10 fs11" style="color:var(--t3)">
<span><i class="fa fa-calendar"></i> ${fmtD(w.dueDate)} ${od?`<strong class="tr">(${Math.abs(daysFrom(w.dueDate))}d overdue)</strong>`:due?`<strong class="ta">(due soon)</strong>`:''}</span>
<span>Created: ${fmtD(w.createdAt)}</span>
${w.completedAt?`<span class="tg"><i class="fa fa-check"></i> Done: ${fmtD(w.completedAt)}</span>`:''}
</div>
</div>
<div class="flex gap4" style="flex-direction:column">
${w.status==='pending'?`<button class="btn btn-xs btn-blu" onclick="updateWorkItem(${w.id},'in_progress')"><i class="fa fa-play"></i> Start</button>`:''}
${w.status==='in_progress'?`<button class="btn btn-xs btn-grn" onclick="updateWorkItem(${w.id},'done')"><i class="fa fa-check"></i> Done</button>`:''}
${w.status==='done'?`<button class="btn btn-xs btn-o" onclick="updateWorkItem(${w.id},'in_progress')"><i class="fa fa-redo"></i></button>`:''}
<button class="btn btn-xs btn-o" onclick="openAddWorkItem(DB.myWorkItems.find(x=>x.id===${w.id}))"><i class="fa fa-edit"></i></button>
<button class="btn btn-xs btn-red" onclick="deleteWorkItem(${w.id})"><i class="fa fa-trash"></i></button>
</div>
</div>`;}).join('')||'<div class="empty"><i class="fa fa-list-check"></i>No work items. Add your first task!</div>';
}
function openAddWorkItem(pre={}){const CATS=['call','email','proposal','design','planning','meeting','review','research','other'];
showMo(`<div class="mt2">${pre.id?'Edit':'Add'} Work Item <button class="mc2" onclick="closeMo()"><i class="fa fa-times"></i></button></div>
<div class="fg"><label class="flbl">Title *</label><input class="finp" id="wi-title" value="${pre.title||''}"></div>
<div class="fr3"><div class="fg"><label class="flbl">Category</label><select class="fsel" id="wi-cat">${CATS.map(c=>`<option ${pre.category===c?'selected':''}>${c}</option>`).join('')}</select></div><div class="fg"><label class="flbl">Priority</label><select class="fsel" id="wi-pri"><option value="high" ${pre.priority==='high'?'selected':''}>High</option><option value="medium" ${(!pre.priority||pre.priority==='medium')?'selected':''}>Medium</option><option value="low" ${pre.priority==='low'?'selected':''}>Low</option></select></div><div class="fg"><label class="flbl">Due Date</label><input class="finp" type="date" id="wi-due" value="${pre.dueDate||''}"></div></div>
<div class="fg"><label class="flbl">Notes</label><textarea class="fta" id="wi-notes" style="min-height:50px">${pre.notes||''}</textarea></div>
<div class="mact"><button class="btn btn-o" onclick="closeMo()">Cancel</button><button class="btn btn-p" onclick="saveWorkItem(${pre.id||0})">Save</button></div>`);}
async function saveWorkItem(id){const title=document.getElementById('wi-title').value.trim();if(!title)return;const d={title,category:document.getElementById('wi-cat').value,priority:document.getElementById('wi-pri').value,dueDate:document.getElementById('wi-due').value||null,notes:document.getElementById('wi-notes').value,status:id?(DB.myWorkItems.find(x=>x.id===id)?.status||'pending'):'pending'};try{await saveEntity('my-work-items',id,d);await loadFromAPI();closeMo();renderMyWork();}catch(e){alert(e.message||'Work item save failed');}}
async function updateWorkItem(id,status){const d={status,completedAt:status==='done'?new Date().toISOString().split('T')[0]:null};try{await saveEntity('my-work-items',id,d);await loadFromAPI();renderMyWork();}catch(e){alert(e.message||'Work item update failed');}}
async function deleteWorkItem(id){if(!confirm('Delete?'))return;try{await API.delete('/my-work-items/'+id);await loadFromAPI();renderMyWork();}catch(e){alert(e.message||'Work item delete failed');}}

// ══════ TARGETS — Fully Admin-Defined, Any Service ══════
function pgTargets(){return`<div class="ph"><div class="ph-t">Sales Targets</div><div class="ph-s">Set custom service targets for your sales team</div></div><div class="flex gap7 mb14"><button class="btn btn-p" onclick="openSetTarget()"><i class="fa fa-plus"></i> Create Target</button><button class="btn btn-sm btn-o" onclick="go('reports')"><i class="fa fa-chart-bar"></i> View Target Report</button></div>
${DB.targets.length===0?'<div class="empty"><i class="fa fa-bullseye"></i>No targets set. Create one for your sales team.</div>':DB.targets.map(t=>{const u=DB.users.find(x=>x.id===t.userId);const a=tgtAch(t);const tot=tgtTotal(t);const p=pct(a,tot);const rem=Math.max(0,tot-a);
return`<div class="card mb14">
<div class="flex ic gap10 mb12">${avH(u?.name,u?.color,38,12)}<div class="f1"><div class="fw8 fs13">${u?.name}</div><div class="fs11" style="color:var(--t3)">${u?.designation} · ${t.label||t.month}</div></div><div style="text-align:right"><div class="mono fw8" style="font-size:22px;color:${p>=100?'var(--green)':p>=70?'var(--amber)':'var(--red)'}">${p}%</div></div></div>
<div class="pb2 mb8" style="height:10px"><div class="pf" style="width:${p}%;height:10px;background:${p>=100?'var(--green)':p>=70?'var(--amber)':'var(--red)'}"></div></div>
<div class="g3 mb12"><div style="text-align:center;background:var(--bg);border-radius:var(--r);padding:10px"><div class="fs10 mb2" style="color:var(--t3);text-transform:uppercase">Target</div><div class="mono fw7 fs14">${fmt(tot)}</div></div><div style="text-align:center;background:var(--gb);border-radius:var(--r);padding:10px"><div class="fs10 mb2" style="color:var(--gd);text-transform:uppercase">Achieved</div><div class="mono fw7 fs14 tg">${fmt(a)}</div></div><div style="text-align:center;background:${rem?'var(--rb)':'var(--gb)'};border-radius:var(--r);padding:10px"><div class="fs10 mb2" style="color:${rem?'var(--rd)':'var(--gd)'};text-transform:uppercase">Remaining</div><div class="mono fw7 fs14" style="color:${rem?'var(--red)':'var(--green)'}">${fmt(rem)}</div></div></div>
<div class="sect-t mb8">Service-Level Breakdown</div>
${(t.items||[]).map(item=>{const ach=tgtItemAch(t,item.id);const p2=pct(ach,item.qty);return`<div class="pb-wrap">
<div class="flex ic sbj mb6"><div><div class="fw7 fs12">${item.serviceName}</div><div class="fs11" style="color:var(--t3)">${fmt(item.unitPrice)}/unit · Target: ${item.qty} units</div></div><div style="text-align:right"><div class="fw8 fs13" style="color:${p2>=100?'var(--green)':p2>=70?'var(--amber)':'var(--red)'}">${ach}/${item.qty}</div><div class="fs11" style="color:var(--t3)">${p2}% done</div></div></div>
<div class="pb2 mb5" style="height:7px"><div class="pf" style="width:${p2}%;height:7px;background:${p2>=100?'var(--green)':p2>=70?'var(--amber)':'var(--red)'}"></div></div>
<div class="flex sbj fs11" style="color:var(--t3)"><span>Earned: <strong class="tg">${fmt(ach*item.unitPrice)}</strong></span><span>Target: <strong>${fmt(item.qty*item.unitPrice)}</strong></span><span>Gap: <strong class="${ach<item.qty?'tr':'tg'}">${Math.max(0,item.qty-ach)} units</strong></span></div>
</div>`;}).join('') }
<div class="sect-t mb6">Deals Logged (${(t.deals||[]).length})</div>
<div class="tw mb10"><table><thead><tr><th>Client</th><th>Service</th><th>Units</th><th>Amount</th><th>Date</th><th></th></tr></thead><tbody>
${(t.deals||[]).map((d,idx)=>`<tr><td>${d.client}</td><td class="fs11">${d.service||'—'}</td><td class="mono">${d.qty||'—'}</td><td class="mono tg">${fmt(d.amount)}</td><td class="fs11">${fmtD(d.date)}</td><td><button class="btn btn-xs btn-red" onclick="DB.targets.find(x=>x.id===${t.id}).deals.splice(${idx},1);save();go('targets')"><i class="fa fa-trash"></i></button></td></tr>`).join('')||'<tr><td colspan="6" style="text-align:center;color:var(--t3);padding:12px">No deals logged</td></tr>'}
</tbody></table></div>
<div class="flex gap7"><button class="btn btn-sm btn-o" onclick="openAddDeal(${t.id})"><i class="fa fa-plus"></i> Log Deal</button><button class="btn btn-sm btn-o" onclick="openSetTarget(DB.targets.find(x=>x.id===${t.id}))"><i class="fa fa-edit"></i> Edit Target</button><button class="btn btn-sm btn-red" onclick="if(confirm('Delete target?')){DB.targets=DB.targets.filter(x=>x.id!==${t.id});save();go('targets')}"><i class="fa fa-trash"></i></button></div>
</div>`;}).join('')}`;}

function pgMyTarget(){
  const t=myTgt();if(!t)return`<div class="empty"><i class="fa fa-bullseye"></i>No target assigned yet. Ask admin to create one for you.</div>`;
  const a=tgtAch(t);const tot=tgtTotal(t);const p=pct(a,tot);const rem=Math.max(0,tot-a);
  return`<div class="ph"><div class="ph-t">My Target — ${t.label||t.month}</div></div>
<div class="card mb14">
<div class="flex ic gap12 mb12">${avH(DB.currentUser.name,DB.currentUser.color,42,14)}<div class="f1"><div class="fw8 fs15">${DB.currentUser.name}</div><div class="fs12" style="color:var(--t3)">${DB.currentUser.designation}</div></div><div class="mono fw8" style="font-size:28px;color:${p>=100?'var(--green)':p>=70?'var(--amber)':'var(--red)'}">${p}%</div></div>
<div class="pb2 mb10" style="height:12px"><div class="pf" style="width:${p}%;height:12px;background:${p>=100?'var(--green)':p>=70?'var(--amber)':'var(--red)'}"></div></div>
<div class="g3 mb14"><div style="text-align:center;background:var(--bg);border-radius:var(--r);padding:12px"><div class="fs10 mb2" style="color:var(--t3);text-transform:uppercase">Total Target</div><div class="mono fw8 fs15">${fmt(tot)}</div></div><div style="text-align:center;background:var(--gb);border-radius:var(--r);padding:12px"><div class="fs10 mb2" style="color:var(--gd);text-transform:uppercase">Achieved</div><div class="mono fw8 fs15 tg">${fmt(a)}</div></div><div style="text-align:center;background:${rem?'var(--rb)':'var(--gb)'};border-radius:var(--r);padding:12px"><div class="fs10 mb2" style="color:${rem?'var(--rd)':'var(--gd)'};text-transform:uppercase">Remaining</div><div class="mono fw8 fs15" style="color:${rem?'var(--red)':'var(--green)'}">${fmt(rem)}</div></div></div>
${(t.items||[]).map(item=>{const ach=tgtItemAch(t,item.id);const p2=pct(ach,item.qty);return`<div class="pb-wrap"><div class="flex ic sbj mb7"><div><div class="fw7 fs13">${item.serviceName}</div><div class="fs11" style="color:var(--t3)">${fmt(item.unitPrice)} per unit</div></div><div style="text-align:right"><div class="fw8 fs14" style="color:${p2>=100?'var(--green)':p2>=70?'var(--amber)':'var(--red)'}">${ach} / ${item.qty} units</div></div></div><div class="pb2 mb5" style="height:8px"><div class="pf" style="width:${p2}%;height:8px;background:${p2>=100?'var(--green)':p2>=70?'var(--amber)':'var(--red)'}"></div></div><div class="flex sbj fs11" style="color:var(--t3)"><span>Earned: <strong class="tg">${fmt(ach*item.unitPrice)}</strong></span><span>Target: <strong>${fmt(item.qty*item.unitPrice)}</strong></span><span>Remaining: <strong class="${ach<item.qty?'tr':'tg'}">${Math.max(0,item.qty-ach)} units left</strong></span></div></div>`;}).join('')}
<div class="sect-t mt12 mb7">My Deals (${(t.deals||[]).length})</div>
<div class="tw mb12"><table><thead><tr><th>Client</th><th>Service</th><th>Units</th><th>Amount</th><th>Date</th></tr></thead><tbody>${(t.deals||[]).map(d=>`<tr><td>${d.client}</td><td class="fs11">${d.service||'—'}</td><td class="mono">${d.qty||'—'}</td><td class="mono tg">${fmt(d.amount)}</td><td class="fs11">${fmtD(d.date)}</td></tr>`).join('')||'<tr><td colspan="5" style="text-align:center;color:var(--t3);padding:12px">No deals yet</td></tr>'}</tbody></table></div>
<button class="btn btn-p" onclick="openAddDeal(${t.id})"><i class="fa fa-plus"></i> Log Closed Deal</button></div>`;
}

function openSetTarget(pre={}){
  const salesUsers=DB.users.filter(u=>u.active&&u.role!=='owner');
  const existItems=pre.items||[];
  let itemsHtml=existItems.map((item,idx)=>`<div class="srvc-row" id="titem-${item.id||idx}">
<input class="finp f1" id="ti-name-${item.id||idx}" value="${item.serviceName||''}" placeholder="Service name (e.g. 50 Designs)">
<input type="number" id="ti-qty-${item.id||idx}" value="${item.qty||''}" placeholder="Qty" style="width:65px;border:1px solid var(--border);border-radius:6px;padding:5px 7px;font-size:12px" oninput="calcTargetTotal()">
<span style="font-size:11px;color:var(--t3)">×</span>
<input type="number" id="ti-price-${item.id||idx}" value="${item.unitPrice||''}" placeholder="Unit Price ৳" style="width:90px;border:1px solid var(--border);border-radius:6px;padding:5px 7px;font-size:12px" oninput="calcTargetTotal()">
<div class="mono fs11 fw7" id="ti-sub-${item.id||idx}" style="min-width:70px;text-align:right">${item.qty&&item.unitPrice?fmt(item.qty*item.unitPrice):'—'}</div>
<button class="btn btn-xs btn-red" onclick="this.closest('.srvc-row').remove();calcTargetTotal()"><i class="fa fa-times"></i></button>
</div>`).join('');
  showMo(`<div class="mt2">${pre.id?'Edit':'Create'} Target <button class="mc2" onclick="closeMo()"><i class="fa fa-times"></i></button></div>
<div class="fr2"><div class="fg"><label class="flbl">Sales Member *</label><select class="fsel" id="tu">${salesUsers.map(u=>`<option value="${u.id}" ${pre.userId===u.id?'selected':''}>${u.name}</option>`).join('')}</select></div><div class="fg"><label class="flbl">Month / Period</label><input class="finp" id="tm" value="${pre.month||'2025-05'}" placeholder="2025-05"></div></div>
<div class="fg"><label class="flbl">Label (optional)</label><input class="finp" id="tl" value="${pre.label||''}" placeholder="e.g. May 2025 Sales Target"></div>
<div class="sect-t mb6">Service Targets — Add each service with quantity & price</div>
<div id="titem-wrap">${itemsHtml||''}</div>
<button class="btn btn-sm btn-o mb10" onclick="addTargetItem()"><i class="fa fa-plus"></i> Add Service Row</button>
<div style="background:var(--gb);border-radius:var(--r);padding:10px;display:flex;justify-content:space-between;align-items:center"><span class="fw7">Auto-Calculated Total Target</span><span class="mono fw8 tg fs14" id="tgt-auto-total">—</span></div>
<div class="fg mt10"><label class="flbl">Override Total (optional)</label><input class="finp" type="number" id="tt" value="${pre.totalTarget||''}" placeholder="Leave blank to use auto-calculated total"></div>
<div class="mact"><button class="btn btn-o" onclick="closeMo()">Cancel</button><button class="btn btn-p" onclick="saveTarget(${pre.id||0})">Save Target</button></div>`,true);calcTargetTotal();
}
window._titemCounter=0;
function addTargetItem(){const idx='new'+(++window._titemCounter);const wrap=document.getElementById('titem-wrap');if(!wrap)return;const row=document.createElement('div');row.className='srvc-row';row.id='titem-'+idx;row.innerHTML=`<input class="finp f1" id="ti-name-${idx}" placeholder="Service name (e.g. 50 Social Media Designs)"><input type="number" id="ti-qty-${idx}" placeholder="Qty" style="width:65px;border:1px solid var(--border);border-radius:6px;padding:5px 7px;font-size:12px" oninput="calcTargetTotal()"><span style="font-size:11px;color:var(--t3)">×</span><input type="number" id="ti-price-${idx}" placeholder="Unit ৳" style="width:90px;border:1px solid var(--border);border-radius:6px;padding:5px 7px;font-size:12px" oninput="calcTargetTotal()"><div class="mono fs11 fw7" id="ti-sub-${idx}" style="min-width:70px;text-align:right">—</div><button class="btn btn-xs btn-red" onclick="this.closest('.srvc-row').remove();calcTargetTotal()"><i class="fa fa-times"></i></button>`;wrap.appendChild(row);}
function calcTargetTotal(){let total=0;document.querySelectorAll('#titem-wrap .srvc-row').forEach(row=>{const id=row.id.replace('titem-','');const q=parseFloat(document.getElementById('ti-qty-'+id)?.value)||0;const p=parseFloat(document.getElementById('ti-price-'+id)?.value)||0;const sub=q*p;const el=document.getElementById('ti-sub-'+id);if(el)el.textContent=sub?fmt(sub):'—';total+=sub;});const el=document.getElementById('tgt-auto-total');if(el)el.textContent=fmt(total);}
function saveTarget(id){const userId=parseInt(document.getElementById('tu')?.value);const month=document.getElementById('tm')?.value;const label=document.getElementById('tl')?.value;const overrideTotal=parseFloat(document.getElementById('tt')?.value)||0;const items=[];let autoTotal=0;document.querySelectorAll('#titem-wrap .srvc-row').forEach(row=>{const rid=row.id.replace('titem-','');const name=document.getElementById('ti-name-'+rid)?.value?.trim();const qty=parseInt(document.getElementById('ti-qty-'+rid)?.value)||0;const price=parseFloat(document.getElementById('ti-price-'+rid)?.value)||0;if(name&&qty&&price){items.push({id:'item_'+uid(),serviceName:name,qty,unitPrice:price,achieved:0});autoTotal+=qty*price;}});if(!items.length){alert('Add at least one service target row');return;}const totalTarget=overrideTotal||autoTotal;const d={userId,month:month||'2025-05',label:label||month,items,totalTarget,deals:id?DB.targets.find(x=>x.id===id)?.deals||[]:[],id:id||uid()};if(id){const i=DB.targets.findIndex(x=>x.id===id);if(i>=0)DB.targets[i]=d;}else DB.targets.push(d);save();closeMo();go('targets');}
function openAddDeal(tid){const t=DB.targets.find(x=>x.id===tid);
showMo(`<div class="mt2">Log Closed Deal <button class="mc2" onclick="closeMo()"><i class="fa fa-times"></i></button></div>
<div class="fg"><label class="flbl">Client Name *</label><input class="finp" id="dc"></div>
<div class="fg"><label class="flbl">Service / Item</label><select class="fsel" id="ds" onchange="calcDA(${tid})">${(t?.items||[]).map(item=>`<option value="${item.id}" data-price="${item.unitPrice}">${item.serviceName} (${fmt(item.unitPrice)}/unit)</option>`).join('')}<option value="other">Other</option></select></div>
<div class="fr2"><div class="fg"><label class="flbl">Units Qty</label><input class="finp" type="number" id="dq" value="1" oninput="calcDA(${tid})"></div><div class="fg"><label class="flbl">Deal Amount (৳)</label><input class="finp" type="number" id="da" placeholder="Auto-calculated" oninput="this.dataset.edited=1"></div></div>
<div class="fg"><label class="flbl">Date</label><input class="finp" type="date" id="dd" value="2025-05-23"></div>
<div class="mact"><button class="btn btn-o" onclick="closeMo()">Cancel</button><button class="btn btn-p" onclick="saveDeal(${tid})">Log Deal</button></div>`);calcDA(tid);}
function calcDA(tid){const sel=document.getElementById('ds');const opt=sel?.options[sel.selectedIndex];const price=parseFloat(opt?.dataset?.price)||0;const q=parseInt(document.getElementById('dq')?.value)||1;const el=document.getElementById('da');if(el&&price&&!el.dataset.edited)el.value=price*q;}
function saveDeal(tid){const t=DB.targets.find(x=>x.id===tid);if(!t)return;const sel=document.getElementById('ds');const itemId=sel?.value;const item=t.items?.find(x=>x.id===itemId);const q=parseInt(document.getElementById('dq')?.value)||1;const a=parseFloat(document.getElementById('da')?.value)||0;if(!a){alert('Enter deal amount');return;}t.deals.push({client:document.getElementById('dc')?.value||'Unknown',service:item?.serviceName||document.getElementById('ds')?.options[document.getElementById('ds').selectedIndex]?.text,itemId,qty:q,amount:a,date:document.getElementById('dd')?.value,loggedBy:DB.currentUser.id});// update achieved
if(item)item.achieved=(item.achieved||0)+q;save();closeMo();canDo('targets')?go('targets'):go('my_target');}

// ══════ REPORTS — Full Analytics with Filters ══════
function pgReports(){return`<div class="ph"><div class="ph-t">Reports & Analytics</div></div>
<div class="tabs" id="rpt-tabs">
<div class="tab act" onclick="rptTab('rpt-overview',this)">📊 Overview</div>
<div class="tab" onclick="rptTab('rpt-content',this)">🎨 Content Produced</div>
<div class="tab" onclick="rptTab('rpt-invoices',this)">💳 Invoices & Payments</div>
<div class="tab" onclick="rptTab('rpt-targets',this)">🎯 Target Achievement</div>
<div class="tab" onclick="rptTab('rpt-expenses',this)">💸 Expenses</div>
<div class="tab" onclick="rptTab('rpt-calendar',this)">📅 Client Calendar</div>
</div>
<div id="rpt-overview"><div id="rpt-body"></div></div>
<div id="rpt-content" style="display:none"></div>
<div id="rpt-invoices" style="display:none"></div>
<div id="rpt-targets" style="display:none"></div>
<div id="rpt-expenses" style="display:none"></div>
<div id="rpt-calendar" style="display:none"></div>`;}
function rptTab(id,el){document.querySelectorAll('#rpt-tabs .tab').forEach(t=>t.classList.remove('act'));el.classList.add('act');['rpt-overview','rpt-content','rpt-invoices','rpt-targets','rpt-expenses','rpt-calendar'].forEach(k=>{const e=document.getElementById(k);if(e)e.style.display=k===id?'block':'none';});if(id==='rpt-overview')renderReports();else if(id==='rpt-content')renderRptContent();else if(id==='rpt-invoices')renderRptInvoices();else if(id==='rpt-targets')renderRptTargets();else if(id==='rpt-expenses')renderRptExpenses();else if(id==='rpt-calendar')renderRptCalendar();}
function renderReports(){
  const tR=DB.clients.reduce((s,c)=>s+cTotal(c),0);const tP=DB.invoices.filter(i=>i.status==='paid').reduce((s,i)=>s+iTotal(i),0);const tExp=expTotal('2025-05');const netP=tP-tExp;const tDue=DB.invoices.filter(i=>i.status!=='paid').reduce((s,i)=>s+iBal(i),0);const wonLeads=DB.leads.filter(l=>l.stageId===7).length;const totalLeads=DB.leads.filter(l=>!l.deleted).length;const convRate=totalLeads?Math.round(wonLeads/totalLeads*100):0;const doneTasks=DB.tasks.filter(t=>t.status==='done').length;
  const el=document.getElementById('rpt-body');if(!el)return;
  el.innerHTML=`<div class="g4 mb14">
<div class="mc"><div class="mc-icon" style="background:var(--al)"><i class="fa fa-chart-line" style="color:var(--amber)"></i></div><div class="mc-lbl">Monthly Revenue</div><div class="mc-val">${fmt(tR)}</div></div>
<div class="mc"><div class="mc-icon" style="background:var(--gb)"><i class="fa fa-arrow-down" style="color:var(--green)"></i></div><div class="mc-lbl">Collected</div><div class="mc-val tg">${fmt(tP)}</div><div class="mc-sub">${pct(tP,tR)}% of billed</div></div>
<div class="mc"><div class="mc-icon" style="background:var(--rb)"><i class="fa fa-receipt" style="color:var(--red)"></i></div><div class="mc-lbl">Expenses</div><div class="mc-val tr">${fmt(tExp)}</div></div>
<div class="mc" style="border:2px solid ${netP>=0?'var(--green)':'var(--red)'}"><div class="mc-icon" style="background:${netP>=0?'var(--gb)':'var(--rb)'}"><i class="fa fa-scale-balanced" style="color:${netP>=0?'var(--green)':'var(--red)'}"></i></div><div class="mc-lbl">Net Profit</div><div class="mc-val" style="color:${netP>=0?'var(--green)':'var(--red)'}">${fmt(netP)}</div><div class="mc-sub">ROI: ${tExp?Math.round(netP/tExp*100):0}%</div></div>
</div>
<div class="g3 mb14">
<div class="card"><div class="sect-t mb10">Lead Funnel</div>
${DB.leadStages.map(s=>{const cnt=DB.leads.filter(l=>!l.deleted&&l.stageId===s.id).length;const w=DB.leads.filter(l=>!l.deleted).length;const p2=pct(cnt,w);return`<div style="margin-bottom:7px"><div class="flex ic sbj mb3"><span style="width:10px;height:10px;border-radius:50%;background:${s.color};display:inline-block;margin-right:6px"></span><span class="fs12">${s.label}</span><span class="mono fw7 fs12">${cnt}</span></div>${cnt?`<div class="pb2" style="height:4px"><div class="pf" style="width:${p2}%;height:4px;background:${s.color}"></div></div>`:''}</div>`;}).join('')}
<div class="sep"></div><div class="flex sbj fs12"><span class="fw6">Conversion Rate</span><span class="mono fw7 tg">${convRate}%</span></div>
</div>
<div class="card"><div class="sect-t mb10">Sales Performance</div>
${DB.targets.map(t=>{const u=DB.users.find(x=>x.id===t.userId);const a=tgtAch(t);const tot=tgtTotal(t);const p2=pct(a,tot);return`<div style="margin-bottom:10px"><div class="flex ic gap7 mb5">${avH(u?.name,u?.color,22,9)}<div class="f1 fw6 fs12">${u?.name}</div><div class="fw7 fs12" style="color:${p2>=100?'var(--green)':p2>=70?'var(--amber)':'var(--red)'}">${p2}%</div></div><div class="pb2 mb3" style="height:5px"><div class="pf" style="width:${p2}%;height:5px;background:${p2>=100?'var(--green)':p2>=70?'var(--amber)':'var(--red)'}"></div></div><div class="flex sbj fs11" style="color:var(--t3)"><span>${fmt(a)}</span><span>${fmt(tot)}</span></div></div>`;}).join('')||'<div class="fs12" style="color:var(--t3)">No targets set</div>'}
</div>
<div class="card"><div class="sect-t mb10">Team Productivity</div>
${DB.users.filter(u=>!['owner','sales'].includes(u.role)).map(u=>{const ut=DB.tasks.filter(t=>t.assignedTo===u.id);const done=ut.filter(t=>t.status==='done').length;const p2=ut.length?pct(done,ut.length):0;return`<div style="margin-bottom:8px"><div class="flex ic gap7 mb4">${avH(u.name,u.color,22,9)}<div class="f1 fs12 fw6">${u.name}</div><span class="fs11 mono">${done}/${ut.length}</span></div><div class="pb2" style="height:4px"><div class="pf" style="width:${p2}%;height:4px;background:${p2>=80?'var(--green)':p2>=50?'var(--amber)':'var(--red)'}"></div></div></div>`;}).join('')}
</div>
</div>`;
}

function renderRptContent(){
  const el=document.getElementById('rpt-content');if(!el)return;
  el.innerHTML=`<div class="fbar mb12">
<label>Service:</label><select class="fsel" id="rc-svc" onchange="filterRptContent()"><option value="">All Services</option>${DB.services.map(s=>`<option value="${s.id}">${s.name}</option>`).join('')}</select>
<label>Member:</label><select class="fsel" id="rc-user" onchange="filterRptContent()"><option value="">All Members</option>${DB.users.filter(u=>!['owner','sales'].includes(u.role)).map(u=>`<option value="${u.id}">${u.name}</option>`).join('')}</select>
<label>From:</label><input class="finp" type="date" id="rc-from" onchange="filterRptContent()">
<label>To:</label><input class="finp" type="date" id="rc-to" onchange="filterRptContent()">
</div><div id="rc-body"></div>`;filterRptContent();
}
function filterRptContent(){
  const fSvc=parseInt(document.getElementById('rc-svc')?.value)||0;const fUser=parseInt(document.getElementById('rc-user')?.value)||0;const frm=document.getElementById('rc-from')?.value||'';const fto=document.getElementById('rc-to')?.value||'';
  let logs=DB.worklogs;if(fSvc)logs=logs.filter(w=>w.serviceId===fSvc);if(fUser)logs=logs.filter(w=>w.userId===fUser);if(frm)logs=logs.filter(w=>w.deliveredDate>=frm);if(fto)logs=logs.filter(w=>w.deliveredDate<=fto);
  let posts=DB.contentPosts;if(fUser)posts=posts.filter(p=>p.assignedTo===fUser);
  // Group by service
  const bySvc={};logs.forEach(w=>{const s=svcName(w.serviceId)||'Unknown';if(!bySvc[s])bySvc[s]={logs:[],units:0};bySvc[s].logs.push(w);bySvc[s].units+=(w.qtyDelivered||0);});
  const el=document.getElementById('rc-body');if(!el)return;
  const totalUnits=logs.reduce((s,w)=>s+(w.qtyDelivered||0),0);const postsTotal=posts.length;const donePostsTotal=posts.filter(p=>p.status==='done').length;
  el.innerHTML=`<div class="g4 mb12">
<div class="mc"><div class="mc-lbl">Total Deliveries</div><div class="mc-val">${logs.length}</div></div>
<div class="mc"><div class="mc-lbl">Units Delivered</div><div class="mc-val tg">${totalUnits}</div></div>
<div class="mc"><div class="mc-lbl">Posts Scheduled</div><div class="mc-val">${postsTotal}</div></div>
<div class="mc"><div class="mc-lbl">Posts Completed</div><div class="mc-val tg">${donePostsTotal}</div></div>
</div>
<div class="g2 mb12">
<div class="card"><div class="sect-t mb10">Production by Service</div>
${Object.entries(bySvc).map(([svc,data])=>`<div style="margin-bottom:8px"><div class="flex ic sbj mb4"><span class="fw6 fs12">${svc}</span><span class="mono fw7 fs12">${data.units} units (${data.logs.length} deliveries)</span></div></div>`).join('')||'<div class="fs12" style="color:var(--t3)">No data</div>'}
</div>
<div class="card"><div class="sect-t mb10">Content by Platform</div>
${['instagram','facebook','tiktok','youtube','linkedin'].map(p=>{const cnt=posts.filter(x=>x.platform===p).length;return cnt?`<div class="flex ic sbj mb7"><span class="fw6 fs12">${p.charAt(0).toUpperCase()+p.slice(1)}</span><div class="flex ic gap6"><span class="mono fw7 fs12">${cnt}</span><div class="pb2" style="height:5px;width:80px"><div class="pf" style="width:${pct(cnt,postsTotal)}%;height:5px;background:var(--amber)"></div></div></div></div>`:''}).join('')}
</div>
</div>
<div class="tw"><table><thead><tr><th>Member</th><th>Service</th><th>Client</th><th>Delivered</th><th>Date</th><th>Quality</th><th>Status</th></tr></thead><tbody>
${logs.sort((a,b)=>(b.deliveredDate||'').localeCompare(a.deliveredDate||'')).map(w=>{const u=DB.users.find(x=>x.id===w.userId);const c=DB.clients.find(x=>x.id===w.clientId);const sm={pending_smm_review:['SMM Review','var(--pd)','var(--pb)'],approved:['Approved','var(--gd)','var(--gb)'],revision:['Revision','var(--rd)','var(--rb)'],rejected:['Rejected','var(--rd)','var(--rb)'],review:['Under Review','var(--ad)','var(--al)']};const[sl,sc,sb]=sm[w.status]||['?','var(--t3)','var(--bg)'];return`<tr><td><div class="flex ic gap6">${avH(u?.name,u?.color,22,8)}<span class="fw6">${u?.name||'?'}</span></div></td><td class="fs11">${svcName(w.serviceId)||'—'}</td><td class="fs11">${c?.name||'—'}</td><td><span class="fw7">${w.qtyDelivered}</span>/${w.qtyTotal||'?'} ${w.unit}</td><td class="fs11">${fmtD(w.deliveredDate)}</td><td>${w.quality?'★'.repeat(w.quality):'—'}</td><td>${bh(sl,sc,sb)}</td></tr>`;}).join('')||'<tr><td colspan="7" style="text-align:center;color:var(--t3);padding:16px">No data</td></tr>'}
</tbody></table></div>`;
}

function renderRptInvoices(){
  const el=document.getElementById('rpt-invoices');if(!el)return;
  el.innerHTML=`<div class="fbar mb12">
<label>Month:</label><select class="fsel" id="ri-month" onchange="filterRptInvoices()"><option value="">All Months</option>${[...new Set(DB.invoices.map(i=>i.month))].map(m=>`<option>${m}</option>`).join('')}</select>
<label>Status:</label><select class="fsel" id="ri-status" onchange="filterRptInvoices()"><option value="">All</option><option value="paid">Paid</option><option value="sent">Unpaid</option><option value="overdue">Overdue</option></select>
<label>Client:</label><select class="fsel" id="ri-client" onchange="filterRptInvoices()"><option value="">All Clients</option>${DB.clients.map(c=>`<option value="${c.id}">${c.name}</option>`).join('')}</select>
</div><div id="ri-body"></div>`;filterRptInvoices();
}
function filterRptInvoices(){
  const fm=document.getElementById('ri-month')?.value||'';const fs=document.getElementById('ri-status')?.value||'';const fc=parseInt(document.getElementById('ri-client')?.value)||0;
  let invs=DB.invoices;if(fm)invs=invs.filter(i=>i.month===fm);if(fc)invs=invs.filter(i=>i.clientId===fc);
  if(fs==='paid')invs=invs.filter(i=>i.status==='paid');else if(fs==='sent')invs=invs.filter(i=>i.status!=='paid');else if(fs==='overdue')invs=invs.filter(i=>i.status!=='paid'&&daysFrom(i.dueDate)<0);
  const tI=invs.reduce((s,i)=>s+iTotal(i),0);const tP=invs.filter(i=>i.status==='paid').reduce((s,i)=>s+iTotal(i),0);const tD=invs.filter(i=>i.status!=='paid').reduce((s,i)=>s+iBal(i),0);
  const el=document.getElementById('ri-body');if(!el)return;
  el.innerHTML=`<div class="g3 mb12">
<div class="mc"><div class="mc-lbl">Invoiced</div><div class="mc-val">${fmt(tI)}</div><div class="mc-sub">${invs.length} invoices</div></div>
<div class="mc"><div class="mc-lbl">Collected</div><div class="mc-val tg">${fmt(tP)}</div><div class="mc-sub">${invs.filter(i=>i.status==='paid').length} paid</div></div>
<div class="mc"><div class="mc-lbl">Outstanding</div><div class="mc-val tr">${fmt(tD)}</div><div class="mc-sub">${invs.filter(i=>i.status!=='paid').length} unpaid</div></div>
</div>
<div class="card mb12"><div class="sect-t mb10">Due Client List</div>
${DB.clients.map(c=>{const ci=invs.filter(i=>i.clientId===c.id&&i.status!=='paid');const due=ci.reduce((s,i)=>s+iBal(i),0);return due>0?`<div class="flex ic gap8" style="padding:7px 0;border-bottom:1px solid var(--border)">${avH(c.name,cclr(c.id),24,9)}<div class="f1 fw6 fs12">${c.name}</div><div class="mono fw7 tr">${fmt(due)}</div><div class="flex gap4">${ci.map(i=>`<button class="btn btn-xs btn-o" onclick="viewInv(${i.id})">${i.number}</button>`).join('')}</div></div>`:''}).join('')||'<div class="empty" style="padding:12px"><i class="fa fa-check-circle"></i>No outstanding dues!</div>'}
</div>
<div class="tw"><table><thead><tr><th>Invoice #</th><th>Client</th><th>Period</th><th>Invoiced</th><th>Balance</th><th>Due Date</th><th>Status</th><th>Actions</th></tr></thead><tbody>
${invs.sort((a,b)=>b.issueDate?.localeCompare(a.issueDate||'')).map(inv=>{const c=DB.clients.find(x=>x.id===inv.clientId);const st=pSt(inv);return`<tr><td class="mono fw7 tb2">${inv.number}</td><td class="fw6 fs12">${c?.name||'—'}</td><td class="fs11">${inv.period}</td><td class="mono">${fmt(iTotal(inv))}</td><td class="mono ${inv.status==='paid'?'tg':'tr'}">${inv.status==='paid'?'PAID':fmt(iBal(inv))}</td><td class="fs11">${fmtD(inv.dueDate)}</td><td>${bh(st.l,st.c,st.b)}</td><td><div class="flex gap4"><button class="btn btn-xs btn-o" onclick="viewInv(${inv.id})"><i class="fa fa-eye"></i></button><button class="btn btn-xs btn-grn" onclick="dlInvoice(${inv.id})"><i class="fa fa-download"></i></button></div></td></tr>`;}).join('')||'<tr><td colspan="8" style="text-align:center;color:var(--t3);padding:16px">No invoices found</td></tr>'}
</tbody></table></div>`;
}

function renderRptTargets(){
  const el=document.getElementById('rpt-targets');if(!el)return;
  el.innerHTML=`<div class="fbar mb12">
<label>Member:</label><select class="fsel" id="rt-user" onchange="filterRptTargets()"><option value="">All Sales Members</option>${DB.users.filter(u=>u.role==='sales').map(u=>`<option value="${u.id}">${u.name}</option>`).join('')}</select>
</div><div id="rt-body"></div>`;filterRptTargets();
}
function filterRptTargets(){const fu=parseInt(document.getElementById('rt-user')?.value)||0;let tgts=DB.targets;if(fu)tgts=tgts.filter(t=>t.userId===fu);const el=document.getElementById('rt-body');if(!el)return;
el.innerHTML=tgts.map(t=>{const u=DB.users.find(x=>x.id===t.userId);const a=tgtAch(t);const tot=tgtTotal(t);const p=pct(a,tot);return`<div class="card mb12"><div class="flex ic gap9 mb10">${avH(u?.name,u?.color,32,11)}<div class="f1"><div class="fw7 fs13">${u?.name}</div><div class="fs11" style="color:var(--t3)">${t.label||t.month}</div></div><div class="mono fw8 fs18" style="color:${p>=100?'var(--green)':p>=70?'var(--amber)':'var(--red)'}">${p}%</div></div>
<div class="pb2 mb8" style="height:9px"><div class="pf" style="width:${p}%;height:9px;background:${p>=100?'var(--green)':p>=70?'var(--amber)':'var(--red)'}"></div></div>
${(t.items||[]).map(item=>{const ach=tgtItemAch(t,item.id);const p2=pct(ach,item.qty);return`<div style="padding:6px 0;border-bottom:1px solid var(--border)"><div class="flex ic sbj mb3"><span class="fs12">${item.serviceName}</span><span class="mono fw7 fs12" style="color:${p2>=100?'var(--green)':p2>=70?'var(--amber)':'var(--red)'}">${ach}/${item.qty}</span></div><div class="pb2" style="height:4px"><div class="pf" style="width:${p2}%;height:4px;background:${p2>=100?'var(--green)':p2>=70?'var(--amber)':'var(--red)'}"></div></div></div>`;}).join('')}
<div class="flex sbj mt8 fs12"><span class="fw7">Total: ${fmt(a)} / ${fmt(tot)}</span><span>Deals: ${(t.deals||[]).length}</span></div>
</div>`;}).join('')||'<div class="empty"><i class="fa fa-bullseye"></i>No targets found</div>';}

function renderRptExpenses(){
  const el=document.getElementById('rpt-expenses');if(!el)return;
  el.innerHTML=`<div class="fbar mb12">
<label>Month:</label><select class="fsel" id="re-month" onchange="filterRptExpenses()"><option value="">All Months</option>${[...new Set(DB.expenses.map(e=>e.month))].map(m=>`<option ${m==='2025-05'?'selected':''}>${m}</option>`).join('')}</select>
<label>Category:</label><select class="fsel" id="re-cat" onchange="filterRptExpenses()"><option value="">All Categories</option>${DB.expenseCategories.map(c=>`<option value="${c.id}">${c.icon} ${c.name}</option>`).join('')}</select>
</div><div id="re-body"></div>`;filterRptExpenses();
}
function filterRptExpenses(){const fm=document.getElementById('re-month')?.value||'';const fc=parseInt(document.getElementById('re-cat')?.value)||0;let exps=DB.expenses;if(fm)exps=exps.filter(e=>e.month===fm);if(fc)exps=exps.filter(e=>e.categoryId===fc);const total=exps.reduce((s,e)=>s+e.amount,0);const catTotals={};exps.forEach(e=>{if(!catTotals[e.categoryId])catTotals[e.categoryId]=0;catTotals[e.categoryId]+=e.amount;});const tP=DB.invoices.filter(i=>i.status==='paid'&&(!fm||i.month===fm)).reduce((s,i)=>s+iTotal(i),0);const net=tP-total;
const el=document.getElementById('re-body');if(!el)return;
el.innerHTML=`<div class="g4 mb12">
<div class="mc"><div class="mc-lbl">Total Expenses</div><div class="mc-val tr">${fmt(total)}</div><div class="mc-sub">${exps.length} entries</div></div>
<div class="mc"><div class="mc-lbl">Income</div><div class="mc-val tg">${fmt(tP)}</div></div>
<div class="mc"><div class="mc-lbl">Net Cash Flow</div><div class="mc-val" style="color:${net>=0?'var(--green)':'var(--red)'}">${fmt(net)}</div></div>
<div class="mc"><div class="mc-lbl">Expense Ratio</div><div class="mc-val">${tP?Math.round(total/tP*100):0}%</div></div>
</div>
<div class="g2 mb12">
<div class="card"><div class="sect-t mb10">By Category</div>
${Object.entries(catTotals).sort((a,b)=>b[1]-a[1]).map(([catId,amt])=>{const cat=expCat(parseInt(catId));const p=pct(amt,total);return`<div style="margin-bottom:8px"><div class="flex ic sbj mb4"><span style="background:${cat.color}22;color:${cat.color};padding:2px 8px;border-radius:20px;font-size:10px;font-weight:700">${cat.icon} ${cat.name}</span><span class="mono fs11 fw7">${fmt(amt)}</span></div><div class="pb2" style="height:5px"><div class="pf" style="width:${p}%;height:5px;background:${cat.color}"></div></div></div>`;}).join('')||'No expenses'}
</div>
<div class="card"><div class="sect-t mb10">Expense List</div>
<div style="max-height:300px;overflow-y:auto">${exps.sort((a,b)=>b.date.localeCompare(a.date)).map(e=>{const cat=expCat(e.categoryId);return`<div class="flex ic gap7" style="padding:6px 0;border-bottom:1px solid var(--border)"><span>${cat.icon}</span><div class="f1"><div class="fw6 fs12">${e.reason}</div><div class="fs11" style="color:var(--t3)">${fmtD(e.date)}</div></div><span class="mono fw7 tr">${fmt(e.amount)}</span></div>`;}).join('')||'<div class="fs12" style="color:var(--t3)">No expenses</div>'}</div>
</div>
</div>`;}

function renderRptCalendar(){
  const el=document.getElementById('rpt-calendar');if(!el)return;
  const myClients=myVisibleClients();
  el.innerHTML=`<div class="fbar mb12">
<label>Client:</label><select class="fsel" id="rk-client" onchange="filterRptCalendar()"><option value="">All Clients</option>${myClients.map(c=>`<option value="${c.id}">${c.name}</option>`).join('')}</select>
<label>Month:</label><select class="fsel" id="rk-month" onchange="filterRptCalendar()"><option value="2025-06" selected>June 2025</option><option value="2025-05">May 2025</option><option value="2025-07">July 2025</option></select>
</div><div id="rk-body"></div>`;filterRptCalendar();
}
function filterRptCalendar(){const fc=parseInt(document.getElementById('rk-client')?.value)||0;const fm=document.getElementById('rk-month')?.value||'2025-06';let posts=DB.contentPosts.filter(p=>p.date&&p.date.startsWith(fm));if(fc)posts=posts.filter(p=>p.clientId===fc);const el=document.getElementById('rk-body');if(!el)return;
const TYPE_COLORS={design:{bg:'#dbeafe',c:'#1e40af'},motion:{bg:'#ede9fe',c:'#5b21b6'},story:{bg:'#d1fae5',c:'#065f46'},video:{bg:'#ffedd5',c:'#9a3412'},other:{bg:'#fef3c7',c:'#92400e'}};
const days=['Mon','Tue','Wed','Thu','Fri','Sat','Sun'];const cells=[];for(let i=0;i<6;i++)cells.push(null);for(let d=1;d<=30;d++){const date=`${fm}-${String(d).padStart(2,'0')}`;const dp=posts.filter(p=>p.date===date);cells.push({day:d,date,posts:dp});}
el.innerHTML=`<div class="g5 mb12">
<div class="mc"><div class="mc-lbl">Total Posts</div><div class="mc-val">${posts.length}</div></div>
<div class="mc"><div class="mc-lbl">Designs</div><div class="mc-val">${posts.filter(p=>p.type==='design').length}</div></div>
<div class="mc"><div class="mc-lbl">Motion/Reels</div><div class="mc-val">${posts.filter(p=>p.type==='motion').length}</div></div>
<div class="mc"><div class="mc-lbl">Completed</div><div class="mc-val tg">${posts.filter(p=>p.status==='done').length}</div></div>
<div class="mc"><div class="mc-lbl">Pending</div><div class="mc-val ta">${posts.filter(p=>p.status!=='done').length}</div></div>
</div>
<div class="card"><div class="cal-grid mb10">${days.map(d=>`<div class="cal-hd2">${d}</div>`).join('')}${cells.map(cell=>{if(!cell)return`<div style="min-height:70px;background:var(--bg);border:1px solid var(--border);border-radius:var(--r);opacity:.3"></div>`;return`<div class="cal-day"><div class="cal-dn">${cell.day}</div>${cell.posts.map(p=>{const tc=TYPE_COLORS[p.type]||TYPE_COLORS.other;const c=DB.clients.find(x=>x.id===p.clientId);return`<div class="cal-chip" style="background:${tc.bg};color:${tc.c}" title="${p.title} — ${c?.name}">${p.status==='done'?'✅':p.status==='in_progress'?'🔄':'⏳'} ${p.title.slice(0,10)}</div>`;}).join('')}</div>`;}).join('')}</div>
</div>
<div class="tw"><table><thead><tr><th>Post</th><th>Client</th><th>Platform</th><th>Type</th><th>Date</th><th>Assigned To</th><th>Status</th></tr></thead><tbody>
${posts.map(p=>{const c=DB.clients.find(x=>x.id===p.clientId);const u=DB.users.find(x=>x.id===p.assignedTo);const tc=TYPE_COLORS[p.type]||TYPE_COLORS.other;return`<tr><td class="fw6">${p.title}</td><td class="fs11">${c?.name||'—'}</td><td class="fs11">${p.platform}</td><td>${bh(p.type,tc.c,tc.bg)}</td><td class="fs11">${fmtD(p.date)}</td><td><div class="flex ic gap5">${avH(u?.name,u?.color,22,8)}<span class="fs11">${u?.name||'?'}</span></div></td><td>${bh(p.status,'var(--t2)','var(--bg)')}</td></tr>`;}).join('')||'<tr><td colspan="7" style="text-align:center;color:var(--t3);padding:16px">No posts</td></tr>'}
</tbody></table></div>`;}

// ══════ CLIENTS (visibility filtered) ══════
function pgClients(){if(!canDo('clients'))return`<div class="empty"><i class="fa fa-lock"></i>You don't have access to the full client list. You can only see clients assigned to you.</div>`;
return`<div class="ph"><div><div class="ph-t">Clients</div><div class="ph-s">${isOwner()?DB.clients.length:myVisibleClients().length} visible to you</div></div>${isOwner()?`<button class="btn btn-p" onclick="openAddClient()"><i class="fa fa-user-plus"></i> Add Client</button>`:''}</div>
${!isOwner()?`<div class="abox a-blu mb10"><i class="fa fa-info-circle"></i>You can only see clients assigned to you or where you have tasks.</div>`:''}
<div class="flex gap7 mb12" style="flex-wrap:wrap"><input class="finp" id="cf-q" oninput="renderCT()" placeholder="Search…" style="max-width:200px;padding:6px 10px;font-size:12px"><select class="fsel" id="cf-status" onchange="renderCT()" style="padding:6px 10px;font-size:12px;width:auto"><option value="">All Status</option><option>active</option><option>onboarding</option></select></div>
<div id="ct"></div>`;}
function renderCT(){
  const q=(document.getElementById('cf-q')?.value||'').toLowerCase();const st=document.getElementById('cf-status')?.value||'';
  let cs=myVisibleClients();if(q)cs=cs.filter(c=>c.name.toLowerCase().includes(q)||c.company?.toLowerCase().includes(q));if(st)cs=cs.filter(c=>c.status===st);
  const el=document.getElementById('ct');if(!el)return;
  el.innerHTML=`<div class="tw"><table><thead><tr><th>Client</th><th>Services</th><th>Monthly</th><th>Advance</th><th>Balance</th><th>SMM</th><th>Status</th><th>Sat.</th><th>Action</th></tr></thead><tbody>
${cs.map(c=>{const t=cTotal(c);const b=t-(c.advance||0);const smm=DB.users.find(x=>x.id===c.assignedSMM);const od=DB.tasks.filter(x=>x.clientId===c.id&&isOverdue(x)).length;const svcs=c.services.map(cs=>svcName(cs.serviceId)).slice(0,2).join(', ')+(c.services.length>2?'…':'');return`<tr>
<td><div class="flex ic gap8">${avH(c.name,cclr(c.id),28,10)}<div><div class="fw7">${c.name} ${od?`<span class="badge" style="background:var(--rb);color:var(--rd)">⚠${od}</span>`:''}</div><div class="fs11" style="color:var(--t3)">${c.company}</div></div></div></td>
<td class="fs11">${svcs||'—'}</td><td class="mono fw7">${fmt(t)}</td><td class="mono tg">${fmt(c.advance)}</td><td class="mono tr fw7">${fmt(b)}</td>
<td>${smm?avH(smm.name,smm.color,22,8):'<span class="fs11" style="color:var(--t3)">—</span>'}</td>
<td>${bh(c.status==='active'?'Active':'Onboarding',c.status==='active'?'var(--gd)':'var(--ad)',c.status==='active'?'var(--gb)':'var(--al)')}</td>
<td>${c.satisfactionScore?'★'.repeat(c.satisfactionScore):'<span style="color:var(--t3)">—</span>'}</td>
<td><div class="flex gap4"><button class="btn btn-xs btn-blu" onclick="openCP(${c.id})"><i class="fa fa-user"></i></button>${isOwner()?`<button class="btn btn-xs btn-o" onclick="openAddClient(DB.clients.find(x=>x.id===${c.id}))"><i class="fa fa-edit"></i></button>`:''}</div></td></tr>`;}).join('')||'<tr><td colspan="9" style="text-align:center;color:var(--t3);padding:20px">No clients found</td></tr>'}
</tbody></table></div>`;
}
function openAddClient(pre={}){
  const smmOpts=DB.users.filter(u=>u.role==='smm').map(u=>`<option value="${u.id}" ${pre.assignedSMM===u.id?'selected':''}>${u.name}</option>`).join('');
  const salesOpts=DB.users.filter(u=>u.role==='sales'||u.role==='owner').map(u=>`<option value="${u.id}" ${pre.assignedSales===u.id?'selected':''}>${u.name}</option>`).join('');
  const svcRows=DB.services.filter(s=>s.active).map(s=>{const sel=(pre.services||[]).find(cs=>cs.serviceId===s.id);return`<div class="srvc-row"><input type="checkbox" id="sc-${s.id}" ${sel?'checked':''} onchange="calcCT()" style="accent-color:var(--amber);width:13px;height:13px;flex-shrink:0"><div class="f1 fs11 fw6">${s.name}</div><input type="number" id="sp-${s.id}" value="${sel?sel.price:s.basePrice}" oninput="calcCT()" style="width:72px;border:1px solid var(--border);border-radius:5px;padding:4px 6px;font-size:11px"><input type="number" id="sq-${s.id}" value="${sel?sel.qty:1}" oninput="calcCT()" style="width:44px;border:1px solid var(--border);border-radius:5px;padding:4px 5px;font-size:11px;text-align:center"><div class="mono fs11 fw7" id="st-${s.id}" style="min-width:60px;text-align:right">${fmt((sel?sel.price:s.basePrice)*(sel?sel.qty:1))}</div></div>`;}).join('');
  showMo(`<div class="mt2">${pre.id?'Edit':'Add'} Client <button class="mc2" onclick="closeMo()"><i class="fa fa-times"></i></button></div>
<div class="fr2"><div class="fg"><label class="flbl">Name *</label><input class="finp" id="cn" value="${pre.name||''}"></div><div class="fg"><label class="flbl">Company</label><input class="finp" id="cco" value="${pre.company||''}"></div></div>
<div class="fr2"><div class="fg"><label class="flbl">Email</label><input class="finp" id="ce" value="${pre.email||''}"></div><div class="fg"><label class="flbl">Phone</label><input class="finp" id="cph" value="${pre.phone||''}"></div></div>
<div class="fr3"><div class="fg"><label class="flbl">Location</label><input class="finp" id="cloc" value="${pre.location||''}"></div><div class="fg"><label class="flbl">SMM Assigned</label><select class="fsel" id="cas2"><option value="">None</option>${smmOpts}</select></div><div class="fg"><label class="flbl">Sales Assigned</label><select class="fsel" id="cas3">${salesOpts}</select></div></div>
<div class="fg"><label class="flbl">Services & Pricing</label><div style="max-height:240px;overflow-y:auto;border:1px solid var(--border);border-radius:var(--r);padding:7px">${svcRows}</div></div>
<div class="fr2"><div class="fg"><label class="flbl">Advance Paid (৳)</label><input class="finp" type="number" id="cadv" value="${pre.advance||0}" oninput="calcCT()"></div><div class="fg"><label class="flbl">Notes</label><input class="finp" id="cnts" value="${pre.notes||''}"></div></div>
<div style="background:var(--bg);border-radius:var(--r);padding:10px;border:1px solid var(--border)"><div class="flex sbj fs12 mb3"><span class="fw6">Monthly Total</span><strong class="mono" id="c-total">—</strong></div><div class="flex sbj fs12"><span style="color:var(--t3)">Balance</span><strong class="mono tr" id="c-bal">—</strong></div></div>
<div class="mact"><button class="btn btn-o" onclick="closeMo()">Cancel</button><button class="btn btn-p" onclick="saveClient(${pre.id||0})">Save Client</button></div>`,true);calcCT();
}
function calcCT(){let total=0;DB.services.filter(s=>s.active).forEach(s=>{const cb=document.getElementById('sc-'+s.id);const p=parseFloat(document.getElementById('sp-'+s.id)?.value||s.basePrice);const q=parseInt(document.getElementById('sq-'+s.id)?.value||1);const sub=(cb&&cb.checked)?p*q:0;const el=document.getElementById('st-'+s.id);if(el)el.textContent=fmt(sub);total+=sub;});const adv=parseFloat(document.getElementById('cadv')?.value||0);const et=document.getElementById('c-total');const eb=document.getElementById('c-bal');if(et)et.textContent=fmt(total);if(eb)eb.textContent=fmt(total-adv);}
async function saveClient(id){const name=document.getElementById('cn')?.value?.trim();if(!name){alert('Name required');return;}const services=DB.services.filter(s=>s.active).map(s=>{const cb=document.getElementById('sc-'+s.id);if(!cb||!cb.checked)return null;return{serviceId:s.id,price:parseFloat(document.getElementById('sp-'+s.id)?.value||s.basePrice),qty:parseInt(document.getElementById('sq-'+s.id)?.value||1)};}).filter(Boolean);const smmVal=document.getElementById('cas2')?.value;const d={name,company:document.getElementById('cco')?.value,email:document.getElementById('ce')?.value,phone:document.getElementById('cph')?.value,location:document.getElementById('cloc')?.value,assignedSMM:smmVal?parseInt(smmVal):null,assignedSales:parseInt(document.getElementById('cas3')?.value||0)||null,advance:parseFloat(document.getElementById('cadv')?.value)||0,notes:document.getElementById('cnts')?.value,services,status:'onboarding',onboarded:new Date().toISOString().split('T')[0],satisfactionScore:null,satisfactionHistory:[]};try{await saveEntity('clients',id,d);await loadFromAPI();closeMo();go('clients');setTimeout(renderCT,50);}catch(e){alert(e.message||'Client save failed');}}
function openCP(id){
  const c=DB.clients.find(x=>x.id===id);if(!c)return;if(!myVisibleClients().find(x=>x.id===id)&&!isOwner()){alert('Access denied');return;}
  const total=cTotal(c);const smm=DB.users.find(u=>u.id===c.assignedSMM);const sales=DB.users.find(u=>u.id===c.assignedSales);const invs=DB.invoices.filter(i=>i.clientId===id);const myT=DB.tasks.filter(t=>t.clientId===id);const chats=DB.clientChats[id]||[];const files=DB.clientFiles[id]||[];
  showMo(`<div class="mt2">${avH(c.name,cclr(c.id),22,9)} ${c.name} <button class="mc2" onclick="closeMo()"><i class="fa fa-times"></i></button></div>
<div class="cp-hero mb10"><div class="flex ic gap10 mb10">${avH(c.name,'rgba(255,255,255,.15)',38,13)}<div class="f1"><div style="font-size:16px;font-weight:800">${c.name}</div><div style="font-size:11px;opacity:.6">${c.company} · ${c.location||'—'}</div><div style="font-size:11px;opacity:.5">SMM: ${smm?.name||'—'} · Sales: ${sales?.name||'—'}</div></div><div style="text-align:right"><div style="font-size:20px;font-weight:800">${(isOwner()||isSales())?fmt(total):"*** hidden ***"}</div><div style="font-size:10px;opacity:.5">${(isOwner()||isSales())?'/month':''}</div></div></div>
<div class="g3" style="gap:6px"><div style="background:rgba(255,255,255,.1);border-radius:6px;padding:8px;text-align:center"><div style="font-size:9px;opacity:.5;text-transform:uppercase;margin-bottom:2px">Advance</div><div style="font-size:14px;font-weight:700">${fmt(c.advance)}</div></div><div style="background:rgba(255,255,255,.1);border-radius:6px;padding:8px;text-align:center"><div style="font-size:9px;opacity:.5;text-transform:uppercase;margin-bottom:2px">Balance</div><div style="font-size:14px;font-weight:700;color:#fca5a5">${fmt(total-c.advance)}</div></div><div style="background:rgba(255,255,255,.1);border-radius:6px;padding:8px;text-align:center"><div style="font-size:9px;opacity:.5;text-transform:uppercase;margin-bottom:2px">Rating</div><div style="font-size:14px;font-weight:700">${c.satisfactionScore?'★'.repeat(c.satisfactionScore):'—'}</div></div></div></div>
<div class="tabs" id="cp-tabs"><div class="tab act" onclick="cpTab('cp-svcs',this)">Services</div><div class="tab" onclick="cpTab('cp-inv',this)">Invoices</div><div class="tab" onclick="cpTab('cp-chat',this)">Chat</div><div class="tab" onclick="cpTab('cp-files',this)">Files</div><div class="tab" onclick="cpTab('cp-tasks',this)">Tasks</div><div class="tab" onclick="cpTab('cp-sat',this)">Satisfaction</div></div>
<div id="cp-svcs">${(isOwner()||isSales())?`<table><thead><tr><th>Service</th><th>Price</th><th>Qty</th><th>Total</th></tr></thead><tbody>${c.services.map(cs=>{const s=DB.services.find(x=>x.id===cs.serviceId);return`<tr><td class='fw6'>${s?.name||'?'}</td><td class='mono'>${fmt(cs.price)}</td><td>${cs.qty}</td><td class='mono fw7'>${fmt(cs.price*cs.qty)}</td></tr>`;}).join('')}</tbody></table>`:`<table><thead><tr><th>Service Required</th><th>Monthly Qty</th><th>Unit</th></tr></thead><tbody>${c.services.map(cs=>{const s=DB.services.find(x=>x.id===cs.serviceId);return`<tr><td class='fw6'>${s?.name||'?'}</td><td class='mono'>${cs.qty}</td><td class='fs12' style='color:var(--t3)'>${s?.unit||''}</td></tr>`;}).join('')}</tbody></table>`}</div>
<div id="cp-inv" style="display:none">${canDo('invoices')?`${invs.length?`<table><thead><tr><th>#</th><th>Period</th><th>Total</th><th>Balance</th><th>Status</th><th></th></tr></thead><tbody>${invs.map(inv=>{const st=pSt(inv);return`<tr><td class="mono fw7 tb2">${inv.number}</td><td class="fs11">${inv.period}</td><td class="mono">${fmt(iTotal(inv))}</td><td class="mono ${inv.status==='paid'?'tg':'tr'}">${inv.status==='paid'?'PAID':fmt(iBal(inv))}</td><td>${bh(st.l,st.c,st.b)}</td><td><button class="btn btn-xs btn-grn" onclick="dlInvoice(${inv.id})"><i class="fa fa-download"></i> PDF</button></td></tr>`;}).join('')}</tbody></table>`:'<div class="empty" style="padding:16px"><i class="fa fa-file-invoice"></i>No invoices</div>'}`:
`<div class="empty"><i class="fa fa-lock"></i>Invoice access restricted</div>`}</div>
<div id="cp-chat" style="display:none"><div class="chat-wrap" style="height:300px"><div class="chat-msgs" id="cc-msgs-${id}">${chats.map(m=>{const u=DB.users.find(x=>x.id===m.userId);const mine=m.userId===DB.currentUser.id;return`<div class="cmsg ${mine?'mine':''}">${avH(u?.name,u?.color,24,9)}<div><div class="fs10" style="color:var(--t3);${mine?'text-align:right':''};margin-bottom:2px">${u?.name}</div><div class="cbub">${m.text}</div></div></div>`;}).join('')||'<div style="text-align:center;color:var(--t3);padding:16px;font-size:12px">No messages</div>'}</div><div class="chat-bar"><textarea class="chat-inp" id="cc-inp-${id}" rows="1" placeholder="Team chat for ${c.name}…" onkeydown="if(event.key==='Enter'&&!event.shiftKey){event.preventDefault();sendCC(${id})}"></textarea><button class="chat-send" onclick="sendCC(${id})"><i class="fa fa-paper-plane"></i></button></div></div></div>
<div id="cp-files" style="display:none"><div class="flex ic sbj mb8"><div class="sect-t" style="margin-bottom:0">Asset Library</div><button class="btn btn-sm btn-p" onclick="uploadFile(${id})"><i class="fa fa-upload"></i> Upload</button></div>${files.map(f=>`<div class="fcard"><div style="width:32px;height:32px;border-radius:6px;background:${f.bg};display:flex;align-items:center;justify-content:center;font-size:15px;flex-shrink:0">${f.icon}</div><div class="f1"><div class="fw6 fs12">${f.name}</div><div class="fs11" style="color:var(--t3)">${f.size} · ${uname(f.uploadedBy)}</div></div></div>`).join('')||'<div class="empty" style="padding:14px"><i class="fa fa-folder-open"></i>No files</div>'}</div>
<div id="cp-tasks" style="display:none">${buildTaskProgress(id)}</div>
<div id="cp-sat" style="display:none"><div class="sect-t mb8">Rate Experience</div><div style="text-align:center;padding:16px;background:var(--bg);border-radius:var(--r);margin-bottom:12px"><div class="star-wrap" style="justify-content:center;margin-bottom:9px">${[1,2,3,4,5].map(n=>`<span class="star ${(c.satisfactionScore||0)>=n?'lit':''}" onclick="rateSat(${id},${n})" style="font-size:24px">${(c.satisfactionScore||0)>=n?'★':'☆'}</span>`).join('')}</div><input class="finp" id="sat-cmt-${id}" placeholder="Comment…" style="margin-bottom:7px"><button class="btn btn-p btn-sm" onclick="saveSat(${id})">Save Rating</button></div>${(c.satisfactionHistory||[]).map(h=>`<div style="padding:8px;border:1px solid var(--border);border-radius:var(--r);margin-bottom:5px"><div class="flex ic sbj"><span>${'★'.repeat(h.stars)}</span><span class="fs11" style="color:var(--t3)">${fmtD(h.date)}</span></div>${h.comment?`<div class="fs11 mt3">${h.comment}</div>`:''}</div>`).join('')||'<div class="empty" style="padding:12px">No ratings</div>'}</div>
<div class="mact"><button class="btn btn-o" onclick="closeMo()">Close</button>${isOwner()?`<button class="btn btn-o" onclick="closeMo();openAddClient(DB.clients.find(x=>x.id===${id}))"><i class="fa fa-edit"></i> Edit</button>`:''}<button class="btn btn-pur" onclick="openBriefGen(${id})"><i class="fa fa-magic"></i> AI Brief</button></div>`,true);
  setTimeout(()=>{const el=document.getElementById(`cc-msgs-${id}`);if(el)el.scrollTop=el.scrollHeight;},100);
}
function buildTaskProgress(clientId){const tasks=DB.tasks.filter(t=>t.clientId===clientId);if(!tasks.length)return'<div class="empty" style="padding:14px"><i class="fa fa-tasks"></i>No tasks</div>';
let html='';tasks.forEach(t=>{const u=DB.users.find(x=>x.id===t.assignedTo);const subs=getSubTasks(t.id);html+=`<div class="pb-wrap"><div class="flex ic gap7 mb7">${avH(u?.name,u?.color,24,9)}<div class="f1"><div class="fw7 fs12">${t.title}</div><div class="fs11" style="color:var(--t3)">→ ${u?.name||'?'} · Due: ${fmtD(t.deadline)}</div></div>${taskStatusBadge(t)}</div>
${t.progress?.length?`<div style="border-left:2px solid var(--amber);padding-left:8px;margin-bottom:6px">${t.progress.map(p=>`<div class="fs11 mb3"><strong>${uname(p.by)}</strong> · ${fmtD(p.date)} — ${p.note}${p.done?` <span class="mono tg">(${p.done}/${p.total})</span>`:''}</div>`).join('')}</div>`:''}
${subs.length?`<div class="fs11 fw7 mb4" style="color:var(--t3)">Sub-tasks:</div>${subs.map(s=>{const su=DB.users.find(x=>x.id===s.assignedTo);const sp=s.progress?.slice(-1)[0];return`<div style="border-left:2px solid var(--border);padding-left:8px;margin-bottom:6px"><div class="flex ic gap5 mb2"><i class="fa fa-${s.status==='done'?'check-circle tg':s.status==='done_pending_review'?'clock tp':'circle'}" style="font-size:10px"></i><span class="fw6 fs11">${s.title}</span><span style="color:var(--t3)">→ ${su?.name||'?'}</span>${taskStatusBadge(s)}</div>${sp?`<div class="fs11" style="color:var(--t2)">Latest: ${sp.note} ${sp.done?`(${sp.done}/${sp.total})`:''}  · ${fmtD(sp.date)}</div>`:''}</div>`;}).join('')}`:''}
</div>`;});return html;}
function cpTab(id,el){document.querySelectorAll('#cp-tabs .tab').forEach(t=>t.classList.remove('act'));el.classList.add('act');['cp-svcs','cp-inv','cp-chat','cp-files','cp-tasks','cp-sat'].forEach(k=>{const e=document.getElementById(k);if(e)e.style.display=k===id?'block':'none';});}
function sendCC(clientId){const inp=document.getElementById(`cc-inp-${clientId}`);if(!inp||!inp.value.trim())return;if(!DB.clientChats[clientId])DB.clientChats[clientId]=[];const msg={id:uid(),userId:DB.currentUser.id,text:inp.value.trim(),ts:new Date().toLocaleString('en-GB',{day:'numeric',month:'short',hour:'2-digit',minute:'2-digit'})};DB.clientChats[clientId].push(msg);inp.value='';save();const c=document.getElementById(`cc-msgs-${clientId}`);if(c){const u=DB.currentUser;c.innerHTML+=`<div class="cmsg mine">${avH(u.name,u.color,24,9)}<div><div class="cbub">${msg.text}</div></div></div>`;c.scrollTop=c.scrollHeight;}}
function uploadFile(id){const name=prompt('File name:');if(!name)return;if(!DB.clientFiles[id])DB.clientFiles[id]=[];const ext=name.split('.').pop().toLowerCase();const icons={pdf:'📋',ai:'🎨',psd:'🖌️',png:'🖼️',fig:'📐',zip:'📦'};DB.clientFiles[id].push({id:uid(),name,category:'creative',size:Math.round(Math.random()*3000)/10+' KB',uploadedBy:DB.currentUser.id,date:new Date().toISOString().split('T')[0],icon:icons[ext]||'📁',bg:'#f1f5f9'});save();addNotif('📁','#dbeafe',`File "${name}" uploaded`);closeMo();openCP(id);}
function rateSat(cid,stars){const c=DB.clients.find(x=>x.id===cid);if(c)c._ts=stars;document.querySelectorAll(`#cp-sat .star`).forEach((el,i)=>{el.textContent=i<stars?'★':'☆';el.classList.toggle('lit',i<stars);});}
function saveSat(cid){const c=DB.clients.find(x=>x.id===cid);if(!c||!c._ts)return;const cmt=document.getElementById(`sat-cmt-${cid}`)?.value||'';c.satisfactionScore=c._ts;if(!c.satisfactionHistory)c.satisfactionHistory=[];c.satisfactionHistory.push({stars:c._ts,comment:cmt,date:new Date().toISOString().split('T')[0]});delete c._ts;save();alert(`Rating saved: ${c.satisfactionScore}/5`);}

// ══════ SERVICES ══════
function pgServices(){return`<div class="ph"><div class="ph-t">Service Catalog</div><button class="btn btn-p" onclick="openAddSvc()"><i class="fa fa-plus"></i> Add Service</button></div>
<div class="tw"><table><thead><tr><th>Service</th><th>Base Price</th><th>Unit</th><th>Recurring</th><th>Trackable</th><th>Status</th><th></th></tr></thead><tbody>
${DB.services.map(s=>`<tr><td class="fw7">${s.name}</td><td class="mono tg">${fmt(s.basePrice)}</td><td class="fs11">${s.unit}</td>
<td>${bh(s.recurring?'Recurring':'One-time',s.recurring?'var(--gd)':'var(--t3)',s.recurring?'var(--gb)':'var(--bg)')}</td>
<td>${bh(s.trackable?'Yes':'No',s.trackable?'var(--pd)':'var(--t3)',s.trackable?'var(--pb)':'var(--bg)')}</td>
<td>${bh(s.active?'Active':'Off',s.active?'var(--gd)':'var(--t3)',s.active?'var(--gb)':'var(--bg)')}</td>
<td><div class="flex gap4"><button class="btn btn-xs btn-o" onclick="openEditSvc(${s.id})"><i class="fa fa-edit"></i></button><button class="btn btn-xs ${s.active?'btn-red':'btn-grn'}" onclick="toggleSvc(${s.id})">${s.active?'Disable':'Enable'}</button></div></td></tr>`).join('')}
</tbody></table></div>`;}
function openAddSvc(pre={}){showMo(`<div class="mt2">${pre.id?'Edit':'Add'} Service <button class="mc2" onclick="closeMo()"><i class="fa fa-times"></i></button></div>
<div class="fg"><label class="flbl">Name *</label><input class="finp" id="sn" value="${pre.name||''}"></div>
<div class="fr2"><div class="fg"><label class="flbl">Base Price (৳)</label><input class="finp" type="number" id="sp2" value="${pre.basePrice||''}"></div><div class="fg"><label class="flbl">Unit</label><select class="fsel" id="su">${['per post','per video','per article','per session','per month','one-time','per page'].map(u=>`<option ${pre.unit===u?'selected':''}>${u}</option>`).join('')}</select></div></div>
<div class="fr2"><div class="fg"><label class="flbl">Recurring?</label><select class="fsel" id="sr"><option value="0" ${!pre.recurring?'selected':''}>No</option><option value="1" ${pre.recurring?'selected':''}>Yes</option></select></div><div class="fg"><label class="flbl">Trackable Units?</label><select class="fsel" id="sk"><option value="0" ${!pre.trackable?'selected':''}>No</option><option value="1" ${pre.trackable?'selected':''}>Yes</option></select></div></div>
<div class="mact"><button class="btn btn-o" onclick="closeMo()">Cancel</button><button class="btn btn-p" onclick="saveSvc(${pre.id||0})">Save</button></div>`);}
function saveSvc(id){const n=document.getElementById('sn')?.value?.trim();const p=parseFloat(document.getElementById('sp2')?.value);if(!n||!p){alert('Fill required fields');return;}const d={name:n,basePrice:p,unit:document.getElementById('su').value,recurring:document.getElementById('sr').value==='1',trackable:document.getElementById('sk').value==='1',active:true};if(id){const i=DB.services.findIndex(s=>s.id===id);if(i>=0)Object.assign(DB.services[i],d);}else{d.id=uid();DB.services.push(d);}save();closeMo();go('services');}
function openEditSvc(id){const s=DB.services.find(x=>x.id===id);if(s)openAddSvc(s);}
function toggleSvc(id){const s=DB.services.find(x=>x.id===id);if(s){s.active=!s.active;save();go('services');}}

// ══════ INVOICES ══════
function pgInvoices(){return`<div class="ph"><div class="ph-t">Invoices</div></div><div class="flex gap7 mb12" style="flex-wrap:wrap"><button class="btn btn-p" onclick="openAddInvoice()"><i class="fa fa-plus"></i> Create Invoice</button>
<select class="fsel" id="if-status" onchange="renderIT()" style="padding:6px 10px;font-size:12px;width:auto"><option value="">All Status</option><option value="paid">Paid</option><option value="sent">Unpaid</option><option value="overdue">Overdue</option><option value="draft">Draft</option></select>
<select class="fsel" id="if-month" onchange="renderIT()" style="padding:6px 10px;font-size:12px;width:auto"><option value="">All Months</option>${[...new Set(DB.invoices.map(i=>i.month))].map(m=>`<option>${m}</option>`).join('')}</select>
<select class="fsel" id="if-client" onchange="renderIT()" style="padding:6px 10px;font-size:12px;width:auto"><option value="">All Clients</option>${DB.clients.map(c=>`<option value="${c.id}">${c.name}</option>`).join('')}</select>
</div><div id="inv-table"></div>`;}
function renderIT(){
  const fs=document.getElementById('if-status')?.value;const fm=document.getElementById('if-month')?.value;const fc=parseInt(document.getElementById('if-client')?.value)||0;
  let invs=DB.invoices;if(fc)invs=invs.filter(i=>i.clientId===fc);if(fm)invs=invs.filter(i=>i.month===fm);
  if(fs==='overdue')invs=invs.filter(i=>i.status!=='paid'&&daysFrom(i.dueDate)<0);else if(fs==='sent')invs=invs.filter(i=>i.status!=='paid');else if(fs)invs=invs.filter(i=>i.status===fs);
  const el=document.getElementById('inv-table');if(!el)return;
  el.innerHTML=`<div class="tw"><table><thead><tr><th>Invoice #</th><th>Client</th><th>Period</th><th>Total</th><th>Advance</th><th>Balance</th><th>Due Date</th><th>Status</th><th>Actions</th></tr></thead><tbody>
${invs.map(inv=>{const c=DB.clients.find(x=>x.id===inv.clientId);const t=iTotal(inv);const b=iBal(inv);const st=pSt(inv);return`<tr>
<td class="mono fw7 tb2">${inv.number}</td>
<td><div class="flex ic gap6">${avH(c?.name,cclr(inv.clientId),22,8)}<span class="fw6 fs12">${c?.name||'—'}</span></div></td>
<td class="fs11">${inv.period}</td><td class="mono">${fmt(t)}</td><td class="mono tg">${fmt(inv.advance)}</td><td class="mono tr fw7">${fmt(b)}</td>
<td class="fs12">${fmtD(inv.dueDate)}</td><td>${bh(st.l,st.c,st.b)}</td>
<td><div class="flex gap4"><button class="btn btn-xs btn-o" onclick="viewInv(${inv.id})"><i class="fa fa-eye"></i></button><button class="btn btn-xs btn-grn" onclick="dlInvoice(${inv.id})"><i class="fa fa-download"></i> PDF</button>${inv.status!=='paid'?`<button class="btn btn-xs btn-grn" onclick="markPaid(${inv.id})"><i class="fa fa-check"></i></button>`:''}</div></td></tr>`}).join('')||'<tr><td colspan="9" style="text-align:center;color:var(--t3);padding:16px">No invoices</td></tr>'}
</tbody></table></div>`;
}
function openAddInvoice(){
  const num='INV-2025-'+String(DB.invoices.length+4).padStart(3,'0');
  showMo(`<div class="mt2">Create Invoice <button class="mc2" onclick="closeMo()"><i class="fa fa-times"></i></button></div>
<div class="fr2"><div class="fg"><label class="flbl">Client</label><select class="fsel" id="ic" onchange="popInvSvcs()">${DB.clients.map(c=>`<option value="${c.id}">${c.name}</option>`).join('')}</select></div><div class="fg"><label class="flbl">Invoice #</label><input class="finp" id="inum" value="${num}"></div></div>
<div class="fr2"><div class="fg"><label class="flbl">Period</label><input class="finp" id="ip" placeholder="June 2025"></div><div class="fg"><label class="flbl">Due Date</label><input class="finp" type="date" id="idd"></div></div>
<div id="inv-svc-wrap"></div>
<div class="mact"><button class="btn btn-o" onclick="closeMo()">Cancel</button><button class="btn btn-p" onclick="saveInv()">Create</button></div>`,true);popInvSvcs();
}
function popInvSvcs(){const cid=parseInt(document.getElementById('ic')?.value);const c=DB.clients.find(x=>x.id===cid);const w=document.getElementById('inv-svc-wrap');if(!w||!c){if(w)w.innerHTML='';return;}const rows=c.services.map(cs=>{const s=DB.services.find(x=>x.id===cs.serviceId);if(!s)return'';return`<div class="srvc-row"><div class="f1 fw6 fs11">${s.name}</div><input type="number" id="iq-${s.id}" value="${cs.qty}" min="1" oninput="calcInvT(${cid})" style="width:48px;border:1px solid var(--border);border-radius:5px;padding:4px;font-size:11px;text-align:center"><div class="fs11">× ${fmt(cs.price)}</div><div class="mono fw7 fs11" id="ist-${s.id}">${fmt(cs.price*cs.qty)}</div></div>`;}).join('');w.innerHTML=rows+`<div class="fr2 mt10"><div class="fg"><label class="flbl">Advance Deduct</label><input class="finp" type="number" id="iadv" value="${c.advance||0}" oninput="calcInvT(${cid})"></div><div style="background:var(--bg);border-radius:var(--r);padding:9px;border:1px solid var(--border)"><div class="flex sbj fs12 mb3"><span>Subtotal</span><strong class="mono" id="i-sub">—</strong></div><div class="flex sbj fs12"><span style="color:var(--t3)">Balance</span><strong class="mono tr" id="i-bal">—</strong></div></div></div>`;calcInvT(cid);}
function calcInvT(cid){const c=DB.clients.find(x=>x.id===cid);if(!c)return;let sub=0;c.services.forEach(cs=>{const q=parseInt(document.getElementById('iq-'+cs.serviceId)?.value||cs.qty);const t=cs.price*q;const el=document.getElementById('ist-'+cs.serviceId);if(el)el.textContent=fmt(t);sub+=t;});const adv=parseFloat(document.getElementById('iadv')?.value||0);const es=document.getElementById('i-sub');const eb=document.getElementById('i-bal');if(es)es.textContent=fmt(sub);if(eb)eb.textContent=fmt(sub-adv);}
function saveInv(){const cid=parseInt(document.getElementById('ic').value);const c=DB.clients.find(x=>x.id===cid);if(!c)return;const items=c.services.map(cs=>{const s=DB.services.find(x=>x.id===cs.serviceId);if(!s)return null;return{name:s.name,qty:parseInt(document.getElementById('iq-'+s.id)?.value||cs.qty),price:cs.price};}).filter(Boolean);const dueDate=document.getElementById('idd').value;const inv={id:uid(),clientId:cid,number:document.getElementById('inum').value,period:document.getElementById('ip').value||'—',month:dueDate?dueDate.slice(0,7):'2025-05',issueDate:new Date().toISOString().split('T')[0],dueDate,status:'draft',items,advance:parseFloat(document.getElementById('iadv')?.value||0),reminders:[]};DB.invoices.push(inv);addNotif('📄','#dbeafe',`Invoice ${inv.number} created`);save();closeMo();go('invoices');setTimeout(renderIT,50);}
function viewInv(id){const inv=DB.invoices.find(x=>x.id===id);if(!inv)return;const c=DB.clients.find(x=>x.id===inv.clientId);const t=iTotal(inv);const b=iBal(inv);
showMo(`<div class="mt2">${inv.number} <button class="mc2" onclick="closeMo()"><i class="fa fa-times"></i></button></div>
<div style="border:2px solid var(--amber);border-radius:var(--rlg);padding:20px">
<div class="flex ic sbj mb12 pb-2" style="padding-bottom:12px;border-bottom:2px solid var(--al)"><div><div style="font-size:18px;font-weight:800;color:var(--navy)">DMS CRM</div><div class="fs11" style="color:var(--t3)">Digital Marketing Agency · Dhaka, Bangladesh</div></div><div style="text-align:right"><div class="fw7">${inv.number}</div><div class="fs11" style="color:var(--t3)">Issued: ${fmtD(inv.issueDate)}</div><div class="fs11 tr">Due: ${fmtD(inv.dueDate)}</div></div></div>
<div class="mb10 fs12"><strong>Bill To:</strong> ${c?.name||'—'} · ${c?.company||''}<br>${c?.email||''} · ${c?.phone||''}</div>
<table style="width:100%;border-collapse:collapse;margin-bottom:10px"><thead><tr style="background:var(--navy)"><th style="padding:6px 9px;color:#fff;font-size:10px;text-align:left">Service</th><th style="padding:6px 9px;color:#fff;font-size:10px;text-align:center">Qty</th><th style="padding:6px 9px;color:#fff;font-size:10px;text-align:right">Price</th><th style="padding:6px 9px;color:#fff;font-size:10px;text-align:right">Total</th></tr></thead><tbody>
${inv.items.map(i=>`<tr><td style="padding:6px 9px;border-bottom:1px solid var(--border)">${i.name}</td><td style="padding:6px 9px;border-bottom:1px solid var(--border);text-align:center">${i.qty}</td><td class="mono" style="padding:6px 9px;border-bottom:1px solid var(--border);text-align:right">${fmt(i.price)}</td><td class="mono fw7" style="padding:6px 9px;border-bottom:1px solid var(--border);text-align:right">${fmt(i.qty*i.price)}</td></tr>`).join('')}
<tr><td colspan="3" style="padding:6px 9px;text-align:right;font-weight:700">Subtotal</td><td class="mono fw7" style="padding:6px 9px;text-align:right">${fmt(t)}</td></tr>
<tr><td colspan="3" style="padding:6px 9px;text-align:right;color:var(--green)">Advance</td><td class="mono tg" style="padding:6px 9px;text-align:right">(${fmt(inv.advance)})</td></tr>
<tr style="background:var(--al)"><td colspan="3" style="padding:8px 9px;text-align:right;font-weight:800">Balance Due</td><td class="mono tr fw7" style="padding:8px 9px;text-align:right;font-size:14px">${fmt(b)}</td></tr>
</tbody></table>
<div class="fs11" style="color:var(--t3)">Period: ${inv.period} · Status: ${inv.status.toUpperCase()}</div></div>
<div class="mact"><button class="btn btn-o" onclick="closeMo()">Close</button>${inv.status!=='paid'?`<button class="btn btn-grn" onclick="markPaid(${inv.id});closeMo();renderIT()"><i class="fa fa-check"></i> Paid</button>`:''}<button class="btn btn-p" onclick="dlInvoice(${inv.id})"><i class="fa fa-download"></i> PDF</button></div>`,true);}

function dlInvoice(id){
  const inv=DB.invoices.find(x=>x.id===id);if(!inv){alert('Not found');return;}const c=DB.clients.find(x=>x.id===inv.clientId);
  try{const {jsPDF}=window.jspdf;const doc=new jsPDF();doc.setFontSize(20);doc.setFont('helvetica','bold');doc.text('DMS CRM',20,20);doc.setFontSize(10);doc.setFont('helvetica','normal');doc.setTextColor(100);doc.text('Digital Marketing Agency · Dhaka, Bangladesh',20,28);doc.setTextColor(0);doc.setFontSize(12);doc.setFont('helvetica','bold');doc.text(inv.number,190,20,{align:'right'});doc.setFont('helvetica','normal');doc.setFontSize(9);doc.text(`Issued: ${fmtD(inv.issueDate)}`,190,27,{align:'right'});doc.text(`Due: ${fmtD(inv.dueDate)}`,190,33,{align:'right'});doc.setLineWidth(0.5);doc.setDrawColor(245,158,11);doc.line(20,36,190,36);doc.setFontSize(10);doc.setFont('helvetica','bold');doc.text('Bill To:',20,44);doc.setFont('helvetica','normal');doc.text(`${c?.name||'—'}`,20,51);doc.text(`${c?.company||''}`,20,57);doc.text(`${c?.email||''} · ${c?.phone||''}`,20,63);let y=74;doc.setFillColor(8,17,31);doc.rect(20,y-5,170,10,'F');doc.setTextColor(255,255,255);doc.setFontSize(9);doc.setFont('helvetica','bold');doc.text('Service',22,y);doc.text('Qty',120,y,{align:'center'});doc.text('Unit Price',155,y,{align:'right'});doc.text('Total',188,y,{align:'right'});doc.setTextColor(0);doc.setFont('helvetica','normal');y+=12;inv.items.forEach(item=>{doc.text(item.name,22,y);doc.text(String(item.qty),120,y,{align:'center'});doc.text(fmt(item.price),155,y,{align:'right'});doc.text(fmt(item.qty*item.price),188,y,{align:'right'});y+=8;doc.setDrawColor(200);doc.line(20,y-2,190,y-2);});y+=4;doc.setFont('helvetica','bold');doc.text('Subtotal',140,y);doc.text(fmt(iTotal(inv)),188,y,{align:'right'});y+=8;doc.setTextColor(22,163,74);doc.text('Advance Paid',140,y);doc.text(`(${fmt(inv.advance)})`,188,y,{align:'right'});y+=8;doc.setFillColor(254,243,199);doc.rect(20,y-5,170,12,'F');doc.setTextColor(0);doc.setFontSize(12);doc.setFont('helvetica','bold');doc.text('Balance Due',22,y+2);doc.text(fmt(iBal(inv)),188,y+2,{align:'right'});y+=18;doc.setFontSize(9);doc.setFont('helvetica','normal');doc.setTextColor(100);doc.text(`Period: ${inv.period} · Status: ${inv.status.toUpperCase()}`,20,y);doc.save(`${inv.number}_${c?.name||'invoice'}.pdf`);}catch(e){alert('PDF error: '+e.message);}
}

// ══════ EXPENSES ══════
function pgExpenses(){return`<div class="ph"><div><div class="ph-t">Expense Tracker</div></div><div class="flex gap7"><button class="btn btn-sm btn-o" onclick="openManageCats()"><i class="fa fa-tags"></i> Categories</button><button class="btn btn-p" onclick="openAddExpense()"><i class="fa fa-plus"></i> Log Expense</button></div></div>
<div class="flex gap7 mb12" style="flex-wrap:wrap">
<select class="fsel" id="ef-month" onchange="renderExpenses()" style="padding:6px 10px;font-size:12px;width:auto"><option value="2025-05" selected>May 2025</option>${['2025-04','2025-06'].map(m=>`<option>${m}</option>`).join('')}<option value="">All Months</option></select>
<select class="fsel" id="ef-cat" onchange="renderExpenses()" style="padding:6px 10px;font-size:12px;width:auto"><option value="">All Categories</option>${DB.expenseCategories.map(c=>`<option value="${c.id}">${c.icon} ${c.name}</option>`).join('')}</select>
</div>
<div id="exp-summary"></div><div id="exp-list"></div>`;}
function renderExpenses(){
  const fm=document.getElementById('ef-month')?.value||'';const fc=parseInt(document.getElementById('ef-cat')?.value)||0;
  let exps=DB.expenses;if(fm)exps=exps.filter(e=>e.month===fm);if(fc)exps=exps.filter(e=>e.categoryId===fc);
  const total=exps.reduce((s,e)=>s+e.amount,0);const catTotals={};exps.forEach(e=>{if(!catTotals[e.categoryId])catTotals[e.categoryId]=0;catTotals[e.categoryId]+=e.amount;});
  const tP=DB.invoices.filter(i=>i.status==='paid'&&(!fm||i.month===fm)).reduce((s,i)=>s+iTotal(i),0);
  const sEl=document.getElementById('exp-summary');if(sEl){sEl.innerHTML=`<div class="g3 mb12"><div class="mc"><div class="mc-icon" style="background:var(--rb)"><i class="fa fa-receipt" style="color:var(--red)"></i></div><div class="mc-lbl">Total Expenses</div><div class="mc-val tr">${fmt(total)}</div><div class="mc-sub">${exps.length} entries</div></div><div class="mc"><div class="mc-icon" style="background:var(--gb)"><i class="fa fa-arrow-down" style="color:var(--green)"></i></div><div class="mc-lbl">Income (Collected)</div><div class="mc-val tg">${fmt(tP)}</div></div><div class="mc" style="cursor:pointer" onclick="go('reports')"><div class="mc-icon" style="background:var(--bb)"><i class="fa fa-chart-bar" style="color:var(--blue)"></i></div><div class="mc-lbl">Net Cash Flow</div><div class="mc-val" style="color:${tP-total>=0?'var(--green)':'var(--red)'}">${fmt(tP-total)}</div></div></div>
<div class="card mb12"><div class="sect-t mb10">Breakdown by Category</div>${Object.entries(catTotals).sort((a,b)=>b[1]-a[1]).map(([catId,amt])=>{const cat=expCat(parseInt(catId));const p=pct(amt,total);return`<div style="margin-bottom:7px"><div class="flex ic sbj mb4"><span style="background:${cat.color}22;color:${cat.color};padding:2px 8px;border-radius:20px;font-size:10px;font-weight:700">${cat.icon} ${cat.name}</span><div class="flex ic gap7"><span class="mono fs11 fw7">${fmt(amt)}</span><span class="fs11" style="color:var(--t3)">${p}%</span></div></div><div class="pb2" style="height:5px"><div class="pf" style="width:${p}%;height:5px;background:${cat.color}"></div></div></div>`;}).join('')||'<div class="fs12" style="color:var(--t3)">No expenses</div>'}</div>`;}
  const lEl=document.getElementById('exp-list');if(!lEl)return;
  lEl.innerHTML=`<div class="tw"><table><thead><tr><th>Date</th><th>Category</th><th>Reason</th><th>Paid To</th><th>Amount</th><th>Notes</th><th></th></tr></thead><tbody>
${exps.sort((a,b)=>b.date.localeCompare(a.date)).map(e=>{const cat=expCat(e.categoryId);return`<tr><td class="fs12">${fmtD(e.date)}</td><td><span class="exp-cat" style="background:${cat.color}22;color:${cat.color}">${cat.icon} ${cat.name}</span></td><td class="fw6 fs12">${e.reason}</td><td class="fs12">${e.paidTo||'—'}</td><td class="mono fw7 tr">${fmt(e.amount)}</td><td class="fs11" style="color:var(--t3)">${e.notes||'—'}</td><td><div class="flex gap4"><button class="btn btn-xs btn-o" onclick="openAddExpense(DB.expenses.find(x=>x.id===${e.id}))"><i class="fa fa-edit"></i></button><button class="btn btn-xs btn-red" onclick="if(confirm('Delete?')){DB.expenses=DB.expenses.filter(x=>x.id!==${e.id});save();renderExpenses()}"><i class="fa fa-trash"></i></button></div></td></tr>`;}).join('')||'<tr><td colspan="7" style="text-align:center;color:var(--t3);padding:16px">No expenses</td></tr>'}
</tbody></table></div>`;
}
function openAddExpense(pre={}){
  showMo(`<div class="mt2">${pre.id?'Edit':'Log'} Expense <button class="mc2" onclick="closeMo()"><i class="fa fa-times"></i></button></div>
<div class="fr2"><div class="fg"><label class="flbl">Category *</label><select class="fsel" id="ec">${DB.expenseCategories.map(c=>`<option value="${c.id}" ${pre.categoryId===c.id?'selected':''}>${c.icon} ${c.name}</option>`).join('')}</select></div><div class="fg"><label class="flbl">Date *</label><input class="finp" type="date" id="ed" value="${pre.date||new Date().toISOString().split('T')[0]}"></div></div>
<div class="fg"><label class="flbl">Reason *</label><input class="finp" id="er" value="${pre.reason||''}" placeholder="e.g. May office rent, Adobe CC…"></div>
<div class="fr2"><div class="fg"><label class="flbl">Amount (৳) *</label><input class="finp" type="number" id="ea" value="${pre.amount||''}"></div><div class="fg"><label class="flbl">Paid To</label><input class="finp" id="ep" value="${pre.paidTo||''}"></div></div>
<div class="fg"><label class="flbl">Notes</label><textarea class="fta" id="en" style="min-height:44px">${pre.notes||''}</textarea></div>
<div class="mact"><button class="btn btn-o" onclick="closeMo()">Cancel</button><button class="btn btn-p" onclick="saveExpense(${pre.id||0})">Save</button></div>`);}
async function saveExpense(id){const reason=document.getElementById('er')?.value?.trim();const amount=parseFloat(document.getElementById('ea')?.value)||0;if(!reason||!amount){alert('Reason and amount required');return;}const date=document.getElementById('ed').value;const d={title:reason,categoryId:parseInt(document.getElementById('ec').value)||null,date,amount,paymentMethod:document.getElementById('ep').value||'cash',notes:document.getElementById('en').value};try{await saveEntity('expenses',id,d);await loadFromAPI();closeMo();renderExpenses();}catch(e){alert(e.message||'Expense save failed');}}
function openManageCats(){showMo(`<div class="mt2">Expense Categories <button class="mc2" onclick="closeMo()"><i class="fa fa-times"></i></button></div>
${DB.expenseCategories.map(c=>`<div class="flex ic gap8 mb7 srvc-row"><span style="font-size:17px">${c.icon}</span><div class="f1 fw6 fs12">${c.name}</div><div style="width:13px;height:13px;border-radius:50%;background:${c.color}"></div><button class="btn btn-xs btn-red" onclick="if(confirm('Delete?')){DB.expenseCategories=DB.expenseCategories.filter(x=>x.id!==${c.id});save();closeMo();openManageCats()}"><i class="fa fa-trash"></i></button></div>`).join('')}
<div class="sep"></div><div class="sect-t">Add Category</div>
<div class="fr3"><div class="fg"><label class="flbl">Name</label><input class="finp" id="nc-name"></div><div class="fg"><label class="flbl">Emoji</label><input class="finp" id="nc-icon" placeholder="💼" maxlength="2"></div><div class="fg"><label class="flbl">Color</label><input type="color" class="finp" id="nc-color" value="#3b82f6" style="height:38px;cursor:pointer"></div></div>
<button class="btn btn-p btn-sm" onclick="addExpCatNew()"><i class="fa fa-plus"></i> Add</button>`);}
function addExpCatNew(){const n=document.getElementById('nc-name')?.value?.trim();if(!n)return;DB.expenseCategories.push({id:uid(),name:n,icon:document.getElementById('nc-icon')?.value||'📦',color:document.getElementById('nc-color')?.value||'#64748b'});save();closeMo();openManageCats();}

// ══════ CRM ══════
function pgCRM(){return`<div class="ph"><div class="ph-t">CRM Pipeline</div><button class="btn btn-p" onclick="openAddLead()"><i class="fa fa-plus"></i> Add Lead</button></div>
<div class="flex gap7 mb12" style="flex-wrap:wrap">
<input class="finp" id="lf-q" placeholder="Search…" oninput="renderPipe()" style="padding:6px 10px;font-size:12px;max-width:180px">
<select class="fsel" id="lf-src" onchange="renderPipe()" style="padding:6px 10px;font-size:12px;width:auto"><option value="">All Sources</option>${[...new Set(DB.leads.map(l=>l.source))].map(s=>`<option>${s}</option>`).join('')}</select>
${isOwner()?`<select class="fsel" id="lf-user" onchange="renderPipe()" style="padding:6px 10px;font-size:12px;width:auto"><option value="">All Members</option>${DB.users.filter(u=>u.role==='sales').map(u=>`<option value="${u.id}">${u.name}</option>`).join('')}</select>`:''}
</div><div id="crm-board"></div>`;}
function renderPipe(){
  const lq=(document.getElementById('lf-q')?.value||'').toLowerCase();const ls=document.getElementById('lf-src')?.value||'';const lu=parseInt(document.getElementById('lf-user')?.value)||0;
  let leads=DB.leads.filter(l=>!l.deleted);if(!isOwner())leads=leads.filter(l=>l.assignedTo===DB.currentUser.id);if(lq)leads=leads.filter(l=>l.name.toLowerCase().includes(lq)||l.company?.toLowerCase().includes(lq));if(ls)leads=leads.filter(l=>l.source===ls);if(lu)leads=leads.filter(l=>l.assignedTo===lu);
  const el=document.getElementById('crm-board');if(!el)return;
  el.innerHTML=`<div class="pipeline">${DB.leadStages.map(stage=>{const sl=leads.filter(l=>l.stageId===stage.id);const val=sl.reduce((s,l)=>s+(l.budget||0),0);return`<div class="pcol"><div class="phd2" style="color:${stage.color}">${stage.label}<span class="pcnt">${sl.length}</span></div>${val?`<div class="mono fs10 fw6 mb5" style="color:var(--t3)">${fmt(val)}</div>`:''}<div>${sl.map(l=>`<div class="pcard" onclick="viewLead(${l.id})"><div class="fw7 fs12 mb2">${l.name}</div><div class="fs11" style="color:var(--t3)">${l.company||'—'} · ${l.source}</div>${l.budget?`<div class="mono fs11 fw7 tg mt3">${fmt(l.budget)}</div>`:''}<div class="fs10 mt3" style="color:var(--t3)">→ ${uname(l.assignedTo)}</div></div>`).join('')||`<div class="fs11" style="color:var(--t4);padding:5px 0;text-align:center">Empty</div>`}</div></div>`;}).join('')}</div>`;
}
function openAddLead(pre={}){const salesUsers=DB.users.filter(u=>u.role==='sales'||u.role==='owner');
showMo(`<div class="mt2">${pre.id?'Edit':'Add'} Lead <button class="mc2" onclick="closeMo()"><i class="fa fa-times"></i></button></div>
<div class="fr2"><div class="fg"><label class="flbl">Name *</label><input class="finp" id="ln" value="${pre.name||''}"></div><div class="fg"><label class="flbl">Company</label><input class="finp" id="lco" value="${pre.company||''}"></div></div>
<div class="fr2"><div class="fg"><label class="flbl">Phone</label><input class="finp" id="lph" value="${pre.phone||''}"></div><div class="fg"><label class="flbl">Email</label><input class="finp" id="le" value="${pre.email||''}"></div></div>
<div class="fr3"><div class="fg"><label class="flbl">Location</label><input class="finp" id="lloc" value="${pre.location||''}"></div><div class="fg"><label class="flbl">Source</label><select class="fsel" id="lsrc">${['Facebook','Referral','Walk-in','Website','Instagram','WhatsApp','Cold Call'].map(s=>`<option ${pre.source===s?'selected':''}>${s}</option>`).join('')}</select></div><div class="fg"><label class="flbl">Budget (৳)</label><input class="finp" type="number" id="lbud" value="${pre.budget||''}"></div></div>
<div class="fr2"><div class="fg"><label class="flbl">Stage</label><select class="fsel" id="lst">${DB.leadStages.map(s=>`<option value="${s.id}" ${pre.stageId===s.id?'selected':''}>${s.label}</option>`).join('')}</select></div><div class="fg"><label class="flbl">Assign To</label><select class="fsel" id="las">${salesUsers.map(u=>`<option value="${u.id}" ${pre.assignedTo===u.id||(!pre.assignedTo&&u.id===DB.currentUser.id)?'selected':''}>${u.name}</option>`).join('')}</select></div></div>
<div class="fr2"><div class="fg"><label class="flbl">Next Follow-up</label><input class="finp" type="date" id="lfu" value="${pre.nextFollowup||''}"></div><div class="fg"><label class="flbl">Notes</label><textarea class="fta" id="lnt" style="min-height:40px">${pre.notes||''}</textarea></div></div>
<div class="mact"><button class="btn btn-o" onclick="closeMo()">Cancel</button><button class="btn btn-p" onclick="saveLead(${pre.id||0})">Save Lead</button></div>`,true);}
async function saveLead(id){const name=document.getElementById('ln').value.trim();if(!name)return;const d={name,company:document.getElementById('lco').value,email:document.getElementById('le').value,phone:document.getElementById('lph').value,location:document.getElementById('lloc').value,source:document.getElementById('lsrc').value,budget:parseFloat(document.getElementById('lbud').value)||0,stageId:parseInt(document.getElementById('lst').value),assignedTo:parseInt(document.getElementById('las').value),nextFollowup:document.getElementById('lfu').value,notes:document.getElementById('lnt').value,deleted:false};try{await saveEntity('leads',id,d);await loadFromAPI();closeMo();go('crm');setTimeout(renderPipe,50);}catch(e){alert(e.message||'Lead save failed');}}
function viewLead(id){const l=DB.leads.find(x=>x.id===id);if(!l)return;const salesUsers=DB.users.filter(u=>u.role==='sales'||u.role==='owner');
showMo(`<div class="mt2">${l.name} <button class="mc2" onclick="closeMo()"><i class="fa fa-times"></i></button></div>
<div class="tabs" id="ld-tabs"><div class="tab act" onclick="ldTab('ld-info',this)">Info</div><div class="tab" onclick="ldTab('ld-reqs',this)">📋 Requirements</div><div class="tab" onclick="ldTab('ld-timeline',this)">Timeline</div><div class="tab" onclick="ldTab('ld-actions',this)">Actions</div></div>
<div id="ld-info"><div class="g2 mb10"><div><div class="fs10 mb2" style="color:var(--t3)">Company</div><div class="fw6">${l.company||'—'}</div></div><div><div class="fs10 mb2" style="color:var(--t3)">Source</div><div class="fw6">${l.source}</div></div><div><div class="fs10 mb2" style="color:var(--t3)">Budget</div><div class="mono fw7 tg">${fmt(l.budget)}</div></div><div><div class="fs10 mb2" style="color:var(--t3)">Stage</div>${bh(stgLabel(l.stageId),stgColor(l.stageId),'#f8fafc')}</div><div><div class="fs10 mb2" style="color:var(--t3)">Assigned</div><div class="fw6">${uname(l.assignedTo)}</div></div><div><div class="fs10 mb2" style="color:var(--t3)">Follow-up</div><div>${fmtD(l.nextFollowup)}</div></div></div>${l.notes?`<div style="background:var(--bg);border-radius:var(--r);padding:9px;font-size:12px">${l.notes}</div>`:''}</div>
<div id="ld-reqs" style="display:none">
<div class="flex ic sbj mb10"><div class="sect-t" style="margin-bottom:0">Client Requirements <span class="badge" style="background:var(--bb);color:var(--bd)">${(l.requirements||[]).length} items</span></div><button class="btn btn-sm btn-p" onclick="openAddRequirement(${l.id})"><i class="fa fa-plus"></i> Add Requirement</button></div>
${(l.requirements||[]).length===0?'<div class="empty" style="padding:18px"><i class="fa fa-clipboard-list"></i>No requirements added yet.<br>Add what the client needs — services, quantities, pricing.</div>':
'<div class="tw mb10"><table><thead><tr><th>Service / Item</th><th>Qty</th><th>Unit Price</th><th>Total</th><th>Notes</th><th></th></tr></thead><tbody>'+
(l.requirements||[]).map((r,idx)=>`<tr><td class="fw7">${r.service}</td><td class="mono">${r.qty}</td><td class="mono">${fmt(r.unitPrice)}</td><td class="mono fw7 tg">${fmt(r.qty*r.unitPrice)}</td><td class="fs11" style="color:var(--t2)">${r.notes||'—'}</td><td><button class="btn btn-xs btn-red" onclick="removeRequirement(${l.id},'${r.id}')"><i class="fa fa-trash"></i></button></td></tr>`).join('')+
'</tbody></table></div>'+
'<div style="background:var(--gb);border-radius:var(--r);padding:10px;display:flex;justify-content:space-between;align-items:center;margin-bottom:12px"><span class="fw7">Total Value</span><span class="mono fw8 tg">'+(()=>{const total=(l.requirements||[]).reduce((s,r)=>s+r.qty*r.unitPrice,0);return fmt(total);})()+'</span></div>'}
${l.stageId===7?`<div class="abox a-grn"><i class="fa fa-trophy"></i><div><div class="fw7 mb4">🎉 Lead Won! Ready to submit requisition to admin.</div><button class="btn btn-p btn-sm" onclick="openSubmitRequisition(${l.id})"><i class="fa fa-paper-plane"></i> Submit Client Requisition for Admin Approval</button></div></div>`:
l.stageId>=5?`<div class="abox a-blu"><i class="fa fa-info-circle"></i>Close this deal and move to <strong>Won</strong> stage to submit requisition for admin approval.</div>`:''}
</div>
<div id="ld-timeline" style="display:none">${(l.timeline||[]).slice().reverse().map(ev=>`<div style="display:flex;gap:9px;padding:8px 0;border-bottom:1px solid var(--border)"><div style="width:24px;height:24px;border-radius:50%;background:var(--bb);display:flex;align-items:center;justify-content:center;font-size:10px;flex-shrink:0">${{created:'✨',note:'💬',stage:'📍',transfer:'🔄',edit:'✏️'}[ev.type]||'·'}</div><div class="f1"><div class="fw6 fs12">${ev.text}</div><div class="fs11" style="color:var(--t3)">${uname(ev.by)} · ${fmtD(ev.date)}</div></div></div>`).join('')||'<div class="empty" style="padding:12px">No events</div>'}
<div class="mt8"><textarea class="fta" id="tl-note" style="min-height:40px" placeholder="Add note…"></textarea><button class="btn btn-sm btn-p mt5" onclick="addTlNote(${l.id})">Add</button></div></div>
<div id="ld-actions" style="display:none">
<div class="fg mb8"><label class="flbl">Move Stage</label><div class="flex gap4" style="flex-wrap:wrap">${DB.leadStages.map(st=>`<button class="btn btn-xs ${st.id===l.stageId?'btn-p':'btn-o'}" onclick="setStage(${l.id},${st.id})">${st.label}</button>`).join('')}</div></div>
<div class="fg mb8"><label class="flbl">Transfer To</label><div class="flex gap7"><select class="fsel f1" id="trn-to">${salesUsers.map(u=>`<option value="${u.id}">${u.name}</option>`).join('')}</select><button class="btn btn-o btn-sm" onclick="transferLead(${l.id})"><i class="fa fa-share"></i> Transfer</button></div></div>
${l.stageId===7?`<button class="btn btn-p btn-sm" onclick="closeMo();convertToClient(${l.id})"><i class="fa fa-user-plus"></i> Convert to Client</button>`:''}</div>
<div class="mact"><button class="btn btn-o" onclick="closeMo()">Close</button><button class="btn btn-o" onclick="closeMo();openAddLead(DB.leads.find(x=>x.id===${id}))"><i class="fa fa-edit"></i> Edit</button>${isOwner()?`<button class="btn btn-red" onclick="if(confirm('Delete?')){DB.leads.find(x=>x.id===${id}).deleted=true;save();closeMo();go('crm');setTimeout(renderPipe,50)}">Delete</button>`:''}</div>`);}
function ldTab(id,el){document.querySelectorAll('#ld-tabs .tab').forEach(t=>t.classList.remove('act'));el.classList.add('act');['ld-info','ld-reqs','ld-timeline','ld-actions'].forEach(k=>{const e=document.getElementById(k);if(e)e.style.display=k===id?'block':'none';});}
function addTlNote(lid){const n=document.getElementById('tl-note')?.value?.trim();if(!n)return;const l=DB.leads.find(x=>x.id===lid);if(!l)return;l.timeline=l.timeline||[];l.timeline.push({type:'note',by:DB.currentUser.id,text:n,date:new Date().toISOString().split('T')[0]});save();closeMo();viewLead(lid);}
function setStage(lid,sid){const l=DB.leads.find(x=>x.id===lid);if(!l)return;l.timeline=l.timeline||[];l.timeline.push({type:'stage',by:DB.currentUser.id,text:`${stgLabel(l.stageId)} → ${stgLabel(sid)}`,date:new Date().toISOString().split('T')[0]});l.stageId=sid;save();closeMo();go('crm');setTimeout(renderPipe,50);}
function transferLead(lid){const l=DB.leads.find(x=>x.id===lid);if(!l)return;const toId=parseInt(document.getElementById('trn-to').value);l.timeline=l.timeline||[];l.timeline.push({type:'transfer',by:DB.currentUser.id,text:`Transferred to ${uname(toId)}`,date:new Date().toISOString().split('T')[0]});l.assignedTo=toId;addNotif('🔄','#dbeafe',`Lead "${l.name}" → ${uname(toId)}`);save();closeMo();go('crm');setTimeout(renderPipe,50);}
function convertToClient(lid){const l=DB.leads.find(x=>x.id===lid);if(!l)return;const d={id:uid(),name:l.name,email:l.email,phone:l.phone,company:l.company,location:l.location,onboarded:new Date().toISOString().split('T')[0],status:'onboarding',assignedSMM:null,assignedSales:l.assignedTo,advance:0,services:[],notes:l.notes,satisfactionScore:null,satisfactionHistory:[]};DB.clients.push(d);DB.clientChats[d.id]=[];DB.clientFiles[d.id]=[];l.stageId=7;addNotif('🎉','#d1fae5',`"${l.name}" won & converted to client!`);save();closeMo();openAddClient(d);}

// FOLLOW-UPS
function pgFollowups(){let leads=DB.leads.filter(l=>!l.deleted&&l.nextFollowup&&l.stageId<7&&l.stageId!==8);if(!isOwner())leads=leads.filter(l=>l.assignedTo===DB.currentUser.id);const TODAY='2025-05-23';const od=leads.filter(l=>l.nextFollowup<TODAY);const due=leads.filter(l=>l.nextFollowup===TODAY);const up=leads.filter(l=>l.nextFollowup>TODAY).sort((a,b)=>a.nextFollowup.localeCompare(b.nextFollowup));const card=l=>`<div class="card mb5" style="padding:11px"><div class="flex ic gap9">${avH(l.name,'#1e3a5f',26,9)}<div class="f1"><div class="fw7 fs12">${l.name}</div><div class="fs11" style="color:var(--t3)">${l.company||'—'} · ${l.source}</div></div>${bh(stgLabel(l.stageId),stgColor(l.stageId),'#f8fafc')}<div class="mono fs11 fw6">${fmtD(l.nextFollowup)}</div><button class="btn btn-xs btn-p" onclick="viewLead(${l.id})"><i class="fa fa-eye"></i></button></div></div>`;
return`<div class="ph"><div class="ph-t">Follow-ups</div><button class="btn btn-p" onclick="openAddLead()"><i class="fa fa-plus"></i> Add Lead</button></div>
${od.length?`<div class="abox a-red mb10"><i class="fa fa-exclamation-triangle fa-lg"></i><div class="f1"><div class="fw7 mb5">${od.length} Overdue</div>${od.map(card).join('')}</div></div>`:''}
<div class="sect-t mb5">Today (${due.length})</div>${due.length?due.map(card).join(''):'<div style="color:var(--t3);font-size:12px;padding:7px 0">None today ✓</div>'}
<div class="sect-t mb5 mt12">Upcoming (${up.length})</div>${up.length?up.map(card).join(''):'<div style="color:var(--t3);font-size:12px">No upcoming</div>'}`;}

// ══════ TASKS — Cascading Approval ══════
function pgTasks(){return`<div class="ph"><div class="ph-t">Task Board</div><button class="btn btn-p" onclick="openAddTask()"><i class="fa fa-plus"></i> Assign Task</button></div>
<div class="abox a-blu mb12"><i class="fa fa-info-circle"></i><strong>Cascading:</strong> Subtask submits → SMM/lead reviews → Admin final approval</div>
<div class="flex gap7 mb12" style="flex-wrap:wrap"><select class="fsel" id="tf-user" onchange="renderTasks()" style="padding:6px 10px;font-size:12px;width:auto"><option value="">All Members</option>${DB.users.map(u=>`<option value="${u.id}">${u.name}</option>`).join('')}</select><select class="fsel" id="tf-client" onchange="renderTasks()" style="padding:6px 10px;font-size:12px;width:auto"><option value="">All Clients</option>${DB.clients.map(c=>`<option value="${c.id}">${c.name}</option>`).join('')}</select><label style="display:flex;align-items:center;gap:5px;font-size:12px;font-weight:600;color:var(--t2);cursor:pointer"><input type="checkbox" id="tf-stages" onchange="renderTasks()" style="accent-color:var(--amber)"> Use Client Stages</label><button class="btn btn-sm btn-o" onclick="openManageStatuses(parseInt(document.getElementById('tf-client')?.value)||0)"><i class="fa fa-palette"></i> Edit Stages</button></div>
<div id="task-board"></div>`;}
function renderTasks(){
  const fu=parseInt(document.getElementById('tf-user')?.value)||0;const fc=parseInt(document.getElementById('tf-client')?.value)||0;
  const useStages=document.getElementById('tf-stages')?.checked&&fc>0;
  let tasks=DB.tasks;if(fu)tasks=tasks.filter(t=>t.assignedTo===fu||t.assignedBy===fu);if(fc)tasks=tasks.filter(t=>t.clientId===fc);
  const topLevel=tasks.filter(t=>!t.parentTaskId);
  const el=document.getElementById('task-board');if(!el)return;
  const stages=useStages?getClientStatuses(fc):null;
  const cols=stages?
    stages.map(s=>({id:s.id,label:s.name,color:s.color,filter:t=>t.customStatus===s.id||(s.core===t.status&&!t.customStatus)})):
    [{id:'pending',label:'Pending',color:'#94a3b8',filter:t=>t.status==='pending'},{id:'ip',label:'In Progress',color:'#3b82f6',filter:t=>t.status==='in_progress'},{id:'rev',label:'⏳ Under Review',color:'#8b5cf6',filter:t=>t.status==='done_pending_review'},{id:'done',label:'✓ Done',color:'#10b981',filter:t=>t.status==='done'}];
  el.innerHTML=`<div class="kb">${cols.map(col=>{const cts=topLevel.filter(col.filter);return`<div class="kcol" style="border-top:3px solid ${col.color||'var(--amber)'}"><div class="kcol-hd" style="color:${col.color||'var(--t2)'}"><span>${col.label}</span><span class="pcnt">${cts.length}</span></div>
${cts.map(t=>{const c=DB.clients.find(x=>x.id===t.clientId);const u=DB.users.find(x=>x.id===t.assignedTo);const subs=getSubTasks(t.id);const od=isOverdue(t);const lp=t.progress?.slice(-1)[0];return`<div class="tcard ${t.priority==='high'?'p-high':''} ${od?'overdue-t':''}">
<div class="fw7 fs12 mb3">${t.title}${t.recurrence?.enabled?'<span class="rec-badge">↻ Rec</span>':''}</div>
<div class="flex gap4 mb5" style="flex-wrap:wrap">${taskStatusBadge(t)}${od?bh('OVERDUE','var(--rd)','var(--rb)'):''}</div>
<div class="flex ic gap5 mb3">${avH(u?.name,u?.color,20,8)}<span class="fs11">${u?.name||'?'}</span></div>
<div class="fs11 mb3" style="color:var(--t2)">📋 ${c?.name||'?'} · <span style="color:${od?'var(--red)':'inherit'}">${fmtD(t.deadline)}</span></div>
${lp?`<div style="background:var(--bg);border-radius:4px;padding:4px 6px;font-size:10px;margin-bottom:5px;color:var(--t2)"><i class="fa fa-edit ta"></i> ${lp.note} ${lp.done?`· ${lp.done}/${lp.total}`:''}</div>`:''}
${subs.length?`<div style="border-top:1px solid var(--border);padding-top:5px;margin-top:3px">${subs.map(s=>{const su=DB.users.find(x=>x.id===s.assignedTo);const sp=s.progress?.slice(-1)[0];return`<div class="flex ic gap4 mb2 fs11"><i class="fa fa-${s.status==='done'?'check-circle tg':s.status==='done_pending_review'?'clock tp':'circle'}" style="font-size:9px"></i><span style="color:var(--t2)">${su?.name?.split(' ')[0]||'?'}</span><span style="color:var(--t3);flex:1;overflow:hidden;text-overflow:ellipsis;white-space:nowrap">${s.title.slice(0,20)}</span>${sp?`<span class="tg mono" style="font-size:9px">${sp.done}/${sp.total}</span>`:''}</div>`;}).join('')}</div>`:''}
<div class="flex gap3 mt7" style="flex-wrap:wrap">
${t.status==='done_pending_review'&&(isOwner()||t.assignedBy===DB.currentUser.id)?`<button class="btn btn-xs btn-grn" onclick="approveTask(${t.id})"><i class="fa fa-check"></i></button><button class="btn btn-xs btn-red" onclick="requestRevision(${t.id})"><i class="fa fa-undo"></i></button>`:''}
<button class="btn btn-xs btn-o" onclick="openTaskDetail(${t.id})"><i class="fa fa-eye"></i></button>
${(isOwner()||t.assignedBy===DB.currentUser.id)?`<button class="btn btn-xs btn-pur" onclick="openBreakdownTask(${t.id})"><i class="fa fa-code-branch"></i></button><button class="btn btn-xs btn-o" onclick="openAssignSub(${t.id})">+Sub</button>`:t.assignedTo===DB.currentUser.id?`<button class="btn btn-xs btn-o" onclick="openAssignSub(${t.id})">+Sub</button>`:''}
</div></div>`;}).join('')||`<div class="fs11" style="color:var(--t4);text-align:center;padding:10px 0">Empty</div>`}</div>`;}).join('')}</div>`;
}
function pgMyTasks(){const me=DB.currentUser;const mt=DB.tasks.filter(t=>t.assignedTo===me.id);const od=mt.filter(isOverdue);const rev=mt.filter(t=>t.approvalStatus==='revision');const pr=mt.filter(t=>t.status==='done_pending_review');
return`${od.length?`<div class="abox a-red mb10"><i class="fa fa-exclamation-triangle"></i><div class="fw7">${od.length} overdue — update now</div></div>`:''}${rev.length?`<div class="abox a-amb mb10"><i class="fa fa-undo"></i><div class="fw7">${rev.length} revision${rev.length>1?'s':''} needed</div></div>`:''}${pr.length?`<div class="abox a-blu mb10"><i class="fa fa-clock pulse"></i><div class="fw6">${pr.length} awaiting approval</div></div>`:''}
<div class="ph"><div class="ph-t">My Tasks</div></div>
<div class="kb">${[{id:'pending',label:'Pending'},{id:'in_progress',label:'In Progress'},{id:'done_pending_review',label:'Review'},{id:'done',label:'Done'}].map(col=>{const cts=mt.filter(t=>t.status===col.id);return`<div class="kcol"><div class="kcol-hd"><span>${col.label}</span><span class="pcnt">${cts.length}</span></div>
${cts.map(t=>{const c=DB.clients.find(x=>x.id===t.clientId);const od2=isOverdue(t);const lp=t.progress?.slice(-1)[0];return`<div class="tcard ${t.priority==='high'?'p-high':''} ${od2?'overdue-t':''}">
<div class="fw7 fs12 mb3">${t.title}</div>${taskStatusBadge(t)}<br>
<div class="fs11 mt3 mb3" style="color:var(--t2)">${c?.name||'?'} · <span style="color:${od2?'var(--red)':'var(--t3)'}">${fmtD(t.deadline)}</span></div>
${t.parentTaskId?`<div class="fs11 mb3" style="color:var(--purple)"><i class="fa fa-level-up-alt fa-rotate-90"></i> Sub from ${uname(t.assignedBy)}</div>`:''}
${lp?`<div style="background:var(--bg);border-radius:4px;padding:4px 6px;font-size:10px;margin-bottom:5px"><i class="fa fa-edit ta"></i> ${lp.note} ${lp.done?`· ${lp.done}/${lp.total}`:''}</div>`:''}
${t.approvalStatus==='revision'&&t.approvalComments?.length?`<div style="background:var(--al);border-radius:4px;padding:5px;font-size:10px;margin-bottom:5px;color:var(--ad)">↩ "${t.approvalComments.slice(-1)[0]?.text}"</div>`:''}
<div class="flex gap3 mt7" style="flex-wrap:wrap">
${t.status==='pending'?`<button class="btn btn-xs btn-blu" onclick="updateTS(${t.id},'in_progress')"><i class="fa fa-play"></i> Start</button>`:''}
${t.status==='in_progress'?`<button class="btn btn-xs btn-grn" onclick="submitForReview(${t.id})"><i class="fa fa-paper-plane"></i> Submit</button><button class="btn btn-xs btn-o" onclick="addProgress(${t.id})"><i class="fa fa-edit"></i></button>`:''}
${t.status==='done_pending_review'?`<div class="fs10 tp pulse"><i class="fa fa-clock"></i> Waiting…</div>`:''}
</div></div>`;}).join('')||`<div class="fs11" style="color:var(--t4);text-align:center;padding:9px">None ✓</div>`}</div>`;}).join('')}</div>`;}
async function submitForReview(id){
  try {
    await API.patch('/tasks/'+id+'/status', {status: 'done_pending_review'});
    await loadFromAPI(['tasks', 'notifications']);
    go('my_tasks');
  } catch(e) {
    alert(e.message || 'Failed to submit task for review');
  }
}
async function approveTask(id){
  try {
    await API.post('/tasks/'+id+'/approve', {approved: true, status: 'approved'});
    await loadFromAPI(['tasks', 'notifications']);
    if(DB.currentPage==='tasks') renderTasks(); else go('my_tasks');
  } catch(e) {
    alert(e.message || 'Failed to approve task');
  }
}
async function requestRevision(id){
  const comment=prompt('Revision needed?');if(!comment)return;
  try {
    await API.post('/tasks/'+id+'/approve', {approved: false, status: 'revision', comment: comment});
    await loadFromAPI(['tasks', 'notifications']);
    if(DB.currentPage==='tasks') renderTasks(); else go('my_tasks');
  } catch(e) {
    alert(e.message || 'Failed to request revision');
  }
}
async function updateTS(id,status){
  try {
    await API.patch('/tasks/'+id+'/status', {status: status});
    await loadFromAPI(['tasks']);
    if(DB.currentPage==='tasks') renderTasks(); else go('my_tasks');
  } catch(e) {
    alert(e.message || 'Failed to update task status');
  }
}
function nextRecDate(d,rec){
  if(!d)return null;
  const dt=new Date(d);const n=rec.interval||1;
  if(rec.type==='daily')dt.setDate(dt.getDate()+n);
  else if(rec.type==='weekly')dt.setDate(dt.getDate()+7*n);
  else if(rec.type==='monthly')dt.setMonth(dt.getMonth()+n);
  return dt.toISOString().split('T')[0];
}
function addProgress(id){const t=DB.tasks.find(x=>x.id===id);
showMo(`<div class="mt2">Log Progress <button class="mc2" onclick="closeMo()"><i class="fa fa-times"></i></button></div>
<div style="background:var(--bg);border-radius:var(--r);padding:9px;font-size:12px;margin-bottom:10px"><strong>${t?.title}</strong></div>
<div class="fg"><label class="flbl">Progress Note *</label><textarea class="fta" id="pr-note" style="min-height:50px" placeholder="e.g. 7 posts done, 3 remaining…"></textarea></div>
<div class="fr2"><div class="fg"><label class="flbl">Units Done</label><input class="finp" type="number" id="pr-done" placeholder="e.g. 7"></div><div class="fg"><label class="flbl">Total Units</label><input class="finp" type="number" id="pr-total" placeholder="e.g. 10"></div></div>
<div class="mact"><button class="btn btn-o" onclick="closeMo()">Cancel</button><button class="btn btn-p" onclick="saveProgress(${id})">Save</button></div>`);}
async function saveProgress(id){const note=document.getElementById('pr-note')?.value?.trim();if(!note)return;const done=parseInt(document.getElementById('pr-done')?.value)||null;const total=parseInt(document.getElementById('pr-total')?.value)||null;try{await API.post('/tasks/'+id+'/progress',{note,done,total});await loadFromAPI(['tasks']);closeMo();go('my_tasks');}catch(e){alert(e.message||'Failed to save task progress');}}
function openTaskDetail(id){const t=DB.tasks.find(x=>x.id===id);if(!t)return;const c=DB.clients.find(x=>x.id===t.clientId);const u=DB.users.find(x=>x.id===t.assignedTo);const assignerU=DB.users.find(x=>x.id===t.assignedBy);const subs=getSubTasks(id);
showMo(`<div class="mt2">${t.title} <button class="mc2" onclick="closeMo()"><i class="fa fa-times"></i></button></div>
<div class="g2 mb10"><div><div class="fs10 mb2" style="color:var(--t3)">Client</div><div class="fw6">${c?.name||'?'}</div></div><div><div class="fs10 mb2" style="color:var(--t3)">Assigned By → To</div><div class="fw6">${assignerU?.name||'?'} → ${u?.name||'?'}</div></div><div><div class="fs10 mb2" style="color:var(--t3)">Priority</div>${bh(t.priority,'var(--rd)','var(--rb)')}</div><div><div class="fs10 mb2" style="color:var(--t3)">Deadline</div><div class="fw6 ${isOverdue(t)?'tr':''}">${fmtD(t.deadline)}</div></div><div><div class="fs10 mb2" style="color:var(--t3)">Status</div>${taskStatusBadge(t)}</div></div>
${t.notes?`<div style="background:var(--bg);border-radius:var(--r);padding:9px;font-size:12px;margin-bottom:10px">${t.notes}</div>`:''}
${t.progress?.length?`<div class="sect-t mb7">Progress Log</div>${t.progress.map(p=>`<div style="border-left:2px solid var(--amber);padding-left:8px;margin-bottom:7px"><div class="fw6 fs12">${p.note}${p.done?` — ${p.done}/${p.total} units`:''}</div><div class="fs11" style="color:var(--t3)">${uname(p.by)} · ${fmtD(p.date)}</div></div>`).join('')}`:''}
${t.approvalComments?.length?`<div class="sect-t mb7">Revision Notes</div>${t.approvalComments.map(ac=>`<div style="background:var(--al);border-radius:var(--r);padding:8px;font-size:12px;margin-bottom:5px"><i class="fa fa-comment ta"></i> "${ac.text}" — ${uname(ac.by)} · ${fmtD(ac.date)}</div>`).join('')}`:''}
${subs.length?`<div class="sect-t mb7">Sub-Tasks (${subs.filter(s=>s.status==='done').length}/${subs.length})</div>${subs.map(s=>{const su=DB.users.find(x=>x.id===s.assignedTo);const sp=s.progress?.slice(-1)[0];return`<div class="pb-wrap" style="margin-bottom:7px"><div class="flex ic gap7 mb5">${avH(su?.name,su?.color,22,8)}<div class="f1"><div class="fw6 fs12">${s.title}</div><div class="fs11" style="color:var(--t3)">→ ${su?.name||'?'} · ${fmtD(s.deadline)}</div></div>${taskStatusBadge(s)}</div>${sp?`<div class="fs11" style="color:var(--t2)"><i class="fa fa-edit ta"></i> ${sp.note} ${sp.done?`· ${sp.done}/${sp.total}`:''} · ${fmtD(sp.date)}</div>`:''}</div>`;}).join('')}`:''}
<div class="mact"><button class="btn btn-o" onclick="closeMo()">Close</button>${isOwner()?`<button class="btn btn-o" onclick="closeMo();openAddTask(DB.tasks.find(x=>x.id===${id}))"><i class="fa fa-edit"></i> Edit</button>`:''}</div>`,true);}
function openAssignSub(parentId){const parent=DB.tasks.find(x=>x.id===parentId);if(!parent)return;const creative=DB.users.filter(u=>!['owner','sales'].includes(u.role));
showMo(`<div class="mt2">Assign Sub-Task <button class="mc2" onclick="closeMo()"><i class="fa fa-times"></i></button></div>
<div class="abox a-pur mb10"><i class="fa fa-info-circle"></i>Sub-task of: <strong>${parent.title.slice(0,35)}</strong></div>
<div class="fg"><label class="flbl">Title *</label><input class="finp" id="stt"></div>
<div class="fr2"><div class="fg"><label class="flbl">Assign To</label><select class="fsel" id="sto">${creative.map(u=>`<option value="${u.id}">${u.name}</option>`).join('')}</select></div><div class="fg"><label class="flbl">Deadline</label><input class="finp" type="date" id="stdl" value="${parent.deadline}"></div></div>
<div class="fg"><label class="flbl">Notes</label><input class="finp" id="stnt"></div>
<div class="mact"><button class="btn btn-o" onclick="closeMo()">Cancel</button><button class="btn btn-p" onclick="saveSubTask(${parentId})">Assign</button></div>`);}
async function saveSubTask(parentId){const title=document.getElementById('stt').value.trim();if(!title)return;const parent=DB.tasks.find(x=>x.id===parentId);const d={title,clientId:parent.clientId,assignedTo:parseInt(document.getElementById('sto').value),priority:'medium',deadline:document.getElementById('stdl').value,notes:document.getElementById('stnt').value,serviceId:parent.serviceId,parentTaskId:parentId,recurringEnabled:false};try{await saveEntity('tasks',null,d);await loadFromAPI(['tasks']);closeMo();if(DB.currentPage==='tasks')renderTasks();}catch(e){alert(e.message||'Sub-task assignment failed');}}
function openAddTask(pre={}){
  const creative=DB.users.filter(u=>!['owner','sales'].includes(u.role));
  const rec=pre.recurrence||{};
  const cid=pre.clientId||DB.clients[0]?.id||0;
  const statuses=getClientStatuses(cid);
  const statusPills=statuses.map(s=>{const sel=pre.customStatus===s.id;const bdr=sel?s.color:'transparent';return '<button type="button" class="cs-pill" id="csp-'+s.id+'" data-sid="'+s.id+'" data-sc="'+s.color+'" style="background:'+s.color+'22;color:'+s.color+';border-color:'+bdr+'" onclick="selCS(this.dataset.sid,this.dataset.sc)">'+s.name+'</button>';}).join('');
  showMo('<div class="mt2">'+(pre.id?'Edit':'Assign')+' Task <button class="mc2" onclick="closeMo()"><i class="fa fa-times"></i></button></div>'
   +'<div class="fg"><label class="flbl">Title *</label><input class="finp" id="tt2" value="'+(pre.title||'')+'"></div>'
   +'<div class="fr2"><div class="fg"><label class="flbl">Client</label><select class="fsel" id="tcl" onchange="reloadStatusPills()">'+DB.clients.map(c=>'<option value="'+c.id+'" '+(pre.clientId===c.id?'selected':'')+'>'+c.name+'</option>').join('')+'</select></div><div class="fg"><label class="flbl">Assign To</label><select class="fsel" id="tto">'+creative.map(u=>'<option value="'+u.id+'" '+(pre.assignedTo===u.id?'selected':'')+'>'+u.name+'</option>').join('')+'</select></div></div>'
   +'<div class="fr3"><div class="fg"><label class="flbl">Priority</label><select class="fsel" id="tpr"><option value="high" '+(pre.priority==='high'?'selected':'')+'>High</option><option value="medium" '+((!pre.priority||pre.priority==='medium')?'selected':'')+'>Medium</option><option value="low" '+(pre.priority==='low'?'selected':'')+'>Low</option></select></div><div class="fg"><label class="flbl">Deadline</label><input class="finp" type="date" id="tdl" value="'+(pre.deadline||'')+'"></div><div class="fg"><label class="flbl">Est. Hours</label><input class="finp" type="number" id="test" value="'+(pre.estimatedHours||'')+'" placeholder="e.g. 3" step="0.5" min="0"></div></div>'
   +'<div class="fr2"><div class="fg"><label class="flbl">Schedule Day (planner)</label><input class="finp" type="date" id="tsd" value="'+(pre.scheduledDate||'')+'" title="Pin this task to a day in the Day Planner"></div><div class="fg"><label class="flbl">Service</label><select class="fsel" id="tsc">'+DB.services.map(s=>'<option value="'+s.id+'" '+(pre.serviceId===s.id?'selected':'')+'>'+s.name+'</option>').join('')+'</select></div></div>'
   +'<div class="fg"><label class="flbl">Workflow Stage</label><div id="status-pills" style="display:flex;gap:5px;flex-wrap:wrap;padding:6px;background:var(--bg);border-radius:var(--r);border:1px solid var(--border)">'+statusPills+'</div></div>'
   +'<input type="hidden" id="tcs" value="'+(pre.customStatus||'')+'"><div class="fg"><label class="flbl">Notes</label><textarea class="fta" id="tnts">'+(pre.notes||'')+'</textarea></div>'
   +'<div style="background:var(--bg);border-radius:var(--r);padding:10px;border:1px solid var(--border);margin-bottom:10px"><div class="flex ic gap8 mb8"><input type="checkbox" id="trec" '+(rec.enabled?'checked':'')+' style="accent-color:var(--amber)" onchange="var s=this.nextElementSibling.nextElementSibling;if(s)s.style.display=this.checked?\x27block\x27:\x27none\x27"><label class="flbl" style="margin:0;cursor:pointer" for="trec">Recurring Task</label></div>'
   +'<div id="rec-ui" style="display:'+(rec.enabled?'block':'none')+'"><div class="fr3"><div class="fg"><label class="flbl">Every</label><input class="finp" type="number" id="rec-int" value="'+(rec.interval||1)+'" min="1"></div><div class="fg"><label class="flbl">Period</label><select class="fsel" id="rec-type"><option value="daily" '+(rec.type==='daily'?'selected':'')+'>Days</option><option value="weekly" '+(!rec.type||rec.type==='weekly'?'selected':'')+'>Weeks</option><option value="monthly" '+(rec.type==='monthly'?'selected':'')+'>Months</option></select></div><div class="fg"><label class="flbl">End Date</label><input class="finp" type="date" id="rec-end" value="'+(rec.endDate||'')+'"></div></div></div></div>'
   +'<div class="mact"><button class="btn btn-o" onclick="closeMo()">Cancel</button><button class="btn btn-p" onclick="saveTask('+(pre.id||0)+')">Save</button></div>',true);}
function selCS(id,color){window._selCS=id;document.getElementById('tcs').value=id;document.querySelectorAll('.cs-pill').forEach(b=>b.style.borderColor='transparent');const b=document.getElementById('csp-'+id);if(b)b.style.borderColor=color;}
function reloadStatusPills(){const cid=parseInt(document.getElementById('tcl')?.value)||0;const s=getClientStatuses(cid);const wrap=document.getElementById('status-pills');if(wrap)wrap.innerHTML=s.map(st=>'<button type="button" class="cs-pill" data-sid="'+st.id+'" data-sc="'+st.color+'" style="background:'+st.color+'22;color:'+st.color+';border-color:transparent" onclick="selCS(this.dataset.sid,this.dataset.sc)">'+st.name+'</button>').join('');}

async function saveTask(id){
  const title=document.getElementById('tt2')?.value?.trim();if(!title)return;
  const recOn=document.getElementById('trec')?.checked||false;
  const recurrence=recOn?{enabled:true,type:document.getElementById('rec-type')?.value||'weekly',interval:parseInt(document.getElementById('rec-int')?.value)||1,endDate:document.getElementById('rec-end')?.value||null}:{enabled:false};
  const customStatus=document.getElementById('tcs')?.value||window._selCS||'';
  window._selCS='';
  const d={title,clientId:parseInt(document.getElementById('tcl').value),assignedTo:parseInt(document.getElementById('tto').value),priority:document.getElementById('tpr').value,deadline:document.getElementById('tdl').value,scheduledDate:document.getElementById('tsd')?.value||null,estimatedHours:parseFloat(document.getElementById('test')?.value)||null,customStatusId:customStatus?parseInt(customStatus):null,notes:document.getElementById('tnts').value,serviceId:parseInt(document.getElementById('tsc').value)||null,status:id?(DB.tasks.find(x=>x.id===id)?.status||'pending'):'pending',recurringEnabled:recurrence.enabled,recurringType:recurrence.type,recurringInterval:recurrence.interval,recurringEndDate:recurrence.endDate};
  try{await saveEntity('tasks',id,d);await loadFromAPI(['tasks']);closeMo();if(DB.currentPage==='tasks')renderTasks();else go('tasks');}catch(e){alert(e.message||'Task save failed');}
}

// ══════ CONTENT CALENDAR — Per Client ══════
function pgCal(){const myClients=myVisibleClients();if(myClients.length===0)return`<div class="empty"><i class="fa fa-calendar-alt"></i>No clients assigned</div>`;
return`<div class="ph"><div class="ph-t">Content Calendar</div><button class="btn btn-p" onclick="openAddPost()"><i class="fa fa-plus"></i> Schedule Post</button></div>
<div class="flex gap6 mb12" style="flex-wrap:wrap">${myClients.map(c=>`<button class="cal-client-btn" id="cal-btn-${c.id}" onclick="switchCalClient(${c.id})" style="display:flex;align-items:center;gap:6px;padding:5px 11px;border-radius:20px;font-size:12px;font-weight:600;cursor:pointer;border:1px solid var(--border);background:var(--card);color:var(--t2);transition:all .12s">${avH(c.name,cclr(c.id),20,8)} ${c.name}</button>`).join('')}</div>
<div id="cal-wrap"></div>`;}
function switchCalClient(clientId){
  document.querySelectorAll('.cal-client-btn').forEach(b=>{b.style.background='var(--card)';b.style.color='var(--t2)';b.style.borderColor='var(--border)';});
  const btn=document.getElementById('cal-btn-'+clientId);if(btn){btn.style.background='var(--amber)';btn.style.color='#fff';btn.style.borderColor='var(--amber)';}
  renderCal(clientId);
}
function renderCal(clientId){
  const myClients=myVisibleClients();if(!clientId&&myClients.length)clientId=myClients[0].id;if(!clientId)return;
  // Auto-select btn
  document.querySelectorAll('.cal-client-btn').forEach(b=>{b.style.background='var(--card)';b.style.color='var(--t2)';b.style.borderColor='var(--border)';});const btn=document.getElementById('cal-btn-'+clientId);if(btn){btn.style.background='var(--amber)';btn.style.color='#fff';btn.style.borderColor='var(--amber)';}
  const c=DB.clients.find(x=>x.id===clientId);let posts=DB.contentPosts.filter(p=>p.clientId===clientId);
  const el=document.getElementById('cal-wrap');if(!el)return;
  const TYPE_COLORS={design:{bg:'#dbeafe',c:'#1e40af'},motion:{bg:'#ede9fe',c:'#5b21b6'},story:{bg:'#d1fae5',c:'#065f46'},video:{bg:'#ffedd5',c:'#9a3412'},other:{bg:'#fef3c7',c:'#92400e'}};
  const STATUS_ICONS={scheduled:'📅',in_progress:'🔄',pending:'⏳',done:'✅'};
  const days=['Mon','Tue','Wed','Thu','Fri','Sat','Sun'];
  const cells=[];for(let i=0;i<6;i++)cells.push(null);for(let d=1;d<=30;d++){const date=`2025-06-${String(d).padStart(2,'0')}`;const dp=posts.filter(p=>p.date===date);cells.push({day:d,date,posts:dp});}
  el.innerHTML=`<div class="card mb12">
<div class="flex ic sbj mb12">${c?`<div class="flex ic gap8">${avH(c.name,cclr(c.id),26,9)}<div><div class="fw7 fs13">${c.name} — June 2025</div><div class="fs11" style="color:var(--t3)">${posts.length} posts</div></div></div>`:''}
<div class="flex gap5">${['design','motion','video','other'].map(t=>{const cnt=posts.filter(p=>p.type===t).length;const tc=TYPE_COLORS[t]||TYPE_COLORS.other;return cnt?`<span class="badge" style="background:${tc.bg};color:${tc.c}">${t}: ${cnt}</span>`:''}).join('')}</div>
</div>
<div class="cal-grid mb12">
${days.map(d=>`<div class="cal-hd2">${d}</div>`).join('')}
${cells.map(cell=>{if(!cell)return`<div style="min-height:74px;background:var(--bg);border:1px solid var(--border);border-radius:var(--r);opacity:.3"></div>`;return`<div class="cal-day" onclick="openAddPost(${clientId},'${cell.date}')"><div class="cal-dn">${cell.day}</div>${cell.posts.map(p=>{const tc=TYPE_COLORS[p.type]||TYPE_COLORS.other;return`<div class="cal-chip" style="background:${tc.bg};color:${tc.c}" onclick="event.stopPropagation();viewPost(${p.id})" title="${p.title}">${STATUS_ICONS[p.status]||''} ${p.title.slice(0,11)}</div>`;}).join('')}</div>`;}).join('')}
</div>
</div>
<div class="tw"><table><thead><tr><th>Post</th><th>Platform</th><th>Type</th><th>Date</th><th>Assigned</th><th>Status</th><th></th></tr></thead><tbody>
${posts.map(p=>{const u=DB.users.find(x=>x.id===p.assignedTo);const tc=TYPE_COLORS[p.type]||TYPE_COLORS.other;return`<tr><td class="fw6 fs12">${p.title}</td><td class="fs11">${p.platform}</td><td>${bh(p.type,tc.c,tc.bg)}</td><td class="fs11">${fmtD(p.date)}</td><td><div class="flex ic gap4">${avH(u?.name,u?.color,20,8)}<span class="fs11">${u?.name||'?'}</span></div></td><td><select class="fsel" style="padding:3px 5px;font-size:10px" onchange="updatePostStatus(${p.id},this.value)"><option ${p.status==='pending'?'selected':''}>pending</option><option ${p.status==='in_progress'?'selected':''}>in_progress</option><option ${p.status==='scheduled'?'selected':''}>scheduled</option><option ${p.status==='done'?'selected':''}>done</option></select></td><td><div class="flex gap3"><button class="btn btn-xs btn-o" onclick="viewPost(${p.id})"><i class="fa fa-eye"></i></button><button class="btn btn-xs btn-red" onclick="if(confirm('Delete?')){DB.contentPosts=DB.contentPosts.filter(p=>p.id!==${p.id});save();renderCal(${clientId})}"><i class="fa fa-trash"></i></button></div></td></tr>`;}).join('')||'<tr><td colspan="7" style="text-align:center;color:var(--t3);padding:14px">No posts. Click a date on the calendar to add one.</td></tr>'}
</tbody></table></div>`;
}
function openAddPost(clientId=null,date=''){const myClients=myVisibleClients();const creative=DB.users.filter(u=>!['owner','sales'].includes(u.role));
showMo(`<div class="mt2">Schedule Post <button class="mc2" onclick="closeMo()"><i class="fa fa-times"></i></button></div>
<div class="fg"><label class="flbl">Title *</label><input class="finp" id="pt"></div>
<div class="fr2"><div class="fg"><label class="flbl">Client</label><select class="fsel" id="pc2">${myClients.map(c=>`<option value="${c.id}" ${c.id===clientId?'selected':''}>${c.name}</option>`).join('')}</select></div><div class="fg"><label class="flbl">Platform</label><select class="fsel" id="ppl"><option>instagram</option><option>facebook</option><option>tiktok</option><option>linkedin</option><option>youtube</option></select></div></div>
<div class="fr2"><div class="fg"><label class="flbl">Type</label><select class="fsel" id="pty"><option value="design">Design/Graphic</option><option value="motion">Motion/Reel</option><option value="story">Story</option><option value="video">Video</option><option value="other">Other</option></select></div><div class="fg"><label class="flbl">Publish Date</label><input class="finp" type="date" id="pd2" value="${date}"></div></div>
<div class="fr2"><div class="fg"><label class="flbl">Assign To</label><select class="fsel" id="pato">${creative.map(u=>`<option value="${u.id}">${u.name}</option>`).join('')}</select></div><div class="fg"><label class="flbl">Notes</label><input class="finp" id="pn" placeholder="Style notes, caption idea…"></div></div>
<div class="fg"><label class="flbl">📋 Designer Brief / Instructions</label><textarea class="fta" id="pbrief" style="min-height:56px" placeholder="Color palette, references, caption notes, do's and don'ts…"></textarea></div><div class="mact"><button class="btn btn-o" onclick="closeMo()">Cancel</button><button class="btn btn-p" onclick="savePost(${clientId})">Schedule</button></div>`);}
function savePost(defaultClientId){const title=document.getElementById('pt')?.value?.trim();if(!title)return;const cid=parseInt(document.getElementById('pc2')?.value)||defaultClientId;DB.contentPosts.push({id:uid(),title,clientId:cid,platform:document.getElementById('ppl').value,type:document.getElementById('pty').value,date:document.getElementById('pd2').value,status:'pending',assignedTo:parseInt(document.getElementById('pato').value),notes:document.getElementById('pn').value,brief:document.getElementById('pbrief')?.value||''});save();closeMo();renderCal(cid);}
function updatePostStatus(id,st){const p=DB.contentPosts.find(x=>x.id===id);if(p){p.status=st;save();}}
function viewPost(id){const p=DB.contentPosts.find(x=>x.id===id);if(!p)return;const c=DB.clients.find(x=>x.id===p.clientId);const u=DB.users.find(x=>x.id===p.assignedTo);const TYPE_COLORS={design:{bg:'#dbeafe',c:'#1e40af'},motion:{bg:'#ede9fe',c:'#5b21b6'},story:{bg:'#d1fae5',c:'#065f46'},video:{bg:'#ffedd5',c:'#9a3412'},other:{bg:'#fef3c7',c:'#92400e'}};const tc=TYPE_COLORS[p.type]||TYPE_COLORS.other;
showMo(`<div class="mt2">${p.title} <button class="mc2" onclick="closeMo()"><i class="fa fa-times"></i></button></div>
<div class="g2 mb10"><div><div class="fs10 mb2" style="color:var(--t3)">Client</div><div class="fw6">${c?.name||'?'}</div></div><div><div class="fs10 mb2" style="color:var(--t3)">Platform</div><div>${p.platform}</div></div><div><div class="fs10 mb2" style="color:var(--t3)">Type</div>${bh(p.type,tc.c,tc.bg)}</div><div><div class="fs10 mb2" style="color:var(--t3)">Date</div><div class="fw7">${fmtD(p.date)}</div></div><div><div class="fs10 mb2" style="color:var(--t3)">Assigned</div><div class="flex ic gap5">${avH(u?.name,u?.color,20,8)}<span>${u?.name||'?'}</span></div></div><div><div class="fs10 mb2" style="color:var(--t3)">Status</div>${bh(p.status,'var(--t2)','var(--bg)')}</div></div>
${p.notes?`<div style="background:var(--bg);border-radius:var(--r);padding:9px;font-size:12px;margin-bottom:6px"><i class="fa fa-sticky-note ta"></i> ${p.notes}</div>`:''}${p.brief?`<div style="background:var(--pb);border-radius:var(--r);padding:9px;font-size:12px;margin-bottom:10px"><i class="fa fa-clipboard-list" style="color:var(--purple)"></i> <strong>Brief:</strong> ${p.brief}</div>`:''}
<div class="mact"><button class="btn btn-o" onclick="closeMo()">Close</button><button class="btn btn-pur" onclick="closeMo();go('agent');setTimeout(function(){agentSend('AI caption for this post');},400)"><i class="fa fa-robot"></i> AI Caption</button></div>`);}

// ══════ WORK REPORTS ══════
function pgWorklogs(){const myOnly=!isOwner()&&!isSMM();const logs=myOnly?DB.worklogs.filter(w=>w.userId===DB.currentUser.id):DB.worklogs;const approved=logs.filter(w=>w.status==='approved').length;
return`<div class="ph"><div class="ph-t">Work Reports</div><button class="btn btn-p" onclick="openAddLog()"><i class="fa fa-plus"></i> Log Work</button></div>
<div class="g4 mb12">
<div class="mc"><div class="mc-lbl">Total Deliveries</div><div class="mc-val">${logs.length}</div></div>
<div class="mc"><div class="mc-lbl">Approved</div><div class="mc-val tg">${approved}</div></div>
<div class="mc"><div class="mc-lbl">Under Review</div><div class="mc-val tp">${logs.length-approved}</div></div>
<div class="mc"><div class="mc-lbl">Approval Rate</div><div class="mc-val">${logs.length?Math.round(approved/logs.length*100):0}%</div></div>
</div>
${isOwner()||isSMM()?`<div class="card mb12"><div class="sect-t mb10">Team Performance</div>
<div class="tw"><table><thead><tr><th>Member</th><th>Deliveries</th><th>Approved</th><th>Avg Quality</th><th>Rate</th></tr></thead><tbody>
${DB.users.filter(u=>!['owner','sales'].includes(u.role)).map(u=>{const ul=logs.filter(w=>w.userId===u.id);if(!ul.length)return'';const appr=ul.filter(w=>w.status==='approved').length;const qScores=ul.filter(w=>w.quality).map(w=>w.quality);const avgQ=qScores.length?Math.round(qScores.reduce((a,b)=>a+b,0)/qScores.length*10)/10:null;const rate=ul.length?Math.round(appr/ul.length*100):0;return`<tr><td><div class="flex ic gap7">${avH(u.name,u.color,26,9)}<div><div class="fw6 fs12">${u.name}</div><div class="fs11" style="color:var(--t3)">${DB.roles.find(r=>r.id===u.role)?.label||u.role}</div></div></div></td><td class="mono fw7">${ul.length}</td><td class="mono tg">${appr}</td><td>${avgQ?'★'.repeat(Math.round(avgQ))+` (${avgQ})` :'—'}</td><td><div class="flex ic gap6"><div class="pb2 f1" style="height:5px;max-width:70px"><div class="pf" style="width:${rate}%;height:5px;background:${rate>=80?'var(--green)':rate>=60?'var(--amber)':'var(--red)'}"></div></div><span class="fw7 fs11" style="color:${rate>=80?'var(--green)':rate>=60?'var(--amber)':'var(--red)'}">${rate}%</span></div></td></tr>`;}).join('')||'<tr><td colspan="5" style="text-align:center;color:var(--t3)">No data</td></tr>'}
</tbody></table></div></div>`:''}
<div class="tw"><table><thead><tr><th>Member</th><th>Client</th><th>Service</th><th>Delivered</th><th>Date</th><th>Quality</th><th>Status</th><th>Note</th>${isOwner()||isSMM()?'<th>Action</th>':''}</tr></thead><tbody>
${logs.sort((a,b)=>(b.deliveredDate||'').localeCompare(a.deliveredDate||'')).map(w=>{const u=DB.users.find(x=>x.id===w.userId);const c=DB.clients.find(x=>x.id===w.clientId);const s=DB.services.find(x=>x.id===w.serviceId);const sm={review:['Review','var(--ad)','var(--al)'],pending_smm_review:['SMM Review','var(--pd)','var(--pb)'],approved:['✅ Approved','var(--gd)','var(--gb)'],revision:['Revision','var(--rd)','var(--rb)'],rejected:['Rejected','var(--rd)','var(--rb)']};const[sl,sc,sb]=sm[w.status]||['?','var(--t3)','var(--bg)'];return`<tr>
<td><div class="flex ic gap6">${avH(u?.name,u?.color,22,8)}<span class="fw6 fs11">${u?.name||'?'}</span></div></td>
<td class="fs11">${c?.name||'—'}</td><td class="fs11">${s?.name||'—'}</td>
<td><span class="fw7">${w.qtyDelivered}</span>${w.qtyTotal?`/${w.qtyTotal}`:''} <span class="fs10" style="color:var(--t3)">${w.unit||''}</span></td>
<td class="fs11">${fmtD(w.deliveredDate)}</td><td>${w.quality?'★'.repeat(w.quality):'—'}</td><td>${bh(sl,sc,sb)}</td>
<td class="fs11" style="color:var(--t2);max-width:100px;white-space:normal">${w.reviewNote||'—'}</td>
${isOwner()||isSMM()?`<td><div class="flex gap3">${w.status!=='approved'?`<button class="btn btn-xs btn-grn" onclick="approveWork(${w.id})"><i class="fa fa-check"></i></button><button class="btn btn-xs btn-o" onclick="openReviewWork(${w.id})"><i class="fa fa-star"></i></button>`:'—'}</div></td>`:''}</tr>`;}).join('')||'<tr><td colspan="9" style="text-align:center;color:var(--t3);padding:16px">No work logs</td></tr>'}
</tbody></table></div>`;}
function openAddLog(){const myTasks=DB.tasks.filter(t=>t.assignedTo===DB.currentUser.id&&['in_progress','pending'].includes(t.status));
showMo(`<div class="mt2">Log Work Delivery <button class="mc2" onclick="closeMo()"><i class="fa fa-times"></i></button></div>
<div class="fg"><label class="flbl">Task</label><select class="fsel" id="wt">${myTasks.length?myTasks.map(t=>`<option value="${t.id}">${t.title.slice(0,45)}</option>`).join(''):'<option>No in-progress tasks</option>'}</select></div>
<div class="fr3"><div class="fg"><label class="flbl">Delivered</label><input class="finp" type="number" id="wq" value="1"></div><div class="fg"><label class="flbl">Total</label><input class="finp" type="number" id="wqt"></div><div class="fg"><label class="flbl">Unit</label><input class="finp" id="wu" placeholder="posts/videos…"></div></div>
<div class="fg"><label class="flbl">Date</label><input class="finp" type="date" id="wd" value="2025-05-23"></div>
<div class="fg"><label class="flbl">Notes</label><textarea class="fta" id="wn" style="min-height:44px" placeholder="What was completed…"></textarea></div>
<div class="mact"><button class="btn btn-o" onclick="closeMo()">Cancel</button><button class="btn btn-p" onclick="saveLog()">Submit for Review</button></div>`);}
async function saveLog(){const tid=parseInt(document.getElementById('wt')?.value);const t=DB.tasks.find(x=>x.id===tid);const qtyDone=parseInt(document.getElementById('wq').value)||1;const qtyTotal=parseInt(document.getElementById('wqt').value)||0;const unit=document.getElementById('wu').value;const notes=document.getElementById('wn').value;const d={clientId:t?t.clientId:null,taskId:tid||null,title:t?.title||'Work delivery',description:[notes,unit?`Unit: ${unit}`:''].filter(Boolean).join('\n'),qtyDone,qtyTotal,date:document.getElementById('wd').value};try{await API.post('/worklogs',d);await loadFromAPI(['worklogs', 'tasks']);closeMo();go('worklogs');}catch(e){alert(e.message||'Work log save failed');}}
async function approveWork(id){try{await API.patch('/worklogs/'+id+'/review',{status:'approved'});await loadFromAPI(['worklogs']);go('worklogs');}catch(e){alert(e.message||'Work review failed');}}
function openReviewWork(id){const w=DB.worklogs.find(x=>x.id===id);
showMo(`<div class="mt2">Review Work <button class="mc2" onclick="closeMo()"><i class="fa fa-times"></i></button></div>
<div class="fg"><label class="flbl">Quality (1-5)</label><div class="star-wrap mb8">${[1,2,3,4,5].map(n=>`<span class="star ${(w.quality||0)>=n?'lit':''}" style="font-size:22px" onclick="document.getElementById('rw-q').value=${n};this.closest('.star-wrap').querySelectorAll('.star').forEach((s,i)=>{s.textContent=i<${n}?'★':'☆';s.classList.toggle('lit',i<${n})})">${(w.quality||0)>=n?'★':'☆'}</span>`).join('')}</div><input type="hidden" id="rw-q" value="${w.quality||''}"></div>
<div class="fg"><label class="flbl">Review Note</label><textarea class="fta" id="rw-n">${w.reviewNote||''}</textarea></div>
<div class="mact"><button class="btn btn-o" onclick="closeMo()">Cancel</button><button class="btn btn-grn" onclick="saveReview(${id})">Approve</button><button class="btn btn-red" onclick="rejectWork(${id})">Reject</button></div>`);}
async function saveReview(id){try{await API.patch('/worklogs/'+id+'/review',{status:'approved',qualityRating:parseInt(document.getElementById('rw-q').value)||null,feedback:document.getElementById('rw-n').value});await loadFromAPI(['worklogs']);closeMo();go('worklogs');}catch(e){alert(e.message||'Work review failed');}}
async function rejectWork(id){if(!confirm('Reject?'))return;try{await API.patch('/worklogs/'+id+'/review',{status:'revision',feedback:document.getElementById('rw-n')?.value||''});await loadFromAPI(['worklogs']);closeMo();go('worklogs');}catch(e){alert(e.message||'Work review failed');}}

// ══════ TEAM & PERMISSIONS ══════
function pgTeam(){return`<div class="ph"><div class="ph-t">Team & Access</div><div class="flex gap7"><button class="btn btn-sm btn-o" onclick="openAddRole()"><i class="fa fa-shield-alt"></i> New Role</button><button class="btn btn-p" onclick="openAddUser()"><i class="fa fa-user-plus"></i> Add Member</button></div></div>
<div class="tabs" id="team-tabs"><div class="tab act" onclick="teamTab('tm-members',this)">Members</div><div class="tab" onclick="teamTab('tm-roles',this)">Roles & Permissions</div></div>
<div id="tm-members">
<div class="tw"><table><thead><tr><th>Member</th><th>Username</th><th>Role</th><th>Pages Access</th><th>Status</th><th>Actions</th></tr></thead><tbody>
${DB.users.map(u=>{const role=DB.roles.find(r=>r.id===u.role)||{label:u.role,color:'#64748b',pages:[]};return`<tr>
<td><div class="flex ic gap9">${avH(u.name,u.color,28,10)}<div><div class="fw6">${u.name}</div><div class="fs11" style="color:var(--t3)">${u.designation||'—'}</div></div></div></td>
<td class="mono fs12">${u.username}</td>
<td><span class="role-chip" style="background:${role.color}22;color:${role.color}">${role.label}</span></td>
<td class="fs11" style="color:var(--t2);max-width:200px">${role.pages.slice(0,5).map(p=>MODULES[p]?.label||p).join(', ')}${role.pages.length>5?` +${role.pages.length-5} more`:''}</td>
<td>${bh(u.active?'Active':'Inactive',u.active?'var(--gd)':'var(--t3)',u.active?'var(--gb)':'var(--bg)')}</td>
<td><div class="flex gap4">${isOwner()?`<button class="btn btn-xs btn-o" onclick="openEditUser(${u.id})"><i class="fa fa-edit"></i></button><button class="btn btn-xs btn-o" onclick="openEditPerms(${u.id})"><i class="fa fa-lock"></i> Perms</button>`:''} ${u.id!==DB.currentUser.id&&isOwner()?`<button class="btn btn-xs ${u.active?'btn-red':'btn-grn'}" onclick="toggleUser(${u.id})">${u.active?'Deactivate':'Activate'}</button>`:''}</div></td></tr>`;}).join('')}
</tbody></table></div>
</div>
<div id="tm-roles" style="display:none">
<div class="abox a-blu mb12"><i class="fa fa-info-circle"></i>Each role defines exactly which sections a member can access. Use <strong>Edit Perms</strong> per-member to override their role's default pages.</div>
<div class="g2">${DB.roles.map(r=>`<div class="card"><div class="flex ic gap7 mb9"><div style="width:11px;height:11px;border-radius:50%;background:${r.color}"></div><div class="fw7 fs13 f1">${r.label}</div>${r.editable&&isOwner()?`<button class="btn btn-xs btn-o" onclick="openEditRole('${r.id}')"><i class="fa fa-edit"></i></button>`:''}</div>
<div class="flex gap3" style="flex-wrap:wrap;margin-bottom:8px">${r.pages.map(p=>`<span style="background:var(--bg);border:1px solid var(--border);border-radius:4px;padding:2px 5px;font-size:9px;color:var(--t2)">${MODULES[p]?.label||p}</span>`).join('')}</div>
<div class="fs11" style="color:var(--t3)">${DB.users.filter(u=>u.role===r.id).length} member(s) · ${r.pages.length} pages</div>
</div>`).join('')}</div>
</div>`;}
function teamTab(id,el){document.querySelectorAll('#team-tabs .tab').forEach(t=>t.classList.remove('act'));el.classList.add('act');['tm-members','tm-roles'].forEach(k=>{const e=document.getElementById(k);if(e)e.style.display=k===id?'block':'none';});}
function openAddRole(){showMo(`<div class="mt2">Create Role <button class="mc2" onclick="closeMo()"><i class="fa fa-times"></i></button></div>
<div class="fr2"><div class="fg"><label class="flbl">Role Name *</label><input class="finp" id="rn"></div><div class="fg"><label class="flbl">Color</label><input type="color" class="finp" id="rc" value="#3b82f6" style="height:38px;cursor:pointer"></div></div>
<div class="fg"><label class="flbl">Accessible Pages</label><div class="perm-grid">${Object.entries(MODULES).map(([k,v])=>`<label class="perm-item"><input type="checkbox" id="rp-${k}" style="accent-color:var(--amber)"> <i class="fa ${v.icon}" style="color:var(--amber);font-size:9px"></i> ${v.label}</label>`).join('')}</div></div>
<div class="mact"><button class="btn btn-o" onclick="closeMo()">Cancel</button><button class="btn btn-p" onclick="saveRole('')">Create Role</button></div>`);}
function openEditRole(id){const r=DB.roles.find(x=>x.id===id);if(!r)return;
showMo(`<div class="mt2">Edit: ${r.label} <button class="mc2" onclick="closeMo()"><i class="fa fa-times"></i></button></div>
<div class="fr2"><div class="fg"><label class="flbl">Name</label><input class="finp" id="rn" value="${r.label}"></div><div class="fg"><label class="flbl">Color</label><input type="color" class="finp" id="rc" value="${r.color}" style="height:38px;cursor:pointer"></div></div>
<div class="fg"><label class="flbl">Permissions — uncheck to block access</label><div class="perm-grid">${Object.entries(MODULES).map(([k,v])=>`<label class="perm-item"><input type="checkbox" id="rp-${k}" ${r.pages.includes(k)?'checked':''} style="accent-color:var(--amber)"> <i class="fa ${v.icon}" style="color:var(--amber);font-size:9px"></i> ${v.label}</label>`).join('')}</div></div>
<div class="mact"><button class="btn btn-o" onclick="closeMo()">Cancel</button><button class="btn btn-p" onclick="saveRole('${id}')">Save</button></div>`);}
function saveRole(id){const name=document.getElementById('rn')?.value?.trim();if(!name)return;const pages=Object.keys(MODULES).filter(k=>document.getElementById('rp-'+k)?.checked);const color=document.getElementById('rc').value;if(id){const r=DB.roles.find(x=>x.id===id);if(r){r.label=name;r.color=color;r.pages=pages;}}else{const newId=name.toLowerCase().replace(/\s+/g,'_').replace(/[^a-z0-9_]/g,'');DB.roles.push({id:newId,label:name,color,pages,editable:true});}save();closeMo();go('team');}
function openEditPerms(userId){const u=DB.users.find(x=>x.id===userId);if(!u)return;const currentRole=DB.roles.find(r=>r.id===u.role)||{pages:[]};
showMo(`<div class="mt2">Permissions — ${u.name} <button class="mc2" onclick="closeMo()"><i class="fa fa-times"></i></button></div>
<div class="abox a-blu mb10"><i class="fa fa-lock"></i>Fine-tune exactly what <strong>${u.name}</strong> can access. This overrides the default role settings.</div>
<div class="fg"><label class="flbl">Role</label><select class="fsel" id="pu-role" onchange="loadRolePerms(this.value)">${DB.roles.map(r=>`<option value="${r.id}" ${u.role===r.id?'selected':''}>${r.label}</option>`).join('')}</select></div>
<div class="fg"><label class="flbl">Page Access — check what ${u.name} can see</label><div class="perm-grid">${Object.entries(MODULES).map(([k,v])=>`<label class="perm-item"><input type="checkbox" id="pu-${k}" ${currentRole.pages.includes(k)?'checked':''} style="accent-color:var(--amber)"> <i class="fa ${v.icon}" style="color:var(--amber);font-size:9px"></i> ${v.label}</label>`).join('')}</div></div>
<div class="mact"><button class="btn btn-o" onclick="closeMo()">Cancel</button><button class="btn btn-p" onclick="saveUserPerms(${userId})">Save Permissions</button></div>`);}
function loadRolePerms(roleId){const r=DB.roles.find(x=>x.id===roleId);if(!r)return;Object.keys(MODULES).forEach(k=>{const cb=document.getElementById('pu-'+k);if(cb)cb.checked=r.pages.includes(k);});}
function saveUserPerms(userId){const u=DB.users.find(x=>x.id===userId);if(!u)return;const role=document.getElementById('pu-role')?.value;const customPages=Object.keys(MODULES).filter(k=>document.getElementById('pu-'+k)?.checked);u.role=role;// Update the role's pages to match this custom assignment
const r=DB.roles.find(x=>x.id===role);if(r&&r.editable)r.pages=[...new Set([...r.pages,...customPages])];// store as custom on user too
u.customPages=customPages;save();closeMo();go('team');}
function openAddUser(pre={}){showMo(`<div class="mt2">${pre.id?'Edit':'Add'} Member <button class="mc2" onclick="closeMo()"><i class="fa fa-times"></i></button></div>
<div class="fr2"><div class="fg"><label class="flbl">Full Name *</label><input class="finp" id="un" value="${pre.name||''}"></div><div class="fg"><label class="flbl">Username *</label><input class="finp" id="uu" value="${pre.username||''}"></div></div>
<div class="fr2"><div class="fg"><label class="flbl">Password ${pre.id?'(blank=keep)':'*'}</label><input class="finp" type="password" id="up"></div><div class="fg"><label class="flbl">Email</label><input class="finp" id="ue" value="${pre.email||''}"></div></div>
<div class="fr2"><div class="fg"><label class="flbl">Role *</label><select class="fsel" id="ur">${DB.roles.map(r=>`<option value="${r.id}" ${pre.role===r.id?'selected':''}>${r.label}</option>`).join('')}</select></div><div class="fg"><label class="flbl">Designation</label><input class="finp" id="ud" value="${pre.designation||''}"></div></div>
<div class="fg"><label class="flbl">Color</label><input type="color" class="finp" id="uc" value="${pre.color||'#2563eb'}" style="height:37px;cursor:pointer"></div>
<div class="mact"><button class="btn btn-o" onclick="closeMo()">Cancel</button><button class="btn btn-p" onclick="saveUser(${pre.id||0})">Save</button></div>`);}
async function saveUser(id){const name=document.getElementById('un')?.value?.trim();const uname2=document.getElementById('uu')?.value?.trim().toLowerCase();if(!name||!uname2){alert('Name and username required');return;}const pass=document.getElementById('up').value;if(!id&&!pass){alert('Password required');return;}if(DB.users.find(u=>u.username===uname2&&u.id!==id)){alert('Username taken');return;}const d={name,username:uname2,email:document.getElementById('ue')?.value,role:document.getElementById('ur').value,color:document.getElementById('uc').value,active:true};if(pass)d.password=pass;try{await saveEntity('users',id,d);await loadFromAPI();closeMo();go('team');}catch(e){alert(e.message||'User save failed');}}
function openEditUser(id){const u=DB.users.find(x=>x.id===id);if(u)openAddUser(u);}
async function toggleUser(id){if(id===DB.currentUser.id)return;const u=DB.users.find(x=>x.id===id);if(u){try{await saveEntity('users',id,{active:!u.active});await loadFromAPI();go('team');}catch(e){alert(e.message||'User update failed');}}}

// ══════ AI BRIEF GENERATOR ══════
function openBriefGen(clientId=null){showMo(`<div class="mt2"><i class="fa fa-magic ta"></i> AI Brief Generator <button class="mc2" onclick="closeMo()"><i class="fa fa-times"></i></button></div>
<div class="fr2"><div class="fg"><label class="flbl">Client</label><select class="fsel" id="br-c">${DB.clients.map(c=>`<option value="${c.id}" ${clientId===c.id?'selected':''}>${c.name}</option>`).join('')}</select></div><div class="fg"><label class="flbl">Platform</label><select class="fsel" id="br-p"><option>Instagram</option><option>Facebook</option><option>LinkedIn</option><option>TikTok</option><option>General</option></select></div></div>
<div class="fg"><label class="flbl">Campaign Topic *</label><input class="finp" id="br-t" placeholder="e.g. Eid Sale, Product Launch, Brand Awareness…"></div>
<div class="fg"><label class="flbl">Notes</label><textarea class="fta" id="br-n" style="min-height:40px" placeholder="Colors, style references…"></textarea></div>
<div id="brief-result" style="display:none"><div class="sep"></div><div class="sect-t mb7">Generated Brief</div><div class="brief-box" id="brief-content"></div></div>
<div class="mact"><button class="btn btn-o" onclick="closeMo()">Cancel</button><button class="btn btn-p" id="gen-btn" onclick="generateBrief()"><i class="fa fa-magic"></i> Generate</button></div>`);}
async function generateBrief(){const cid=parseInt(document.getElementById('br-c').value);const c=DB.clients.find(x=>x.id===cid);const platform=document.getElementById('br-p').value;const topic=document.getElementById('br-t')?.value?.trim();if(!topic){alert('Topic required');return;}const btn=document.getElementById('gen-btn');btn.disabled=true;btn.innerHTML='<div class="dots"><span></span><span></span><span></span></div>';const svcs=(c?.services||[]).map(cs=>svcName(cs.serviceId)).join(', ');
const briefPrompt='Create a complete creative brief for a digital agency.\n\nClient: '+(c?.name||'?')+' ('+(c?.company||'')+')\nServices: '+svcs+'\nPlatform: '+platform+'\nCampaign: '+topic+'\nNotes: '+(document.getElementById('br-n')?.value||'None')+'\n\nInclude: 1) Objective 2) Target Audience 3) Key Message 4) Visual Direction 5) Content Specs 6) Tone & Voice 7) Dos & Donts 8) References';
try{const res=await fetch('https://api.anthropic.com/v1/messages',{method:'POST',headers:{'Content-Type':'application/json','x-api-key':window.ANTHROPIC_KEY||'','anthropic-version':'2023-06-01','anthropic-dangerous-direct-browser-access':'true'},body:JSON.stringify({model:'claude-sonnet-4-20250514',max_tokens:1000,messages:[{role:'user',content:briefPrompt}]})});const data=await res.json();const text=data.content?.[0]?.text||'Error.';document.getElementById('brief-content').textContent=text;document.getElementById('brief-result').style.display='block';}catch(e){document.getElementById('brief-content').textContent='Connection error.';}
btn.disabled=false;btn.innerHTML='<i class="fa fa-magic"></i> Regenerate';}

// ══════ AI AGENT ══════
function pgAgent(){
  const me=DB.currentUser;
  const isAdm=isOwner();const isSls=isSales();const isSmm=isSMM();

  // Role-specific quick prompts
  const adminPrompts=[
    {i:'📧',t:'Draft a payment reminder for Ahmed Rahman — Invoice INV-2025-001 — ৳8,200 overdue'},
    {i:'📊',t:'Summarize May 2025 business — revenue collected, expenses, net profit'},
    {i:'💰',t:'Which clients have unpaid invoices this month? Give me a collection strategy'},
    {i:'📣',t:'Write a Facebook ad for website design service targeting Dhaka businesses'},
    {i:'🎨',t:'Generate Eid Sale campaign brief for Ahmed Rahman — Instagram + Facebook'},
    {i:'🤝',t:'Draft onboarding welcome email for new client Rafiq Islam, Rafiq Ventures'},
    {i:'📈',t:'Analyze our sales pipeline and give 3 recommendations to close more deals'},
  ];
  const salesPrompts=[
    {i:'💬',t:'Write a WhatsApp follow-up message for a lead who went silent after the proposal'},
    {i:'📋',t:'Help me write a social media management proposal — 20 posts/month package'},
    {i:'🎯',t:'What are the best objection-handling strategies when a client says its too expensive?'},
    {i:'📞',t:'Script a 2-minute cold call opening for website design services in Dhaka'},
    {i:'✍️',t:'Write a follow-up email after a meeting with a prospect interested in our SM package'},
    {i:'🏆',t:'Give me 5 tips to improve my sales conversion rate this month'},
    {i:'🤝',t:'How should I negotiate when a client wants 30% discount on a ৳15,000 project?'},
  ];
  const smmPrompts=[
    {i:'✍️',t:'Write 5 Instagram caption ideas for a product launch post — energetic and engaging'},
    {i:'📅',t:'Give me a 30-day content calendar structure for a restaurant client on Instagram'},
    {i:'#️⃣',t:'Best hashtag strategy for a Dhaka-based fashion brand on Instagram in 2025'},
    {i:'🎬',t:'Write a reel script concept — 30 seconds — for a before/after transformation post'},
    {i:'💡',t:'10 content ideas for a B2B software company on LinkedIn this month'},
    {i:'📊',t:'How do I write a clear client content report? What metrics should I include?'},
    {i:'🎯',t:'Tips for writing engaging Facebook ad copy for a local service business'},
  ];
  const creativePrompts=[
    {i:'🎨',t:'Explain the difference between primary, secondary, and accent colors in brand design'},
    {i:'📐',t:'What are the best practices for social media graphic sizes in 2025?'},
    {i:'✏️',t:'Give me tips for designing a post that works for both Instagram feed and stories'},
    {i:'🎬',t:'What makes a good motion design reel — pacing, transitions, music?'},
    {i:'🖼️',t:'How do I maintain visual consistency across a client brand on different platforms?'},
    {i:'💡',t:'What are the latest design trends for social media content in 2025?'},
    {i:'⚡',t:'Give me 5 tips to work faster in Adobe Photoshop without losing quality'},
  ];

  const prompts=isAdm?adminPrompts:isSls?salesPrompts:isSmm?smmPrompts:creativePrompts;
  const roleLabel=isAdm?'Full agency access':isSls?'Your leads & pipeline only':isSmm?'Your clients & content only':'Your tasks only';
  const roleColor=isAdm?'var(--amber)':isSls?'var(--blue)':isSmm?'var(--pink)':'var(--green)';

  return`<div class="ph"><div class="ph-t">AI Agent</div><div class="ph-s">Claude-powered assistant</div></div>
<div class="g2" style="align-items:start;height:calc(100vh - 130px)">
<div style="display:flex;flex-direction:column;gap:9px">
<div class="card">
<div style="background:${roleColor}22;border:1px solid ${roleColor}44;border-radius:var(--r);padding:8px 11px;margin-bottom:10px;font-size:11px;display:flex;align-items:center;gap:7px">
<i class="fa fa-lock" style="color:${roleColor}"></i>
<div><strong style="color:${roleColor}">${me.name}</strong> — ${roleLabel}</div>
</div>
<div class="sect-t mb7">Quick Prompts</div><div style="display:flex;flex-direction:column;gap:4px">
${prompts.map(q=>`<button class="btn btn-o" style="text-align:left;justify-content:flex-start;font-size:11px;padding:6px 9px;white-space:normal" onclick="agentSend(\`${q.t}\`)"><span style="margin-right:6px">${q.i}</span>${q.t.slice(0,58)}…</button>`).join('')}
</div></div>
</div>
<div style="display:flex;flex-direction:column;background:var(--card);border:1px solid var(--border);border-radius:var(--rlg);overflow:hidden;height:565px">
<div style="padding:10px 14px;border-bottom:1px solid var(--border);background:linear-gradient(90deg,var(--navy),var(--navy3))">
<div class="fw7 fs12" style="color:#fff"><i class="fa fa-robot" style="color:var(--amber);margin-right:6px"></i>DMS AI Agent</div>
<div class="fs11" style="color:rgba(255,255,255,.35)">${roleLabel}</div>
</div>
<div style="flex:1;overflow-y:auto;padding:12px;display:flex;flex-direction:column;gap:9px" id="agent-msgs"></div>
<div style="padding:9px;border-top:1px solid var(--border);display:flex;gap:6px;background:#fff">
<textarea id="agent-inp" style="flex:1;padding:7px 10px;border:1.5px solid var(--border);border-radius:var(--r);font-size:12px;font-family:'Plus Jakarta Sans',sans-serif;outline:none;resize:none;min-height:38px" placeholder="${isAdm?'Ask anything — emails, proposals, financials, analysis…':isSls?'Ask about sales, proposals, follow-ups, scripts…':isSmm?'Ask about content, captions, strategy, calendars…':'Ask about design, tools, techniques, creative ideas…'}" onkeydown="if(event.key==='Enter'&&!event.shiftKey){event.preventDefault();sendAgent()}"></textarea>
<div style="display:flex;flex-direction:column;gap:4px">
<button class="chat-send" onclick="sendAgent()"><i class="fa fa-paper-plane"></i></button>
<button class="chat-send" style="background:var(--rb)" onclick="DB.aiMsgs=[];initAgent()" title="Clear"><i class="fa fa-trash"></i></button>
</div>
</div>
</div>
</div>`;}

function initAgent(){
  const m=document.getElementById('agent-msgs');
  if(!m)return;
  const me=DB.currentUser;
  const isAdm=isOwner();const isSls=isSales();const isSmm=isSMM();
  const welcomeMsg=isAdm
    ?'Hi '+me.name.split(' ')[0]+'! I have full access to agency data — clients, invoices, financials, leads, and more. Ask me anything.'
    :isSls
    ?'Hi '+me.name.split(' ')[0]+'! I can help with your sales pipeline, proposals, follow-ups, and scripts. I only have access to your own leads and targets — company financials are admin-only.'
    :isSmm
    ?'Hi '+me.name.split(' ')[0]+'! I can help with content strategy, captions, campaign ideas, and client briefs for your assigned clients. Financial and billing data is admin-only.'
    :'Hi '+me.name.split(' ')[0]+'! I can help with creative work — design tips, motion concepts, technical guidance, and improving your deliverables. Company data is admin-only.';
  if(!DB.aiMsgs.length){
    m.innerHTML=`<div style="text-align:center;padding:20px;color:var(--t3)"><i class="fa fa-robot" style="font-size:26px;display:block;margin-bottom:9px;opacity:.4"></i>${welcomeMsg}</div>`;
  }else renderAgentHistory();
}

function renderAgentHistory(){const m=document.getElementById('agent-msgs');if(!m)return;m.innerHTML=DB.aiMsgs.map(msg=>`<div style="display:flex;gap:8px;${msg.r==='user'?'flex-direction:row-reverse':''}">${msg.r==='user'?avH(DB.currentUser?.name,DB.currentUser?.color,24,8):'<div style="width:24px;height:24px;border-radius:50%;background:var(--amber);display:flex;align-items:center;justify-content:center;font-size:11px;flex-shrink:0">🤖</div>'}<div style="max-width:78%;padding:8px 11px;border-radius:11px;font-size:12px;line-height:1.6;${msg.r==='user'?'background:var(--amber);color:#fff;border-radius:11px 11px 2px 11px':'background:var(--bg);border:1px solid var(--border);white-space:pre-wrap'}">${msg.c}</div></div>`).join('');}
async function sendAgent(){
  const inp=document.getElementById('agent-inp');
  if(!inp||!inp.value.trim())return;
  const userMsg=inp.value.trim();inp.value='';
  const me=DB.currentUser;
  const role=me.role;

  // ── Build role-scoped system prompt ──
  let system='';

  if(isOwner()){
    // Admin sees everything
    const tR=DB.clients.reduce((s,c)=>s+cTotal(c),0);
    const tExp=expTotal('2025-05');
    const tP=DB.invoices.filter(i=>i.status==='paid').reduce((s,i)=>s+iTotal(i),0);
    const invDue=DB.invoices.filter(i=>i.status!=='paid').map(i=>{const c=DB.clients.find(x=>x.id===i.clientId);return i.number+': '+( c?.name||'?')+' — '+fmt(iBal(i))+' due '+i.dueDate;}).join('\n');
    const clientList=DB.clients.map(c=>c.name+' ('+( c?.company||'?')+', '+fmt(cTotal(c))+'/mo)').join('\n');
    system='You are DMS AI Agent — full-access assistant for the agency owner/admin in Dhaka, Bangladesh. Currency: ৳ (BDT).\n\nYou have full visibility into all agency data.\n\nFinancials:\n- Monthly Revenue: '+fmt(tR)+' | Collected: '+fmt(tP)+' | Expenses: '+fmt(tExp)+' | Net: '+fmt(tP-tExp)+'\n- Clients: '+DB.clients.length+' | Open Leads: '+DB.leads.filter(l=>!l.deleted&&l.stageId<7).length+' | Active Tasks: '+DB.tasks.filter(t=>t.status!=="done").length+'\n\nClient List:\n'+clientList+'\n\nUnpaid Invoices:\n'+(invDue||'None')+'\n\nHelp with: payment reminders, proposals, emails, reports, analysis, briefs, ad copy. Always use ৳.';

  } else if(isSales()){
    // Sales: only their own leads, pipeline, targets — no billing, no other clients
    const myLeads=DB.leads.filter(l=>!l.deleted&&l.assignedTo===me.id);
    const myTgt=DB.targets.find(t=>t.userId===me.id&&t.month==='2025-05');
    const achieved=myTgt?tgtAch(myTgt):0;
    const total=myTgt?tgtTotal(myTgt):0;
    const leadSummary=myLeads.map(l=>l.name+' ('+stgLabel(l.stageId)+', budget: '+fmt(l.budget)+')').join('\n');
    const tgtSummary=myTgt?(myTgt.items||[]).map(item=>{const ach=tgtItemAch(myTgt,item.id);return item.serviceName+': '+ach+'/'+item.qty+' units';}).join('\n'):'No target set';
    system='You are DMS AI Agent — sales assistant for '+me.name+' at a digital marketing agency in Dhaka, Bangladesh. Currency: ৳ (BDT).\n\nYour role: Sales Executive. You only have access to YOUR OWN data.\n\nYour Pipeline ('+myLeads.length+' leads):\n'+( leadSummary||'No leads')+'\n\nYour May Target Progress:\n'+tgtSummary+'\nAchieved: '+fmt(achieved)+' / '+fmt(total)+'\n\nYou can help with: crafting proposals, lead follow-up messages, WhatsApp templates, pitch scripts, objection handling, sales strategies.\n\nIMPORTANT: You do NOT have access to company financials, other staff data, client billing, or invoice details. Do not discuss or reveal any confidential company data. If asked, politely say that data is restricted to management.';

  } else if(isSMM()){
    // SMM: only their assigned clients (name/brief only), their tasks — no financials
    const myClients=myVisibleClients();
    const myTasks=DB.tasks.filter(t=>t.assignedTo===me.id&&t.status!=='done');
    const clientSummary=myClients.map(c=>c.name+' ('+( c?.company||'')+')').join(', ');
    const taskSummary=myTasks.map(t=>{const c=DB.clients.find(x=>x.id===t.clientId);return t.title+' for '+(c?.name||'?')+' — due '+t.deadline;}).join('\n');
    system='You are DMS AI Agent — social media assistant for '+me.name+' at a digital marketing agency in Dhaka, Bangladesh.\n\nYour role: Social Media Manager. You can only see your assigned clients and tasks.\n\nYour Clients: '+( clientSummary||'None assigned')+'\n\nYour Active Tasks:\n'+(taskSummary||'No active tasks')+'\n\nYou can help with: writing captions, content ideas, post schedules, hashtag strategies, campaign concepts, client briefs, creative direction.\n\nIMPORTANT: You do NOT have access to financial data, invoices, billing, other staff data, or the full client list. Do not discuss or reveal any confidential company data. If asked about payments, billing, or revenue, politely say that is restricted to management.';

  } else {
    // All other creative roles (designer, motion, video, seo, mediabuyer)
    // Only their own tasks — no client details, no financials
    const myTasks=DB.tasks.filter(t=>t.assignedTo===me.id&&t.status!=='done');
    const taskSummary=myTasks.map(t=>{const c=DB.clients.find(x=>x.id===t.clientId);return t.title+' — due '+t.deadline+(t.notes?' ('+t.notes.slice(0,40)+')':'');}).join('\n');
    const roleName=DB.roles.find(r=>r.id===me.role)?.label||me.role;
    system='You are DMS AI Agent — creative assistant for '+me.name+' ('+roleName+') at a digital marketing agency in Dhaka, Bangladesh.\n\nYour Active Tasks:\n'+(taskSummary||'No active tasks')+'\n\nYou can help with: understanding task requirements, creative ideas, design concepts, technical guidance, writing briefs, improving your work quality.\n\nIMPORTANT: You do NOT have access to financial data, client lists, invoices, billing amounts, other staff performance, or any company business data. Do not discuss, estimate, or reveal any confidential information. If asked about money, clients, or company performance, say that is restricted to management only.';
  }

  // ── Render user message immediately ──
  DB.aiMsgs.push({r:'user',c:userMsg});
  const m=document.getElementById('agent-msgs');
  if(m){
    m.innerHTML+=`<div style="display:flex;gap:8px;flex-direction:row-reverse">${avH(me.name,me.color,24,8)}<div style="max-width:78%;padding:8px 11px;border-radius:11px 11px 2px 11px;font-size:12px;background:var(--amber);color:#fff">${userMsg}</div></div><div id="typing-ind" style="display:flex;gap:8px;align-items:center"><div style="width:24px;height:24px;border-radius:50%;background:var(--amber);display:flex;align-items:center;justify-content:center;font-size:11px">🤖</div><div class="dots" style="background:var(--bg);border:1px solid var(--border);padding:8px 11px;border-radius:8px"><span></span><span></span><span></span></div></div>`;
    m.scrollTop=m.scrollHeight;
  }

  try{
    const res=await fetch('https://api.anthropic.com/v1/messages',{
      method:'POST',
      headers:{'Content-Type':'application/json','x-api-key':window.ANTHROPIC_KEY||'','anthropic-version':'2023-06-01','anthropic-dangerous-direct-browser-access':'true'},
      body:JSON.stringify({model:'claude-sonnet-4-20250514',max_tokens:1000,system,messages:DB.aiMsgs.map(msg=>({role:msg.r,content:msg.c}))})
    });
    const data=await res.json();
    const text=data.content?.[0]?.text||'Could not respond.';
    DB.aiMsgs.push({r:'assistant',c:text});
    document.getElementById('typing-ind')?.remove();
    if(m){
      m.innerHTML+=`<div style="display:flex;gap:8px"><div style="width:24px;height:24px;border-radius:50%;background:var(--amber);display:flex;align-items:center;justify-content:center;font-size:11px;flex-shrink:0">🤖</div><div style="max-width:78%;padding:8px 11px;border-radius:11px;font-size:12px;background:var(--bg);border:1px solid var(--border);white-space:pre-wrap">${text}</div></div>`;
      m.scrollTop=m.scrollHeight;
    }
  }catch(e){
    document.getElementById('typing-ind')?.remove();
    if(m)m.innerHTML+=`<div style="padding:8px;background:var(--rb);border-radius:var(--r);font-size:11px;color:var(--rd)">Connection error. Check internet.</div>`;
  }
}

function agentSend(txt){const inp=document.getElementById('agent-inp');if(inp){inp.value=txt;sendAgent();}else{go('agent');setTimeout(()=>{const i=document.getElementById('agent-inp');if(i){i.value=txt;sendAgent();}},500);}}

// ══════ SETTINGS ══════
function pgSettings(){return`<div class="ph"><div class="ph-t">Settings</div></div>
<div class="g2"><div>
<div class="card mb12"><div class="sect-t mb10">Agency Info</div>
<div class="fg"><label class="flbl">Agency Name</label><input class="finp" id="ag-n" value="DMS Creative Agency"></div>
<div class="fg"><label class="flbl">Email</label><input class="finp" id="ag-e" value="admin@agency.com"></div>
<div class="fg"><label class="flbl">Phone</label><input class="finp" id="ag-p" value="+880-171-0000000"></div>
<div class="fg"><label class="flbl">Address</label><input class="finp" id="ag-a" value="Dhaka, Bangladesh"></div>
<button class="btn btn-p btn-sm mt6" onclick="alert('Saved!')">Save</button>
</div>
<div class="card"><div class="sect-t mb10">My Account</div>
<div class="fg"><label class="flbl">Full Name</label><input class="finp" id="my-n" value="${DB.currentUser?.name||''}"></div>
<div class="fg"><label class="flbl">New Password</label><input class="finp" type="password" id="my-p" placeholder="Leave blank to keep"></div>
<button class="btn btn-p btn-sm mt6" onclick="saveMyAcc()">Update</button>
</div>
</div>
<div>
<div class="card mb12"><div class="sect-t mb10">Lead Stages</div>
${DB.leadStages.map(s=>`<div class="flex ic gap7 mb7"><input class="finp f1" value="${s.label}" id="ls-l-${s.id}" style="padding:5px 9px;font-size:12px"><input type="color" value="${s.color}" id="ls-c-${s.id}" style="width:34px;height:34px;border:1px solid var(--border);border-radius:5px;cursor:pointer"><button class="btn btn-xs btn-o" onclick="updateStage(${s.id})">✓</button></div>`).join('')}
<button class="btn btn-sm btn-o mt5" onclick="DB.leadStages.push({id:uid(),label:'New Stage',color:'#64748b'});save();go('settings')"><i class="fa fa-plus"></i> Add Stage</button>
</div>
<div class="card"><div class="sect-t mb10">Data Management</div>
<button class="btn btn-o btn-sm mb7" onclick="exportData()"><i class="fa fa-download"></i> Export JSON Backup</button><br>
<button class="btn btn-red btn-sm" onclick="if(confirm('RESET ALL DATA to demo? This cannot be undone!'))resetData()"><i class="fa fa-trash"></i> Reset to Demo Data</button>
</div>
</div>
</div>`;}
async function saveMyAcc(){const n=document.getElementById('my-n')?.value?.trim();const p=document.getElementById('my-p')?.value;const d={};if(n)d.name=n;if(p)d.password=p;try{await saveEntity('users',DB.currentUser.id,d);await loadFromAPI();alert('Updated!');go('settings');}catch(e){alert(e.message||'Account update failed');}}
function updateStage(id){const s=DB.leadStages.find(x=>x.id===id);if(s){s.label=document.getElementById('ls-l-'+id)?.value||s.label;s.color=document.getElementById('ls-c-'+id)?.value||s.color;save();}}
function exportData(){const blob=new Blob([JSON.stringify(DB,null,2)],{type:'application/json'});const a=document.createElement('a');a.href=URL.createObjectURL(blob);a.download='dmscrm_v5_backup.json';a.click();}
function resetData(){localStorage.removeItem('dmscrm_v5');location.reload();}


// ══════ CLIENT REQUIREMENTS (on leads) ══════
window._reqCounter=0;
function openAddRequirement(leadId){
  const l=DB.leads.find(x=>x.id===leadId);
  const svcOpts=DB.services.filter(s=>s.active).map(s=>`<option value="${s.name}" data-price="${s.basePrice}">${s.name} (${fmt(s.basePrice)}/${s.unit})</option>`).join('');
  showMo(`<div class="mt2">Add Requirement <button class="mc2" onclick="closeMo()"><i class="fa fa-times"></i></button></div>
<div class="abox a-blu mb10"><i class="fa fa-info-circle"></i>Add what the client needs. You can add multiple items.</div>
<div id="req-rows"></div>
<button class="btn btn-sm btn-o mb10" onclick="addReqRow()"><i class="fa fa-plus"></i> Add Another Item</button>
<div class="mact"><button class="btn btn-o" onclick="closeMo()">Cancel</button><button class="btn btn-p" onclick="saveRequirements(${leadId})"><i class="fa fa-save"></i> Save Requirements</button></div>`);
  addReqRow(svcOpts);
}
function addReqRow(svcOptsParam){
  const idx=++window._reqCounter;
  const svcOpts=svcOptsParam||DB.services.filter(s=>s.active).map(s=>`<option value="${s.name}" data-price="${s.basePrice}">${s.name} (${fmt(s.basePrice)}/${s.unit})</option>`).join('');
  const wrap=document.getElementById('req-rows');if(!wrap)return;
  const row=document.createElement('div');row.className='srvc-row';row.id='reqrow-'+idx;row.style.cssText='flex-wrap:wrap;gap:6px;margin-bottom:8px;padding:10px;background:var(--bg);border-radius:var(--r);border:1px solid var(--border)';
  row.innerHTML=`<div style="width:100%;display:flex;gap:7px;align-items:center;margin-bottom:6px"><select class="fsel f1" id="rq-svc-${idx}" onchange="fillReqPrice(${idx})" style="font-size:12px"><option value="">— Select service or type custom —</option>${svcOpts}<option value="__custom__">✏️ Custom / Other</option></select><button class="btn btn-xs btn-red" onclick="document.getElementById('reqrow-${idx}').remove()"><i class="fa fa-times"></i></button></div>
<div id="rq-custom-wrap-${idx}" style="display:none;width:100%;margin-bottom:6px"><input class="finp" id="rq-custom-${idx}" placeholder="Type custom service name…" style="font-size:12px"></div>
<div style="display:flex;gap:7px;width:100%;flex-wrap:wrap">
<div class="fg" style="flex:1;min-width:80px;margin-bottom:0"><label class="flbl">Qty</label><input class="finp" type="number" id="rq-qty-${idx}" value="1" min="1" oninput="calcReqTotal(${idx})" style="font-size:12px"></div>
<div class="fg" style="flex:1;min-width:100px;margin-bottom:0"><label class="flbl">Unit Price (৳)</label><input class="finp" type="number" id="rq-price-${idx}" placeholder="0" oninput="calcReqTotal(${idx})" style="font-size:12px"></div>
<div class="fg" style="flex:1;min-width:80px;margin-bottom:0"><label class="flbl">Total</label><div class="finp mono fw7 tg" id="rq-total-${idx}" style="background:var(--gb);font-size:12px">—</div></div>
</div>
<div class="fg" style="width:100%;margin-bottom:0;margin-top:4px"><label class="flbl">Notes (optional)</label><input class="finp" id="rq-notes-${idx}" placeholder="e.g. Brand colors, special instructions, agreed discount…" style="font-size:12px"></div>`;
  wrap.appendChild(row);
}
function fillReqPrice(idx){
  const sel=document.getElementById('rq-svc-'+idx);const opt=sel?.options[sel.selectedIndex];
  const isCustom=sel?.value==='__custom__';
  const cw=document.getElementById('rq-custom-wrap-'+idx);if(cw)cw.style.display=isCustom?'block':'none';
  const price=parseFloat(opt?.dataset?.price||0);
  const priceEl=document.getElementById('rq-price-'+idx);if(priceEl&&!priceEl.value&&price)priceEl.value=price;
  calcReqTotal(idx);
}
function calcReqTotal(idx){
  const q=parseFloat(document.getElementById('rq-qty-'+idx)?.value)||0;
  const p=parseFloat(document.getElementById('rq-price-'+idx)?.value)||0;
  const el=document.getElementById('rq-total-'+idx);if(el)el.textContent=q&&p?fmt(q*p):'—';
}
function saveRequirements(leadId){
  const l=DB.leads.find(x=>x.id===leadId);if(!l)return;
  if(!l.requirements)l.requirements=[];
  const rows=document.querySelectorAll('#req-rows .srvc-row');
  let added=0;
  rows.forEach(row=>{
    const idx=row.id.replace('reqrow-','');
    const selEl=document.getElementById('rq-svc-'+idx);
    const isCustom=selEl?.value==='__custom__';
    const svcName=isCustom?(document.getElementById('rq-custom-'+idx)?.value?.trim()||'Custom'):selEl?.value;
    if(!svcName||svcName==='')return;
    const qty=parseInt(document.getElementById('rq-qty-'+idx)?.value)||1;
    const price=parseFloat(document.getElementById('rq-price-'+idx)?.value)||0;
    const notes=document.getElementById('rq-notes-'+idx)?.value||'';
    if(qty&&price){l.requirements.push({id:'r'+uid(),service:svcName,qty,unitPrice:price,notes});added++;}
  });
  if(added===0){alert('Add at least one requirement with qty and price');return;}
  save();closeMo();
  addNotif('📋','#dbeafe',`${added} requirement${added>1?'s':''} added for ${l.name}`);
  viewLead(leadId);
}
function removeRequirement(leadId,reqId){
  const l=DB.leads.find(x=>x.id===leadId);if(!l)return;
  l.requirements=(l.requirements||[]).filter(r=>r.id!==reqId);
  save();closeMo();viewLead(leadId);
}

// ══════ SUBMIT REQUISITION (sales → admin) ══════
function openSubmitRequisition(leadId){
  const l=DB.leads.find(x=>x.id===leadId);if(!l)return;
  const reqs=l.requirements||[];
  if(reqs.length===0){alert('Please add client requirements first before submitting.');return;}
  const existing=DB.requisitions.find(r=>r.leadId===leadId&&r.status==='pending');
  if(existing){alert('A requisition for this client is already pending admin review.');return;}
  const totalVal=reqs.reduce((s,r)=>s+r.qty*r.unitPrice,0);
  const smmOpts=DB.users.filter(u=>u.role==='smm').map(u=>`<option value="${u.id}">${u.name}</option>`).join('');
  showMo(`<div class="mt2">Submit Client Requisition <button class="mc2" onclick="closeMo()"><i class="fa fa-times"></i></button></div>
<div class="abox a-grn mb10"><i class="fa fa-trophy"></i><div><strong>${l.name}</strong> is won! Submit this requisition for admin to review and assign the team.</div></div>
<div class="card mb12" style="background:var(--bg)">
<div class="sect-t mb8">Services Agreed</div>
<table style="width:100%;border-collapse:collapse"><thead><tr style="background:var(--navy)"><th style="padding:6px 9px;color:#fff;font-size:10px;text-align:left">Service</th><th style="padding:6px 9px;color:#fff;font-size:10px;text-align:center">Qty</th><th style="padding:6px 9px;color:#fff;font-size:10px;text-align:right">Price</th><th style="padding:6px 9px;color:#fff;font-size:10px;text-align:right">Total</th></tr></thead><tbody>
${reqs.map(r=>`<tr><td style="padding:6px 9px;border-bottom:1px solid var(--border)">${r.service}${r.notes?`<div class="fs10" style="color:var(--t3)">${r.notes}</div>`:''}</td><td style="padding:6px 9px;border-bottom:1px solid var(--border);text-align:center">${r.qty}</td><td class="mono" style="padding:6px 9px;border-bottom:1px solid var(--border);text-align:right">${fmt(r.unitPrice)}</td><td class="mono fw7 tg" style="padding:6px 9px;border-bottom:1px solid var(--border);text-align:right">${fmt(r.qty*r.unitPrice)}</td></tr>`).join('')}
<tr style="background:var(--gb)"><td colspan="3" style="padding:8px 9px;font-weight:800">Total Contract Value</td><td class="mono fw8 tg" style="padding:8px 9px;text-align:right;font-size:14px">${fmt(totalVal)}</td></tr>
</tbody></table>
</div>
<div class="fr2"><div class="fg"><label class="flbl">Advance Paid (৳)</label><input class="finp" type="number" id="rq-adv" value="0"></div><div class="fg"><label class="flbl">Billing Cycle</label><select class="fsel" id="rq-billing"><option value="monthly">Monthly</option><option value="one-time">One-time</option><option value="quarterly">Quarterly</option></select></div></div>
<div class="fg"><label class="flbl">Special Notes for Admin</label><textarea class="fta" id="rq-snotes" style="min-height:50px" placeholder="Any important info for admin — timeline, client preferences, commitments made…"></textarea></div>
<div class="mact"><button class="btn btn-o" onclick="closeMo()">Cancel</button><button class="btn btn-p" onclick="submitRequisition(${leadId})"><i class="fa fa-paper-plane"></i> Submit to Admin</button></div>`,true);
}
function submitRequisition(leadId){
  const l=DB.leads.find(x=>x.id===leadId);if(!l)return;
  const reqs=l.requirements||[];const totalVal=reqs.reduce((s,r)=>s+r.qty*r.unitPrice,0);
  const req={
    id:uid(),leadId,
    clientName:l.name,company:l.company||'',phone:l.phone||'',email:l.email||'',location:l.location||'',
    submittedBy:DB.currentUser.id,submittedAt:new Date().toISOString().split('T')[0],
    status:'pending',
    items:reqs.map(r=>({...r,total:r.qty*r.unitPrice})),
    totalValue:totalVal,
    advancePaid:parseFloat(document.getElementById('rq-adv')?.value)||0,
    billingCycle:document.getElementById('rq-billing')?.value||'monthly',
    specialNotes:document.getElementById('rq-snotes')?.value||'',
    assignedSMM:null,assignedTeam:[],adminNotes:'',reviewedAt:null,reviewedBy:null,convertedClientId:null
  };
  DB.requisitions.push(req);
  l.stageId=7;// Mark as Won
  l.timeline=l.timeline||[];
  l.timeline.push({type:'stage',by:DB.currentUser.id,text:'Requisition submitted — awaiting admin approval',date:new Date().toISOString().split('T')[0]});
  addNotif('📋','#fef3c7',`New requisition from ${DB.currentUser.name}: ${l.name} — ${fmt(totalVal)}`);
  save();closeMo();
  alert('Requisition submitted! Admin will review and set up the client account.');
  go('crm');setTimeout(renderPipe,50);
}

// ══════ REQUISITIONS PAGE (admin reviews, approves, assigns team) ══════
function pgRequisitions(){
  const canSee=isOwner()||(isSales()&&canDo('requisitions'));
  if(!canSee)return`<div class="empty"><i class="fa fa-lock"></i>Access restricted</div>`;
  const pending=DB.requisitions.filter(r=>r.status==='pending');
  const approved=DB.requisitions.filter(r=>r.status==='approved');
  const rejected=DB.requisitions.filter(r=>r.status==='rejected');
  return`<div class="ph"><div><div class="ph-t">Client Requisitions</div><div class="ph-s">Sales → Admin approval → Team assignment</div></div></div>
<div class="g3 mb14">
<div class="mc" style="border-color:var(--amber)"><div class="mc-icon" style="background:var(--al)"><i class="fa fa-clock" style="color:var(--amber)"></i></div><div class="mc-lbl">Pending Review</div><div class="mc-val ta">${pending.length}</div></div>
<div class="mc" style="border-color:var(--green)"><div class="mc-icon" style="background:var(--gb)"><i class="fa fa-check-circle" style="color:var(--green)"></i></div><div class="mc-lbl">Approved</div><div class="mc-val tg">${approved.length}</div></div>
<div class="mc"><div class="mc-icon" style="background:var(--rb)"><i class="fa fa-times-circle" style="color:var(--red)"></i></div><div class="mc-lbl">Rejected</div><div class="mc-val tr">${rejected.length}</div></div>
</div>
${pending.length?`<div class="abox a-amb mb12"><i class="fa fa-exclamation-circle fa-lg"></i><div><div class="fw7 mb2">${pending.length} requisition${pending.length>1?'s':''} awaiting your review</div><div class="fs11">Review each one, assign team members, then approve to auto-create the client account.</div></div></div>`:''}
<div id="req-list"></div>`;
}
function renderRequisitions(){
  const el=document.getElementById('req-list');if(!el)return;
  const allReqs=[...DB.requisitions].sort((a,b)=>(b.submittedAt||'').localeCompare(a.submittedAt||''));
  if(allReqs.length===0){el.innerHTML='<div class="empty"><i class="fa fa-clipboard-list"></i>No requisitions yet. Sales team submits them when they win a client.</div>';return;}
  el.innerHTML=allReqs.map(req=>{
    const submitter=DB.users.find(u=>u.id===req.submittedBy);
    const smm=DB.users.find(u=>u.id===req.assignedSMM);
    const teamMembers=req.assignedTeam.map(uid=>DB.users.find(u=>u.id===uid)).filter(Boolean);
    const statusColors={pending:{c:'var(--ad)',b:'var(--al)',icon:'⏳'},approved:{c:'var(--gd)',b:'var(--gb)',icon:'✅'},rejected:{c:'var(--rd)',b:'var(--rb)',icon:'❌'}};
    const sc=statusColors[req.status]||statusColors.pending;
    return`<div class="card mb12" style="border-left:4px solid ${req.status==='pending'?'var(--amber)':req.status==='approved'?'var(--green)':'var(--red)'}">
<div class="flex ic gap12 mb12">
<div style="width:42px;height:42px;border-radius:50%;background:${sc.b};display:flex;align-items:center;justify-content:center;font-size:18px;flex-shrink:0">${sc.icon}</div>
<div class="f1">
<div class="fw8 fs14">${req.clientName} ${req.company?`<span class="fs12 fw6" style="color:var(--t3)">· ${req.company}</span>`:''}}</div>
<div class="fs12" style="color:var(--t3)">Submitted by ${submitter?.name||'?'} · ${fmtD(req.submittedAt)} · ${bh(req.status,sc.c,sc.b)}</div>
</div>
<div style="text-align:right">
<div class="mono fw8 fs18 tg">${fmt(req.totalValue)}</div>
<div class="fs11" style="color:var(--t3)">${req.billingCycle}</div>
</div>
</div>
<div class="tw mb10"><table><thead><tr><th>Service</th><th>Qty</th><th>Unit Price</th><th>Total</th><th>Notes</th></tr></thead><tbody>
${(req.items||[]).map(item=>`<tr><td class="fw6">${item.service}</td><td class="mono">${item.qty}</td><td class="mono">${fmt(item.unitPrice)}</td><td class="mono fw7 tg">${fmt(item.qty*item.unitPrice)}</td><td class="fs11" style="color:var(--t2)">${item.notes||'—'}</td></tr>`).join('')}
<tr style="background:var(--gb)"><td colspan="3" style="padding:7px 12px;font-weight:800">Total</td><td class="mono fw8 tg" style="padding:7px 12px">${fmt(req.totalValue)}</td><td></td></tr>
</tbody></table></div>
<div class="g3 mb10">
<div style="background:var(--bg);border-radius:var(--r);padding:9px"><div class="fs10 mb2" style="color:var(--t3);text-transform:uppercase">Contact</div><div class="fs12 fw6">${req.phone||'—'}</div><div class="fs11" style="color:var(--t3)">${req.email||'—'}</div></div>
<div style="background:var(--bg);border-radius:var(--r);padding:9px"><div class="fs10 mb2" style="color:var(--t3);text-transform:uppercase">Advance Paid</div><div class="mono fw7 tg">${fmt(req.advancePaid)}</div><div class="fs11" style="color:var(--t3)">Balance: ${fmt(req.totalValue-req.advancePaid)}</div></div>
<div style="background:var(--bg);border-radius:var(--r);padding:9px"><div class="fs10 mb2" style="color:var(--t3);text-transform:uppercase">Assigned SMM</div><div class="fw6 fs12">${smm?smm.name:'Not assigned'}</div></div>
</div>
${req.specialNotes?`<div class="abox a-blu mb10"><i class="fa fa-comment-alt"></i><div><strong>Sales Note:</strong> ${req.specialNotes}</div></div>`:''}
${req.adminNotes?`<div class="abox a-amb mb10"><i class="fa fa-sticky-note"></i><div><strong>Admin Note:</strong> ${req.adminNotes}</div></div>`:''}
${teamMembers.length?`<div class="flex ic gap7 mb10"><span class="fs12 fw6 mr8">Team:</span>${teamMembers.map(u=>`<div class="flex ic gap5">${avH(u.name,u.color,22,8)}<span class="fs11">${u.name}</span></div>`).join('')}</div>`:''}
${req.status==='approved'&&req.convertedClientId?`<div class="abox a-grn mb8"><i class="fa fa-user-check"></i><div><strong>Client created!</strong> Account is live. <button class="btn btn-xs btn-grn" onclick="openCP(${req.convertedClientId})">View Client Profile</button></div></div>`:''}
${isOwner()&&req.status==='pending'?`<div class="flex gap7" style="flex-wrap:wrap"><button class="btn btn-p" onclick="openApproveRequisition(${req.id})"><i class="fa fa-check-circle"></i> Review & Approve</button><button class="btn btn-o" onclick="openRejectRequisition(${req.id})"><i class="fa fa-times"></i> Reject</button></div>`:''}
${isOwner()&&req.status==='approved'&&!req.convertedClientId?`<button class="btn btn-grn btn-sm" onclick="activateClientFromReq(${req.id})"><i class="fa fa-user-plus"></i> Create Client Account</button>`:''}
</div>`;
  }).join('');
}

function openApproveRequisition(reqId){
  const req=DB.requisitions.find(x=>x.id===reqId);if(!req)return;
  const smmOpts=DB.users.filter(u=>u.role==='smm').map(u=>`<option value="${u.id}">${u.name}</option>`).join('');
  const creative=DB.users.filter(u=>!['owner','sales'].includes(u.role));
  showMo(`<div class="mt2">Review Requisition — ${req.clientName} <button class="mc2" onclick="closeMo()"><i class="fa fa-times"></i></button></div>
<div class="abox a-grn mb10"><i class="fa fa-info-circle"></i>Once approved, a client account will be created. Assign the right team members.</div>
<div class="tw mb12"><table><thead><tr><th>Service</th><th>Qty</th><th>Price</th><th>Total</th></tr></thead><tbody>
${(req.items||[]).map(item=>`<tr><td class="fw6">${item.service}</td><td class="mono">${item.qty}</td><td class="mono">${fmt(item.unitPrice)}</td><td class="mono fw7 tg">${fmt(item.qty*item.unitPrice)}</td></tr>`).join('')}
</tbody></table></div>
<div class="fr2"><div class="fg"><label class="flbl">Assign SMM / Account Manager *</label><select class="fsel" id="apr-smm"><option value="">— Select SMM —</option>${smmOpts}</select></div><div class="fg"><label class="flbl">Billing Cycle</label><select class="fsel" id="apr-billing"><option value="monthly" ${req.billingCycle==='monthly'?'selected':''}>Monthly</option><option value="one-time" ${req.billingCycle==='one-time'?'selected':''}>One-time</option><option value="quarterly">Quarterly</option></select></div></div>
<div class="fg"><label class="flbl">Assign Creative Team Members (multi-select)</label><div class="flex gap5" style="flex-wrap:wrap;border:1px solid var(--border);border-radius:var(--r);padding:10px;background:var(--bg)">
${creative.map(u=>`<label style="display:flex;align-items:center;gap:5px;font-size:11px;cursor:pointer;padding:3px 8px;border:1px solid var(--border);border-radius:20px;background:#fff"><input type="checkbox" id="apr-team-${u.id}" style="accent-color:var(--amber)"> ${avH(u.name,u.color,18,7)} ${u.name}</label>`).join('')}
</div></div>
<div class="fg"><label class="flbl">Admin Notes (optional)</label><textarea class="fta" id="apr-notes" style="min-height:44px" placeholder="Internal notes about this client setup…"></textarea></div>
<div class="mact"><button class="btn btn-o" onclick="closeMo()">Cancel</button><button class="btn btn-p" onclick="approveRequisition(${reqId})"><i class="fa fa-check-circle"></i> Approve & Set Up Client</button></div>`,true);
}
function approveRequisition(reqId){
  const req=DB.requisitions.find(x=>x.id===reqId);if(!req)return;
  const smmId=parseInt(document.getElementById('apr-smm')?.value)||null;
  if(!smmId&&DB.users.filter(u=>u.role==='smm').length>0){alert('Please assign an SMM');return;}
  const team=DB.users.filter(u=>!['owner','sales'].includes(u.role)&&document.getElementById('apr-team-'+u.id)?.checked).map(u=>u.id);
  const billing=document.getElementById('apr-billing')?.value||'monthly';
  req.assignedSMM=smmId;req.assignedTeam=team;req.billingCycle=billing;
  req.adminNotes=document.getElementById('apr-notes')?.value||'';
  req.status='approved';req.reviewedAt=new Date().toISOString().split('T')[0];req.reviewedBy=DB.currentUser.id;
  save();closeMo();
  // Notify SMM and team
  if(smmId)addNotif('🎯','#fce7f3',`You're assigned to new client: ${req.clientName} — review their requirements`);
  team.forEach(uid=>addNotif('📋','#dbeafe',`You're assigned to ${req.clientName} project — check task board`));
  addNotif('✅','#d1fae5',`Requisition approved: ${req.clientName}`);
  renderRequisitions();
}
function openRejectRequisition(reqId){
  const req=DB.requisitions.find(x=>x.id===reqId);if(!req)return;
  showMo(`<div class="mt2">Reject Requisition <button class="mc2" onclick="closeMo()"><i class="fa fa-times"></i></button></div>
<div class="fg"><label class="flbl">Reason for rejection</label><textarea class="fta" id="rej-reason" style="min-height:60px" placeholder="Tell the sales team why this is being rejected or what needs to change…"></textarea></div>
<div class="mact"><button class="btn btn-o" onclick="closeMo()">Cancel</button><button class="btn btn-red" onclick="rejectRequisition(${reqId})"><i class="fa fa-times"></i> Reject</button></div>`);
}
function rejectRequisition(reqId){
  const req=DB.requisitions.find(x=>x.id===reqId);if(!req)return;
  req.status='rejected';req.adminNotes=document.getElementById('rej-reason')?.value||'';
  req.reviewedAt=new Date().toISOString().split('T')[0];req.reviewedBy=DB.currentUser.id;
  addNotif('❌','#fee2e2',`Requisition rejected: ${req.clientName} — ${req.adminNotes.slice(0,60)}`);
  save();closeMo();renderRequisitions();
}
function activateClientFromReq(reqId){
  const req=DB.requisitions.find(x=>x.id===reqId);if(!req||req.convertedClientId)return;
  // Build services array from requisition items
  const services=req.items.map(item=>{
    // Try to match to existing service, else use first service as placeholder
    const svc=DB.services.find(s=>s.name.toLowerCase().includes(item.service.toLowerCase().split(' ')[0]))||null;
    return{serviceId:svc?svc.id:1,price:item.unitPrice,qty:item.qty,_customName:item.service};
  });
  const client={
    id:uid(),name:req.clientName,company:req.company,phone:req.phone,email:req.email,
    location:req.location,onboarded:new Date().toISOString().split('T')[0],
    status:'active',assignedSMM:req.assignedSMM,assignedSales:req.submittedBy,
    billingCycle:req.billingCycle,advance:req.advancePaid,services,notes:req.specialNotes,
    satisfactionScore:null,satisfactionHistory:[]
  };
  DB.clients.push(client);
  DB.clientChats[client.id]=[];DB.clientFiles[client.id]=[];
  req.convertedClientId=client.id;
  // Create initial tasks for each team member based on services
  req.assignedTeam.forEach(uid=>{
    const u=DB.users.find(x=>x.id===uid);if(!u)return;
    req.items.forEach(item=>{
      DB.tasks.push({id:uid(),title:item.service+' — '+req.clientName,clientId:client.id,assignedTo:uid,assignedBy:DB.currentUser.id,priority:'high',status:'pending',deadline:'',notes:item.notes||'',createdAt:new Date().toISOString().split('T')[0],serviceId:null,approvalStatus:null,approvalComments:[],parentTaskId:null,progress:[]});
    });
  });
  addNotif('🎉','#d1fae5',`Client activated: ${req.clientName} — account live!`);
  save();closeMo();renderRequisitions();
}


// ══════ SMM TASK BREAKDOWN ══════
function openBreakdownTask(taskId){
  const t=DB.tasks.find(x=>x.id===taskId);if(!t)return;
  const c=DB.clients.find(x=>x.id===t.clientId);
  const designers=DB.users.filter(u=>!['owner','sales','smm'].includes(u.role)&&u.active);
  const subs=getSubTasks(taskId);
  const totalQty=t.totalQty||10;
  const assignedQty=subs.reduce((s,st)=>s+(st.qty||0),0);
  let subsHtml='';
  if(subs.length){
    subsHtml='<div class="sect-t mb7" style="font-size:12px">Current Assignments ('+subs.length+')</div>';
    subs.forEach(function(st){
      const u=DB.users.find(x=>x.id===st.assignedTo);
      const lp=st.progress&&st.progress.slice(-1)[0];
      subsHtml+='<div class="flex ic gap8 mb6" style="padding:7px;background:var(--bg);border-radius:var(--r)">'+avH(u?.name,u?.color,24,9)+'<div class="f1"><div class="fw6 fs12">'+(u?.name||'?')+'</div><div class="fs11" style="color:var(--t3)">'+(st.qty||'?')+' items · due '+fmtD(st.deadline)+'</div>'+(lp?'<div class="fs11 tg">Progress: '+lp.done+'/'+lp.total+'</div>':'')+'</div>'+taskStatusBadge(st)+'</div>';
    });
    subsHtml+='<div class="sep"></div>';
  }
  let rowsHtml='';
  designers.forEach(function(u){
    rowsHtml+='<div class="srvc-row" id="bd-row-'+u.id+'" style="margin-bottom:6px">'+avH(u.name,u.color,24,9)+'<label style="display:flex;align-items:center;gap:5px;font-size:12px;cursor:pointer;flex:1"><input type="checkbox" id="bd-chk-'+u.id+'" data-uid="'+u.id+'" style="accent-color:var(--amber)" onchange="bdToggle(this)"> '+u.name+'</label><input type="number" id="bd-qty-'+u.id+'" placeholder="Qty" min="1" disabled style="width:60px;border:1px solid var(--border);border-radius:5px;padding:4px 7px;font-size:12px" oninput="bdCalcRem()"><input type="date" id="bd-dl-'+u.id+'" style="border:1px solid var(--border);border-radius:5px;padding:4px 7px;font-size:12px" value="'+(t.deadline||'')+'"></div>';
  });
  showMo('<div class="mt2">Break Down Task <button class="mc2" onclick="closeMo()"><i class="fa fa-times"></i></button></div>'
    +'<div class="abox a-blu mb10"><i class="fa fa-info-circle"></i>Assign portions of "<strong>'+t.title.slice(0,35)+'</strong>" to multiple designers. Each gets their own task card on their dashboard.</div>'
    +subsHtml
    +'<div class="flex ic gap10 mb12"><label class="flbl" style="margin:0">Total items:</label><input type="number" id="bd-total" value="'+totalQty+'" style="width:70px;border:1px solid var(--border);border-radius:5px;padding:5px 8px;font-size:13px" oninput="bdCalcRem()"><div class="fs12 fw6" style="margin-left:8px">Remaining: <span id="bd-rem" class="mono fw8 tg">'+(totalQty-assignedQty)+'</span></div></div>'
    +'<div id="bd-rows">'+rowsHtml+'</div>'
    +'<div class="mact"><button class="btn btn-o" onclick="closeMo()">Cancel</button><button class="btn btn-p" onclick="saveBreakdown('+taskId+')"><i class="fa fa-code-branch"></i> Assign to Designers</button></div>',true);
}
function bdToggle(el){var uid=el.dataset.uid;var q=document.getElementById('bd-qty-'+uid);if(q)q.disabled=!el.checked;bdCalcRem();}
function bdCalcRem(){
  const total=parseInt(document.getElementById('bd-total')?.value)||0;
  let used=0;
  DB.users.filter(u=>!['owner','sales','smm'].includes(u.role)&&u.active).forEach(function(u){
    const chk=document.getElementById('bd-chk-'+u.id);
    if(chk&&chk.checked) used+=parseInt(document.getElementById('bd-qty-'+u.id)?.value)||0;
  });
  const rem=document.getElementById('bd-rem');
  if(rem){rem.textContent=total-used;rem.style.color=total-used>=0?'var(--green)':'var(--red)';}
}
function saveBreakdown(taskId){
  const t=DB.tasks.find(x=>x.id===taskId);if(!t)return;
  const total=parseInt(document.getElementById('bd-total')?.value)||0;
  const designers=DB.users.filter(u=>!['owner','sales','smm'].includes(u.role)&&u.active);
  let created=0;
  designers.forEach(function(u){
    const chk=document.getElementById('bd-chk-'+u.id);if(!chk||!chk.checked)return;
    const qty=parseInt(document.getElementById('bd-qty-'+u.id)?.value)||0;if(!qty)return;
    const dl=document.getElementById('bd-dl-'+u.id)?.value||t.deadline;
    const newTask={id:uid(),title:t.title+' ['+u.name.split(' ')[0]+' — '+qty+' items]',clientId:t.clientId,assignedTo:u.id,assignedBy:DB.currentUser.id,priority:t.priority||'medium',status:'pending',deadline:dl,notes:'Assigned by '+uname(DB.currentUser.id)+': '+qty+' items.\n'+(t.notes||''),serviceId:t.serviceId,approvalStatus:null,approvalComments:[],parentTaskId:taskId,progress:[],recurrence:{enabled:false},qty:qty,estimatedHours:null,scheduledDate:null,customStatus:''};
    DB.tasks.push(newTask);
    addNotif('📋','#dbeafe','"'+t.title.slice(0,20)+'" — '+qty+' items → '+u.name);
    created++;
  });
  if(!created){alert('Check at least one designer and enter a quantity.');return;}
  t.totalQty=total;save();closeMo();
  if(DB.currentPage==='tasks')renderTasks();
  else if(DB.currentPage==='dashboard')go('dashboard');
}

// ══════ CUSTOM STATUSES HELPERS ══════
function getClientStatuses(clientId){
  const custom=DB.customStatuses.filter(s=>s.clientId===parseInt(clientId));
  if(custom.length>0)return custom.sort((a,b)=>a.order-b.order);
  return DB.customStatuses.filter(s=>!s.clientId).sort((a,b)=>a.order-b.order);
}
function openManageStatuses(clientId){
  clientId=parseInt(clientId)||0;
  const c=DB.clients.find(x=>x.id===clientId);
  const list=DB.customStatuses.filter(s=>s.clientId===clientId);
  showMo('<div class="mt2">Workflow Stages — '+(c?.name||'Global Default')+' <button class="mc2" onclick="closeMo()"><i class="fa fa-times"></i></button></div>'
  +'<div class="abox a-blu mb10"><i class="fa fa-info-circle"></i>Define the columns that appear in the task board for this client. Each stage maps to a core status.</div>'
  +'<div id="cs-list">'+list.map((s,i)=>'<div class="srvc-row" style="margin-bottom:6px" id="csr-'+s.id+'"><input class="finp f1" id="cs-n-'+s.id+'" value="'+s.name+'" style="font-size:12px"><input type="color" id="cs-c-'+s.id+'" value="'+s.color+'" style="width:34px;height:34px;border:1px solid var(--border);border-radius:5px;cursor:pointer"><select class="fsel" id="cs-core-'+s.id+'" style="font-size:11px;padding:5px"><option value="pending" '+(s.core==='pending'?'selected':'')+'>→ Pending</option><option value="in_progress" '+(s.core==='in_progress'?'selected':'')+'>→ In Progress</option><option value="done_pending_review" '+(s.core==='done_pending_review'?'selected':'')+'>→ Review</option><option value="done" '+(s.core==='done'?'selected':'')+'>→ Done</option></select><button class="btn btn-xs btn-red" onclick="removeCSRow('+JSON.stringify(s.id)+','+clientId+')"><i class="fa fa-trash"></i></button></div>').join('')+'</div>'
  +'<button class="btn btn-sm btn-o mt8 mb12" onclick="addCSRow('+clientId+')"><i class="fa fa-plus"></i> Add Stage</button>'
  +'<div class="mact"><button class="btn btn-o" onclick="closeMo()">Cancel</button><button class="btn btn-p" onclick="saveCSRows('+clientId+')">Save Stages</button></div>');
}
function removeCSRow(sid,clientId){DB.customStatuses=DB.customStatuses.filter(x=>x.id!==sid);save();closeMo();openManageStatuses(clientId);}
function addCSRow(clientId){
  const wrap=document.getElementById('cs-list');if(!wrap)return;
  const id='new_'+uid();const row=document.createElement('div');row.className='srvc-row';row.style.marginBottom='6px';row.id='csr-'+id;
  row.innerHTML='<input class="finp f1" id="cs-n-'+id+'" placeholder="Stage name…" style="font-size:12px"><input type="color" id="cs-c-'+id+'" value="#3b82f6" style="width:34px;height:34px;border:1px solid var(--border);border-radius:5px;cursor:pointer"><select class="fsel" id="cs-core-'+id+'" style="font-size:11px;padding:5px"><option value="pending">→ Pending</option><option value="in_progress" selected>→ In Progress</option><option value="done_pending_review">→ Review</option><option value="done">→ Done</option></select><button class="btn btn-xs btn-red" onclick="removeParentRow(this)"><i class="fa fa-trash"></i></button>';
  wrap.appendChild(row);
}
function saveCSRows(clientId){
  DB.customStatuses=DB.customStatuses.filter(s=>s.clientId!==clientId);
  const rows=document.querySelectorAll('#cs-list .srvc-row');
  rows.forEach((row,i)=>{
    const rid=row.id.replace('csr-','');
    const name=document.getElementById('cs-n-'+rid)?.value?.trim();if(!name)return;
    DB.customStatuses.push({id:'cs_'+uid(),clientId:clientId,name,color:document.getElementById('cs-c-'+rid)?.value||'#64748b',order:i+1,core:document.getElementById('cs-core-'+rid)?.value||'in_progress'});
  });
  save();closeMo();if(DB.currentPage==='tasks')renderTasks();
}


// ══════ TEAM WORKLOAD ══════
function pgWorkload(){
  return '<div class="ph"><div><div class="ph-t">Team Workload</div><div class="ph-s">Weekly capacity & task distribution</div></div></div>'
  +'<div class="fbar mb12"><label>Week of:</label><input class="finp" type="date" id="wl-week" value="2025-05-19" onchange="renderWorkload()" style="width:auto"><label style="margin-left:10px">Hours/day:</label><select class="fsel" id="wl-cap" onchange="renderWorkload()" style="width:auto;padding:6px 10px;font-size:12px"><option value="8">8h (Full-time)</option><option value="6">6h</option><option value="4">4h (Part-time)</option></select></div>'
  +'<div id="wl-grid"></div>';
}
function renderWorkload(){
  const el=document.getElementById('wl-grid');if(!el)return;
  const weekStr=document.getElementById('wl-week')?.value||'2025-05-19';
  const capDay=parseInt(document.getElementById('wl-cap')?.value)||8;
  const weekCap=capDay*5;
  const wStart=new Date(weekStr);
  const days=[];
  for(let i=0;i<5;i++){const d=new Date(wStart);d.setDate(d.getDate()+i);days.push({date:d.toISOString().split('T')[0],lbl:d.toLocaleDateString('en-GB',{weekday:'short',day:'numeric'})});}
  const team=DB.users.filter(u=>!['owner','sales'].includes(u.role)&&u.active);
  let html='<div style="overflow-x:auto"><table style="width:100%;border-collapse:collapse;font-size:12px">';
  html+='<thead><tr><th style="padding:9px 12px;background:var(--bg);border-bottom:1px solid var(--border);text-align:left;min-width:150px">Member</th>';
  days.forEach(d=>{html+='<th style="padding:9px 10px;background:'+(d.date==='2025-05-23'?'var(--al)':'var(--bg)')+';border-bottom:1px solid var(--border);border-left:1px solid var(--border);text-align:center;min-width:110px;font-size:10px">'+d.lbl+'</th>';});
  html+='<th style="padding:9px 10px;background:var(--bg);border-left:1px solid var(--border);border-bottom:1px solid var(--border);text-align:center;font-size:10px">Total</th>';
  html+='<th style="padding:9px 10px;background:var(--bg);border-left:1px solid var(--border);border-bottom:1px solid var(--border);text-align:center;font-size:10px">Load</th></tr></thead><tbody>';
  team.forEach(u=>{
    const uTasks=DB.tasks.filter(t=>t.assignedTo===u.id&&t.status!=='done');
    const uMeets=DB.meetings.filter(m=>m.with.includes(u.id)&&m.status==='scheduled'&&days.some(d=>d.date===m.date));
    let totalH=0;
    const cells=days.map(d=>{
      const dt=uTasks.filter(t=>t.scheduledDate===d.date||(t.deadline===d.date&&!t.scheduledDate));
      const dm=uMeets.filter(m=>m.date===d.date);
      const tH=dt.reduce((s,t)=>s+(t.estimatedHours||0),0);
      const mH=dm.reduce((s,m)=>s+(m.duration||60)/60,0);
      const tot=tH+mH;totalH+=tot;
      const bg=tot===0?'':tot>=capDay?'var(--rb)':tot>=capDay*0.8?'var(--al)':'var(--gb)';
      const isToday=d.date==='2025-05-23';
      let cell='<td style="padding:6px 8px;border-left:1px solid var(--border);border-bottom:1px solid var(--border);text-align:center;background:'+(isToday?'#fefdf8':bg||'')+';vertical-align:top">';
      if(tot)cell+='<div style="font-weight:600;font-size:11px">'+Math.round(tot*10)/10+'h</div>';
      else cell+='<div style="color:var(--t4);font-size:10px">—</div>';
      dt.slice(0,2).forEach(t=>{cell+='<div style="font-size:9px;background:'+(t.priority==='high'?'#fee2e2':'var(--bg)')+';border-radius:3px;padding:1px 4px;margin-top:2px;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;max-width:90px" title="'+t.title+'">'+t.title.slice(0,13)+'</div>';});
      if(dt.length>2)cell+='<div style="font-size:9px;color:var(--t3)">+'+( dt.length-2)+' more</div>';
      dm.forEach(m=>{cell+='<div style="font-size:9px;background:#dbeafe;border-radius:3px;padding:1px 4px;margin-top:2px">🤝 '+(m.duration||60)+'min</div>';});
      cell+='</td>';return cell;
    });
    const p=Math.round(totalH/weekCap*100);const col=p>=100?'var(--red)':p>=80?'var(--amber)':'var(--green)';
    html+='<tr><td style="padding:8px 12px;border-bottom:1px solid var(--border)"><div class="flex ic gap8">'+avH(u.name,u.color,26,9)+'<div><div class="fw6 fs12">'+u.name+'</div><div class="fs10" style="color:var(--t3)">'+( DB.roles.find(r=>r.id===u.role)?.label||u.role)+'</div></div></div></td>';
    html+=cells.join('');
    html+='<td style="padding:6px 10px;border-left:1px solid var(--border);border-bottom:1px solid var(--border);text-align:center;font-weight:600;font-size:12px">'+Math.round(totalH*10)/10+'h</td>';
    html+='<td style="padding:6px 10px;border-left:1px solid var(--border);border-bottom:1px solid var(--border)"><div style="text-align:center;font-weight:700;font-size:12px;color:'+col+'">'+p+'%</div><div style="height:5px;background:var(--bg);border-radius:20px;margin-top:4px"><div style="width:'+Math.min(100,p)+'%;height:5px;border-radius:20px;background:'+col+'"></div></div></td></tr>';
  });
  html+='</tbody></table></div>';
  html+='<div class="g3 mt14"><div style="background:var(--gb);border-radius:var(--r);padding:9px;text-align:center;font-size:12px"><strong style="color:var(--gd)">🟢 Under 80%</strong> — Has capacity</div><div style="background:var(--al);border-radius:var(--r);padding:9px;text-align:center;font-size:12px"><strong style="color:var(--ad)">🟡 80–99%</strong> — Near full</div><div style="background:var(--rb);border-radius:var(--r);padding:9px;text-align:center;font-size:12px"><strong style="color:var(--rd)">🔴 100%+</strong> — Overloaded</div></div>';
  html+='<div class="abox a-blu mt12"><i class="fa fa-lightbulb"></i><div><strong>Tip:</strong> Set <em>Estimated Hours</em> and <em>Schedule Day</em> on tasks to populate this grid accurately.</div></div>';
  el.innerHTML=html;
}

// ══════ DAY PLANNER ══════
function pgDayPlan(){
  const creative=DB.users.filter(u=>!['owner','sales'].includes(u.role)&&u.active);
  const myId=DB.currentUser.id;
  return '<div class="ph"><div><div class="ph-t">Day Planner</div><div class="ph-s">Drag tasks to days — build your week</div></div><button class="btn btn-p" onclick="openAddTask()"><i class="fa fa-plus"></i> New Task</button></div>'
  +'<div class="fbar mb12"><label>Week:</label><input class="finp" type="date" id="dp-week" value="2025-05-19" onchange="renderDayPlan()" style="width:auto"><label style="margin-left:10px">Member:</label><select class="fsel" id="dp-user" onchange="renderDayPlan()" style="width:auto;padding:6px 10px;font-size:12px"><option value="'+myId+'" selected>My Tasks</option>'+creative.filter(u=>u.id!==myId).map(u=>'<option value="'+u.id+'">'+u.name+'</option>').join('')+'<option value="0">All Members</option></select></div>'
  +'<div class="g2" style="gap:14px;align-items:start"><div id="dp-board"></div><div><div class="sect-t mb8">📋 Unscheduled</div><div id="dp-unscheduled" style="background:var(--bg);border:1px solid var(--border);border-radius:var(--rlg);padding:12px;max-height:600px;overflow-y:auto"></div></div></div>';
}
function renderDayPlan(){
  const weekStr=document.getElementById('dp-week')?.value||'2025-05-19';
  const fu=parseInt(document.getElementById('dp-user')?.value)||0;
  const wStart=new Date(weekStr);
  const days=[];
  for(let i=0;i<7;i++){const d=new Date(wStart);d.setDate(d.getDate()+i);days.push({date:d.toISOString().split('T')[0],lbl:d.toLocaleDateString('en-GB',{weekday:'long',day:'numeric',month:'short'}),short:d.toLocaleDateString('en-GB',{weekday:'short'})});}
  let tasks=DB.tasks.filter(t=>t.status!=='done');
  if(fu>0)tasks=tasks.filter(t=>t.assignedTo===fu);
  else if(!isOwner())tasks=tasks.filter(t=>t.assignedTo===DB.currentUser.id||t.assignedBy===DB.currentUser.id);
  const sched=tasks.filter(t=>t.scheduledDate&&days.some(d=>d.date===t.scheduledDate));
  const unsched=tasks.filter(t=>!t.scheduledDate);
  const brd=document.getElementById('dp-board');
  const uns=document.getElementById('dp-unscheduled');
  if(!brd||!uns)return;
  let boardHtml='<div style="display:flex;flex-direction:column;gap:7px">';
  days.forEach(day=>{
    const dt=sched.filter(t=>t.scheduledDate===day.date);
    const dm=DB.meetings.filter(m=>m.date===day.date&&(fu>0?m.with.includes(fu):true)&&m.status!=='cancelled');
    const totH=dt.reduce((s,t)=>s+(t.estimatedHours||0),0);
    const isToday=day.date==='2025-05-23';
    let col='<div class="dp-col '+(isToday?'today':'')+'" id="dpd-'+day.date+'" ondragover="dpOver(this)" ondragleave="dpLeave(this)" ondrop="dropOnDayEvent(this,event)">';
    col+='<div style="font-size:11px;font-weight:700;margin-bottom:7px;display:flex;align-items:center;justify-content:space-between"><span>'+day.lbl+(isToday?' <span style="background:var(--amber);color:#fff;padding:0 5px;border-radius:3px;font-size:8px;margin-left:4px">TODAY</span>':'')+'</span>'+(totH?'<span style="font-size:10px;color:var(--t3)">'+totH+'h</span>':'')+'</div>';
    dm.forEach(m=>{col+='<div style="background:var(--pb);border-radius:4px;padding:3px 7px;font-size:10px;margin-bottom:3px;color:var(--pd)">🤝 '+(m.time||'')+' '+(m.clientName||'Meeting')+' ('+(m.duration||60)+'min)</div>';});
    dt.forEach(t=>{
      const u=DB.users.find(x=>x.id===t.assignedTo);
      col+='<div class="dp-chip '+(t.priority||'')+'" draggable="true" ondragstart="window._dtask='+t.id+'" onclick="openTaskDetail('+t.id+')" style="display:flex;align-items:center;gap:5px">'
        +'<span style="flex:1;overflow:hidden;text-overflow:ellipsis;white-space:nowrap">'+t.title.slice(0,22)+'</span>'
        +(t.estimatedHours?'<span style="font-size:9px;color:var(--t3)">'+t.estimatedHours+'h</span>':'')
        +(fu===0&&u?avH(u.name,u.color,14,6):'')
        +(t.recurrence?.enabled?'<span style="color:var(--teal);font-size:9px">↻</span>':'')
        +'</div>';
    });
    if(!dt.length&&!dm.length)col+='<div style="font-size:10px;color:var(--t4);text-align:center;padding:8px 0">Drop here</div>';
    col+='</div>';
    boardHtml+=col;
  });
  boardHtml+='</div>';
  brd.innerHTML=boardHtml;
  let unHtml='';
  if(!unsched.length){unHtml='<div class="empty" style="padding:14px"><i class="fa fa-check-circle"></i>All tasks scheduled!</div>';}
  else{unsched.forEach(t=>{const u=DB.users.find(x=>x.id===t.assignedTo);const c=DB.clients.find(x=>x.id===t.clientId);unHtml+='<div class="dp-chip '+(t.priority||'')+'" draggable="true" ondragstart="window._dtask='+t.id+'" onclick="openTaskDetail('+t.id+')" style="display:flex;align-items:center;gap:5px;margin-bottom:5px"><div style="flex:1"><div style="font-weight:600;overflow:hidden;text-overflow:ellipsis;white-space:nowrap">'+t.title.slice(0,26)+'</div><div style="font-size:9px;color:var(--t3);margin-top:1px">'+(c?.name||'?')+' · '+fmtD(t.deadline)+(t.estimatedHours?' · '+t.estimatedHours+'h':'')+'</div></div>'+(u?avH(u.name,u.color,18,7):'')+'</div>';});}
  uns.innerHTML=unHtml;
}
function dpOver(el){el.classList.add('dp-over');}
function dpLeave(el){el.classList.remove('dp-over');}
function dropOnDayEvent(el,e){el.style.borderColor='';var date=el.id.replace('dpd-','');dropOnDay(date,e);}
function dropOnDay(date,e){
  e.preventDefault();document.querySelectorAll('.dp-col').forEach(d=>d.classList.remove('drag-over'));
  const id=window._dtask;if(!id)return;
  const t=DB.tasks.find(x=>x.id===id);if(t){t.scheduledDate=date;save();addNotif('📅','#dbeafe','"'+t.title.slice(0,25)+'" scheduled → '+fmtD(date));renderDayPlan();}
  window._dtask=null;
}

// ══════ GOOGLE CALENDAR SYNC ══════
function pgGcal(){
  const cfg=DB.gcalConfig||{};
  const conCls=cfg.connected?'connected':'';
  const conTitle=cfg.connected?'Connected to Google Calendar':'Google Calendar';
  const conSub=cfg.connected?'Export buttons below will sync automatically':'Not connected — export works without setup';
  let html='<div class="ph"><div><div class="ph-t">Google Calendar</div><div class="ph-s">Export meetings & tasks to your calendar</div></div></div>';
  html+='<div class="gcal-connect-btn '+conCls+'">';
  html+='<div style="width:44px;height:44px;border-radius:50%;background:var(--rb);display:flex;align-items:center;justify-content:center;font-size:22px">G</div>';
  html+='<div style="flex:1"><div style="font-size:14px;font-weight:700">'+conTitle+'</div>';
  html+='<div style="font-size:12px;color:var(--t3)">'+conSub+'</div></div>';
  if(cfg.connected) html+='<button class="btn btn-sm btn-red" onclick="disconnectGcal()">Disconnect</button>';
  html+='</div>';
  if(!cfg.clientId){
    html+='<div class="abox a-amb mt14 mb14"><i class="fa fa-key fa-lg"></i><div><div class="fw7 mb6">First-time Setup — Google Client ID Required</div>';
    html+='<div class="fs12 mb10">You need a free Google Cloud project for live 2-way sync. The ICS export below works immediately with no setup.</div>';
    html+='<div class="fg mb8"><label class="flbl">Google OAuth Client ID</label><input class="finp" id="gcal-cid" placeholder="12345.apps.googleusercontent.com" style="font-size:12px"></div>';
    html+='<button class="btn btn-p btn-sm" onclick="saveGcalId()"><i class="fa fa-save"></i> Save Client ID</button></div></div>';
  }
  html+='<div class="g2 mt14">';
  html+='<div class="card"><div class="sect-t mb10">📥 Export Meetings (.ics)</div>';
  html+='<div class="fs12 mb10" style="color:var(--t2);line-height:1.6">Download your DMS meetings as a calendar file. Import into Google Calendar, Outlook, or Apple Calendar.</div>';
  html+='<div class="fs11 mb12" style="color:var(--t3)">'+DB.meetings.length+' meetings available</div>';
  html+='<button class="btn btn-p" onclick="exportMeetingsICS()"><i class="fa fa-download"></i> Download Meetings (.ics)</button></div>';
  html+='<div class="card"><div class="sect-t mb10">📥 Export Task Deadlines (.ics)</div>';
  html+='<div class="fs12 mb10" style="color:var(--t2);line-height:1.6">Export all task deadlines as all-day calendar events to see team workload in Google Calendar.</div>';
  html+='<div class="fs11 mb12" style="color:var(--t3)">'+DB.tasks.filter(function(t){return t.deadline&&t.status!=='done';}).length+' active tasks with deadlines</div>';
  html+='<button class="btn btn-p" onclick="exportTasksICS()"><i class="fa fa-download"></i> Download Tasks (.ics)</button></div></div>';
  html+='<div class="card mt14"><div class="sect-t mb12">📖 How to Import into Google Calendar</div>';
  var steps=['Go to <a href="https://calendar.google.com" target="_blank" style="color:var(--blue)">calendar.google.com</a>','Click the ⚙️ gear → <strong>Settings</strong>','Left sidebar → <strong>Import & Export</strong>','Click <strong>Select file</strong> → choose the .ics file','Select which calendar to add events to','Click <strong>Import</strong>'];
  steps.forEach(function(s,i){html+='<div class="flex ic gap10 mb10"><div class="step-num">'+(i+1)+'</div><div class="fs12">'+s+'</div></div>';});
  html+='</div>';
  html+='<div class="card mt14"><div class="sect-t mb12">🔧 Google Cloud Setup (for live sync)</div>';
  var setup=['Go to <a href="https://console.cloud.google.com" target="_blank" style="color:var(--blue)">console.cloud.google.com</a>','Enable <strong>Google Calendar API</strong>','Create OAuth 2.0 credentials → Web application','Add your website URL to authorized origins','Copy the Client ID and paste it above'];
  setup.forEach(function(s,i){html+='<div class="flex ic gap10 mb9"><div class="step-num">'+(i+1)+'</div><div class="fs12">'+s+'</div></div>';});
  html+='</div>';
  return html;
}

function saveGcalId(){const id=document.getElementById('gcal-cid')?.value?.trim();if(!id)return;DB.gcalConfig.clientId=id;save();go('gcal');}
function exportMeetingsICS(){
  const lines=['BEGIN:VCALENDAR','VERSION:2.0','PRODID:-//DMS CRM//EN','CALSCALE:GREGORIAN'];
  DB.meetings.forEach(m=>{
    if(!m.date)return;
    const dt=m.date.replace(/-/g,'');
    const tm=(m.time||'09:00').replace(':','');
    const endH=String(parseInt(tm.slice(0,2))+Math.floor((m.duration||60)/60)).padStart(2,'0');
    const endM=String((parseInt(tm.slice(2,4))+(m.duration||60)%60)%60).padStart(2,'0');
    lines.push('BEGIN:VEVENT','DTSTART:'+dt+'T'+tm+'00','DTEND:'+dt+'T'+endH+endM+'00','SUMMARY:'+(m.clientName||'Meeting')+' — '+(m.agenda||'DMS Meeting'),'DESCRIPTION:Attendees: '+m.with.map(uid=>uname(uid)).join(', ')+'\\nOutcome: '+(m.outcome||'—')+'\\nNext: '+(m.nextAction||'—'),'LOCATION:'+(m.location||''),'STATUS:'+(m.status==='completed'?'CONFIRMED':'TENTATIVE'),'UID:dms-meet-'+m.id+'@dmscrm','END:VEVENT');
  });
  lines.push('END:VCALENDAR');
  const blob=new Blob([lines.join('\r\n')],{type:'text/calendar'});
  const a=document.createElement('a');a.href=URL.createObjectURL(blob);a.download='DMS_Meetings.ics';a.click();
  addNotif('📥','#dbeafe','Meetings exported — import the .ics file into Google Calendar');
}
function exportTasksICS(){
  const lines=['BEGIN:VCALENDAR','VERSION:2.0','PRODID:-//DMS CRM//EN','CALSCALE:GREGORIAN'];
  DB.tasks.filter(t=>t.deadline&&t.status!=='done').forEach(t=>{
    const dt=t.deadline.replace(/-/g,'');
    const c=DB.clients.find(x=>x.id===t.clientId);
    lines.push('BEGIN:VEVENT','DTSTART;VALUE=DATE:'+dt,'DTEND;VALUE=DATE:'+dt,'SUMMARY:'+t.title+' — '+(c?.name||'?'),'DESCRIPTION:Assigned to: '+uname(t.assignedTo)+'\\nPriority: '+t.priority+(t.estimatedHours?'\\nEst: '+t.estimatedHours+'h':'')+'\\nNotes: '+(t.notes||'—')+(t.recurrence?.enabled?'\\nRecurring: '+t.recurrence.type:''),'STATUS:'+(t.status==='done_pending_review'?'CONFIRMED':'NEEDS-ACTION'),'UID:dms-task-'+t.id+'@dmscrm','END:VEVENT');
  });
  lines.push('END:VCALENDAR');
  const blob=new Blob([lines.join('\r\n')],{type:'text/calendar'});
  const a=document.createElement('a');a.href=URL.createObjectURL(blob);a.download='DMS_Tasks.ics';a.click();
  addNotif('📥','#dbeafe','Task deadlines exported — import the .ics file into Google Calendar');
}

// ══════ NOTIFICATIONS ══════
function toggleNP(){const p=document.getElementById('np');p.classList.toggle('on');if(p.classList.contains('on'))renderNP();}
function closeNP(){document.getElementById('np')?.classList.remove('on');}
function markAllRead(){DB.notifications.forEach(n=>n.read=true);save();updNB();renderNP();}
function renderNP(){const el=document.getElementById('np-list');if(!el)return;el.innerHTML=DB.notifications.filter(n=>!n.adminOnly||isOwner()).slice(0,9).map(n=>`<div class="ni ${n.read?'':'unread'}" onclick="n.read=true;save();updNB();renderNP()"><div style="width:28px;height:28px;border-radius:6px;display:flex;align-items:center;justify-content:center;font-size:13px;background:${n.bg||'var(--al)'};flex-shrink:0">${n.icon||'🔔'}</div><div class="f1" style="margin-left:7px"><div class="fs12 fw6" style="line-height:1.4">${n.msg}</div><div class="fs11" style="color:var(--t3);margin-top:2px">${n.time}</div></div></div>`).join('')||'<div class="empty" style="padding:14px">All caught up!</div>';}

// ══════ MODAL ══════
function showMo(html,lg=false){const mo=document.getElementById('mo');const mb=document.getElementById('mb');if(!mo||!mb)return;mb.className='mb'+(lg?' mb-lg':'');mb.innerHTML=html;mo.style.display='flex';}
function closeMo(){document.getElementById('mo').style.display='none';}

// fcard CSS is in the main stylesheet

// ══════ INIT ══════
document.addEventListener('click',e=>{if(!document.getElementById('np')?.contains(e.target)&&!document.getElementById('nb-btn')?.contains(e.target))closeNP();});
window.addEventListener('load', async () => {
    load();
    if (!window.CURRENT_USER) {
        showLoginScreen();
        return;
    }
    try {
        await loadFromAPI();
        initApp();
    } catch (e) {
        console.error('API sync failed or unauthorized', e);
        if (e.message && (e.message.includes('401') || e.message.includes('419') || e.message.includes('Unauthenticated'))) {
            showLoginScreen();
        } else {
            const appEl = document.getElementById('app');
            if (appEl) {
                appEl.innerHTML = `<div style="padding: 20px; color: #ef4444; background: #fee2e2; border: 1px solid #ef4444; border-radius: 8px; margin: 20px; font-family: sans-serif;">
                    <h3 style="margin-bottom: 8px;">Application Load Error</h3>
                    <p style="font-family: monospace; font-size: 12px; margin-top: 10px; white-space: pre-wrap; background: #fff; padding: 10px; border-radius: 4px; border: 1px solid #fecaca; color: #7f1d1d;">${e.stack || e.message || e}</p>
                    <p style="margin-top: 12px; font-size: 11px; color: #64748b;">This is a front-end script crash. Please copy this error and report it.</p>
                </div>`;
                const loading = document.getElementById('loading-screen');
                if (loading) loading.style.display = 'none';
                appEl.classList.add('on');
            } else {
                alert('JS Crash: ' + (e.stack || e.message || e));
            }
        }
    }
});

@endverbatim
</script>
</body>
</html>
