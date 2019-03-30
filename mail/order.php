<div class="table-responsive">
    <table class="table table-hover table-stripped">
        <thead>
        <tr>
            <th>Наименование</th>
            <th>Кол-во</th>
            <th>Цена</th>
            <th>Сумма</th>
            <th><span class="glyphicon glyphicon-remove" aria-hidden="true"></span></th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($session['cart'] as $id => $item): ?>
            <tr>
                <td><a href="<?=\yii\helpers\Url::to(['/product/view', 'id' => $id, true])?>"><?= $item['name']?></a></td>
                <td><?= $item['quantity']?></td>
                <td><?= $item['price']?></td>
                <td><?= $item['quantity']*$item['price']?></td>
            </tr>
        <?php endforeach; ?>
        <tr>
            <td colspan="3">Итого: </td>
            <td><?= $session['cart.quantity']?></td>
        </tr>
        <tr>
            <td colspan="3">На сумму: </td>
            <td><?= $session['cart.sum']?></td>
        </tr>
        </tbody>
    </table>
</div>
