# Terminals

## PhpStorm

This configuration will likely work on any of the IntelliJ-based IDEs, but PHPStorm makes the most sense for UCRM Plugin
development.

> _**IMPORTANT**: Currently, PhpStorm's Terminal settings are application-wide and by configuring ny of the following you
> will have to revert to the built-in terminals in any other opened projects.  The alternative is to include the `bin`
> folder in other projects._

Navigate to the correct area of settings:

```
File | Settings | Tools | Terminal
```

_The below options append the following to the `PATH` environment variable in any newly executed Terminal in PhpStorm._
- `{PROJECT_ROOT}\bin`
- `{PROJECT_ROOT}\ide\bin`
- `{PROJECT_ROOT}\ide\vendor\bin`
- `{PROJECT_ROOT}\vendor\bin`

Choose one of the following, depending upon your preferred terminal.

## CMD
Shell Path
```
cmd /k ide\terminals\cmd.bat || cls
```

## PowerShell 7
Shell Path
```
pwsh -NoExit -Command "ide\terminals\powershell.ps1 || cls"
```

## Cmder
Environment Variables (if not set in PATH already)
```
CMDER_ROOT={CMDER_PATH}
```
Shell Path
```
cmd /k ide\terminals\cmder.cmd || cls && call \"%CMDER_ROOT%\vendor\init.bat\"
```

## Git Bash
Shell Path
```
C:\Program Files\Git\bin\bash.exe --rcfile ide/terminals/.bashrc
```