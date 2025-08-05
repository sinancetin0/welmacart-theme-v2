# SFTP Deployment Workflow for WelmaCarte Theme

## Initial Setup

### 1. Configure SFTP Connection

1. Copy `.vscode/sftp.json.template` to `.vscode/sftp.json`
2. Update the following values in `.vscode/sftp.json`:
   - `host`: Your Turhost domain (e.g., "yourdomain.com")
   - `username`: Your SFTP/cPanel username
   - `password`: Your SFTP/cPanel password
   - `remotePath`: Verify the correct path (usually "/public_html/wp-content/themes/welmacart-v2")

### 2. Install VS Code SFTP Extension

Install the "SFTP" extension by Natizyskunk in VS Code if not already installed.

## Development Workflow

### Local Development with Local.app

1. **Make changes locally** in your Local.app environment
2. **Test thoroughly** on your local WordPress installation
3. **Commit changes to git** (see Git Workflow below)
4. **Deploy to production** using SFTP

### Git Workflow

```bash
# Check current status
git status

# Add specific files (avoid debug/backup files)
git add functions.php
git add inc/setup.php
git add assets/css/
# ... add other production files

# Or add all except ignored files
git add .

# Commit with descriptive message
git commit -m "feat: Add new product gallery functionality"

# Push to repository
git push origin main
```

### SFTP Deployment

#### Option 1: Manual Selective Upload
1. Right-click on specific files/folders in VS Code Explorer
2. Select "Upload Folder" or "Upload File"
3. Files will be uploaded according to ignore rules

#### Option 2: Full Sync Upload
1. Open Command Palette (`Cmd+Shift+P`)
2. Run command: "SFTP: Sync Remote -> Local" or "SFTP: Sync Local -> Remote"
3. Choose "Local -> Remote" to upload all changes

#### Option 3: Compare and Upload
1. Open Command Palette (`Cmd+Shift+P`)
2. Run command: "SFTP: List Active"
3. Right-click on your SFTP config and select "Upload Changed Files"

## Files Excluded from Deployment

The following files are automatically excluded from deployment:

### Development Files
- `*-backup.php` (e.g., `functions-backup.php`)
- `*-safe.php` (e.g., `functions-safe.php`)
- `*.disabled` (e.g., `template-debug.php.disabled`)
- `template-debug.php`
- `inc/debug.php`

### System Files
- `.git/` and `.gitignore`
- `.vscode/` folder
- `.DS_Store`, `Thumbs.db`
- Log files (`*.log`, `debug.log`, `error_log`)

### Build/Cache Files
- `node_modules/`
- `.sass-cache/`
- `*.css.map`
- `.env*` files

## Production Safety Checklist

Before deploying to production:

- [ ] Remove or disable all debug code
- [ ] Test on local environment
- [ ] Backup production database
- [ ] Ensure no sensitive data in code
- [ ] Verify file permissions after upload
- [ ] Test critical functionality on production

## Common Commands

### Git Commands
```bash
# Quick commit workflow
git add .
git commit -m "Description of changes"
git push

# Check what files are staged
git status

# View changes before committing
git diff

# Undo uncommitted changes to a file
git checkout -- filename.php
```

### SFTP VS Code Commands
- `SFTP: Upload Changed Files` - Upload only modified files
- `SFTP: Sync Local -> Remote` - Upload all files
- `SFTP: Download File` - Download specific file from server
- `SFTP: List Active` - Show active SFTP connections

## Troubleshooting

### Connection Issues
1. Verify host, username, password in `sftp.json`
2. Check if port 22 is open (contact Turhost if needed)
3. Try different connection protocols if SFTP fails

### File Not Uploading
1. Check if file is in ignore list
2. Verify remote path exists
3. Check file permissions locally

### Deployment Rollback
1. Use git to revert to previous version
2. Upload the reverted files via SFTP
3. Or restore from production backup

## Security Notes

- Never commit `.vscode/sftp.json` with real credentials
- Use strong passwords for SFTP access
- Regularly update credentials
- Consider using SSH keys instead of passwords for better security
