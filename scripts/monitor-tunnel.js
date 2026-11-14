const fs = require('fs');
const path = require('path');
const https = require('https');

const targetUrl = process.env.MONITOR_URL || 'https://soft-rice-create.loca.lt/dashboard';
const intervalMs = 60 * 1000;

const now = new Date();
const endAt = new Date(now);
endAt.setHours(23, 0, 0, 0);
if (now >= endAt) {
  endAt.setDate(endAt.getDate() + 1);
}

const logDir = path.join(process.cwd(), 'storage', 'logs');
fs.mkdirSync(logDir, { recursive: true });

const dateStamp = `${now.getFullYear()}-${String(now.getMonth() + 1).padStart(2, '0')}-${String(now.getDate()).padStart(2, '0')}`;
const logFile = path.join(logDir, `tunnel-monitor-${dateStamp}.log`);

function ts() {
  const d = new Date();
  const y = d.getFullYear();
  const m = String(d.getMonth() + 1).padStart(2, '0');
  const day = String(d.getDate()).padStart(2, '0');
  const hh = String(d.getHours()).padStart(2, '0');
  const mm = String(d.getMinutes()).padStart(2, '0');
  const ss = String(d.getSeconds()).padStart(2, '0');
  return `${y}-${m}-${day} ${hh}:${mm}:${ss}`;
}

function writeLine(message) {
  const line = `[${ts()}] ${message}`;
  fs.appendFileSync(logFile, line + '\n', 'utf8');
  console.log(line);
}

function checkUrl(url) {
  return new Promise((resolve) => {
    const req = https.request(
      url,
      {
        method: 'GET',
        timeout: 20000,
        headers: {
          'User-Agent': 'web-gis-tunnel-monitor/1.0',
        },
      },
      (res) => {
        res.resume();
        resolve({
          ok: typeof res.statusCode === 'number' && res.statusCode < 500,
          statusCode: res.statusCode || 0,
        });
      }
    );

    req.on('timeout', () => {
      req.destroy(new Error('Request timeout'));
    });

    req.on('error', (err) => {
      resolve({ ok: false, error: err.message });
    });

    req.end();
  });
}

let timer = null;

async function runCheck() {
  const result = await checkUrl(targetUrl);
  if (result.ok) {
    writeLine(`UP status=${result.statusCode} url=${targetUrl}`);
  } else {
    writeLine(`DOWN status=${result.statusCode || 'ERR'} error=${result.error || 'unknown'} url=${targetUrl}`);
  }

  if (new Date() >= endAt) {
    writeLine(`STOP reached end time ${endAt.toLocaleString()}`);
    if (timer) {
      clearInterval(timer);
    }
    process.exit(0);
  }
}

writeLine(`START monitoring url=${targetUrl} until=${endAt.toLocaleString()} interval=60s`);
runCheck();
timer = setInterval(runCheck, intervalMs);
