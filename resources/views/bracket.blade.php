<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>2026 NCAA Bracket</title>
<style>
* { box-sizing: border-box; margin: 0; padding: 0; }
body { font-family: 'Segoe UI', sans-serif; background: #0a0e1a; color: #e0e6f0; min-height: 100vh; }

nav { display: flex; gap: 20px; justify-content: center; padding: 14px; border-bottom: 1px solid #1e2d4a; }
nav a { color: #90adc4; text-decoration: none; font-size: 0.88em; letter-spacing: 1px; text-transform: uppercase; }
nav a.active { color: #f0b429; border-bottom: 2px solid #f0b429; padding-bottom: 2px; }

h1 { text-align: center; padding: 18px 10px 4px; color: #f0b429; font-size: 1.4em; letter-spacing: 1px; }
#status { text-align: center; padding: 6px 12px; color: #90adc4; font-size: 0.8em; min-height: 22px; }
#odds-note { text-align: center; color: #50d0a0; font-size: 0.75em; min-height: 18px; padding-bottom: 4px; padding: 0 12px 4px; }

.legend { display: flex; gap: 14px; justify-content: center; padding: 6px; font-size: 0.75em; color: #6080a0; flex-wrap: wrap; }
.legend span { display: flex; align-items: center; gap: 4px; }
.dot { width: 9px; height: 9px; border-radius: 50%; flex-shrink: 0; }
.dot-win { background: #2a5a2a; } .dot-upset { background: #8b0000; } .dot-odds { background: #50d0a0; }

/* --- Button row --- */
.btn-row { display: flex; gap: 8px; justify-content: center; margin: 8px 0; flex-wrap: wrap; padding: 0 12px; }
.resim-btn { padding: 8px 20px; background: #f0b429; color: #0a0e1a; border: none; border-radius: 6px; font-weight: bold; cursor: pointer; font-size: 0.85em; }
.resim-btn:hover { background: #ffd166; }
.odds-btn { padding: 8px 20px; background: #1a3a2a; color: #50d0a0; border: 1px solid #50d0a0; border-radius: 6px; font-weight: bold; cursor: pointer; font-size: 0.85em; }
.odds-btn:hover { background: #1f4a35; }
.odds-btn.active { background: #50d0a0; color: #0a0e1a; }
.view-toggle { display: flex; background: #0d1525; border: 1px solid #2a3a5a; border-radius: 6px; overflow: hidden; }
.view-toggle button { padding: 8px 16px; background: none; border: none; color: #6080a0; cursor: pointer; font-size: 0.82em; font-weight: bold; }
.view-toggle button.active { background: #1e3050; color: #f0b429; }

.model-note { text-align: center; color: #3a5070; font-size: 0.68em; padding: 4px 12px 14px; }

/* ===================== BRACKET VIEW ===================== */
#bracket-wrap { overflow-x: auto; padding: 10px 10px 30px; -webkit-overflow-scrolling: touch; }
.scroll-hint { text-align: center; color: #3a5070; font-size: 0.72em; padding: 0 0 6px; display: none; }
@media (max-width: 1400px) { .scroll-hint { display: block; } }

.full-bracket { display: flex; gap: 6px; min-width: 1500px; align-items: flex-start; }
.side { display: flex; gap: 0; flex: 1; }
.side.right { flex-direction: row-reverse; }
.round-col { display: flex; flex-direction: column; width: 175px; flex-shrink: 0; }
.round-header { text-align: center; font-size: 0.72em; color: #6080a0; letter-spacing: 1px; text-transform: uppercase; padding: 4px 0 6px; font-weight: bold; }
.team-slot { display: flex; align-items: center; gap: 5px; padding: 5px 8px; background: #12192e; border: 1px solid #1e2d4a; margin: 1px 2px; border-radius: 4px; font-size: 0.8em; min-height: 30px; white-space: nowrap; overflow: hidden; }
.team-slot.winner { background: #0f2010; border-color: #2a5a2a; }
.team-slot.loser { opacity: 0.3; }
.team-slot.upset-winner { background: #2a0808; border-color: #8b2020; }
.seed { color: #6080b0; font-size: 0.9em; min-width: 16px; text-align: right; flex-shrink: 0; font-weight: bold; }
.tname { flex: 1; overflow: hidden; text-overflow: ellipsis; font-weight: 500; }
.elo-val { color: #c09020; font-size: 0.78em; flex-shrink: 0; }
.odds-val { color: #50d0a0; font-size: 0.72em; flex-shrink: 0; font-weight: bold; }
.upset-tag { background: #8b0000; color: #ffaaaa; font-size: 0.6em; padding: 1px 3px; border-radius: 2px; flex-shrink: 0; }
.center-col { display: flex; flex-direction: column; align-items: center; width: 210px; flex-shrink: 0; padding-top: 28px; }
.ff-label { color: #f0b429; font-weight: bold; font-size: 0.8em; letter-spacing: 2px; text-align: center; margin: 10px 0 4px; }
.ff-game { background: #0d1525; border: 1px solid #2a3a5a; border-radius: 6px; padding: 8px; width: 100%; margin-bottom: 6px; }
.ff-sublabel { font-size: 0.65em; color: #4a6080; text-align: center; margin-bottom: 4px; }
.champ-box { background: #0d1525; border: 2px solid #f0b429; border-radius: 8px; padding: 12px; width: 100%; margin-top: 10px; }
.champ-footer { margin-top: 10px; border-top: 1px solid #2a3a5a; padding-top: 8px; text-align: center; }
.reg-div { text-align: center; font-size: 0.65em; color: #f0b429; font-weight: bold; letter-spacing: 1px; padding: 4px 0 2px; border-top: 1px solid #1e2d4a; margin-top: 3px; }

/* ===================== ROUNDS VIEW ===================== */
#rounds-wrap { padding: 10px 12px 40px; display: none; }

.round-tabs { display: flex; overflow-x: auto; gap: 4px; padding-bottom: 12px; -webkit-overflow-scrolling: touch; scrollbar-width: none; }
.round-tabs::-webkit-scrollbar { display: none; }
.round-tab { flex-shrink: 0; padding: 7px 14px; background: #0d1525; border: 1px solid #2a3a5a; border-radius: 20px; font-size: 0.78em; color: #6080a0; cursor: pointer; white-space: nowrap; font-weight: bold; }
.round-tab.active { background: #f0b429; color: #0a0e1a; border-color: #f0b429; }

.round-games { display: flex; flex-direction: column; gap: 10px; }
.region-section { background: #0d1525; border: 1px solid #1e2d4a; border-radius: 8px; overflow: hidden; }
.region-label { padding: 8px 14px; font-size: 0.72em; color: #f0b429; font-weight: bold; letter-spacing: 1px; text-transform: uppercase; background: #0a1020; border-bottom: 1px solid #1e2d4a; }
.matchup-card { display: flex; flex-direction: column; border-bottom: 1px solid #1e2d4a; }
.matchup-card:last-child { border-bottom: none; }
.m-team { display: flex; align-items: center; gap: 8px; padding: 10px 14px; font-size: 0.9em; }
.m-team.winner { background: #0f2010; }
.m-team.loser { opacity: 0.35; }
.m-team.upset-winner { background: #2a0808; }
.m-seed { color: #6080b0; font-weight: bold; min-width: 22px; text-align: right; font-size: 0.95em; }
.m-name { flex: 1; font-weight: 500; }
.m-record { color: #5070a0; font-size: 0.78em; }
.m-odds { color: #50d0a0; font-size: 0.78em; font-weight: bold; }
.m-elo { color: #c09020; font-size: 0.78em; }
.m-upset { background: #8b0000; color: #ffaaaa; font-size: 0.62em; padding: 1px 5px; border-radius: 3px; }
.matchup-divider { height: 1px; background: #1e2d4a; margin: 0 14px; }

/* ===================== RESPONSIVE ===================== */
@media (max-width: 700px) {
  h1 { font-size: 1.1em; padding: 14px 8px 4px; }
  .btn-row { gap: 6px; }
  .resim-btn, .odds-btn { padding: 7px 14px; font-size: 0.8em; }
  .view-toggle button { padding: 7px 12px; font-size: 0.78em; }
}
</style>
</head>
<body>

<nav>
  <a href="/" class="active">🏀 Bracket</a>
  <a href="/how-it-works">📖 How It Works</a>
</nav>

<h1>🏀 2026 NCAA Men's Basketball Championship</h1>
<div id="status"></div>

<div class="legend">
  <span><span class="dot dot-win"></span> Winner</span>
  <span><span class="dot dot-upset"></span> Upset</span>
  <span>★ = Elo</span>
  <span><span class="dot dot-odds"></span> Champ %</span>
</div>

<div class="btn-row">
  <button class="resim-btn" onclick="resim()">🔄 Re-Simulate</button>
  <button class="odds-btn" id="oddsBtn" onclick="toggleOdds()">📊 Show Championship Odds</button>
  <div class="view-toggle">
    <button id="btnBracket" onclick="setView('bracket')" class="active">🗂 Bracket</button>
    <button id="btnRounds" onclick="setView('rounds')">📋 Rounds</button>
  </div>
</div>
<div id="odds-note"></div>

<div class="scroll-hint">← Scroll to see full bracket →</div>
<div id="bracket-wrap"></div>
<div id="rounds-wrap">
  <div class="round-tabs" id="round-tabs"></div>
  <div class="round-games" id="round-games"></div>
</div>

<div class="model-note">Model: Win% (70%) · Seed strength (20%) · Upset factor (10%) · Based on 2025-26 records & seeds</div>

<script>
const RAW = {
  east: [
    {seed:1,  name:"Duke",             w:32, l:2},
    {seed:16, name:"Siena",            w:23, l:11},
    {seed:8,  name:"Ohio St.",         w:21, l:12},
    {seed:9,  name:"TCU",              w:22, l:11},
    {seed:5,  name:"St. John's",       w:28, l:6},
    {seed:12, name:"Northern Iowa",    w:23, l:12},
    {seed:4,  name:"Kansas",           w:23, l:10},
    {seed:13, name:"Cal Baptist",      w:25, l:8},
    {seed:6,  name:"Louisville",       w:23, l:10},
    {seed:11, name:"South Florida",    w:25, l:8},
    {seed:3,  name:"Michigan St.",     w:25, l:7},
    {seed:14, name:"N. Dakota St.",    w:27, l:7},
    {seed:7,  name:"UCLA",             w:23, l:11},
    {seed:10, name:"UCF",              w:21, l:11},
    {seed:2,  name:"UConn",            w:29, l:5},
    {seed:15, name:"Furman",           w:22, l:12},
  ],
  west: [
    {seed:1,  name:"Arizona",          w:32, l:2},
    {seed:16, name:"Long Island",      w:24, l:10},
    {seed:8,  name:"Villanova",        w:24, l:8},
    {seed:9,  name:"Utah St.",         w:28, l:6},
    {seed:5,  name:"Wisconsin",        w:24, l:10},
    {seed:12, name:"High Point",       w:30, l:4},
    {seed:4,  name:"Arkansas",         w:26, l:8},
    {seed:13, name:"Hawaii",           w:24, l:8},
    {seed:6,  name:"BYU",              w:23, l:11},
    {seed:11, name:"Texas",            w:19, l:14},
    {seed:3,  name:"Gonzaga",          w:30, l:3},
    {seed:14, name:"Kennesaw St.",     w:21, l:13},
    {seed:7,  name:"Miami FL",         w:25, l:8},
    {seed:10, name:"Missouri",         w:20, l:12},
    {seed:2,  name:"Purdue",           w:27, l:8},
    {seed:15, name:"Queens NC",        w:21, l:13},
  ],
  south: [
    {seed:1,  name:"Florida",          w:26, l:7},
    {seed:16, name:"Prairie View",     w:19, l:17},
    {seed:8,  name:"Clemson",          w:24, l:10},
    {seed:9,  name:"Iowa",             w:21, l:12},
    {seed:5,  name:"Vanderbilt",       w:26, l:8},
    {seed:12, name:"McNeese",          w:28, l:5},
    {seed:4,  name:"Nebraska",         w:26, l:6},
    {seed:13, name:"Troy",             w:22, l:11},
    {seed:6,  name:"North Carolina",   w:24, l:8},
    {seed:11, name:"VCU",              w:27, l:7},
    {seed:3,  name:"Illinois",         w:24, l:8},
    {seed:14, name:"Penn",             w:18, l:11},
    {seed:7,  name:"Saint Mary's",     w:27, l:5},
    {seed:10, name:"Texas A&M",        w:21, l:11},
    {seed:2,  name:"Houston",          w:28, l:6},
    {seed:15, name:"Idaho",            w:21, l:14},
  ],
  midwest: [
    {seed:1,  name:"Michigan",         w:31, l:3},
    {seed:16, name:"Howard",           w:24, l:10},
    {seed:8,  name:"Georgia",          w:22, l:10},
    {seed:9,  name:"Saint Louis",      w:28, l:5},
    {seed:5,  name:"Texas Tech",       w:22, l:10},
    {seed:12, name:"Akron",            w:29, l:5},
    {seed:4,  name:"Alabama",          w:23, l:9},
    {seed:13, name:"Hofstra",          w:24, l:10},
    {seed:6,  name:"Tennessee",        w:22, l:11},
    {seed:11, name:"Miami OH",         w:32, l:1},
    {seed:3,  name:"Virginia",         w:29, l:5},
    {seed:14, name:"Wright St.",       w:23, l:11},
    {seed:7,  name:"Kentucky",         w:21, l:13},
    {seed:10, name:"Santa Clara",      w:26, l:8},
    {seed:2,  name:"Iowa St.",         w:27, l:7},
    {seed:15, name:"Tennessee St.",    w:23, l:9},
  ]
};

const SEED_BASE = {1:1840,2:1760,3:1710,4:1665,5:1625,6:1595,7:1565,8:1535,9:1515,10:1492,11:1472,12:1448,13:1398,14:1358,15:1315,16:1268};

let championshipOdds = {};
let showOdds = false;
let currentView = window.innerWidth < 700 ? 'rounds' : 'bracket';
let lastSim = null;

function calcElo(t) {
  const base = SEED_BASE[t.seed] || 1300;
  const winPct = t.w / (t.w + t.l);
  const winBonus = (winPct - 0.60) * 200;
  const gamesBonus = Math.min((t.w + t.l - 25) * 1.5, 15);
  return Math.round(base + winBonus + gamesBonus);
}

function buildTeams() {
  const out = {};
  for (const [reg, teams] of Object.entries(RAW)) {
    out[reg] = teams.map(t => ({...t, elo: calcElo(t)}));
  }
  return out;
}

const R1_PAIRS = [[0,1],[2,3],[4,5],[6,7],[8,9],[10,11],[12,13],[14,15]];

function simGame(a, b, rnd) {
  const pA = 1 / (1 + Math.exp(-(a.elo - b.elo) / 120));
  const gap = Math.max(a.seed, b.seed) - Math.min(a.seed, b.seed);
  const upsetProb = rnd <= 1 ? (gap===5?0.20 : gap===6?0.18 : gap===7?0.15 : gap===4?0.14 : 0) : 0;
  let winner, loser, isUpset = false;
  if (upsetProb > 0 && Math.random() < upsetProb) {
    isUpset = true;
    const dog = a.seed > b.seed ? a : b;
    const fav = a.seed < b.seed ? a : b;
    winner = {...dog, upset: true};
    loser = fav;
  } else {
    const aWins = Math.random() < pA;
    winner = {...(aWins ? a : b)};
    loser = aWins ? b : a;
  }
  return {winner, loser, isUpset};
}

function simRegion(teams) {
  const r1  = R1_PAIRS.map(([i,j]) => simGame(teams[i], teams[j], 0));
  const r2  = [[0,1],[2,3],[4,5],[6,7]].map(([i,j]) => simGame(r1[i].winner, r1[j].winner, 1));
  const s16 = [[0,1],[2,3]].map(([i,j]) => simGame(r2[i].winner, r2[j].winner, 2));
  const e8  = [simGame(s16[0].winner, s16[1].winner, 3)];
  return {r1, r2, s16, e8, winner: e8[0].winner};
}

function runSims(n) {
  const counts = {};
  for (let i = 0; i < n; i++) {
    const teams = buildTeams();
    const sim = {};
    for (const [reg, ts] of Object.entries(teams)) sim[reg] = simRegion(ts);
    const ff1   = simGame(sim.east.winner,  sim.west.winner,    4);
    const ff2   = simGame(sim.south.winner, sim.midwest.winner, 4);
    const champ = simGame(ff1.winner, ff2.winner, 5);
    counts[champ.winner.name] = (counts[champ.winner.name] || 0) + 1;
  }
  const odds = {};
  for (const name in counts) odds[name] = Math.round(counts[name] / n * 100);
  return odds;
}

function toggleOdds() {
  if (!showOdds) {
    document.getElementById('odds-note').textContent = 'Running 2,000 simulations…';
    setTimeout(() => {
      championshipOdds = runSims(2000);
      showOdds = true;
      document.getElementById('oddsBtn').classList.add('active');
      document.getElementById('oddsBtn').textContent = '✅ Odds On — Click to Hide';
      const top = Object.entries(championshipOdds).sort((a,b) => b[1]-a[1]).slice(0,3)
        .map(([n,p]) => `${n} ${p}%`).join(' · ');
      document.getElementById('odds-note').textContent = `Top picks: ${top} — green % = chance to win it all`;
      render();
    }, 10);
  } else {
    showOdds = false;
    document.getElementById('oddsBtn').classList.remove('active');
    document.getElementById('oddsBtn').textContent = '📊 Show Championship Odds';
    document.getElementById('odds-note').textContent = '';
    render();
  }
}

function setView(v) {
  currentView = v;
  document.getElementById('btnBracket').classList.toggle('active', v === 'bracket');
  document.getElementById('btnRounds').classList.toggle('active', v === 'rounds');
  document.getElementById('bracket-wrap').style.display = v === 'bracket' ? 'block' : 'none';
  document.getElementById('rounds-wrap').style.display  = v === 'rounds'  ? 'block' : 'none';
  document.querySelector('.scroll-hint').style.display  = v === 'bracket' ? '' : 'none';
  if (lastSim) renderRounds(lastSim.sim, lastSim.ff1, lastSim.ff2, lastSim.champ);
}

// ==================== BRACKET RENDER ====================
function slotEl(t, win) {
  const d = document.createElement("div");
  d.className = "team-slot" + (win ? (t.upset ? " upset-winner" : " winner") : " loser");
  const odds = showOdds && championshipOdds[t.name] ? championshipOdds[t.name] : null;
  const oddsHtml = odds ? `<span class="odds-val">${odds}%</span>` : '';
  d.innerHTML = `<span class="seed">${t.seed}</span><span class="tname">${t.name}</span>${t.upset?'<span class="upset-tag">UPSET</span>':''}${oddsHtml}<span class="elo-val">★${t.elo}</span>`;
  return d;
}
function gameEl(g) {
  const d = document.createElement("div"); d.style.margin = "2px 0";
  d.appendChild(slotEl(g.winner, true)); d.appendChild(slotEl(g.loser, false));
  return d;
}
function hdr(txt) { const d=document.createElement("div"); d.className="round-header"; d.textContent=txt; return d; }
function sp(h) { const d=document.createElement("div"); d.style.height=h+"px"; return d; }
function regDiv(txt) { const d=document.createElement("div"); d.className="reg-div"; d.textContent=txt; return d; }

function buildSideCol(hdrTxt, topGames, topSpacer, topGapH, botGames, botSpacer, botGapH, topLbl, botLbl) {
  const col = document.createElement("div"); col.className="round-col";
  col.appendChild(hdr(hdrTxt));
  col.appendChild(regDiv(topLbl));
  col.appendChild(sp(topSpacer));
  topGames.forEach((g,i) => { col.appendChild(gameEl(g)); if(i<topGames.length-1) col.appendChild(sp(topGapH)); });
  col.appendChild(regDiv(botLbl));
  col.appendChild(sp(botSpacer));
  botGames.forEach((g,i) => { col.appendChild(gameEl(g)); if(i<botGames.length-1) col.appendChild(sp(botGapH)); });
  return col;
}

function renderBracket(sim, ff1, ff2, champ) {
  const wrap = document.getElementById("bracket-wrap");
  wrap.innerHTML = "";
  const full = document.createElement("div"); full.className="full-bracket";

  const left = document.createElement("div"); left.className="side";
  left.appendChild(buildSideCol("1st Round", sim.east.r1,  0, 4,  sim.south.r1,  6, 4,  "EAST","SOUTH"));
  left.appendChild(buildSideCol("2nd Round", sim.east.r2,  26,10, sim.south.r2,  32,10, "EAST","SOUTH"));
  left.appendChild(buildSideCol("Sweet 16",  sim.east.s16, 68,22, sim.south.s16, 74,22, "EAST","SOUTH"));
  left.appendChild(buildSideCol("Elite 8",   sim.east.e8,  148,0, sim.south.e8,  154,0, "EAST","SOUTH"));

  const right = document.createElement("div"); right.className="side right";
  right.appendChild(buildSideCol("1st Round", sim.west.r1,    0, 4,  sim.midwest.r1,    6, 4,  "WEST","MIDWEST"));
  right.appendChild(buildSideCol("2nd Round", sim.west.r2,    26,10, sim.midwest.r2,    32,10, "WEST","MIDWEST"));
  right.appendChild(buildSideCol("Sweet 16",  sim.west.s16,   68,22, sim.midwest.s16,   74,22, "WEST","MIDWEST"));
  right.appendChild(buildSideCol("Elite 8",   sim.west.e8,    148,0, sim.midwest.e8,    154,0, "WEST","MIDWEST"));

  const center = document.createElement("div"); center.className="center-col";
  const ffLbl = document.createElement("div"); ffLbl.className="ff-label"; ffLbl.textContent="🏟️ FINAL FOUR";
  center.appendChild(ffLbl);
  [["East vs West", ff1],["South vs Midwest", ff2]].forEach(([lbl,g]) => {
    const box = document.createElement("div"); box.className="ff-game";
    const sub = document.createElement("div"); sub.className="ff-sublabel"; sub.textContent=lbl;
    box.appendChild(sub); box.appendChild(gameEl(g)); center.appendChild(box);
  });

  const cLbl = document.createElement("div"); cLbl.className="ff-label"; cLbl.style.marginTop="14px"; cLbl.textContent="🏆 CHAMPIONSHIP";
  center.appendChild(cLbl);
  const cBox = document.createElement("div"); cBox.className="champ-box";
  cBox.appendChild(gameEl(champ));
  const cFoot = document.createElement("div"); cFoot.className="champ-footer";
  const co = showOdds && championshipOdds[champ.winner.name] ? ` · ${championshipOdds[champ.winner.name]}% odds` : '';
  cFoot.innerHTML=`<div style="color:#6080a0;font-size:0.68em;letter-spacing:2px;">2026 CHAMPION</div>
    <div style="color:#f0b429;font-size:1.2em;font-weight:bold;margin-top:3px;">${champ.winner.name}</div>
    <div style="color:#90adc4;font-size:0.75em;">Seed #${champ.winner.seed} · Elo ${champ.winner.elo}${co}</div>`;
  cBox.appendChild(cFoot); center.appendChild(cBox);
  full.appendChild(left); full.appendChild(center); full.appendChild(right);
  wrap.appendChild(full);
}

// ==================== ROUNDS RENDER ====================
const ROUND_DEFS = [
  { key: 'r1',   label: '1st Round' },
  { key: 'r2',   label: '2nd Round' },
  { key: 's16',  label: 'Sweet 16'  },
  { key: 'e8',   label: 'Elite 8'   },
  { key: 'ff',   label: 'Final Four'},
  { key: 'champ',label: 'Championship'},
];
const REGIONS = ['east','west','south','midwest'];
const REG_LABELS = {east:'East', west:'West', south:'South', midwest:'Midwest'};
let activeRoundKey = 'r1';

function mTeamEl(t, win) {
  const d = document.createElement("div");
  d.className = "m-team" + (win ? (t.upset ? " upset-winner" : " winner") : " loser");
  const odds = showOdds && championshipOdds[t.name] ? `<span class="m-odds">${championshipOdds[t.name]}%</span>` : '';
  d.innerHTML = `<span class="m-seed">${t.seed}</span>
    <span class="m-name">${t.name}</span>
    ${t.upset ? '<span class="m-upset">UPSET</span>' : ''}
    <span class="m-record">${t.w}-${t.l}</span>
    ${odds}
    <span class="m-elo">★${t.elo}</span>`;
  return d;
}

function mGameEl(g) {
  const card = document.createElement("div"); card.className = "matchup-card";
  card.appendChild(mTeamEl(g.winner, true));
  const div = document.createElement("div"); div.className = "matchup-divider";
  card.appendChild(div);
  card.appendChild(mTeamEl(g.loser, false));
  return card;
}

function renderRounds(sim, ff1, ff2, champ) {
  // Build tabs
  const tabsEl = document.getElementById('round-tabs');
  tabsEl.innerHTML = '';
  ROUND_DEFS.forEach(({key, label}) => {
    const btn = document.createElement("button");
    btn.className = "round-tab" + (key === activeRoundKey ? " active" : "");
    btn.textContent = label;
    btn.onclick = () => { activeRoundKey = key; renderRounds(sim, ff1, ff2, champ); };
    tabsEl.appendChild(btn);
  });

  const gamesEl = document.getElementById('round-games');
  gamesEl.innerHTML = '';

  if (activeRoundKey === 'ff') {
    const section = document.createElement("div"); section.className = "region-section";
    const lbl = document.createElement("div"); lbl.className = "region-label"; lbl.textContent = "Final Four";
    section.appendChild(lbl);
    [["East vs West", ff1], ["South vs Midwest", ff2]].forEach(([matchupLbl, g]) => {
      const sub = document.createElement("div");
      sub.style.cssText = "font-size:0.72em;color:#4a6080;padding:8px 14px 0;text-transform:uppercase;letter-spacing:1px;";
      sub.textContent = matchupLbl;
      section.appendChild(sub);
      section.appendChild(mGameEl(g));
    });
    gamesEl.appendChild(section);
    return;
  }

  if (activeRoundKey === 'champ') {
    const section = document.createElement("div"); section.className = "region-section";
    const lbl = document.createElement("div"); lbl.className = "region-label"; lbl.textContent = "🏆 Championship Game";
    section.appendChild(lbl);
    section.appendChild(mGameEl(champ));
    const foot = document.createElement("div");
    const co = showOdds && championshipOdds[champ.winner.name] ? ` · ${championshipOdds[champ.winner.name]}% odds` : '';
    foot.style.cssText = "text-align:center;padding:12px;color:#f0b429;font-weight:bold;font-size:1em;";
    foot.innerHTML = `🏆 2026 Champion: ${champ.winner.name}<br><span style="color:#90adc4;font-size:0.78em;font-weight:normal;">Seed #${champ.winner.seed} · ${champ.winner.w}-${champ.winner.l}${co}</span>`;
    section.appendChild(foot);
    gamesEl.appendChild(section);
    return;
  }

  REGIONS.forEach(reg => {
    const games = sim[reg][activeRoundKey];
    if (!games || !games.length) return;
    const section = document.createElement("div"); section.className = "region-section";
    const lbl = document.createElement("div"); lbl.className = "region-label"; lbl.textContent = REG_LABELS[reg];
    section.appendChild(lbl);
    games.forEach(g => section.appendChild(mGameEl(g)));
    gamesEl.appendChild(section);
  });
}

// ==================== STATUS ====================
function updateStatus(sim, ff1, ff2, champ) {
  let upsets = 0;
  for (const reg of Object.values(sim)) {
    for (const round of [reg.r1, reg.r2, reg.s16, reg.e8]) round.forEach(g => { if(g.isUpset) upsets++; });
  }
  if(ff1.isUpset) upsets++; if(ff2.isUpset) upsets++;
  document.getElementById("status").textContent =
    `Champion: ${champ.winner.name} (${champ.winner.w}-${champ.winner.l}) · ${upsets} upset${upsets!==1?'s':''} picked · Click Re-Simulate for a new bracket`;
}

function render() {
  if (!lastSim) return;
  const {sim, ff1, ff2, champ} = lastSim;
  renderBracket(sim, ff1, ff2, champ);
  renderRounds(sim, ff1, ff2, champ);
  updateStatus(sim, ff1, ff2, champ);
}

function resim() {
  const teams = buildTeams();
  const sim = {};
  for (const [reg, ts] of Object.entries(teams)) sim[reg] = simRegion(ts);
  const ff1   = simGame(sim.east.winner,  sim.west.winner,    4);
  const ff2   = simGame(sim.south.winner, sim.midwest.winner, 4);
  const champ = simGame(ff1.winner, ff2.winner, 5);
  lastSim = {sim, ff1, ff2, champ};
  render();
}

// Init
setView(currentView);
resim();
</script>
</body>
</html>
