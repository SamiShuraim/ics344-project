import subprocess
import logging
import logging.handlers


# Configure syslog logging
logger = logging.getLogger("SQLMapLogger")
logger.setLevel(logging.INFO)
syslog_handler = logging.handlers.SysLogHandler(address='/dev/log')  # Change to '/var/run/syslog' for macOS
formatter = logging.Formatter('%(name)s: %(levelname)s %(message)s')
syslog_handler.setFormatter(formatter)
logger.addHandler(syslog_handler)


# Run the sqlmap command
def run_sqlmap():
    logger.info("Starting SQLMap scan...")
    print("[*] Running sqlmap...")

    result = subprocess.run([
        "sqlmap", "-r", "req.txt", "--dbms=MySQL", "--level=1", "--risk=1", "--dump", "--batch", "--flush-session"
    ])

    if result.returncode == 0:
        logger.info("SQLMap scan completed successfully.")
    else:
        logger.error("SQLMap scan failed with return code: %d", result.returncode)


# Main function
def main():
    run_sqlmap()


if __name__ == "__main__":
    main()
