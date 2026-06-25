const fs = require('fs');
const path = require('path');

const filesToUpdate = [
    'app/Http/Controllers/admin/ReservasiController.php',
    'app/Http/Controllers/ReservasiController.php',
    'resources/views/reservasi_history.blade.php',
    'app/Http/Controllers/OrderController.php',
    'app/Http/Controllers/admin/PesananController.php',
    'resources/views/order_history.blade.php'
];

const basePath = 'C:/laragon/www/Website-KOPITIAM33';

filesToUpdate.forEach(file => {
    const fullPath = path.join(basePath, file);
    if (fs.existsSync(fullPath)) {
        let content = fs.readFileSync(fullPath, 'utf8');
        
        // Replace can_edit with edit_status
        content = content.replace(/can_edit/g, 'edit_status');
        
        // Replace can_cancel with cancel_status
        content = content.replace(/can_cancel/g, 'cancel_status');
        
        fs.writeFileSync(fullPath, content, 'utf8');
        console.log(`Updated: ${file}`);
    } else {
        console.log(`File not found: ${file}`);
    }
});
