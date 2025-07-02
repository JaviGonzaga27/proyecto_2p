<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Producto>
 */
class ProductoFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        // Array de categorías de productos con nombres creíbles
        $categorias = [
            'electrodomesticos' => ['Refrigerador', 'Microondas', 'Lavadora', 'Secadora', 'Licuadora', 'Televisor', 'Aire Acondicionado'],
            'tecnologia' => ['Laptop', 'Smartphone', 'Tablet', 'Monitor', 'Teclado', 'Mouse', 'Auriculares', 'Cámara'],
            'hogar' => ['Mesa', 'Silla', 'Sofá', 'Cama', 'Escritorio', 'Estante', 'Lámpara', 'Espejo'],
            'deportes' => ['Pelota', 'Bicicleta', 'Pesas', 'Cinta de Correr', 'Raqueta', 'Casco', 'Patines'],
            'belleza' => ['Shampoo', 'Crema Facial', 'Perfume', 'Maquillaje', 'Loción', 'Aceite Corporal'],
            'cocina' => ['Sartén', 'Olla', 'Cuchillo', 'Plato', 'Vaso', 'Taza', 'Cucharón', 'Batidora']
        ];

        $marcas = ['Samsung', 'LG', 'Sony', 'Apple', 'Dell', 'HP', 'Philips', 'Bosch', 'Whirlpool', 'Panasonic', 'Xiaomi'];
        $adjetivos = ['Premium', 'Pro', 'Plus', 'Max', 'Ultra', 'Smart', 'Digital', 'Compact', 'Deluxe', 'Advanced'];

        // Seleccionar categoría aleatoria
        $categoria = $this->faker->randomElement(array_keys($categorias));
        $producto = $this->faker->randomElement($categorias[$categoria]);
        $marca = $this->faker->randomElement($marcas);

        // Crear nombres más creíbles con diferentes patrones
        $patrones = [
            $marca . ' ' . $producto,
            $producto . ' ' . $this->faker->randomElement($adjetivos),
            $marca . ' ' . $producto . ' ' . $this->faker->randomElement($adjetivos),
            $producto . ' ' . $marca,
        ];

        return [
            'nombre' => $this->faker->unique()->randomElement($patrones),
            'codigo' => strtoupper($this->faker->unique()->lexify('?????')),
            'cantidad' => $this->faker->numberBetween(10, 100),
            'precio' => $this->faker->randomFloat(2, 10, 1000),
        ];
    }
}
