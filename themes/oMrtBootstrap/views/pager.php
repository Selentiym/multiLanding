<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 07.05.2017
 * Time: 10:17
 */
/**
 * @var integer $curPage
 * @var integer $totalPages
 * @var string $baseLink must contain :pageNumber string which will be replaced by a number
 *
 * @var integer $pagesLeft
 * @var integer $pagesRight
 */
$pagesLeft = $pagesLeft ? $pagesLeft : 3;
$pagesRight = $pagesRight ? $pagesRight : 3;
$startPage = max(1, $curPage - $pagesLeft);
$endPage = min($totalPages, $curPage + $pagesRight);
$genLink = function($num)use($baseLink){
    return str_replace([':pageNumber','%3ApageNumber'],$num,$baseLink);
};
if ($totalPages <= 1) {
    return;
}
?>
<nav aria-label="">
    <ul class="pagination">
        <?php
        if ($curPage > 1):
        ?>
        <li class="page-item">
            <a class="page-link" href="<?php echo $genLink($curPage - 1); ?>">Предыдущая</a>
        </li>
        <?php endif; ?>
        <?php
            for ($i = $startPage; $i <= $endPage; $i++) {
                $link = $genLink($i);
                if ($i == $curPage) {
                    ?>
                    <li class="page-item active">
                        <span class="page-link"><?php echo $i; ?>
                        <span class="sr-only">(текущая)</span>
                        </span>
                    </li>
                    <?php
                } else {
                    echo "<li class='page-item'><a class='page-link' href='$link'>$i</a></li>";
                }
            }
        ?>
        <?php
        if ($curPage < $totalPages):
            ?>
            <li class="page-item">
                <a class="page-link" href="<?php echo $genLink($curPage + 1); ?>">Следующая</a>
            </li>
        <?php endif; ?>
        <li class="page-item<?php echo $curPage=='noPage' ? ' active' : ''; ?>">
            <a class="page-link" href="<?php echo $genLink('noPage'); ?>">Показать все</a>
        </li>
    </ul>
</nav>
