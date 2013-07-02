require 'spec_helper'

TRIVIA_PATH = File.dirname(__FILE__) + '/../bin/trivia'
GOLDEN_MASTER_PATH = 'golden_master.out'
RUNS = 100

describe "#{RUNS} trivia output with different seeds" do
  it "should match golden master" do
    create_golden_master unless File.exist?(GOLDEN_MASTER_PATH)

    golden_master_content = File.open(GOLDEN_MASTER_PATH) { |file| file.read }
    trivia_output = run_trivia

    expect(trivia_output).to eq(golden_master_content)
  end

  def create_golden_master
    output = run_trivia
    File.open(GOLDEN_MASTER_PATH, 'w') { |file| file.write(output) }
  end

  def run_trivia
    output = ''
    1.upto(RUNS) do |i|
      output += `ruby #{TRIVIA_PATH} #{i}`
    end
    return output
  end
end
