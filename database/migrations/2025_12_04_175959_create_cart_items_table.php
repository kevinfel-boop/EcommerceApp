<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Crée la table des articles du panier
     */
    // database/migrations/xxxx_create_cart_items_table.php

    public function up()
    {
        Schema::table('cart_items', function (Blueprint $table) {
            // Vérifier si la colonne existe déjà
            if (!Schema::hasColumn('cart_items', 'product_id')) {
                $table->foreignId('product_id')->after('cart_id');
            }

            // Ajouter la contrainte de clé étrangère
            $table->foreign('product_id')
                ->references('id')
                ->on('products')
                ->onDelete('cascade');
        });
    }

    /**
     * Supprime la table cart_items
     */
    public function down(): void
    {
        Schema::dropIfExists('cart_items');
    }
};
