const fs = require('fs');
const path = require('path');

const src = path.join(__dirname, '../storage/app/public');
const dst = path.join(__dirname, '../storage_backup');

function copyFolderSync(from, to) {
    if (!fs.existsSync(from)) return;
    fs.mkdirSync(to, { recursive: true });
    fs.readdirSync(from).forEach(element => {
        const stat = fs.lstatSync(path.join(from, element));
        if (stat.isFile()) {
            fs.copyFileSync(path.join(from, element), path.join(to, element));
        } else if (stat.isDirectory()) {
            copyFolderSync(path.join(from, element), path.join(to, element));
        }
    });
}

copyFolderSync(src, dst);
console.log('Image assets backed up successfully to storage_backup!');
