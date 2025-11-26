import os
import sys

# Formats we want to rename (you can add more if needed)
IMAGE_EXTENSIONS = {'.jpg', '.jpeg', '.png', '.gif', '.webp'}

def interactive_recursive_rename():
    # Start in the folder where the script is located
    start_path = os.getcwd()
    
    print(f"🚀 Starting recursive scan from: {start_path}")
    print("The script will walk through every subfolder found.\n")
    print("Commands:")
    print(" - Type a name to rename.")
    print(" - Press ENTER to skip a single file.")
    print(" - Type 'next' to skip the rest of the current folder.")
    print(" - Type 'quit' to stop everything.\n")

    # os.walk travels through the directory tree
    for root, dirs, files in os.walk(start_path):
        
        # Filter files in the CURRENT folder (root) for images
        images = [f for f in files if os.path.splitext(f)[1].lower() in IMAGE_EXTENSIONS]
        
        # If this folder has no images, just keep walking to the next one silently
        if not images:
            continue

        # Print which folder we are currently in
        folder_name = os.path.basename(root)
        print("="*50)
        print(f"📁  Entering Folder: {folder_name}")
        print(f"    Path: {root}")
        print("="*50)

        count_in_folder = 0
        skip_folder = False

        for filename in images:
            if skip_folder:
                break

            # Get the full path to the file (needed since we are in different folders)
            old_file_path = os.path.join(root, filename)
            
            # Get just the name and extension
            name, ext = os.path.splitext(filename)
            
            print(f"🖼️  File: [{filename}]")
            
            # Ask user for input
            new_name_input = input("Rename to > ").strip()
            
            # --- COMMANDS ---
            
            # 1. Quit everything
            if new_name_input.lower() in ['quit', 'exit']:
                print("\nStopping script. Goodbye!")
                sys.exit() # Completely stops the program

            # 2. Skip the rest of this folder
            if new_name_input.lower() in ['next', 'skip folder']:
                print(f"⏭️  Skipping remaining files in '{folder_name}'...")
                skip_folder = True
                continue

            # 3. Skip single file (Empty Enter)
            if not new_name_input:
                print(f"   Skipped.\n")
                continue
            
            # --- RENAMING LOGIC ---
            
            # Create the full new filename
            clean_name = new_name_input.replace(" ", "-").lower()
            new_filename = f"{clean_name}{ext}"
            new_file_path = os.path.join(root, new_filename)
            
            # Check for duplicates
            if os.path.exists(new_file_path):
                print(f"⚠️  Error: '{new_filename}' already exists here! Skipped.\n")
                continue
                
            # Perform the rename
            try:
                os.rename(old_file_path, new_file_path)
                print(f"✅ Renamed to: {new_filename}")
                count_in_folder += 1
            except Exception as e:
                print(f"❌ Error: {e}")
            
            print("-" * 20)

        print(f"\nDone with folder '{folder_name}'. Processed {count_in_folder} files.\n")

    print("\n🎉 All folders scanned! Execution complete.")

if __name__ == "__main__":
    interactive_recursive_rename()