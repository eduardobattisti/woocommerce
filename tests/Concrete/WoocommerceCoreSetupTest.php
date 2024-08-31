<?php

namespace Woocommerce\Pagarme\Tests\Concrete;

use PHPUnit\Framework\TestCase;
use Woocommerce\Pagarme\Concrete\WoocommerceCoreSetup;
use Mockery;
use Pagarme\Core\Kernel\ValueObjects\Configuration\MarketplaceConfig;

/**
 * @runTestsInSeparateProcesses
 * @preserveGlobalState disabled
 */
class WoocommerceCoreSetupTest extends TestCase
{
    protected function tearDown(): void
    {
        Mockery::close();
    }

    public function testMarketplaceConfigWithoutCallFilter()
    {
        require_once("vendor/wordpress/wordpress/src/wp-includes/plugin.php");
        $configMock = $this->getMockForConfiguration();
        $this->assertNull($configMock->getModuleConfiguration()->getMarketplaceConfig());
    }

    public function testMarketplaceConfigWithCallFilter()
    {
        require_once("vendor/wordpress/wordpress/src/wp-includes/plugin.php");
        add_filter('pagarme_marketplace_config', function($object){
            $object->mainRecipientId = "re_xxxxxxxxx0x00000xxxx000xx";
            return $object;
        });
        $configMock = $this->getMockForConfiguration();
        $this->assertInstanceOf(MarketplaceConfig::class, $configMock->getModuleConfiguration()->getMarketplaceConfig());
    }

    private function getMockForConfiguration()
    {
        $configMock = Mockery::mock('overload:Woocommerce\Pagarme\Model\Config');
        $configMock->shouldReceive(
            'getEnabled',
            'getIsSandboxMode',
            'getAllowNoAddress',
            'getEnableCreditCard',
            'getCardOperationForCore',
            'getAntifraudEnabled',
            'getVoucherCardWallet',
            'getEnableBillet',
            'getMultimethodsBilletCard',
            'getMultimethods2Card',
            'getMulticustomers',
            'getEnablePix',
            'getEnableVoucher'

        )->andReturn(true);
        $configMock->shouldReceive('getSecretKey')->andReturn('xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx');
        $configMock->shouldReceive('getPublicKey')->andReturn('pk_test_xxxxxxxxxxxxxxxx');
        $configMock->shouldReceive('getIsCardStatementDescriptor', 'getVoucherSoftDescriptor')->andReturn('test');
        $configMock->shouldReceive('getAntifraudMinValue')->andReturn(0);
        $configMock->shouldReceive('getCcAllowSave')->andReturn(false);
        $configMock->shouldReceive('getIsInstallmentsDefaultConfig')->andReturn(0);
        $configMock->shouldReceive('getCcFlags')->andReturn(['visa', 'mastercard']);
        $configMock->shouldReceive('getCcInstallmentsByFlag')->andReturn([]);
        $configMock->shouldReceive('getCcInstallmentsMaximum')->andReturn(12);
        $configMock->shouldReceive('getCcInstallmentsInterest')->andReturn(0);
        $configMock->shouldReceive('getCcInstallmentsInterestIncrease')->andReturn(0);
        $configMock->shouldReceive('getCcInstallmentsWithoutInterest')->andReturn(0);
        $configMock->shouldReceive('getBilletInstructions')->andReturn(null);
        $configMock->shouldReceive('getBilletDeadlineDays')->andReturn(3);
        $configMock->shouldReceive('getBilletBank')->andReturn(001);
        $configMock->shouldReceive('getPixQrcodeExpirationTime')->andReturn(3600);
        $configMock->shouldReceive('getPixAdditionalData')->andReturn(null);
        $configMock->shouldReceive('getHubInstallId')->andReturn('XXXXXXXX-XXXX-XXXX-XXXX-XXXXXXXXXXXX');
        $configMock->shouldReceive('getHubEnvironment')->andReturn('sandbox');
        $config = new WoocommerceCoreSetup();
        $config->loadModuleConfigurationFromPlatform();
        return $config;
    }
}
