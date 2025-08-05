#!/bin/bash

# WelmaCarte Theme Deployment Script
# This script helps with git workflow and reminds about SFTP deployment

set -e

echo "🚀 WelmaCarte Theme Deployment Helper"
echo "======================================"

# Check if we're in the right directory
if [ ! -f "style.css" ] || [ ! -f "functions.php" ]; then
    echo "❌ Error: Please run this script from the theme root directory"
    exit 1
fi

# Check git status
echo ""
echo "📋 Current Git Status:"
git status --short

# Check for debug files that shouldn't be committed
echo ""
echo "🔍 Checking for debug files..."
DEBUG_FILES=(
    "template-debug.php"
    "inc/debug.php"
    "functions-backup.php"
    "functions-safe.php"
    "*.disabled"
)

found_debug=false
for pattern in "${DEBUG_FILES[@]}"; do
    if ls $pattern 1> /dev/null 2>&1; then
        echo "⚠️  Found debug file: $pattern"
        found_debug=true
    fi
done

if [ "$found_debug" = true ]; then
    echo "💡 Debug files found. These will be excluded from deployment automatically."
fi

# Ask for commit message
echo ""
read -p "📝 Enter commit message (or press Enter to skip git operations): " commit_msg

if [ ! -z "$commit_msg" ]; then
    echo ""
    echo "📦 Adding files to git..."
    git add .
    
    echo "💾 Committing changes..."
    git commit -m "$commit_msg"
    
    echo "⬆️  Pushing to repository..."
    git push origin main
    
    echo "✅ Git operations completed!"
else
    echo "⏭️  Skipping git operations"
fi

echo ""
echo "🌐 SFTP Deployment Reminder:"
echo "1. Open VS Code Command Palette (Cmd+Shift+P)"
echo "2. Run: 'SFTP: Upload Changed Files'"
echo "3. Or right-click folders and select 'Upload Folder'"
echo ""
echo "📂 Files excluded from deployment:"
echo "   - Debug files (*-backup.php, *-safe.php, *.disabled)"
echo "   - System files (.git, .DS_Store, etc.)"
echo "   - Development files (node_modules, logs, etc.)"
echo ""
echo "✨ Deployment preparation complete!"
