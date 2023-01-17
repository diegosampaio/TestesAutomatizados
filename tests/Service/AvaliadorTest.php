<?php

namespace Alura\Leilao\Tests\Service;

use Alura\Leilao\Model\Lance;
use Alura\Leilao\Model\Leilao;
use Alura\Leilao\Model\Usuario;
use Alura\Leilao\Service\Avaliador;
use PHPUnit\Framework\TestCase;

class AvaliadorTest extends TestCase
{

  private $leiloeiro;

  /**
   * Método executado antes de cada teste da classe
   *
   * @return void
   */
  protected function setUp(): void
  {
    $this->leiloeiro = new Avaliador();
  }

  /**
   * @dataProvider leilaoEmOrdemCrescente
   * @dataProvider leilaoEmOrdemDecrescente
   * @dataProvider leilaoEmOrdemAleatoria
   */
  public function testAvaliadorDeveEncontrarOMaiorValorDeLances(Leilao $leilao)
  {
    $this->leiloeiro->avalia($leilao);

    $maiorValor = $this->leiloeiro->getMaiorValor();

    $this->assertEquals(2000, $maiorValor);
  }

  /**
   * @dataProvider leilaoEmOrdemCrescente
   * @dataProvider leilaoEmOrdemDecrescente
   * @dataProvider leilaoEmOrdemAleatoria
   */
  public function testAvaliadorDeveEncontrarOMenorValorDeLances(Leilao $leilao)
  {
    $this->leiloeiro->avalia($leilao);

    $menorValor = $this->leiloeiro->getMenorValor();

    $this->assertEquals(1000, $menorValor);
  }

  /**
   * @dataProvider leilaoEmOrdemCrescente
   * @dataProvider leilaoEmOrdemDecrescente
   * @dataProvider leilaoEmOrdemAleatoria
   */
  public function testAvaliadorDeveBuscar3MaioresValores(Leilao $leilao)
  {
    $this->leiloeiro->avalia($leilao);

    $maiores = $this->leiloeiro->getMaioresLances();

    static::assertCount(3, $maiores);
    static::assertEquals(2000, $maiores[0]->getValor());
    static::assertEquals(1700, $maiores[1]->getValor());
    static::assertEquals(1500, $maiores[2]->getValor());
  }

  public function leilaoEmOrdemCrescente()
  {
    $leilao = new Leilao('Diat 147 0km');

    $joao = new Usuario('João');
    $ana = new Usuario('Ana');
    $maria = new Usuario('Maria');
    $jorge = new Usuario('Jorge');

    $leilao->recebeLance(new Lance($maria, 1000));
    $leilao->recebeLance(new Lance($joao, 1500));
    $leilao->recebeLance(new Lance($jorge, 1700));
    $leilao->recebeLance(new Lance($ana, 2000));

    return [
      'ordem-crescente' => [$leilao]
    ];
  }

  public function leilaoEmOrdemDecrescente()
  {
    $leilao = new Leilao('Diat 147 0km');

    $joao = new Usuario('João');
    $ana = new Usuario('Ana');
    $maria = new Usuario('Maria');
    $jorge = new Usuario('Jorge');

    $leilao->recebeLance(new Lance($ana, 2000));
    $leilao->recebeLance(new Lance($jorge, 1700));
    $leilao->recebeLance(new Lance($joao, 1500));
    $leilao->recebeLance(new Lance($maria, 1000));

    return [
      'ordem-decrescente' => [$leilao]
    ];
  }

  public function leilaoEmOrdemAleatoria()
  {
    $leilao = new Leilao('Diat 147 0km');

    $joao = new Usuario('João');
    $ana = new Usuario('Ana');
    $maria = new Usuario('Maria');
    $jorge = new Usuario('Jorge');

    $leilao->recebeLance(new Lance($maria, 1000));
    $leilao->recebeLance(new Lance($ana, 2000));
    $leilao->recebeLance(new Lance($jorge, 1700));
    $leilao->recebeLance(new Lance($joao, 1500));

    return [
      'ordem-aleatoria' => [$leilao]
    ];
  }

}
