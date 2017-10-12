<?php
/**
 * Created by PhpStorm.
 * User: satos
 * Date: 2017/10/02
 * Time: 15:49
 */
class AssociationBehavior extends AppModel{

public function getJoins() {
    return [
        'fields' => '*',
        'joins' => [
            [
                'type' => 'inner',
                'table' => 'users',
                'alias' => 'User',
                'conditions' => 'proceedings.user_id = User.id'
            ],
            [
                'type' => 'inner',
                'table' => 'headings',
                'alias' => 'Heading',
                'conditions' => 'proceedings.id = Heading.proceeding_id'
            ],
            [
                'type' => 'inner',
                'table' => 'attenders',
                'alias' => 'Attender',
                'conditions' => 'proceedings.id = Attender.proceeding_id'
            ],
            [
                'type' => 'inner',
                'table' => 'customers',
                'alias' => 'Customer',
                'conditions' => 'Order.customers_id = Customer.id'
            ],
            [
                'type' => 'inner',
                'table' => 'item_sizes',
                'alias' => 'ItemSize',
                'conditions' => 'Item.item_sizes_id = ItemSize.id'
            ]
        ]
    ];
}

public function getData() {
    $itemsOrdersRelation = ClassRegistry::init('ItemsOrdersRelation');
    $joinParam = $this->getJoins();
    return $itemsOrdersRelation->find('all', $joinParam);
}
}