<?php
defined('BASEPATH') or exit('Direct Script is not all');
?>
</tr>
<tr>
    <td><?php 
        echo (ENVIRONMENT === 'development') ?
                '<font size="1">[rendered: <strong>{elapsed_time}</strong> ver. <strong>'
                . CI_VERSION
                . '</strong>]</font>' : ''
        ?></td>
</tr>
</table>
</body>
</html>

