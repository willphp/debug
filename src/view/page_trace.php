<div id="willphp_trace" style="position:fixed;bottom:0;right:0;font-size:14px;width:100%;z-index: 999999;text-align:left;">
	<div id="willphp_trace_tab" style="display:none;background:white;margin:0;height: 250px;">
		<div id="willphp_trace_tab_tit" style="background-color:#f0f1f3;height:30px;padding: 3px 12px;border-bottom:1px solid #ccc;border-top:1px solid #ccc;font-size:16px">
			<?php foreach ($trace as $name => $v) {?>               
			<span style="color:#000;padding-right:12px;height:30px;line-height:30px;display:inline-block;margin-right:3px;cursor:pointer;font-weight:700"><?php echo $name; ?></span>
			<?php }?>					
        </div>
        <div id="willphp_trace_tab_cont" style="overflow:auto;height:212px;padding:0;line-height: 25px">
			<?php foreach ($trace as $info) {?>
			<div style="display:none;">
				<ol style="padding: 0; margin:0">
                	<?php foreach ((array) $info as $val) {?>
                	<li style="border-bottom:1px solid #ddd;font-size:14px;padding:0 12px"><?php echo $val; ?></li>
                	<?php }?>
 				</ol>
            </div>            			
            <?php }?>	
		</div>
	</div>
    <div id="willphp_trace_close" style="display:none;text-align:right;height:18px;position:absolute;top:10px;right:12px;cursor:pointer;">
    	<img style="height:18px;vertical-align:top;" src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAACAAAAAgCAYAAABzenr0AAABOUlEQVRYR+2W0W0CMRBE33VACXQAdAAlpAJIBaGTKBUk6SAdJB0AHaQESogG3UknY+Pd9cfl4+7Tsj3v1rOr6Zj46ybWZwb4txVYAC/AJ/Db6JMlsAfegGt6V6kCB+C9P7ADzkGINfAN6IeegQ8rgA78AKsGiLH4Bdh6KiDQFgiTuERqJoxAmMUtAN5KuMStAFYIt7gHoAYREvcClCC0PrRa0e2lNq6ZMHcuNeYA5haPVGAAGkNoLSTeAjB+c92jERuamJEnSA0ngPDE9ALk3C6A8Nj2ADxqtcjEvPnJCmDp8xCEBcAinusOkzFrAB7xEMQjgIi4G6IEoBh16jNBdMikntjk4l0J4Ai8tky4vhRjiCfgyxrJtE8RSlnwLkg686EglDGVB82h1KkR317rgvjNxpMzwOQV+AM8QnIhRC5g4gAAAABJRU5ErkJggg==" />
    </div>
</div>
<div id="willphp_trace_open" style="height:30px;float:right;text-align:right;overflow:hidden;position:fixed;bottom:0;right:0;line-height:30px;cursor:pointer;">
    <div style="background:#232323;color:#FFF;padding:0 6px;float:right;line-height:30px;font-size:14px"><?php echo round((microtime(true) - START_TIME) , 4);?>s <?php echo $errno; ?></div>
	<img width="30" title="WillPHP DebugBar" src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAB4AAAAeCAYAAAA7MK6iAAAABGdBTUEAAK/INwWK6QAAABl0RVh0U29mdHdhcmUAQWRvYmUgSW1hZ2VSZWFkeXHJZTwAAAMrSURBVHjaxJdLaFNBFIZv9Da2CVK1ojVUsb5daH0gBkFRES2CCx9VpAURsboQdSkoQRQ3BUUERS0o9YkKbhSahd2Ij2B9VRGtLsS6sFaoQXykTZr4H/mvjNcZkpsUMvB15s6d3n/OzDlnJr49rQstTdkLDoJfYAjoATvAGVAJUlb+xQbd8sfPj/eDNF8OB+XEGTwMVIDR1iAUEWwBrWCp0p92jUuxb8AanJIS4fUUrVBeZFwDZQV8mv5s5Sc4DLaAp+71PsAPzwPzlf59bIvgVxAHJR6FW47XxiJ/nCYafoYqBgKOQBMH3QAb2JZZPgabuMzjuTLiWG/Ba9BFi6RvKpgLylzC35X2D3WrbMPySnsl2K70yUTWgQfgs9MJi8SaUjSnc/xWxyqUbXgnk+wEEa7sX2GxcoS4OMNF9r0N1CqOtR8cM4URxBOoOsAuCF1FfRLUgFHgnMmrT4Nm8AhcB7IXU8AShlgjtyOn2MUk7qNaA9qzBfMLUAU+gCNgsfJeHO88CNLr+8AXbsVYyQGw8BvE4qgDHJPE80c816N9lz6gtfgQM1WJa9ATcJTttXSoKBOJjL3MvkaOkRV6I2IQnQDxd4rjai1uptf6XOFyCiTYHkqHUWM9yL5S5VsB+ovjtFfAbjBRZ3EZrfBT3GJubtN4/IAmu2U0YzLcb/H+O6al1qXBTnq5pSSRbMWU1dpNwrrSTUfyUkyT69JNyiSczkPQ52WWJuExrqxmFbDUVbpJmYSnMU7dVqW5BerZ3c86qXxTFarxYnGIcWm5Pj4SzOLEQuybibiV/gV87nP8A/0SWitMcWzaN0n412jZQ9DL3Hub1lVzbAOYwxPK4tgeJfHM8GKxlGVgJ9vvmd3i3LNqHnkxfmM284Hk+QjiNwlrK5lyLS8WO6WJ4SBWXgTPOSH5v3vgFVjFpf8EbkG0l0t/AUzKV1jS4iU57li/JOppdPOf62k0PBnVWbA82+mUrZTzQrganKDVif/uw9GwLP9G5uZQLnfcXON9M6jjud3B7JaGYJC3jzAY5+Vy7fUyvogUfK8uSimqsF0EXdvmVdVf4A8xzz/afgswADn3zfhlrXIaAAAAAElFTkSuQmCC"/>
</div>
<script type="text/javascript">
    (function(){
        var tab_tit  = document.getElementById('willphp_trace_tab_tit').getElementsByTagName('span');
        var tab_cont = document.getElementById('willphp_trace_tab_cont').getElementsByTagName('div');
        var open     = document.getElementById('willphp_trace_open');
        var close    = document.getElementById('willphp_trace_close').children[0];
        var trace    = document.getElementById('willphp_trace_tab');
        var cookie   = document.cookie.match(/willphp_show_page_trace=(\d\|\d)/);
        var history  = (cookie && typeof cookie[1] != 'undefined' && cookie[1].split('|')) || [0,0];
        open.onclick = function(){
            trace.style.display = 'block';
            this.style.display = 'none';
            close.parentNode.style.display = 'block';
            history[0] = 1;
            document.cookie = 'willphp_show_page_trace='+history.join('|')
        }
        close.onclick = function(){
            trace.style.display = 'none';
            this.parentNode.style.display = 'none';
            open.style.display = 'block';
            history[0] = 0;
            document.cookie = 'willphp_show_page_trace='+history.join('|')
        }
        for(var i = 0; i < tab_tit.length; i++){
            tab_tit[i].onclick = (function(i){
                return function(){
                    for(var j = 0; j < tab_cont.length; j++){
                        tab_cont[j].style.display = 'none';
                        tab_tit[j].style.color = '#999';
                    }
                    tab_cont[i].style.display = 'block';
                    tab_tit[i].style.color = '#000';
                    history[1] = i;
                    document.cookie = 'willphp_show_page_trace='+history.join('|')
                }
            })(i)
        }
        parseInt(history[0]) && open.click();
        tab_tit[history[1]].click();
    })();
</script>