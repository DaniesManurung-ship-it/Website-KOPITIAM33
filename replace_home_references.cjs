const fs = require('fs');
const path = require('path');

const filesToUpdate = [
    'app/Http/Controllers/Auth/LoginController.php',
    'app/Http/Controllers/Auth/RegisterController.php',
    'resources/views/dashboard.blade.php',
    'resources/views/layouts/navbar.blade.php',
    'resources/views/notifications.blade.php'
];

const basePath = 'C:/laragon/www/Website-KOPITIAM33';

filesToUpdate.forEach(file => {
    const fullPath = path.join(basePath, file);
    if (fs.existsSync(fullPath)) {
        let content = fs.readFileSync(fullPath, 'utf8');
        
        content = content.replace(/route\('home'\)/g, "route('dashboard')");
        content = content.replace(/css\/home\.css/g, "css/dashboard.css");
        content = content.replace(/images\/home\//g, "images/dashboard/");
        content = content.replace(/activeMenu === 'home'/g, "activeMenu === 'dashboard'");
        content = content.replace(/activeMenu: 'home'/g, "activeMenu: 'dashboard'");
        content = content.replace(/path === '\/home'/g, "path === '/dashboard'");
        content = content.replace(/this\.activeMenu = 'home'/g, "this.activeMenu = 'dashboard'");
        
        fs.writeFileSync(fullPath, content, 'utf8');
        console.log(`Updated: ${file}`);
    } else {
        console.log(`File not found: ${file}`);
    }
});
