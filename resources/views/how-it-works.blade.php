<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>How It Works — 2026 NCAA Bracket</title>
<style>
* { box-sizing: border-box; margin: 0; padding: 0; }
body { font-family: 'Segoe UI', sans-serif; background: #0a0e1a; color: #e0e6f0; min-height: 100vh; line-height: 1.7; }

nav { display: flex; gap: 20px; justify-content: center; padding: 16px; border-bottom: 1px solid #1e2d4a; }
nav a { color: #90adc4; text-decoration: none; font-size: 0.88em; letter-spacing: 1px; text-transform: uppercase; }
nav a:hover { color: #f0b429; }
nav a.active { color: #f0b429; border-bottom: 2px solid #f0b429; padding-bottom: 2px; }

h1 { text-align: center; padding: 32px 20px 8px; color: #f0b429; font-size: 1.5em; letter-spacing: 2px; }
.subtitle { text-align: center; color: #6080a0; font-size: 0.88em; padding-bottom: 32px; }

.container { max-width: 860px; margin: 0 auto; padding: 0 24px 60px; }

.section { margin-bottom: 40px; }
.section h2 { color: #f0b429; font-size: 1.1em; letter-spacing: 1px; text-transform: uppercase; margin-bottom: 12px; padding-bottom: 8px; border-bottom: 1px solid #1e2d4a; }
.section p { color: #b0c4d8; margin-bottom: 12px; font-size: 0.95em; }
.section ul { color: #b0c4d8; font-size: 0.95em; padding-left: 20px; }
.section ul li { margin-bottom: 8px; }

.formula-box { background: #0d1525; border: 1px solid #2a3a5a; border-radius: 8px; padding: 16px 20px; margin: 16px 0; font-family: 'Courier New', monospace; font-size: 0.88em; color: #c09020; }
.formula-box .label { color: #4a6080; font-family: 'Segoe UI', sans-serif; font-size: 0.8em; margin-bottom: 6px; text-transform: uppercase; letter-spacing: 1px; }

.weight-grid { display: grid; grid-template-columns: repeat(3, 1fr); gap: 12px; margin: 16px 0; }
.weight-card { background: #0d1525; border: 1px solid #2a3a5a; border-radius: 8px; padding: 16px; text-align: center; }
.weight-card .pct { font-size: 2em; font-weight: bold; color: #f0b429; }
.weight-card .name { font-size: 0.8em; color: #6080a0; text-transform: uppercase; letter-spacing: 1px; margin-top: 4px; }
.weight-card .desc { font-size: 0.78em; color: #90adc4; margin-top: 8px; }

.seed-table { width: 100%; border-collapse: collapse; margin: 16px 0; font-size: 0.88em; }
.seed-table th { color: #6080a0; text-align: left; padding: 8px 12px; border-bottom: 1px solid #1e2d4a; font-size: 0.8em; text-transform: uppercase; letter-spacing: 1px; }
.seed-table td { padding: 7px 12px; border-bottom: 1px solid #12192e; color: #b0c4d8; }
.seed-table tr:hover td { background: #0d1525; }
.elo-high { color: #50d0a0; }
.elo-mid { color: #f0b429; }
.elo-low { color: #e05050; }

.upset-table { width: 100%; border-collapse: collapse; margin: 16px 0; font-size: 0.88em; }
.upset-table th { color: #6080a0; text-align: left; padding: 8px 12px; border-bottom: 1px solid #1e2d4a; font-size: 0.8em; text-transform: uppercase; letter-spacing: 1px; }
.upset-table td { padding: 7px 12px; border-bottom: 1px solid #12192e; color: #b0c4d8; }
.upset-table tr:hover td { background: #0d1525; }

.tip-box { background: #0d1a10; border: 1px solid #2a5a2a; border-radius: 8px; padding: 16px 20px; margin: 16px 0; }
.tip-box h3 { color: #50d0a0; font-size: 0.88em; text-transform: uppercase; letter-spacing: 1px; margin-bottom: 10px; }
.tip-box ul { color: #90c4a0; font-size: 0.9em; padding-left: 20px; }
.tip-box ul li { margin-bottom: 6px; }

.warn-box { background: #1a0d0d; border: 1px solid #5a2a2a; border-radius: 8px; padding: 16px 20px; margin: 16px 0; }
.warn-box h3 { color: #e05050; font-size: 0.88em; text-transform: uppercase; letter-spacing: 1px; margin-bottom: 10px; }
.warn-box p { color: #c09090; font-size: 0.9em; }
</style>
</head>
<body>

<nav>
  <a href="/">🏀 Bracket</a>
  <a href="/how-it-works" class="active">📖 How It Works</a>
</nav>

<h1>📖 How It Works</h1>
<p class="subtitle">A plain-English breakdown of how this bracket simulator predicts games</p>

<div class="container">

  <!-- Overview -->
  <div class="section">
    <h2>Overview</h2>
    <p>This simulator uses a statistical model to predict the outcome of every game in the 2026 NCAA Men's Basketball Tournament. It is not a crystal ball — it's a probability engine. Every time you click <strong>Re-Simulate</strong>, a new bracket is generated based on each team's odds of winning each individual game.</p>
    <p>The model combines three signals to estimate how strong each team is: their win percentage, their seed (how tournament selectors ranked them), and a small random upset factor that reflects the unpredictability of March Madness.</p>
  </div>

  <!-- Model Weights -->
  <div class="section">
    <h2>Model Weights</h2>
    <p>Each team is assigned an <strong>Elo rating</strong> — a single number representing their overall strength. That rating is built from three components:</p>
    <div class="weight-grid">
      <div class="weight-card">
        <div class="pct">70%</div>
        <div class="name">Win %</div>
        <div class="desc">How often the team won their games this season. The primary signal of quality.</div>
      </div>
      <div class="weight-card">
        <div class="pct">20%</div>
        <div class="name">Seed Strength</div>
        <div class="desc">The tournament committee's own ranking. Baked in as a starting baseline Elo.</div>
      </div>
      <div class="weight-card">
        <div class="pct">10%</div>
        <div class="name">Upset Factor</div>
        <div class="desc">A random chance that a big underdog knocks off a heavy favorite, especially in early rounds.</div>
      </div>
    </div>
  </div>

  <!-- Elo Rating -->
  <div class="section">
    <h2>Elo Ratings Explained</h2>
    <p>Elo is a rating system originally invented for chess, now widely used in sports analytics. A higher Elo means a stronger team. The gap between two teams' Elos determines the win probability — the bigger the gap, the more likely the stronger team wins.</p>
    <p>Each team's Elo is calculated like this:</p>
    <div class="formula-box">
      <div class="label">Formula</div>
      Elo = Seed Baseline + Win% Bonus + Games Volume Bonus
      <br><br>
      Win% Bonus  = (win_percentage − 0.60) × 200
      <br>
      Volume Bonus = min((total_games − 25) × 1.5,  15)
    </div>
    <p>The <strong>Win% Bonus</strong> rewards teams above a .600 baseline and penalizes those below it. A team winning 75% of games gets +30 Elo; a team at 50% loses −20 Elo. The <strong>Volume Bonus</strong> gives a small edge to teams who played more games, since their rating is based on more evidence.</p>

    <p>Seed baselines — the starting Elo before any adjustments:</p>
    <table class="seed-table">
      <thead><tr><th>Seed</th><th>Baseline Elo</th><th>Typical profile</th></tr></thead>
      <tbody>
        <tr><td>1</td><td class="elo-high">1840</td><td>Conference champion, 28+ wins</td></tr>
        <tr><td>2</td><td class="elo-high">1760</td><td>Top-5 conference finisher</td></tr>
        <tr><td>3</td><td class="elo-high">1710</td><td>Strong regular season, few losses</td></tr>
        <tr><td>4</td><td class="elo-mid">1665</td><td>Solid team, some bad losses</td></tr>
        <tr><td>5</td><td class="elo-mid">1625</td><td>Mid-tier tourney team</td></tr>
        <tr><td>6–8</td><td class="elo-mid">1535–1595</td><td>Bubble teams, dangerous opponents</td></tr>
        <tr><td>9–12</td><td class="elo-mid">1448–1515</td><td>Underdog territory — upset potential</td></tr>
        <tr><td>13–16</td><td class="elo-low">1268–1398</td><td>Long shots, here for the experience</td></tr>
      </tbody>
    </table>
  </div>

  <!-- Win Probability -->
  <div class="section">
    <h2>How Game Outcomes Are Decided</h2>
    <p>Once both teams have Elo ratings, the model calculates the probability that Team A beats Team B using a standard logistic formula:</p>
    <div class="formula-box">
      <div class="label">Win Probability</div>
      P(A wins) = 1 / (1 + e ^ −(EloA − EloB) / 120)
    </div>
    <p>The <strong>120</strong> is a scaling factor that controls how much the Elo gap matters. A 120-point Elo advantage translates to roughly a 73% chance of winning. A 240-point gap means about 87%. Even a massive gap still leaves the underdog with a non-zero chance.</p>
    <p>Then a random number is drawn. If it falls within Team A's probability range, A wins. Otherwise B wins. This means the better team wins <em>most of the time</em> — but not always.</p>
  </div>

  <!-- Upset Factor -->
  <div class="section">
    <h2>The Upset Factor</h2>
    <p>March Madness is famous for upsets. The model adds a special override in the first two rounds for specific seed matchups with a history of surprises:</p>
    <table class="upset-table">
      <thead><tr><th>Seed Gap</th><th>Example Matchup</th><th>Upset Chance</th><th>Why</th></tr></thead>
      <tbody>
        <tr><td>4 seeds</td><td>5 vs 12</td><td>14%</td><td>The classic "12 over 5" upset — happens ~35% historically</td></tr>
        <tr><td>5 seeds</td><td>4 vs 9 area</td><td>20%</td><td>High variance mid-tier matchups</td></tr>
        <tr><td>6 seeds</td><td>3 vs 14 range</td><td>18%</td><td>Strong mid-majors can pull these off</td></tr>
        <tr><td>7 seeds</td><td>2 vs 10 range</td><td>15%</td><td>10-seeds beat 2-seeds more than people expect</td></tr>
      </tbody>
    </table>
    <p>These upsets only apply in Rounds 1 and 2. By the Sweet 16 and beyond, the model relies purely on Elo — the surviving teams have already proven themselves.</p>
  </div>

  <!-- Championship Odds -->
  <div class="section">
    <h2>What the Championship Odds Button Does</h2>
    <p>When you click <strong>"Show Championship Odds"</strong>, the simulator runs 2,000 complete tournaments behind the scenes — in under a second. It then counts how many times each team won the championship and displays that as a percentage next to their name.</p>
    <p>For example, if Duke wins the championship in 620 out of 2,000 simulations, their odds show as <strong>31%</strong>. This is the model's best estimate of each team's true title probability given their Elo rating and the bracket matchups.</p>
    <div class="tip-box">
      <h3>How to use odds to pick your bracket</h3>
      <ul>
        <li><strong>Champion:</strong> Pick the team with the highest odds — that's who the model thinks is most likely to cut down the nets.</li>
        <li><strong>Final Four:</strong> Look for teams with 8%+ odds — they have realistic paths to the end.</li>
        <li><strong>Upsets to pick:</strong> Any team seeded 10–12 with strong win percentages is worth a first-round upset pick.</li>
        <li><strong>Avoid the perfect bracket trap:</strong> Picking all favorites gives you a statistically boring bracket. One or two smart upsets (backed by high Elo mid-majors) scores better in pools.</li>
      </ul>
    </div>
  </div>

  <!-- Limitations -->
  <div class="section">
    <h2>Model Limitations</h2>
    <div class="warn-box">
      <h3>What this model does not account for</h3>
      <p>This is a simplified statistical model. Real bracket prediction is much harder. The following factors are <em>not</em> included and can meaningfully change outcomes:</p>
    </div>
    <ul>
      <li><strong>Injuries & roster changes</strong> — a star player sitting out changes everything</li>
      <li><strong>Strength of schedule</strong> — a 26-7 record in a weak conference is not the same as 26-7 in the Big Ten</li>
      <li><strong>Momentum & hot streaks</strong> — teams peaking in March often outperform their season stats</li>
      <li><strong>Coaching & experience</strong> — tournament-tested coaches win more close games</li>
      <li><strong>Matchup styles</strong> — a team that suffocates pace can upset an Elo-superior run-and-gun squad</li>
      <li><strong>Geography & crowd effects</strong> — playing near your home city is a real advantage</li>
    </ul>
    <p style="margin-top:14px;">Use the model as a starting point for your bracket decisions, not the final word. The best bracket pickers combine statistical models with their own basketball knowledge.</p>
  </div>

</div>
</body>
</html>
