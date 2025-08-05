#!/bin/bash

# GitHub Actions Setup Script for WelmaCarte Theme
# This script helps you set up GitHub Actions deployment

set -e

echo "🚀 GitHub Actions Deployment Setup"
echo "==================================="

# Check if we're in the right directory
if [ ! -f "style.css" ] || [ ! -f "functions.php" ]; then
    echo "❌ Error: Please run this script from the theme root directory"
    exit 1
fi

echo ""
echo "📋 Current Setup Status:"

# Check if GitHub workflows exist
if [ -d ".github/workflows" ]; then
    echo "✅ GitHub workflows directory exists"
    workflow_count=$(find .github/workflows -name "*.yml" | wc -l)
    echo "📊 Found $workflow_count workflow files"
else
    echo "❌ GitHub workflows directory missing"
fi

# Check if git repository exists
if [ -d ".git" ]; then
    echo "✅ Git repository initialized"
    
    # Check remote origin
    if git remote get-url origin &> /dev/null; then
        remote_url=$(git remote get-url origin)
        echo "🔗 Remote origin: $remote_url"
    else
        echo "⚠️  No remote origin configured"
    fi
else
    echo "❌ Git repository not initialized"
fi

echo ""
echo "🔧 Required GitHub Secrets:"
echo "  TURHOST_HOST = srvc82.trwww.com"
echo "  TURHOST_USERNAME = welm3258" 
echo "  TURHOST_PASSWORD = be1813a6d5T"
echo ""
echo "📝 Optional GitHub Secrets:"
echo "  SLACK_WEBHOOK_URL = (for Slack notifications)"

echo ""
echo "📚 Next Steps:"
echo "1. Commit and push these workflow files to GitHub"
echo "2. Go to GitHub repository → Settings → Secrets and variables → Actions"
echo "3. Add the required secrets listed above"
echo "4. Push changes to main branch to trigger first deployment"
echo "5. Monitor deployment in GitHub Actions tab"

echo ""
echo "🧪 Testing:"
echo "- Use 'Test Deployment Setup' workflow to validate configuration"
echo "- Run manual deployment using 'Deploy with Notifications' workflow"

echo ""
read -p "🤔 Do you want to commit these GitHub Actions files now? (y/N): " commit_choice

if [[ $commit_choice =~ ^[Yy]$ ]]; then
    echo ""
    echo "📦 Adding GitHub Actions files to git..."
    
    git add .github/
    git add GITHUB_ACTIONS.md
    git add .gitignore
    
    echo "💾 Committing GitHub Actions setup..."
    git commit -m "feat: Add GitHub Actions deployment workflows

- Add basic deployment workflow (deploy.yml)
- Add enhanced deployment with notifications (deploy-enhanced.yml)
- Add setup testing workflow (test-setup.yml)
- Add comprehensive documentation (GITHUB_ACTIONS.md)
- Configure file exclusions for production deployment
- Include PHP validation and security scanning"
    
    echo "⬆️  Pushing to repository..."
    git push origin main
    
    echo "✅ GitHub Actions setup committed and pushed!"
    echo ""
    echo "🌐 Next: Go to GitHub and set up the required secrets"
    echo "📖 Documentation: Check GITHUB_ACTIONS.md for detailed instructions"
else
    echo "⏭️  Skipping git commit. You can commit manually later."
fi

echo ""
echo "📖 Quick Reference:"
echo "- Documentation: GITHUB_ACTIONS.md"
echo "- Local deployment: ./deploy.sh"
echo "- SFTP config: .vscode/sftp.json"

echo ""
echo "✨ GitHub Actions deployment setup complete!"
