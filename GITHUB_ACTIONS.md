# GitHub Actions Deployment Setup

## Overview

This repository includes automated deployment workflows for the WelmaCarte WordPress theme using GitHub Actions. The workflows automatically deploy your theme to Turhost hosting whenever you push changes to the main branch.

## 🚀 Quick Setup

### 1. Set Up GitHub Secrets

Go to your GitHub repository → Settings → Secrets and variables → Actions → New repository secret

Add the following secrets:

```
TURHOST_HOST = srvc82.trwww.com
TURHOST_USERNAME = welm3258
TURHOST_PASSWORD = be1813a6d5T
```

#### Optional Slack Notifications
```
SLACK_WEBHOOK_URL = https://hooks.slack.com/services/YOUR/SLACK/WEBHOOK
```

### 2. Enable GitHub Actions

1. Go to your repository → Actions tab
2. Enable workflows if prompted
3. The workflows will run automatically on push to main branch

## 📁 Available Workflows

### 1. `deploy.yml` - Basic Deployment
- **Trigger**: Push to main branch
- **Features**: 
  - PHP syntax validation
  - WordPress theme structure check
  - SFTP deployment to Turhost
  - Basic notifications
- **Runtime**: ~3-5 minutes

### 2. `deploy-enhanced.yml` - Advanced Deployment
- **Trigger**: Push to main branch (excluding documentation files)
- **Features**:
  - File change analysis
  - Enhanced PHP validation
  - Security scanning
  - Slack notifications
  - Manual deployment option
  - Production environment protection
- **Runtime**: ~5-8 minutes

## 🔧 Workflow Configuration

### Files Included in Deployment
- ✅ All PHP files (`*.php`)
- ✅ CSS files (`style.css`, `assets/css/*`)
- ✅ JavaScript files (`assets/js/*`)
- ✅ Image assets (`assets/images/*`)
- ✅ Template files
- ✅ Include files (`inc/*`)

### Files Excluded from Deployment
- ❌ `.git/` - Git repository data
- ❌ `.github/` - GitHub Actions workflows
- ❌ `.vscode/` - VS Code settings
- ❌ `node_modules/` - Node.js dependencies
- ❌ `*-backup.php` - Backup files
- ❌ `*-safe.php` - Safe backup files
- ❌ `*.disabled` - Disabled files
- ❌ `template-debug.php` - Debug template
- ❌ `inc/debug.php` - Debug include
- ❌ `*.log` - Log files
- ❌ `.DS_Store` - macOS system files
- ❌ `deploy.sh` - Local deployment script

## 🛠️ Manual Deployment

You can trigger deployments manually:

1. Go to Actions tab in GitHub
2. Select "Deploy with Notifications" workflow
3. Click "Run workflow"
4. Choose environment and notification options
5. Click "Run workflow" button

## 📊 Deployment Process

### Phase 1: Validation
1. **Checkout code** - Downloads latest code
2. **PHP syntax check** - Validates all PHP files
3. **Theme structure** - Checks required WordPress files
4. **Security scan** - Basic security checks

### Phase 2: Deployment
1. **Prepare package** - Creates clean deployment package
2. **SFTP upload** - Uploads files to Turhost
3. **Verification** - Confirms deployment success
4. **Notifications** - Sends status updates

### Phase 3: Notifications
1. **Success notification** - Confirms successful deployment
2. **Failure notification** - Reports any errors
3. **Slack integration** - Optional team notifications

## 🔒 Security Features

### Credential Protection
- All sensitive data stored in GitHub Secrets
- Secrets are encrypted and only accessible during workflow runs
- No credentials visible in logs or code

### File Validation
- PHP syntax checking prevents broken deployments
- WordPress theme structure validation
- Basic security scanning for common issues

### Deployment Safety
- Dry-run verification before actual deployment
- Selective file inclusion/exclusion
- Error handling with rollback capabilities

## 🐛 Troubleshooting

### Common Issues

#### 1. SFTP Connection Failed
**Symptoms**: Connection timeout or authentication error
**Solutions**:
- Verify `TURHOST_HOST`, `TURHOST_USERNAME`, `TURHOST_PASSWORD` secrets
- Check if Turhost allows FTP connections from GitHub's IP ranges
- Confirm cPanel credentials are correct

#### 2. PHP Syntax Errors
**Symptoms**: Validation fails with PHP errors
**Solutions**:
- Test PHP files locally: `php -l filename.php`
- Check for missing semicolons, brackets, or quotes
- Ensure all debug code is removed

#### 3. Missing Files After Deployment
**Symptoms**: Some files don't appear on production
**Solutions**:
- Check if files are in the exclusion list
- Verify file names don't match excluded patterns
- Review deployment logs for upload confirmations

#### 4. Slack Notifications Not Working
**Symptoms**: No Slack messages received
**Solutions**:
- Verify `SLACK_WEBHOOK_URL` secret is correct
- Check Slack webhook is active
- Ensure workflow has `notify_slack: true` parameter

### Debug Commands

#### Check Deployment Logs
1. Go to Actions → Select failed workflow
2. Click on failed job
3. Expand step logs to see detailed error messages

#### Test SFTP Connection Locally
```bash
# Test FTP connection
ftp srvc82.trwww.com
# Enter username and password when prompted
```

#### Validate PHP Files Locally
```bash
# Check all PHP files
find . -name "*.php" -exec php -l {} \;

# Check specific file
php -l functions.php
```

## 📈 Monitoring & Maintenance

### Regular Checks
- **Weekly**: Review deployment logs for any warnings
- **Monthly**: Update GitHub Actions versions
- **Quarterly**: Rotate SFTP credentials

### Performance Optimization
- **File Size**: Monitor deployment package size
- **Upload Time**: Track deployment duration
- **Success Rate**: Monitor deployment success percentage

### Security Updates
- **Credentials**: Rotate passwords regularly
- **Access**: Review who has repository access
- **Logs**: Monitor for suspicious deployment attempts

## 🔄 Workflow Customization

### Modify Deployment Triggers
Edit `.github/workflows/deploy.yml`:

```yaml
on:
  push:
    branches: [ main, staging ]  # Add staging branch
    paths-ignore:
      - 'README.md'  # Ignore documentation changes
```

### Add Environment Variables
```yaml
env:
  THEME_NAME: welmacart-v2
  SITE_URL: https://welma.tr
  BACKUP_ENABLED: true
```

### Custom Exclusions
Add to the `exclude` list in deployment step:
```yaml
exclude: |
  **/.git*
  **/custom-exclude-pattern/**
```

## 📞 Support

### GitHub Issues
- Create issues for workflow problems
- Include deployment logs and error messages
- Tag with `deployment` label

### Emergency Rollback
If deployment causes issues:

1. **Quick fix**: Push a revert commit to main branch
2. **Manual rollback**: Use SFTP to restore previous files
3. **Database**: Restore database backup if needed

### Contact Information
- **Repository**: [welmacart-theme-v2](https://github.com/sinancetin0/welmacart-theme-v2)
- **Hosting**: Turhost support for server issues
- **Theme**: GitHub issues for theme-related problems

---

## 📋 Deployment Checklist

Before pushing to main:

- [ ] Test changes locally with Local.app
- [ ] Validate PHP syntax: `php -l functions.php`
- [ ] Remove debug code and backup files
- [ ] Update CHANGELOG.md if needed
- [ ] Commit with descriptive message
- [ ] Push to main branch
- [ ] Monitor deployment in Actions tab
- [ ] Verify changes on https://welma.tr
- [ ] Check for any console errors or warnings

**Happy Deploying! 🚀**
