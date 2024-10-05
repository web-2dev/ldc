<style>
    body * {
        font-size: 40px;
    }    
    .crossout {
        text-decoration: line-through;
    }

    /* Masquer la checkbox réelle */
    .custom-checkbox input {
        position: absolute;
        opacity: 0;
        cursor: pointer;
        height: 0;
        width: 0;
    }

    /* Créer une fausse case à cocher */
    .custom-checkbox .checkmark {
        position: relative;
        height: 20px;
        width: 20px;
        background-color: #ccc;
        border-radius: 4px;
        display: inline-block;
        vertical-align: middle;
        margin-right: 10px;
        cursor: pointer;
    }

    /* Lorsque la checkbox est cochée, styliser la fausse case à cocher */
    .custom-checkbox input:checked + .checkmark {
        background-color: #4CAF50;
    }

    /* Créer une coche (✓) à l'intérieur de la case lorsque cochée */
    .custom-checkbox .checkmark::after {
        content: "";
        position: absolute;
        display: none;
        left: 7px;
        top: 3px;
        width: 5px;
        height: 10px;
        border: solid white;
        border-width: 0 2px 2px 0;
        transform: rotate(45deg);
    }

    /* Afficher la coche lorsque la checkbox est cochée */
    .custom-checkbox input:checked + .checkmark::after {
        display: block;
    }

</style>
<form action="" method="post">
<table>
    <thead>
        <tr>
            <th>
                <input type="checkbox" disabled>
            </th>
            <th>Produit</th>
            <th>🖍</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach($list as $item => $checked): ?>
        <tr>
            <td>
                <label class="custom-checkbox">
                    <input type="checkbox" name="<?= $item ?>" value="true" <?= $checked ? "checked" : "" ?>>
                    <span class="checkmark"></span>
                </label>                

            </td>
            <td <?= $checked ? "class='crossout'" : "" ?>><?= $item ?></td>
            <td>
                <label class="custom-checkbox">
                    <input type="checkbox" name="delete[]" id="" value="<?= $item ?>">
                    <span class="checkmark"></span>
                </label>                
            </td>
        </tr>
        <?php endforeach ?>
    </tbody>
    <tfoot>
        <tr>
            <th colspan="2">
                <button name="btSave">Enregistrer</button>
            </th>
            <th>
                <button name="btDel">Supprimer</button>
            </th>
        </tr>
    </tfoot>
</table>
</form>
