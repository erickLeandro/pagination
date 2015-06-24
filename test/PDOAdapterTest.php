<?php
namespace Trinix\Pagination\Test;

use Trinix\Pagination\PDOAdapter;
use Pagerfanta\View\TwitterBootstrapView;
use Pagerfanta\Pagerfanta;
use \PDO;

class PDOAdapterTest extends \PHPUnit_Framework_TestCase
{
    protected $adapter;

    public function setUp()
    {
        $pdo = new PDO('sqlite::memory:');
        $pdo->exec($this->getSchema());
        $pdo->exec($this->insertDataInSchema());
        $query = 'SELECT * FROM classif';
        $this->adapter = new PDOAdapter($query, $pdo);
    }

    public function testCountResultForQuery()
    {   
        $this->assertEquals(9 , $this->adapter->getNbResults());
    }

    public function testResultsPerOffset()
    {
        $pagerfanta = new Pagerfanta($this->adapter);
        $pagerfanta->setMaxPerPage(1);
        $currentPageResults = $pagerfanta->getCurrentPageResults();

        $expected = [
            [
                'codigo' => "1",
                "tipo" => "01",
                "tipo2" => "01",
                "cvaluga" => "1",
                "bairro" => "4",
                "titulo" => "RUY PINHEIRO IMOVEIS",
                "texto" => "Boa Esperança - 03 Quartos, Sala, WC Social, Cozinha, Varanda, Área de Serviço, 04 Vagas de garagem, Vlr. R$- 260.000,00, CRECI-J 0191, Fone:3623-6263, Site: ruypinheiroimoveis.com.br",
                "cod" => null
            ]
        ];

        $this->assertEquals($expected, $currentPageResults);


    }

    private function getSchema()
    {
        return <<<EOF
CREATE TABLE classif(codigo integer,tipo text,tipo2 text,cvaluga text,bairro integer,titulo text,texto text,cod text);
EOF;
    }

    private function insertDataInSchema()
    {
        return <<<EOS
INSERT INTO `classif` (`codigo`, `tipo`, `tipo2`, `cvaluga`, `bairro`, `titulo`, `texto`, `cod`) VALUES (1, '01', '01', '1', 4, 'RUY PINHEIRO IMOVEIS', 'Boa Esperança - 03 Quartos, Sala, WC Social, Cozinha, Varanda, Área de Serviço, 04 Vagas de garagem, Vlr. R$- 260.000,00, CRECI-J 0191, Fone:3623-6263, Site: ruypinheiroimoveis.com.br', NULL),
(2, '01', '01', '1', 4, 'RUY PINHEIRO IMOVEIS', 'Boa Esperança - 04 Quartos, Sendo Suítes, Sala de Estar, Sala de Jantar, WC Social, Copa/Cozinha, Varanda, Área de Serviço, 02 Vagas de garagem,Churrasqueira, Piscina, Lavanderia, Vlr. R$- 500.000,00, CRECI-J 0191, Fone: 3623-6263, Site: ruypinheiroimoveis.com.br', NULL),
(3, '01', '01', '1', 6, 'CENTRO NORTE VENDE-SE', 'R. Batista das Nenes, 336: sala, 3 qtos, coz., banheiro, área serv. e quintal. GFB. IMOB. C.J485 F:3624-1713/3028-6893. SEC. Nº 12', NULL),
(4, '01', '01', '1', 6, 'ED. SOFISTICATO - 188 M² SOL DA MANHÃ', 'RUA ESTEVÃO DE MENDONÇA . 3 SUÍTES, ESCRITÓRIO, VARANDA COM CHURRASQUEIRA SALA DE JANTAR, SALA P/ 2 AMBIENTES, LAVABO, COZINHA, BANHEIRO SOCIAL,TODOCOM ARMÁRIOS, ÁREA DE SEVIÇO, 3 VAGAS, ÁREA DE LAZER COMPLETA.(65) 3637-3107 / 9956-2560 / 8124-1488 C. 3.065E-mail: Beneditoimoveis10@gmail.com', NULL),
(5, '01', '01', '1', 6, 'GFB IMOBILIARIA LTDA', 'Apartamento Residencial - Garden 3 Américas - Quitado - Chaves Disponíveis - 03 quartos sendo 01 suíte, sala de estar e jantar, banheiro social,cozinha e área de serviço, 01 vaga de garagem. Condomínio com ótimas opções de lazer.   GFB IMOBILIÁRIA LTDA- FONES 3624-1713 E 3028-6893 -gfbimob@terra.com.br - CRECI J. 485-SECOVI Nº 12', NULL),
(6, '01', '01', '1', 6, 'TORRES DO PARQUE APARTAMENTO CLASSE "A"', '96,97 - FRENTE PARQUE MÃE BONIFÁCIA.3 DORMITÓRIOS S/ 1 SUÍTE, SALA P/ 2 AMBIENTES, SALA AMPLA COM SACADA E CHURRASQUEIRA, COZINHA, ÁREA DE SERVIÇO, ARMÁRIOS, 2 VAGAS, ÁREA DE LAZERCOMPLETA.(65) 3637-3107 / 9956-2560 / 8124-1488 C. 3.065E-mail: beneditoimoveis10@gmail.com', NULL),
(7, '01', '01', '1', 9, 'HALLCY VENDE NEGOCIOS IMOBILIARIOS', 'PREDIO COM ótimo paisagismo - Apartamento com 03 quartos sala cozinha- wc. Social - todo com pintura nova - Fácil acesso ao aeroporto -BairroCOOPHAMIL -Oferece Tranqilidade e infra-estrutura dentro do bairro que mais compactado e charmoso - dentro bairro- padaria- farmácia- hospital -clubesportes- sensação de refúgio, ventilação, além de ser próximo aeroporto vizinho a grandes redes supermercado e universidade. Na Hallcy vende-Vocêencontra diversas facilidades e formas de fazer negocio. R$ 120mil - 3637-6000, 3027-1800 (8117-8280/ 9981-8222). C. F2724 www. hallcyvende.com.br', NULL),
(8, '01', '01', '1', 11, 'LÉO COELHO VENDE-SE JD. PRESIDENTE PARA FINANCIAR', 'CASA NOVA COM ENTREGA EM FEVEREIRO COM 03 QUARTOS SENDO 01 SUITE,sala, COZ, BWC, AREA SERV. Valor R$ 190.000,00.TEL: 9266-5833 E 3321-1673/ CreciJ-0167. www.abdalaimoveis@brturbo. com. Br    CRECI: F.3.104', NULL),
(9, '01', '01', '1', 20, 'ED. CECILIA MEIRELLIS 151M² - SOL DA MANHÃ', 'FRENTE PARA O SHOPPING GOIABEIRAS - APTO CLASSE "A".3 SUÍTES, VARANDA COM CHURRASQUEIRA SALA DE ESTAR E JANTAR, SALA INTIMA, LAVABO, COZINHA,ÁREA DE SEVIÇO, 3 VAGAS, ÁREA DE LAZER COMPLETA(65) 3637-3107 / 9956-2560 / 8124-1488 C. 3.065E-mail: Beneditoimoveis10@gmail.com', NULL);
EOS;
    }
}
