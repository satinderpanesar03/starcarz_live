<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Permission extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    const permissions = [

        //master
        'color' => [
            'view_color',
            'add_color',
            'edit_color',
            'view_color',
            'status_color'
        ],
        'executive' => [
            'view_executive',
            'add_executive',
            'edit_executive',
            'show_executive',
            'status_executive'
        ],
        'brand' => [
            'view_brand',
            'add_brand',
            'edit_brand',
            'view_brand',
            'status_brand'
        ],
        'model' => [
            'view_model',
            'add_model',
            'edit_model',
            'view_model',
            'status_model'
        ],
        'supplier' => [
            'view_supplier',
            'add_supplier',
            'edit_supplier',
            'view_supplier',
            'status_supplier'
        ],
        'rto_agent' => [
            'view_rto_agent',
            'add_rto_agent',
            'edit_rto_agent',
            'show_rto_agent',
            'status_rto_agent'
        ],
        'party' => [
            'view_party',
            'add_party',
            'edit_party',
            'show_party',
            'status_party'
        ],
        'dealer' => [
            'view_dealer',
            'add_dealer',
            'edit_dealer',
            'show_dealer',
            'status_dealer',
        ],
        // 'broker' => [
        //     'view_broker',
        //     'add_broker',
        //     'edit_broker',
        //     'view_broker'
        // ],
        //
        'bank' => [
            'view_bank',
            'add_bank',
            'edit_bank',
            'show_bank',
            'status_bank'
        ],
        // 'master_insurance' => [
        //     'view_master_insurance',
        //     'add_master_insurance',
        //     'edit_master_insurance',
        //     'view_master_insurance'
        // ],

        // 'upload_file' => [
        //     'view_upload_file',
        //     'add_upload_file',
        //     'edit_upload_file',
        //     'view_upload_file',
        // ],

        // 'article' => [
        //     'view_article',
        //     'add_article',
        //     'edit_article',
        //     'view_article',
        // ],

        // 'insurance_type' => [
        //     'view_insurance_type',
        //     'add_insurance_type',
        //     'edit_insurance_type',
        //     'view_insurance_type'
        // ],



        //insurance
        'car_loans' => [
            'view_car_loans',
            'add_car_loans',
            'edit_car_loans',
            'show_car_loans',
            'status_car_loans'
        ],
        'mortage_loans' => [
            'view_mortage_loans',
            'add_mortage_loans',
            'edit_mortage_loans',
            'show_mortage_loans',
            'status_mortage_loans'
        ],
        'aggregrator_loans' => [
            'view_aggregrator_loans',
            'add_aggregrator_loans',
            'edit_aggregrator_loans',
            'show_aggregrator_loans',
            'status_aggregrator_loans'
        ],
        'purchase' => [
            'view_purchase',
            'add_purchase',
            'edit_purchase',
            'show_purchase',
            'status_party'
        ],

        'sale' => [
            'view_sale',
            'add_sale',
            'edit_sale',
            'show_sale',
            'status_sale'
        ],

        'health_insurance' => [
            'view_health_insurance',
            'add_health_insurance',
            'edit_health_insurance',
            'show_health_insurance',
            'status_health_insurance'
        ],

        'term_insurance' => [
            'view_term_insurance',
            'add_term_insurance',
            'edit_term_insurance',
            'show_term_insurance',
            'status_term_insurance'
        ],

        'motor_insurance' => [
            'view_motor_insurance',
            'add_motor_insurance',
            'edit_motor_insurance',
            'show_motor_insurance',
            'status_motor_insurance'
        ],

        'refurbishment' => [
            'view_refurbishment',
            'add_refurbishment',
            'edit_refurbishment',
            'show_refurbishment',
            'status_refurbishment'
        ],

        'rc_transfer' => [
            'view_rc_transfer',
            'add_rc_transfer',
            'edit_rc_transfer',
            'show_rc_transfer',
            'status_rc_transfer'
        ],

        'users' => [
            'view_users',
            'add_users',
            'edit_users',
            'show_users',
            'status_users'
        ],
        'roles' => [
            'view_roles',
            'add_roles',
            'edit_roles',
            'show_roles',
            'status_roles'
        ],
        'permission' => [
            'view_permission',
            'add_permission',
            'edit_permission',
            'show_permission',
            'status_permission'
        ],

        'customer_demand' => [
            'view_customer_demand',
            'add_customer_demand',
            'edit_customer_demand',
            'show_customer_demand',
            'status_customer_demand'
        ],

        'motor_insurance_claim' => [
            'view_motor_insurance_claim',
            'add_motor_insurance_claim',
            'edit_motor_insurance_claim',
            'show_motor_insurance_claim',
            'status_motor_insurance_claim'
        ],

        'general_insurance' => [
            'view_general_insurance',
            'add_general_insurance',
            'edit_general_insurance',
            'show_general_insurance',
            'status_general_insurance'
        ],

        'sub_type' => [
            'view_sub_type',
            'add_sub_type',
            'edit_sub_type',
            'show_sub_type',
            'status_sub_type'
        ],
        'insurance_company' => [
            'view_insurance',
            'add_insurance',
            'edit_insurance',
            'show_insurance',
            'status_insurance'
        ],

    ];
}
