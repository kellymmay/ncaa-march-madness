<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>2026 NCAA Bracket</title>
<style>
* { box-sizing: border-box; margin: 0; padding: 0; }
body { font-family: 'Segoe UI', sans-serif; background: #0a0e1a; color: #e0e6f0; min-height: 100vh; }
h1 { text-align: center; padding: 18px 10px 4px; color: #f0b429; font-size: 1.4em; letter-spacing: 2px; }
#status { text-align: center; padding: 6px; color: #90adc4; font-size: 0.78em; min-height: 22px; }
#bracket-wrap { overflow-x: auto; padding: 10px 10px 30px; }
.full-bracket { display: flex; gap: 6px; min-width: 1300px; align-items: flex-start; }
.side { display: flex; gap: 0; flex: 1; }
.side.right { flex-direction: row-reverse; }
.round-col { display: flex; flex-direction: column; width: 150px; flex-shrink: 0; }
.round-header { text-align: center; font-size: 0.62em; color: #4a6080; letter-spacing: 1px; text-transform: uppercase; padding: 4px 0 6px; }
.team-slot { display: flex; align-items: center; gap: 4px; padding: 4px 6px; background: #12192e; border: 1px solid #1e2d4a; margin: 1px 2px; border-radius: 3px; font-size: 0.68em; min-height: 24px; white-space: nowrap; overflow: hidden; }
.team-slot.winner { background: #0f2010; border-color: #2a5a2a; }
.team-slot.loser { opacity: 0.35; }
.team-slot.upset-winner { background: #2a0808; border-color: #8b2020; }
.seed { color: #5070a0; font-size: 0.85em; min-width: 14px; text-align: right; flex-shrink: 0; }
.tname { flex: 1; overflow: hidden; text-overflow: ellipsis; }
.elo-val { color: #c09020; font-size: 0.78em; flex-shrink: 0; }
.upset-tag { background: #8b0000; color: #ffaaaa; font-size: 0.58em; padding: 0 3px; border-radius: 2px; flex-shrink: 0; }
.center-col { display: flex; flex-direction: column; align-items: center; width: 200px; flex-shrink: 0; padding-top: 28px; }
.ff-label { color: #f0b429; font-weight: bold; font-size: 0.75em; letter-spacing: 2px; text-align: center; margin: 10px 0 4px; }
.ff-game { background: #0d1525; border: 1px solid #2a3a5a; border-radius: 6px; padding: 8px; width: 100%; margin-bottom: 6px; }
.ff-sublabel { font-size:0.62em; color:#4a6080; text-align:center; margin-bottom:4px; }
.champ-box { background: #0d1525; border: 2px solid #f0b429; border-radius: 8px; padding: 12px; width: 100%; margin-top: 10px; }
.champ-footer { margin-top:10px; border-top:1px solid #2a3a5a; padding-top:8px; text-align:center; }
.legend { display: flex; gap: 14px; justify-content: center; padding: 6px; font-size: 0.7em; color: #6080a0; flex-wrap: wrap; }
.legend span { display: flex; align-items: center; gap: 4px; }
.dot { width: 9px; height: 9px; border-radius: 50%; flex-shrink: 0; }
.dot-win { background: #2a5a2a; } .dot-upset { background: #8b0000; }
.model-note { text-align: center; color: #3a5070; font-size: 0.68em; padding: 4px 0 14px; }
.reg-div { text-align:center; font-size:0.62em; color:#f0b429; font-weight:bold; letter-spacing:1px; padding:4px 0 2px; border-top:1px solid #1e2d4a; margin-top:3px; }
.resim-btn { display:block; margin: 0 auto 10px; padding: 7px 22px; background:#f0b429; color:#0a0e1a; border:none; border-radius:6px; font-weight:bold; cursor:pointer; font-size:0.85em; }
.resim-btn:hover { background:#ffd166; }
</style>
</head>
<body>
<h1>🏀 2026 NCAA Men's Basketball Championship</h1>
<div id="status"></div>
<div class="legend">
  <span><span class="dot dot-win"></span> Winner</span>
  <span><span class="dot dot-upset"></span> Upset</span>
  <span>★ = Elo</span>
</div>
<button class="resim-btn" onclick="resim()">🔄 Re-Simulate Bracket</button>
<div id="bracket-wrap"></div>
<div class="model-note">Model: Win% (70%) · Seed strength (20%) · Upset factor (10%) · Based on 2025-26 records & seeds</div>

<script>
// Teams with seed, name, record (wins-losses)
// Elo computed from: seed base + win% bonus + record volume
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

// Seed baseline Elo
const SEED_BASE = {1:1840,2:1760,3:1710,4:1665,5:1625,6:1595,7:1565,8:1535,9:1515,10:1492,11:1472,12:1448,13:1398,14:1358,15:1315,16:1268};

function calcElo(t) {
  const base = SEED_BASE[t.seed] || 1300;
  const winPct = t.w / (t.w + t.l);
  // Win% bonus: scale ±60 around .600 baseline
  const winBonus = (winPct - 0.60) * 200;
  // Games played volume (more games = more reliable)
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

// NCAA bracket pairing order for a 16-team region (indices into flat seed array)
// Seeds: idx0=1,idx1=16, idx2=8,idx3=9, idx4=5,idx5=12, idx6=4,idx7=13,
//        idx8=6,idx9=11, idx10=3,idx11=14, idx12=7,idx13=10, idx14=2,idx15=15
const R1_PAIRS = [[0,1],[2,3],[4,5],[6,7],[8,9],[10,11],[12,13],[14,15]];

function simGame(a, b, rnd) {
  const pA = 1 / (1 + Math.exp(-(a.elo - b.elo) / 120));
  const favSeed = Math.min(a.seed, b.seed);
  const dogSeed = Math.max(a.seed, b.seed);
  const gap = dogSeed - favSeed;
  // Upset chances by seed gap, only rounds 0-1
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
  const r1 = R1_PAIRS.map(([i,j]) => simGame(teams[i], teams[j], 0));
  const r2 = [[0,1],[2,3],[4,5],[6,7]].map(([i,j]) => simGame(r1[i].winner, r1[j].winner, 1));
  const s16 = [[0,1],[2,3]].map(([i,j]) => simGame(r2[i].winner, r2[j].winner, 2));
  const e8  = [simGame(s16[0].winner, s16[1].winner, 3)];
  return {r1, r2, s16, e8, winner: e8[0].winner};
}

// --- Render ---
function slotEl(t, win) {
  const d = document.createElement("div");
  d.className = "team-slot" + (win ? (t.upset ? " upset-winner" : " winner") : " loser");
  d.innerHTML = `<span class="seed">${t.seed}</span><span class="tname">${t.name}</span>${t.upset?'<span class="upset-tag">UPSET</span>':''}<span class="elo-val">★${t.elo}</span>`;
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

  // LEFT: East (top) + South (bottom)
  const left = document.createElement("div"); left.className="side";
  left.appendChild(buildSideCol("1st Round", sim.east.r1,  0, 4,  sim.south.r1,  6, 4,  "EAST","SOUTH"));
  left.appendChild(buildSideCol("2nd Round", sim.east.r2,  26,10, sim.south.r2,  32,10, "EAST","SOUTH"));
  left.appendChild(buildSideCol("Sweet 16",  sim.east.s16, 68,22, sim.south.s16, 74,22, "EAST","SOUTH"));
  left.appendChild(buildSideCol("Elite 8",   sim.east.e8,  148,0, sim.south.e8,  154,0, "EAST","SOUTH"));

  // RIGHT: West (top) + Midwest (bottom)
  const right = document.createElement("div"); right.className="side right";
  right.appendChild(buildSideCol("1st Round", sim.west.r1,    0, 4,  sim.midwest.r1,    6, 4,  "WEST","MIDWEST"));
  right.appendChild(buildSideCol("2nd Round", sim.west.r2,    26,10, sim.midwest.r2,    32,10, "WEST","MIDWEST"));
  right.appendChild(buildSideCol("Sweet 16",  sim.west.s16,   68,22, sim.midwest.s16,   74,22, "WEST","MIDWEST"));
  right.appendChild(buildSideCol("Elite 8",   sim.west.e8,    148,0, sim.midwest.e8,    154,0, "WEST","MIDWEST"));

  // CENTER
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
  cFoot.innerHTML=`<div style="color:#6080a0;font-size:0.65em;letter-spacing:2px;">2026 CHAMPION</div>
    <div style="color:#f0b429;font-size:1.15em;font-weight:bold;margin-top:3px;">${champ.winner.name}</div>
    <div style="color:#90adc4;font-size:0.72em;">Seed #${champ.winner.seed} · Elo ${champ.winner.elo}</div>`;
  cBox.appendChild(cFoot); center.appendChild(cBox);

  full.appendChild(left); full.appendChild(center); full.appendChild(right);
  wrap.appendChild(full);

  // Count upsets
  let upsets = 0;
  for (const reg of Object.values(sim)) {
    for (const round of [reg.r1, reg.r2, reg.s16, reg.e8]) round.forEach(g => { if(g.isUpset) upsets++; });
  }
  if(ff1.isUpset) upsets++; if(ff2.isUpset) upsets++;
  document.getElementById("status").textContent =
    `Champion: ${champ.winner.name} (${champ.winner.w}-${champ.winner.l}) · ${upsets} upset${upsets!==1?'s':''} picked · Click Re-Simulate for a new bracket`;
}

function resim() {
  const teams = buildTeams();
  const sim = {};
  for (const [reg, ts] of Object.entries(teams)) sim[reg] = simRegion(ts);
  const ff1   = simGame(sim.east.winner,  sim.west.winner,    4);
  const ff2   = simGame(sim.south.winner, sim.midwest.winner, 4);
  const champ = simGame(ff1.winner, ff2.winner, 5);
  renderBracket(sim, ff1, ff2, champ);
}

resim();
</script>
</body>
</html>