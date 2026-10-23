const { app, BrowserWindow } = require('electron');

function createWindow() {
    const win = new BrowserWindow({
        width: 1440,
        height: 900,
        backgroundColor: '#12110f',
        title: 'Dülgeroğlu Filo',
        webPreferences: { contextIsolation: true },
    });

    win.loadURL(process.env.FILO_URL || 'http://127.0.0.1:8000');
}

app.whenReady().then(createWindow);
app.on('window-all-closed', () => app.quit());
