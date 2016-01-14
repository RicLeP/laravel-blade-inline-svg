<?php

use InlineSvg\Contracts\SvgInliner as SvgInlinerContract;

use Mockery as m;

class SvgInlinerTest extends TestCase
{
    private $svgPath;

    public function setUp()
    {
        parent::setUp();

        $this->svgPath = __DIR__ . '/laravel.svg';
    }


    public function testAddsSvgAttributes()
    {
        /** @var SvgInlinerContract $inliner */
        $inliner = app( SvgInlinerContract::class );

        $content = $inliner->render( $this->svgPath, [ 'class' => 'InlineTest' ] );
        $this->assertContains( 'class="InlineTest"', $content );
    }

    public function testFacadeWorks()
    {
        $content = SvgInliner::render( $this->svgPath, [ 'class' => 'InlineTest' ] );
        $this->assertContains( 'class="InlineTest"', $content );
    }

    public function testBladeExtensionWorks()
    {
        $compiler = $this->app->make( 'blade.compiler' );

        $string = sprintf( '@svg(\'%s\', ["class" => "InlineText"])', $this->svgPath );
        $this->assertEquals(
          '<?php SvgInliner::render(\'/home/vagrant/Tjenestetorget/packages/laravel-blade-inline-svg/tests/laravel.svg\', ["class" => "InlineText"]); ?>',
          $compiler->compileString( $string )
        );
    }
}
