# API de FileBeam

### La API se ubica en https://filebeam.xyz/api.php

La **API** de FileBeam es simple de usar, solo se necesita enviar un solo argumento de nombre **"file"**, de la siguiente manera:

`file="/ruta/al/archivo.extension"`

Cabe destacar que tambien puedes usar **cURL** para enviar peticiones a la API, solo necesitas usar el comando de la siguiente forma:

`curl -X POST -F "file=@/ruta/al/archivo.extension" https://filebeam.xyz/api.php`

La respuesta que arrojará el servidor sería el enlace del archivo subido, por ejemplo:

`https://filebeam.xyz/file/v6kAW7.jpg`

**NOTA:** Solo se admiten peticiones POST al servidor, de lo contrario el servidor devolverá un codigo de error `405` (Method Not Allowed).
