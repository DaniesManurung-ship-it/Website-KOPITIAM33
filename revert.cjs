const fs = require('fs');
const path = require('path');

function processDir(dir) {
    const files = fs.readdirSync(dir);
    for (const file of files) {
        const fullPath = path.join(dir, file);
        if (fs.statSync(fullPath).isDirectory()) {
            processDir(fullPath);
        } else if (fullPath.endsWith('.blade.php')) {
            let content = fs.readFileSync(fullPath, 'utf8');
            let originalContent = content;

            // Revert: window.confirmAction('message', () => { -> if(confirm('message')) {
            content = content.replace(/window\.confirmAction\(\s*(['\`\"].*?['\`\"])\s*,\s*\(\)\s*=>\s*\{/g, 'if(confirm($1)) {');

            // Revert: onsubmit="event.preventDefault(); window.confirmAction('message', () => { this.submit(); });" -> onsubmit="return confirm('message');"
            content = content.replace(/onsubmit=[\"\']event\.preventDefault\(\);\s*window\.confirmAction\((.*?),\s*\(\)\s*=>\s*\{\s*this\.submit\(\);\s*\}\);\s*[\"\']/g, 'onsubmit=\"return confirm($1);\"');

            if (content !== originalContent) {
                fs.writeFileSync(fullPath, content, 'utf8');
                console.log('Reverted: ' + fullPath);
            }
        }
    }
}

processDir('resources/views');
