<?php

namespace Tests\Unit\TestCode;
use Tests\TestCase;
//use PHPUnit\Framework\TestCase;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Testing\RefreshDatabase;
//use Tests\TestCase;

class ProductTest extends TestCase
{
    /** @test */
    public function check_index_route()
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }
    /** @test */
    public function check_product_route()
    {
        $response = $this->get('/printpdftobookinbd');

        $response->assertStatus(200);
    }
    /** @test */
    public function check_pdf_route()
    {
        $response = $this->get('/admin');

        $response->assertStatus(200);
    }
    /** @test */
    public function check_cart_route()
    {
        $response = $this->get('/cart');

        $response->assertRedirect('/');
  }




}
