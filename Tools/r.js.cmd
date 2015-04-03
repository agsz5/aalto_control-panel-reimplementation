@IF EXIST "%~dp0\node.exe" (
  "%~dp0\node.exe"  "%~dp0\node_modules\requirejs\bin\r.js" %*
) ELSE (
  node  "%~dp0\node_modules\requirejs\bin\r.js" %*
)