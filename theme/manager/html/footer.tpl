<footer class="footer">
    <div class="float-left">
    © {''|date:'Y'} <!--strong style="color:#00b5ff">FIN</strong><strong style="color:#ff8202">FIVE</strong-->
    </div>
    <div class="float-right">
    
    {if $manager->offline_point_id}
        {$offline_points[$manager->offline_point_id]->city}
        {$offline_points[$manager->offline_point_id]->address}
    {/if}
    </div>
</footer>